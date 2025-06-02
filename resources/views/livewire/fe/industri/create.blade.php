<div class="fixed inset-0 z-10 overflow-y-auto ease-out duration-400">
  <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
      
    <div class="fixed inset-0 transition-opacity">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>
  
    <!-- Trick to center modal contents -->
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
    
    <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
      <div class='py-4 px-4'>
        <h2 class='font-semibold text-lg text-center'>Tambah Industri</h2>
        <div class="border-t border-gray-300 my-2"></div>
      </div>
      
      <form wire:submit.prevent="store">
        <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
          <div>
            {{-- Nama --}}
            <div class="mb-4">
              <label for="nama" class="block mb-2 font-semibold text-gray-700">Nama Industri</label>
              <input type="text" id="nama" wire:model.defer="nama" 
                class="mt-1 p-2 border rounded-md w-full focus:ring focus:ring-blue-300 focus:outline-none" placeholder="Masukkan nama industri">
              @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            {{-- Bidang Usaha --}}
            <div class="mb-4">
              <label for="bidang_usaha" class="block mb-2 font-semibold text-gray-700">Bidang Usaha</label>
              <input type="text" id="bidang_usaha" wire:model.defer="bidang_usaha" 
                class="mt-1 p-2 border rounded-md w-full focus:ring focus:ring-blue-300 focus:outline-none" placeholder="Masukkan bidang usaha">
              @error('bidang_usaha') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            {{-- Alamat --}}
            <div class="mb-4">
              <label for="alamat" class="block mb-2 font-semibold text-gray-700">Alamat</label>
              <input type="text" id="alamat" wire:model.defer="alamat" 
                class="mt-1 p-2 border rounded-md w-full focus:ring focus:ring-blue-300 focus:outline-none" placeholder="Masukkan alamat">
              @error('alamat') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            {{-- Kontak --}}
            <div class="mb-4">
              <label for="kontak" class="block mb-2 font-semibold text-gray-700">Kontak</label>
              <input type="text" id="kontak" wire:model.defer="kontak" 
                class="mt-1 p-2 border rounded-md w-full focus:ring focus:ring-blue-300 focus:outline-none" placeholder="Masukkan kontak">
              @error('kontak') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
              <label for="email" class="block mb-2 font-semibold text-gray-700">Email</label>
              <input type="email" id="email" wire:model.defer="email" 
                class="mt-1 p-2 border rounded-md w-full focus:ring focus:ring-blue-300 focus:outline-none" placeholder="Masukkan email">
              @error('email') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            {{-- Website --}}
            <div class="mb-4">
              <label for="website" class="block mb-2 font-semibold text-gray-700">Website</label>
              <input type="text" id="website" wire:model.defer="website" 
                class="mt-1 p-2 border rounded-md w-full focus:ring focus:ring-blue-300 focus:outline-none" placeholder="Masukkan website">
              @error('website') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>
          </div>
        </div>
    
        <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
          <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <button type="submit" 
              class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-6 text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green sm:text-sm sm:leading-5">
              Simpan
            </button>
          </span>
          <span class="flex w-full mt-3 rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <button wire:click.prevent="closeModal" type="button" 
              class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-6 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue sm:text-sm sm:leading-5">
              Batal
            </button>
          </span>
        </div>
      </form>
        
    </div>
  </div>
</div>