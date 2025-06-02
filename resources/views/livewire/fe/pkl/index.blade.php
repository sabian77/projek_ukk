<div class="py-24">
  {{-- Card --}}
  <div class="mx-auto bg-white rounded-lg shadow-lg overflow-hidden px-6 py-6">
    <div wire:poll.10000ms> <!-- refresh setiap 10detik -->
    </div>


    {{-- Tampilan Pesan --}}
    <div>
      @if (session()->has('error'))
          <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
              class="p-4 bg-red-500 text-white rounded-md mb-4">
              {{ session('error') }}
          </div>
      @endif

      @if (session()->has('success'))
          <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
              class="p-4 bg-green-500 text-white rounded-md mb-4">
              {{ session('success') }}
          </div>
      @endif
      
      {{-- Flash Messages dari Livewire --}}
      @if (session()->has('message'))
          <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
              class="p-4 bg-blue-500 text-white rounded-md mb-4">
              {{ session('message') }}
          </div>
      @endif
    </div>
    {{-- ./Tampilan Pesan --}}

    
{{-- Konfirmasi Hapus --}}
@if($pklIdToDelete)
  <div class="fixed inset-0 flex items-center justify-center z-50">
    {{-- Overlay Background Semi-Transparan --}}
    <div class="absolute inset-0  bg-opacity-50 backdrop-blur-sm"></div>

    {{-- Modal Box --}}
    <div class="relative bg-white border border-black rounded-lg p-6 w-80 shadow-2xl transition transform scale-100 animate-fade-in">
      <h2 class="text-lg font-semibold mb-4 text-gray-800">Konfirmasi Hapus</h2>
      <p class="text-gray-700">Apakah Anda yakin ingin menghapus data PKL ini?</p>
      <div class="flex justify-end mt-4">
        <button wire:click="$set('pklIdToDelete', null)"
                class="bg-gray-500 text-white px-3 py-1 rounded-md hover:bg-gray-600 mr-2 transition duration-200">
          Batal
        </button>
        <button wire:click="confirmDelete"
                class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition duration-200">
          Hapus
        </button>
      </div>
    </div>
  </div>
@endif


    {{-- Judul --}}
    <div class="w-full bg-gray-200 p-4 text-center text-2xl font-bold text-gray-700">
      Siswa PKL
    </div>
    {{-- ./Judul --}}
    
    {{-- Form Entry dan Searching --}}
    <div class="mx-auto flex items-center justify-between bg-white p-6 rounded-lg shadow-md mb-6">

        <!-- Tombol Create Lapor PKL di kiri -->
        <button wire:click="create" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
            Create Lapor PKL
        </button>

        {{-- Cek apakah menampilkan halaman modal --}}
        @if($isOpen)
            @include('livewire.fe.pkl.create')
        @endif
        {{-- ./Cek apakah menampilkan halaman modal --}}

        {{-- Form Searching --}}
        <input wire:model.live="search" type="text" placeholder="Search ..." class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        {{-- ./Form Searching --}}
    </div>
    {{-- ./Form Entry dan Searching --}}

    {{-- Table PKL --}}
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white border border-gray-200">
        <thead>
          <tr>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">No</th>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">Nama Siswa</th>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">Industri</th>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">Bidang Usaha</th>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">Guru Pembimbing</th>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">Mulai</th>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">Selesai</th>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">Durasi (Hari)</th>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">Action</th>
          </tr>
        </thead>

        <tbody>
          @php
            use Carbon\Carbon;
            use Illuminate\Support\Facades\Auth;
            use App\Models\Siswa;

            $siswa_login = Siswa::where('email', Auth::user()->email)->first();
            $no = 0;
          @endphp

          @foreach($pkls as $key => $pkl)
            @php
              $no++;
              $d1 = Carbon::parse($pkl->mulai);
              $d2 = Carbon::parse($pkl->selesai);
              $selisihHari = $d1->diffInDays($d2); // Selisih dalam hari
            @endphp
            
            <tr class="hover:bg-gray-100 transition duration-200">
              <td class="px-4 py-2 border-b border-gray-200">{{ $no }}</td>
              <td class="px-4 py-2 border-b border-gray-200">{{ $pkl->siswa->nama }}</td>
              <td class="px-4 py-2 border-b border-gray-200">{{ $pkl->industri->nama }}</td>
              <td class="px-4 py-2 border-b border-gray-200">{{ $pkl->industri->bidang_usaha }}</td>
              <td class="px-4 py-2 border-b border-gray-200">{{ $pkl->guru->nama ?? '-'  }}</td>
              <td class="px-4 py-2 border-b border-gray-200">{{ $pkl->mulai }}</td>
              <td class="px-4 py-2 border-b border-gray-200">{{ $pkl->selesai }}</td>
              <td class="px-4 py-2 border-b border-gray-200">{{ $selisihHari }}</td>
              <td class="px-4 py-2 border-b border-gray-200">
                {{-- Action buttons dengan pengecekan authorization --}}
                @if($siswa_login && $siswa_login->id == $pkl->siswa_id)
                  <div class="flex space-x-2">
                    {{-- Tombol Edit --}}
                    <button wire:click="edit({{ $pkl->id }})" 
                            class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition duration-200 text-sm">
                      <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                      </svg>
                      Edit
                    </button>
                    <button wire:click="setPklIdToDelete({{ $pkl->id }})"
                            class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 text-sm">
                        Delete
                    </button>
                  </div>
                @else
                  <span class="text-gray-400 text-sm">-</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{-- ./Table PKL --}}

    {{-- Pagination --}}
    <div class="p-4">
       {{ $pkls->links() }}
    </div>
    {{-- ./Pagination --}}
  </div>
  {{-- ./Card --}}
</div>