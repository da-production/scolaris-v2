<div>
    @if (session()->has('success'))
        <div class="text-green-600">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="save">
        <input type="file" wire:model="file">
        @error('file') <div class="text-red-500">{{ $message }}</div> @enderror

        <input type="text" wire:model="type" placeholder="Type du document">
        @error('type') <div class="text-red-500">{{ $message }}</div> @enderror

        <textarea wire:model="comments" placeholder="Commentaires facultatifs"></textarea>

        <button type="submit">Uploader</button>
    </form>
</div>
