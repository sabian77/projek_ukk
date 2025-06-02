<?php

namespace App\Livewire\Fe\Industri;

use App\Models\Industri;
use App\Models\Pkl;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    public $nama, $bidang_usaha, $alamat, $kontak, $email, $website;
    public $isOpen = false;
    public $rowPerPage = 10;
    public $search;
    public $editMode = false;
    public $editingId = null;

    protected $listeners = ['industriCreated' => 'render']; // Menambahkan listener

    public function render()
    {
        return view('livewire.fe.industri.index', [
            'industris' => $this->search === null
                ? Industri::oldest()->paginate($this->rowPerPage)
                : Industri::oldest()
                    ->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('bidang_usaha', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat', 'like', '%' . $this->search . '%')
                    ->paginate($this->rowPerPage),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->nama = '';
        $this->bidang_usaha = '';
        $this->alamat = '';
        $this->kontak = '';
        $this->email = '';
        $this->website = '';
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'bidang_usaha' => 'required',
            'alamat' => 'required',
            'kontak' => 'required',
            'email' => 'required|email',
            'website' => 'required',
        ]);

        DB::beginTransaction();

        try {
            // Cek apakah nama industri sudah ada (untuk create saja)
            if (!$this->editMode && Industri::where('nama', $this->nama)->exists()) {
                DB::rollBack();
                session()->flash('error', "Nama industri sudah ada di database!");
                return;
            }

            if ($this->editMode) {
                $industri = Industri::findOrFail($this->editingId);
                $industri->update([
                    'nama' => $this->nama,
                    'bidang_usaha' => $this->bidang_usaha,
                    'alamat' => $this->alamat,
                    'kontak' => $this->kontak,
                    'email' => $this->email,
                    'website' => $this->website,
                ]);

                $message = 'Data industri berhasil diupdate!';
            } else {
                $industri = Industri::create([
                    'nama' => $this->nama,
                    'bidang_usaha' => $this->bidang_usaha,
                    'alamat' => $this->alamat,
                    'kontak' => $this->kontak,
                    'email' => $this->email,
                    'website' => $this->website,
                ]);

                $message = 'Data industri berhasil disimpan!';
            }

            DB::commit();

            $this->resetInputFields();
            $this->editMode = false; // reset edit mode
            $this->closeModal();

            session()->flash('success', $message);

            /// Emit event setelah menyimpan
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', "Terjadi kesalahan: " . $e->getMessage());
        }
    }



    public function edit($id)
    {
        $industri = Industri::findOrFail($id);

        //memasukan field edit ke database
        $this->editingId = $id;
        $this->nama = $industri->nama;
        $this->bidang_usaha = $industri->bidang_usaha;
        $this->alamat = $industri->alamat;
        $this->kontak = $industri->kontak;
        $this->email = $industri->email;
        $this->website = $industri->website;

        //membuka modal
        $this->editMode = true;
        $this->openModal();
    }

}
