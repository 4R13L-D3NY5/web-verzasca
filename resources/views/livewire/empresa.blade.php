<div class="dark:bg-gray-900 text-white p-4 flex justify-center">
    <div class="w-full max-w-screen-md">
      <div class="relative flex w-full flex-col rounded-xl bg-white text-gray-700 shadow-md p-6">
        <h6 class="text-center text-xl font-bold text-gray-800 dark:text-white mb-4">Información de la Empresa</h6>
  
        @if ($empresa)
          <div class="grid grid-cols-1 gap-4">
            <div>
              <label class="label1">Nombre</label>
              <input type="text" wire:model.defer="nombre" class="input1">
              @error('nombre') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
  
            <div>
              <label class="label1">Slogan</label>
              <input type="text" wire:model.defer="slogan" class="input1">
              @error('slogan') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
  
            <div>
              <label class="label1">Misión</label>
              <textarea wire:model.defer="mision" class="input1"></textarea>
              @error('mision') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
  
            <div>
              <label class="label1">Visión</label>
              <textarea wire:model.defer="vision" class="input1"></textarea>
              @error('vision') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
  
            <div>
              <label class="label1">Número de Contacto</label>
              <input type="text" wire:model.defer="nroContacto" class="input1">
              @error('nroContacto') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
  
            <div>
              <label class="label1">Facebook</label>
              <input type="text" wire:model.defer="facebook" class="input1">
              @error('facebook') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
  
            <div>
              <label class="label1">Instagram</label>
              <input type="text" wire:model.defer="instagram" class="input1">
              @error('instagram') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
  
            <div>
              <label class="label1">TikTok</label>
              <input type="text" wire:model.defer="tiktok" class="input1">
              @error('tiktok') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
          </div>
  
          <div class="mt-6 flex justify-end">
            <button wire:click="actualizarEmpresa" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">Guardar Cambios</button>
          </div>
        @else
          <p class="text-center text-gray-700 dark:text-gray-300">No hay información de empresa registrada.</p>
        @endif
      </div>
    </div>
  </div>
  