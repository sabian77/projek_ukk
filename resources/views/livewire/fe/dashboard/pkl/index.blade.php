<div class="py-24">
    <div wire:poll.10000ms> <!-- refresh setiap 10detik -->
    </div>

    {{-- Card --}}
    <div class="mx-auto bg-white rounded-lg shadow-lg overflow-hidden px-6 py-6">

        {{-- Tampilan Pesan --}}
        <div>
           @if (session()->has('login_message'))
        <div x-data="{ show: true }" x-show="show" 
            class="p-4 text-black bg-green-200 rounded-md mb-4">
            {{ session()->get('login_message') }}
        </div>
        @endif

        </div>
        {{-- ./Tampilan Pesan --}}

        {{-- Judul --}}
        <div class="w-full bg-gray-200 p-4 text-center text-2xl font-bold text-gray-700">
            Siswa PKL
        </div>
        {{-- ./Judul --}}

        {{-- Form Searching --}}
        <div class="flex justify-end items-center mt-6 mb-6">
            <input wire:model.live="search" type="text" placeholder="Search ..." 
                class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

        </div>
        {{-- ./Form Searching --}}

        {{-- Table PKL --}}
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b border-gray-200 text-left text-gray-600">No</th>
                        <th class="px-4 py-2 border-b border-gray-200 text-left text-gray-600">Nama Siswa</th>
                        <th class="px-4 py-2 border-b border-gray-200 text-left text-gray-600">Industri</th>
                        <th class="px-4 py-2 border-b border-gray-200 text-left text-gray-600">Bidang Usaha</th>
                        <th class="px-4 py-2 border-b border-gray-200 text-left text-gray-600">Guru </th>
                        <th class="px-4 py-2 border-b border-gray-200 text-left text-gray-600">Mulai</th>
                        <th class="px-4 py-2 border-b border-gray-200 text-left text-gray-600">Selesai</th>
                        <th class="px-4 py-2 border-b border-gray-200 text-left text-gray-600">Durasi (Hari)</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        use Carbon\Carbon;
                        $no = 0;
                    @endphp

                    @foreach($pkls as $pkl)
                        @php
                            $no++;
                            $mulai = Carbon::parse($pkl->mulai);
                            $selesai = Carbon::parse($pkl->selesai);
                            $durasi = $mulai->diffInDays($selesai); 
                        @endphp

                        <tr class="hover:bg-gray-100 transition duration-200">
                            <td class="px-4 py-2 border-b border-gray-200">{{ $no }}</td>
                            <td class="px-4 py-2 border-b border-gray-200">{{ $pkl->siswa->nama ?? '-' }}</td>
                            <td class="px-4 py-2 border-b border-gray-200">{{ $pkl->industri->nama ?? '-' }}</td>
                            <td class="px-4 py-2 border-b border-gray-200">{{ $pkl->industri->bidang_usaha ?? '-' }}</td>
                            <td class="px-4 py-2 border-b border-gray-200">{{ $pkl->guru->nama }}</td>
                            <td class="px-4 py-2 border-b border-gray-200">{{ $pkl->mulai ?? '-' }}</td>
                            <td class="px-4 py-2 border-b border-gray-200">{{ $pkl->selesai ?? '-' }}</td>
                            <td class="px-4 py-2 border-b border-gray-200">{{ $durasi }}</td>
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
    </div>
    {{-- ./Card --}}
</div>
