<div class="p-4">
    <button wire:click="clearSelectedItem" class="">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-9 h-9 text-black">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
        </svg>                  
    </button>

    <div class="shadow-lg p-4 flex flex-col md:flex-row justify-between w-full mx-auto">
        <div class="bg-black flex items-center justify-center p-1 overflow-hidden w-full md:w-[800px] h-auto md:h-[900px]">
            @if($selectedItem->image)
                <img src="{{ asset('storage/' . $selectedItem->image) }}" alt="Item Image" class="w-full h-full object-cover">
            @endif
        </div>

        <div class="flex flex-col items-center p-4 w-full md:w-[500px] h-auto md:h-[700px] mt-4 md:mt-0">
            <div class="w-full flex">
                <div class="ml-4">
                    <img src="{{ asset('assets/logo.png') }}" alt="Image Header" class="w-[150px] h-[150px]">
                </div>
                <div class="ml-6">
                    <h1 class="mt-3 text-4xl font-bold">{{ $selectedItem->name }}</h1>
                    <h2 class="mt-3 text-3xl font-bold">₱{{ number_format($selectedItem->price, 2) }}</h2>
                </div>
            </div>

            <div class="flex items-center w-full h-auto">
                <img src="{{ asset('assets/feee.png') }}" alt="free" class="cover">
            </div>

            <div class="p-3 w-full mt-9">
                <h1 class="text-xl">{{ $selectedItem->description }}</h1>
            </div>

            <div class="mt-4 p-3 w-full h-auto">
                <h1 class="text-2xl font-bold">Quantity</h1>
                <div class="flex items-center mt-2">
                    <button wire:click="decrementQuantity" 
                        class="group px-2 py-1 bg-black border-2 border-black hover:bg-yellow-500 hover:border-black">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                            stroke-width="1.5" stroke="currentColor" 
                            class="w-9 h-9 text-yellow-500 group-hover:text-black">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                        </svg>                               
                    </button>
                    
                    <input type="number" min="1" wire:model="quantity" class="w-16 text-center text-lg border-2 border-black mx-2 no-spinner">
                    
                    <button wire:click="incrementQuantity" 
                        class="group px-2 py-1 bg-black border-2 border-black hover:bg-yellow-500 hover:border-black">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                            stroke-width="1.5" stroke="currentColor" 
                            class="w-9 h-9 text-yellow-500 group-hover:text-black">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg> 
                    </button>
                </div>
            </div>

            @if($selectedItem->variants->pluck('size.value')->filter()->unique()->isNotEmpty())
                <div class="p-3 w-full mt-4">
                    <h1 class="text-2xl font-bold">Select Size</h1>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($selectedItem->variants->pluck('size.value')->filter()->unique() as $size)
                        <div 
                            wire:click="setSelectedSize('{{ $size }}')"
                            class="px-4 py-2 cursor-pointer border-2 
                                {{ $selectedSize === $size 
                                    ? 'border-black bg-yellow-500 text-black font-bold' 
                                    : 'border-black bg-black text-yellow-500 font-bold hover:border-black hover:bg-yellow-500 hover:text-black' }}">
                            {{ $size }}
                        </div>
                    
                        @endforeach
                    </div>
                </div>
            @endif

            @if($selectedItem->variants->pluck('color.value')->filter()->unique()->isNotEmpty())
                <div class="p-3 w-full mt-4">
                    <h1 class="text-2xl font-bold">Select Color</h1>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($selectedItem->variants->pluck('color.value')->filter()->unique() as $color)
                            <div 
                                wire:click="setSelectedColor('{{ $color }}')"
                                class="px-4 py-2 border-2 cursor-pointer 
                                    {{ $selectedColor === $color 
                                        ? 'border-black bg-yellow-500 text-black font-bold' 
                                        : 'border-black bg-black text-yellow-500 font-bold hover:border-black hover:bg-yellow-500 hover:text-black' }}">
                                    {{ $color }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif


            <div x-data="{ animate: false }" class="relative w-full">
                <button type="button"
                    wire:click="addToCart({{ $selectedItem->id }})"
                    @click="animate = true; setTimeout(() => animate = false, 800)"
                    class="mt-3 px-4 py-2 bg-red-500 w-full text-white text-xl rounded-2xl hover:scale-95 transition-all duration-200">
                    Add to Cart
                </button>

                <!-- Floating Animation Element -->
                <div x-show="animate" x-transition
                    class="absolute left-1/2 top-0 w-10 h-10 bg-black text-white flex items-center justify-center rounded-full"
                    :class="animate ? 'animate-throw' : ''">
                    🛒
                </div>

                @if (session()->has('error'))
                    <div class="bg-red-200 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
                @endif

                @if (session()->has('success'))
                    <div class="bg-green-200 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
                @endif

            </div>
        </div>
    </div>
</div>

<!-- Animation Styles -->
<style>
    @keyframes throwToCart {
        0% { transform: translate(0, 0) scale(1); opacity: 1; }
        50% { transform: translate(150px, -200px) scale(1.3); opacity: 0.7; }
        100% { transform: translate(250px, -500px) scale(0); opacity: 0; }
    }

    .animate-throw {
        animation: throwToCart 0.8s ease-in-out forwards;
    }

    input.no-spinner::-webkit-inner-spin-button,
    input.no-spinner::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input.no-spinner {
        -moz-appearance: textfield;
    }
</style>
