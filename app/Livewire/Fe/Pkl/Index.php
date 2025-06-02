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

class Index extends Component
{
    public $siswaId, $industriId, $guruId, $mulai, $selesai;
    public $isOpen = 0;
    public $editMode = false;
    public $editingId = null;
    public $pklIdToDelete = null;

    use WithPagination;

    public $rowPerPage=10;
    public $search;
    public $userMail;
    public $siswa_login; // Tambahkan property ini

    public function mount(){
        //membaca email user yang seddang login
        $this->userMail = Auth::user()->email;
        //mengakses record siswa yang emailnya sama dengan user yang sedang login
        $this->siswa_login = Siswa::where('email','=',$this->userMail)->first();
    }
    
    public function render()
    {
        return view('livewire.fe.pkl.index',[
            'pkls' => $this->search === NULL ?
                        Pkl::latest()->paginate($this->rowPerPage) :
                        Pkl::latest()->whereHas('siswa', function ($query) {
                                                $query->where('nama', 'like', '%' . $this->search . '%');
                                            })
                                    ->orWhereHas('industri', function ($query) {
                                                $query->where('nama', 'like', '%' . $this->search . '%');
                                    })->paginate($this->rowPerPage),
            
            'siswa_login'=>$this->siswa_login,
            'industris'=>Industri::all(),
            'gurus'=>Guru::all(),
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

    private function resetInputFields(){
        $this->siswaId      ='';
        $this->industriId   = '';
        $this->guruId       = '';
        $this->mulai        ='';
        $this->selesai      = '';
    }

    // Fungsi untuk mengecek apakah user bisa edit/hapus
    public function canEditDelete($pklSiswaId)
    {
        return $this->siswa_login && $this->siswa_login->id == $pklSiswaId;
    }

    public function store()
    {
        $this->validate([
                'siswaId'       => 'required',
                'industriId'    => 'required',
                'guruId'        => 'nullable',
                'mulai'         => 'required|date',
                'selesai'       => 'required|date|after:mulai',
            ]);
        
        DB::beginTransaction();
        
        try {
            $siswa = Siswa::find($this->siswaId);

            // Cek status PKL untuk create baru
            if (!$this->editMode && $siswa->status_pkl) {
                DB::rollBack();
                $this->closeModal();
                session()->flash('error', 'Transaksi dibatalkan: Siswa sudah melapor.');
                return;
            }

            if ($this->editMode) {
                // Update existing PKL
                $pkl = Pkl::findOrFail($this->editingId);
                
                // Pastikan hanya siswa yang bersangkutan yang bisa update
                if ($pkl->siswa_id !== $this->siswa_login->id) {
                    DB::rollBack();
                    $this->closeModal();
                    session()->flash('error', 'Anda tidak memiliki izin untuk mengedit data ini.');
                    return;
                }

                $pkl->update([
                    'siswa_id'    => $this->siswaId,
                    'industri_id' => $this->industriId,
                    'guru_id'     => $this->guruId ?: null,
                    'mulai'       => $this->mulai,
                    'selesai'     => $this->selesai,
                ]);

                $message = "Data PKL berhasil diupdate!";
            } else {
                // Create new PKL
                Pkl::create([
                    'siswa_id'    => $this->siswaId,
                    'industri_id' => $this->industriId,
                    'guru_id'     => $this->guruId ?: null,
                    'mulai'       => $this->mulai,
                    'selesai'     => $this->selesai,
                ]);

                // Update status_lapor siswa
                $siswa->update(['status_pkl' => 1]);
                
                $siswanama = $siswa->nama;
                $message = "Data PKL berhasil disimpan dan status $siswanama lapor pkl!";
            }

            DB::commit();
            
            $this->closeModal();
            $this->resetInputFields();

            session()->flash('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->closeModal();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pkl = Pkl::findOrFail($id);

        // Cek authorization
        if ($pkl->siswa_id !== $this->siswa_login->id) {
            session()->flash('error', 'Anda tidak memiliki izin untuk mengedit data ini.');
            return;
        }

        // Set data ke form
        $this->editingId = $id;
        $this->siswaId = $pkl->siswa_id;
        $this->industriId = $pkl->industri_id;
        $this->guruId = $pkl->guru_id;
        $this->mulai = $pkl->mulai;
        $this->selesai = $pkl->selesai;
        
        $this->editMode = true;
        $this->openModal();
    }
       // SET ID untuk konfirmasi hapus
    public function setPklIdToDelete($id)
    {
        $this->pklIdToDelete = $id;
    }


        // KONFIRMASI DELETE
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

}