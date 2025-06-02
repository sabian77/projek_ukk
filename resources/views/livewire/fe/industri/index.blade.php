<div class="py-24">
  <div wire:poll.10000ms> <!-- refresh setiap 10detik -->
  </div>

  {{-- Card --}}
  <div class="mx-auto bg-white rounded-lg shadow-lg overflow-hidden px-6 py-6">

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
    </div>
    {{-- ./Tampilan Pesan --}}

    {{-- Judul --}}
    <div class="w-full bg-gray-200 p-4 text-center text-2xl font-bold text-gray-700 mb-6">
      Daftar Industri
    </div>
    {{-- ./Judul --}}
    
    {{-- Form Entry dan Searching --}}
    <div class="mx-auto flex items-center justify-between bg-white p-6 rounded-lg shadow-md mb-6">

        <!-- Tombol Create Industri di kiri -->
        <button wire:click="create()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
            + Tambah Industri
        </button>

        {{-- Cek apakah menampilkan halaman modal --}}
        @if($isOpen)
            @include('livewire.fe.industri.create')
        @endif
        {{-- ./Cek apakah menampilkan halaman modal --}}

        {{-- Form Searching --}}
        <input wire:model.live="search" type="text" placeholder="Cari industri..." class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        {{-- ./Form Searching --}}
    </div>
    {{-- ./Form Entry dan Searching --}}

    {{-- Table Industri --}}
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white border border-gray-200">
        <thead>
          <tr>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">No</th>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">Nama</th>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">Bidang Usaha</th>
            <th class="px-9 py-2 border-b border-gray-200 text-left text-gray-600">Alamat</th>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">Kontak</th>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">Email</th>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">Website</th>
            <th class="px-6 py-2 border-b border-gray-200 text-left text-gray-600">Action</th>
          </tr>
        </thead>

        <tbody>
          @php $no = ($industris->currentPage() - 1) * $industris->perPage() + 1; @endphp
          @foreach($industris as $industri)
            <tr class="hover:bg-gray-100 transition duration-200">
              <td class="px-4 py-2 border-b border-gray-200">{{ $no++ }}</td>
              <td class="px-4 py-2 border-b border-gray-200">{{ $industri->nama }}</td>
              <td class="px-4 py-2 border-b border-gray-200">{{ $industri->bidang_usaha }}</td>
              <td class="px-4 py-2 border-b border-gray-200">{{ $industri->alamat }}</td>
              <td class="px-4 py-2 border-b border-gray-200">{{ $industri->kontak }}</td>
              <td class="px-4 py-2 border-b border-gray-200">{{ $industri->email }}</td>
              <td class="px-4 py-2 border-b border-gray-200">{{ $industri->website }}</td>
              <td class="px-4 py-2 border-b border-gray-200">
                <button wire:click="edit({{ $industri->id }})" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 mr-2">
                  Edit
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{-- ./Table Industri --}}

    {{-- Pagination --}}
    <div class="p-4">
       {{ $industris->links() }}
    </div>
    {{-- ./Pagination --}}
  </div>
  {{-- ./Card --}}
</div>