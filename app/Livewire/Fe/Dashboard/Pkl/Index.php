<?php

namespace App\Livewire\Fe\Dashboard\Pkl;

use App\Models\Pkl;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Industri;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Volt\Compilers\Mount;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $siswaId, $industriId, $guruId, $mulai, $selesai;
    public $isOpen = 0;

    use WithPagination;

    public $rowPerPage=10;
    public $search;
    public $userMail;

    public function mount()
    {
        // Membaca email user yang sedang login
        $this->userMail = Auth::user()->email;
        
        // Mendapatkan data siswa yang login
        $siswa_login = Siswa::where('email', '=', $this->userMail)->first();

        // Jika ditemukan, simpan pesan ke session secara permanen dalam sesi
        if ($siswa_login) {
            session()->put('login_message', "Halo {$siswa_login->nama} ");
        } else {
            session()->put('login_message', "Data siswa tidak ditemukan untuk email: {$this->userMail}");
        }

    }

    public function render()
    {
        return view('livewire.fe.dashboard.pkl.index', [
            'pkls' => Pkl::latest()->paginate($this->rowPerPage),
            'pkls' => $this->search === NULL ?
                        Pkl::latest()->paginate($this->rowPerPage) :
                        Pkl::latest()->whereHas('siswa', function ($query) {
                                                $query->where('nama', 'like', '%' . $this->search . '%');
                                            })
                                    ->orWhereHas('industri', function ($query) {
                                                $query->where('nama', 'like', '%' . $this->search . '%');
                                    })->paginate($this->rowPerPage),
                // Pkl::latest()->where('pkls->siswas->id','like','%'.$this->search.'%')->paginate($this->rowPerPage),
            
            //mengakses record siswa yang emailnya sama dengan user yang sedang login
            'siswa_login'=>Siswa::where('email','=',$this->userMail)->first(),
            
            'industris'=>Industri::all(),
            'gurus'=>Guru::all(),
        ]);
    }
}
