<div class="max-w-full overflow-x-auto">
    <!-- Search Bar -->
    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search items..." class="border p-2 rounded mb-2">

    <table class="w-full border-collapse border border-gray-300">
        <thead> 
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Description</th>
                <th class="border px-4 py-2">Price</th>
                <th class="border px-4 py-2">Quantity</th>
                <th class="border px-4 py-2">Category</th>
                <th class="border px-4 py-2">Size</th>
                <th class="border px-4 py-2">Color</th>
                <th class="border px-4 py-2">Image</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td class="border px-4 py-2">{{ $item->id }}</td>
                    <td class="border px-4 py-2">{{ $item->name }}</td>
                    <td class="border px-4 py-2">{{ $item->description }}</td>
                    <td class="border px-4 py-2">₱{{ $item->price }}</td>
                    <td class="border px-4 py-2">{{ $item->quantity }}</td>
                    <td class="border px-4 py-2">{{ $item->category->name ?? 'No Category' }}</td>

                    <td class="border px-4 py-2">
                        @if($item->variants->isNotEmpty())
                            @php
                                $sizes = $item->variants->pluck('size.value')->filter()->unique()->join(', ');
                            @endphp
                            {{ $sizes ?: 'N/A' }}
                        @else
                            N/A
                        @endif
                    </td>
                    
                    <td class="border px-4 py-2">
                        @if($item->variants->isNotEmpty())
                            @php
                                $colors = $item->variants->pluck('color.value')->filter()->unique()->join(', ');
                            @endphp
                            {{ $colors ?: 'N/A' }}
                        @else
                            N/A
                        @endif
                    </td>
                    
    
                    <td class="border px-4 py-2">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="Item Image" class="w-16 h-16 object-cover">
                        @else
                            No Image
                        @endif
                    </td>
                    <td class="border px-4 py-2 max-w-xs truncate">
                        <button wire:click="edit({{ $item->id }})" class="px-2 py-1 bg-blue-500 text-white rounded">Edit</button>
                        <button wire:click="delete({{ $item->id }})" class="px-2 py-1 bg-red-500 text-white rounded">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="border px-4 py-2 text-center">No items found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="mt-4">
        {{ $items->links() }}
    </div>

    @if($isOpen)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-md flex justify-center items-center">
        <div class="bg-white p-4 rounded shadow-md w-[600px] max-w-[90%] max-h-[90vh] overflow-y-auto">
            <h2 class="text-lg font-bold mb-4">Edit Item</h2>
            
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Item Name</label>
            <input type="text" wire:model="name" class="w-full border p-2 rounded mb-2" placeholder="Item Name">

            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Item Description</label>
            <input type="text" wire:model="description" class="w-full border p-2 rounded mb-2" placeholder="Description">

            <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Item Price</label>
            <input type="number" wire:model="price" class="w-full border p-2 rounded mb-2" placeholder="Price">

            <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900">Item Quantity</label>
            <input type="number" wire:model="quantity" class="w-full border p-2 rounded mb-2" placeholder="Quantity">

            <div class="mb-6">
                <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                <select wire:model="category_id"  id="category_id" class="bg-gray-100 text-gray-900 text-sm rounded block w-full p-2.5">
                    <option value="" disabled selected>Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') 
                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span> 
                @enderror
            </div>

            <div class="mb-6">
                <label for="variants" class="block mb-2 text-sm font-medium text-gray-900">Variants</label>
            
                @if(is_array($variants) && count($variants) > 0)
                    @foreach ($variants as $index => $variant)
                        <div class="flex flex-col md:flex-row gap-4 mb-2 items-center w-full">
                            <div class="w-full md:w-1/3">
                                <label for="size" class="block mb-2 text-sm font-medium text-gray-900">Size</label>
                                <select wire:model="variants.{{ $index }}.size_id" class="bg-gray-100 rounded p-2.5 w-full">
                                    <option value="" disabled>Select Size</option>
                                    @foreach($sizesActive as $size)
                                        <option value="{{ $size->id }}">{{ $size->value }}</option>
                                    @endforeach
                                </select>
                            </div>
            
                            <div class="w-full md:w-1/3">
                                <label for="color" class="block mb-2 text-sm font-medium text-gray-900">Color</label>
                                <select wire:model="variants.{{ $index }}.color_id" class="bg-gray-100 rounded p-2.5 w-full">
                                    <option value="" disabled>Select Color</option>
                                    @foreach($colorsActive as $color)
                                        <option value="{{ $color->id }}">{{ $color->value }}</option>
                                    @endforeach
                                </select>
                            </div>
            
                            <div class="w-full md:w-1/3">
                                <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900">Quantity</label>
                                <input type="number" wire:model="variants.{{ $index }}.quantity" placeholder="Quantity"
                                    class="bg-gray-100 rounded p-2.5 w-full">
                            </div>
            
                            <button type="button" wire:click="removeVariant({{ $index }})"
                                class="px-2 py-1 text-white rounded mt-[22px]">
                                ❌
                            </button>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">No variants available.</p>
                @endif
            
                <div class="flex items-center gap-6">
                    <button type="button" wire:click="addVariant()" class="bg-green-500 px-2 py-1 text-white rounded">
                        + Add Variant
                    </button>
                </div>
            </div>
            
            

            <div class="mb-6">
                <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Upload Item Image</label>
                <input type="file" wire:model="image" accept="image/*" 
                    class="bg-gray-100 text-gray-900 border text-sm rounded block w-full p-2.5">
            
                @if ($image)
                    <img class="ml-2 mt-3 w-20 h-20 object-cover rounded-lg" src="{{ $image->temporaryUrl() }}">
                @elseif ($editItem && $editItem->image)
                    <img class="ml-2 mt-3 w-20 h-20 object-cover rounded-lg" src="{{ asset('storage/' . $editItem->image) }}">
                @endif
            
                <div wire:loading wire:target="image">
                    <span class="text-green-500">Uploading ...</span>
                </div>
            </div>
            
            <div class="mb-6">
                <label for="images" class="block mb-2 text-sm font-medium text-gray-900">Upload Item Images</label>
                <input multiple type="file" wire:model="images"
                    class="bg-gray-100 text-gray-900 border text-sm rounded block w-full p-2.5">
            
                @if ($images)
                    <div class="flex flex-wrap mt-3">
                        @foreach ($images as $image)
                            <img class="ml-2 mt-3 w-20 h-20 object-cover rounded-lg" src="{{ $image->temporaryUrl() }}">
                        @endforeach
                    </div>
                @elseif ($editItem && $editItem->images)
                    <div class="flex flex-wrap mt-3">
                        @foreach (json_decode($editItem->images) as $img)
                            <img class="ml-2 mt-3 w-20 h-20 object-cover rounded-lg" src="{{ asset('storage/' . $img) }}">
                        @endforeach
                    </div>
                @endif
            
                <div wire:loading wire:target="images">
                    <span class="text-green-500">Uploading ...</span>
                </div>
            </div>
            

            <button wire:click="update()" class="px-2 py-1 bg-blue-500 text-white rounded">Save</button>
            <button wire:click="closeModal()" class="px-2 py-1 bg-red-500 text-white rounded">Cancel</button>
        </div>
    </div>
    @endif
</div>
