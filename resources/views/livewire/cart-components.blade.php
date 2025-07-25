<div class="p-4">
    @foreach ($this->carts as $cart)
        @if($cart->item)
        <div class="flex items-center justify-between bg-white shadow-md rounded-lg p-4 mb-3 gap-x-4" wire:key="cart-{{ $cart->id }}">
                @if($cart->item->image)
                    <img src="{{ asset('storage/' . $cart->item->image) }}" alt="Item Image" class="w-9 h-9 object-cover">
                @endif
                <div>
                    <h2 class="text-lg font-semibold">{{ $cart->item->name }}</h2>
                    <p class="text-gray-500 text-sm">
                        @if($cart->color)
                            Color: {{ $cart->color['value'] }}
                        @endif

                        @if($cart->size)
                            | Size: {{ $cart->size['value'] }}
                        @endif
                    </p>
                    <p class="text-gray-500">₱{{ number_format($cart->item->price, 2) }} each</p>
                </div>
                
                <div class="flex items-center space-x-3">
                    @if ($cart->quantity > 1)
                        <button wire:click.prevent="decreaseQuantity({{ $cart->id }})" class="px-2 py-1 bg-gray-200 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                            </svg>                               
                        </button>
                    @else
                        <button wire:click.prevent="removeItem({{ $cart->id }})" class="px-2 py-1 bg-red-500 text-white rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>                           
                        </button>
                    @endif
                
                    <span class="text-lg font-semibold w-8 text-center" style="width: 30px">{{ $cart->quantity }}</span>

                    <button wire:click.prevent="increaseQuantity({{ $cart->id }})" class="px-2 py-1 bg-gray-200 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg> 
                    </button>
                </div>
                
            </div>
        @else
            <div class="p-4 bg-white shadow-md rounded-lg mb-3">
                <p class="text-red-500 font-semibold">Item Not Found</p>
            </div>
        @endif
    @endforeach
</div>
