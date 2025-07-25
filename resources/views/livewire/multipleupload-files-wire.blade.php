<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    @foreach ($files as $key => $value)
        <div class="mb-4">
            <label for="file_upload" class="block text-sm font-medium text-gray-700 mb-2">
                Sélectionner {{ $value }}
            </label>
            
            <input 
                type="file" 
                id="file_upload" 
                wire:model.change="file.{!! $key !!}"
                class="block w-full text-sm text-gray-900 border border-gray-300 p-4 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
        </div>
    @endforeach
    
</div>
