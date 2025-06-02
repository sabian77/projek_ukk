<?php

namespace App\Livewire\Fe\Pkl;

use App\Models\Pkl;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Industri;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Volt\Compilers\Mount;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Index extends Component
{
    public $siswaId, $industriId, $guruId, $mulai, $selesai;
    public $isOpen = 0;
    public $editMode = false;
    public $editingId = null;
    public $pklIdToDelete = null;

    use WithPagination;

    public $rowPerPage = 10;
    public $search;
    public $userMail;
    public $siswa_login;

    public function mount()
    {
        $this->userMail = Auth::user()->email;
        $this->siswa_login = Siswa::where('email', '=', $this->userMail)->first();
    }
    
    public function render()
    {
        return view('livewire.fe.pkl.index', [
            'pkls' => $this->search === NULL ?
                        Pkl::latest()->paginate($this->rowPerPage) :
                        Pkl::latest()->whereHas('siswa', function ($query) {
                                                $query->where('nama', 'like', '%' . $this->search . '%');
                                            })
                                    ->orWhereHas('industri', function ($query) {
                                                $query->where('nama', 'like', '%' . $this->search . '%');
                                    })->paginate($this->rowPerPage),
            
            'siswa_login' => $this->siswa_login,
            'industris' => Industri::all(),
            'gurus' => Guru::all(),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->editMode = false;
        $this->openModal();
    }
    
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->editMode = false;
        $this->editingId = null;
    }

    private function resetInputFields()
    {
        $this->siswaId = '';
        $this->industriId = '';
        $this->guruId = '';
        $this->mulai = '';
        $this->selesai = '';
    }

    public function canEditDelete($pklSiswaId)
    {
        return $this->siswa_login && $this->siswa_login->id == $pklSiswaId;
    }

    /**
     * Validasi tanggal mulai minimal 1 Juli tahun berjalan
     */
    private function validateTanggalMulai($attribute, $value, $fail)
    {
        $mulaiDate = Carbon::parse($value);
        $currentYear = Carbon::now()->year;
        
        // Tanggal 1 Juli tahun berjalan
        $julyFirst = Carbon::create($currentYear, 7, 1);
        
        // Jika sekarang sudah lewat 1 Juli, maka tahun depan
        if (Carbon::now()->lt($julyFirst)) {
            $julyFirst = Carbon::create($currentYear, 7, 1);
        } else {
            // Jika sudah lewat 1 Juli tahun ini, bisa mulai tahun ini atau tahun depan
            $julyFirstThisYear = Carbon::create($currentYear, 7, 1);
            $julyFirstNextYear = Carbon::create($currentYear + 1, 7, 1);
            
            if ($mulaiDate->lt($julyFirstThisYear)) {
                $fail('Tanggal mulai harus minimal tanggal 1 Juli ' . $currentYear . ' atau setelahnya.');
                return;
            }
        }
        
        if ($mulaiDate->lt($julyFirst)) {
            $fail('Tanggal mulai harus minimal tanggal 1 Juli atau setelahnya.');
        }
    }

    /**
     * Validasi durasi minimal 90 hari
     */
    private function validateDurasi($attribute, $value, $fail)
    {
        if ($value && $this->mulai) {
            $mulaiDate = Carbon::parse($this->mulai);
            $selesaiDate = Carbon::parse($value);
            
            // Hitung selisih hari (termasuk hari mulai)
            $durasiHari = $mulaiDate->diffInDays($selesaiDate) + 1;
            
            if ($durasiHari < 90) {
                $fail('Durasi PKL harus minimal 90 hari. Saat ini durasi adalah ' . $durasiHari . ' hari.');
            }
        }
    }

    /**
     * Auto-set tanggal selesai berdasarkan tanggal mulai
     */
    public function updatedMulai()
    {
        if ($this->mulai) {
            $mulaiDate = Carbon::parse($this->mulai);
            // Set tanggal selesai otomatis 90 hari setelah mulai
            $this->selesai = $mulaiDate->addDays(89)->format('Y-m-d'); // 89 hari karena sudah include hari mulai
        }
    }

    public function store()
    {
        $this->validate([
            'siswaId' => 'required',
            'industriId' => 'required',
            'guruId' => 'nullable|exists:gurus,id', // Validasi jika diisi harus ada di tabel guru
            'mulai' => [
                'required', 
                'date',
                function($attribute, $value, $fail) {
                    $this->validateTanggalMulai($attribute, $value, $fail);
                }
            ],
            'selesai' => [
                'required', 
                'date', 
                'after_or_equal:mulai',
                function($attribute, $value, $fail) {
                    $this->validateDurasi($attribute, $value, $fail);
                }
            ],
        ], [
            // Custom error messages
            'siswaId.required' => 'Siswa harus dipilih.',
            'industriId.required' => 'Industri harus dipilih.',
            'guruId.exists' => 'Guru yang dipilih tidak valid.',
            'mulai.required' => 'Tanggal mulai harus diisi.',
            'mulai.date' => 'Format tanggal mulai tidak valid.',
            'selesai.required' => 'Tanggal selesai harus diisi.',
            'selesai.date' => 'Format tanggal selesai tidak valid.',
            'selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);

        DB::beginTransaction();
        try {
            // Cek apakah siswa sudah punya PKL aktif
            $existingPkl = Pkl::where('siswa_id', $this->siswaId)->first();
            if ($existingPkl && !$this->editMode) {
                throw new \Exception('Siswa sudah memiliki data PKL.');
            }

            if ($this->editMode) {
                // Update existing PKL
                $pkl = Pkl::findOrFail($this->editingId);
                $pkl->update([
                    'siswa_id' => $this->siswaId,
                    'industri_id' => $this->industriId,
                    'guru_id' => $this->guruId ?: null, // Convert empty string to null
                    'mulai' => $this->mulai,
                    'selesai' => $this->selesai,
                ]);
                
                session()->flash('success', 'Data PKL berhasil diupdate.');
            } else {
                // Create new PKL
                Pkl::create([
                    'siswa_id' => $this->siswaId,
                    'industri_id' => $this->industriId,
                    'guru_id' => $this->guruId ?: null, // Convert empty string to null
                    'mulai' => $this->mulai,
                    'selesai' => $this->selesai,
                ]);

                // Update status siswa
                $siswa = Siswa::find($this->siswaId);
                if ($siswa) {
                    $siswa->update(['status_pkl' => 1]);
                }
                
                session()->flash('success', 'Data PKL berhasil ditambahkan.');
            }

            DB::commit();
            $this->closeModal();
            $this->resetInputFields();

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pkl = Pkl::findOrFail($id);

        if ($pkl->siswa_id !== $this->siswa_login->id) {
            session()->flash('error', 'Anda tidak memiliki izin untuk mengedit data ini.');
            return;
        }

        $this->editingId = $id;
        $this->siswaId = $pkl->siswa_id;
        $this->industriId = $pkl->industri_id;
        $this->guruId = $pkl->guru_id;
        $this->mulai = $pkl->mulai;
        $this->selesai = $pkl->selesai;
        
        $this->editMode = true;
        $this->openModal();
    }

    public function setPklIdToDelete($id)
    {
        $this->pklIdToDelete = $id;
    }

    public function confirmDelete()
    {
        if (!$this->pklIdToDelete) {
            session()->flash('error', 'Tidak ada data yang dipilih untuk dihapus.');
            return;
        }

        $pkl = Pkl::findOrFail($this->pklIdToDelete);

        if ($pkl->siswa_id !== $this->siswa_login->id) {
            session()->flash('error', 'Anda tidak memiliki izin untuk menghapus data ini.');
            $this->pklIdToDelete = null;
            return;
        }

        DB::beginTransaction();
        try {
            $siswa = Siswa::find($pkl->siswa_id);
            if ($siswa) {
                Log::info('Before update:', ['status_pkl' => $siswa->status_pkl]);
                $pkl->delete();
                $siswa->update(['status_pkl' => 0]);
                Log::info('After update:', ['status_pkl' => $siswa->status_pkl]);
            }

            DB::commit();
            session()->flash('success', 'Data PKL berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }

        $this->pklIdToDelete = null;
    }

    /**
     * Helper method untuk mendapatkan tanggal minimal
     */
    public function getMinStartDate()
    {
        $currentYear = Carbon::now()->year;
        $julyFirst = Carbon::create($currentYear, 7, 1);
        
        // Jika sekarang masih sebelum 1 Juli, maka minimal 1 Juli tahun ini
        // Jika sudah lewat 1 Juli, maka bisa mulai dari sekarang atau 1 Juli tahun depan
        if (Carbon::now()->lt($julyFirst)) {
            return $julyFirst->format('Y-m-d');
        } else {
            return Carbon::now()->format('Y-m-d');
        }
    }
}