<div>
    @if(!$selectedItem)
        <div class="w-full h-80 mb-9 mx-auto">
            <img src="{{ asset('assets/head.jpg') }}" alt="Image Header" class="w-full h-full object-cover shadow-md">
        </div>
    @endif
    <div class="w-[95%] flex mx-auto p-2 justify-center align-center">
        @include('livewire.includes.shop-listing')
    </div>
</div>
