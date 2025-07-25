<div>
    @if($selectedItem)
        <div>
            @include('livewire.includes.item-fullinfo')
        </div>
    @else
        <div class="w-full">
            <div class="w-full flex justify-between align-center mb-2">
                <button wire:click="toggleFilters" class="flex items-center justify-between w-[100px]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-[25px] h-[25px] mr-2" fill="currentColor">
                        <path d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                    </svg>    
                    Filter
                    
                    <div class="w-[25px] h-[25px] ml-4">
                        @if ($showFilters)
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-full h-full" wire:loading.remove wire:target="toggleFilters">
                                <path fill-rule="evenodd" d="M7.72 12.53a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 1 1 1.06 1.06L9.31 12l6.97 6.97a.75.75 0 1 1-1.06 1.06l-7.5-7.5Z" clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-full h-full" wire:loading.remove wire:target="toggleFilters">
                                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                </button>
                     
                <h1>100 pruducts</h1>
        
                <button>date</button>
            </div>

            <div class="flex">
                <div>
                    <!-- Filter Section -->
                    @if($showFilters)
                        <div class="p-4">
                            <h2 class="font-bold mb-2">Filter by Category</h2>
                            @foreach($categories as $id => $name)
                                <label class="block">
                                    <input type="checkbox" wire:model="selectedCategories" value="{{ $id }}"> {{ $name }}
                                </label>
                            @endforeach
                
                            <h2 class="font-bold mt-4">Filter by Price</h2>
                            <div class="flex gap-2">
                                <input type="number" wire:model="minPrice" placeholder="Min Price" class="border p-2 w-full">
                                <input type="number" wire:model="maxPrice" placeholder="Max Price" class="border p-2 w-full">
                            </div>
                        </div>
                    @endif
                </div>                
                <div wire:poll.500ms="fetchItems" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($items as $item)
                        <div wire:click="selectItem({{ $item->id }})" class="group cursor-pointer bg-black shadow-lg hover:shadow-[10px_10px_0px_black] transition-shadow p-1 flex flex-col align-center justify-center min-h-[200px] max-h-[400px] min-w-[200px] max-w-[350px] w-full">
                            <div class="relative h-64 sm:h-72 md:h-80 bg-gray-200 flex items-center justify-center overflow-hidden">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="Item Image" class="w-full h-full object-cover">
                                @endif
                                @if($item->images)
                                    @php $hoverImages = json_decode($item->images); @endphp
                                    @if(!empty($hoverImages))
                                        <img src="{{ asset('storage/' . $hoverImages[0]) }}" alt="Hover Image" class="w-full h-full object-cover absolute top-0 left-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    @endif
                                @endif
                            </div>
                            <h1 class="mt-3 text-lg font-bold text-white self-center">{{ $item->name }}</h1>
                            <h2 class="mt-3 text-lg font-semibold self-center text-green-600">₱{{ number_format($item->price, 2) }}</h2>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if($isSearch)
        <div class="fixed inset-0 flex justify-end bg-black bg-opacity-80 z-50"> 
            <div class="bg-white p-5 w-full shadow-lg relative flex flex-col
                min-h-[22vh] max-h-auto overflow-auto transition-all duration-300"
                style="{{ !empty($searchResults) ? 'height: auto;' : 'height: 22vh;' }}">
                <div class="flex items-center mt-9 justify-between w-full px-4 md:px-8">
                    <div></div>
                
                    <div class="relative w-full max-w-[600px]">
                        <input type="text" wire:model.debounce.500ms="search" 
                            placeholder="Search items..." 
                            class="form-control px-4 py-2 w-full h-[50px] md:h-[60px] shadow-[3px_3px_0px_white,7px_7px_0px_black] 
                            placeholder-black placeholder:text-lg rounded-sm border-2 border-black text-black pr-12"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                            class="w-6 h-6 text-black absolute right-4 top-1/2 transform -translate-y-1/2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                
                    <button wire:click="closeSearch" class="p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-black">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>  
                    </button>
                </div>
                

                <div class="mt-9">
                    @if(!empty($searchResults))
                    <div wire:poll.2s class="flex flex-wrap justify-center items-center gap-4 mt-4">
                            @foreach($searchResults as $item)
                                <div wire:click="selectItem({{ $item->id }})" 
                                    class="group cursor-pointer bg-black shadow-lg hover:shadow-[10px_10px_0px_black] transition-shadow p-1 flex flex-col align-center justify-center min-h-[150px] max-h-[350px] min-w-[150px] max-w-[300px] w-full">
                                    
                                    <div class="relative h-64 sm:h-72 md:h-80 bg-gray-200 flex items-center justify-center overflow-hidden">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="Item Image" class="w-full h-full object-cover">
                                        @endif
                                        @if($item->images)
                                            @php $hoverImages = json_decode($item->images); @endphp
                                            @if(!empty($hoverImages))
                                                <img src="{{ asset('storage/' . $hoverImages[0]) }}" alt="Hover Image" 
                                                    class="w-full h-full object-cover absolute top-0 left-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            @endif
                                        @endif
                                    </div>

                                    <h1 class="mt-3 text-lg font-bold text-white self-center">{{ $item->name }}</h1>
                                    <h2 class="mt-3 text-lg font-semibold self-center text-green-600">
                                        ₱{{ number_format($item->price, 2) }}
                                    </h2>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>

            </div>  
        </div>
    @endif
</div>



