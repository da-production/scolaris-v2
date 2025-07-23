<div>
    @error('rateErrorMessage')
        <div  x-data="{ duration: @entangle('rateDuration') }" x-init="let timer = setInterval(() => {
                if (duration <= 0) {
                    $wire.resetRateLimiter();
                    clearInterval(timer);
                } else {
                    duration--;
                }
            }, 1000);" class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded relative mt-5" role="alert">
            <strong class="font-bold">Attention !</strong>
            <span class="block sm:inline">{{ $message }} Réessayez dans <span x-text="duration > 0 ? duration : 'Temps écoulé !'"></span> secondes</span>
        </div>
    @enderror
    @if ($rateTentatives > 0)
        <div class="bg-gray-100 border border-gray-400  px-4 py-3 rounded relative text-sm text-gray-600 mt-2"
            id="countdown" >
            Tentatives : {{ $rateTentatives }} / 10 <br>
        </div>
    @endif
</div>
