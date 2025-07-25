<form wire:submit.prevent="create">
    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Item Name</label>
    <div class="mb-6">
        <input wire:model="name" type="text" id="name" placeholder="Item Name"
            class="bg-gray-100 text-gray-900 text-sm rounded block w-full p-2.5">
        @error('name') <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span> @enderror
    </div>
    
    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Item Description</label>
    <div class="mb-6">
        <input wire:model="description" type="text" id="description" placeholder="Item Description"
            class="bg-gray-100 text-gray-900 text-sm rounded block w-full p-2.5">
        @error('description') <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span> @enderror
    </div>
    
    <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Item Price</label>
    <div class="mb-6">
        <input wire:model="price" type="number" id="price" placeholder="Price"
            class="bg-gray-100 text-gray-900 text-sm rounded block w-full p-2.5">
        @error('price') <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span> @enderror
    </div>
    
    <div class="mb-6" wire:poll>
        <label for="total-quantity" class="block mb-2 text-sm font-medium text-gray-900">
            Total Quantity (Auto-calculated)
        </label>
        <input type="text" id="total-quantity" value="{{ collect($variants)->sum('quantity') }}" 
            readonly class="bg-gray-200 text-gray-900 text-sm rounded block w-full p-2.5">
    </div>
    
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

        @foreach ($variants as $index => $variant)
            <div class="flex flex-col md:flex-row gap-4 mb-2 items-center w-full">
                <div class="w-full md:w-1/3">
                    <label for="size" class="block mb-2 text-sm font-medium text-gray-900">Size</label>
                    <select wire:model="variants.{{ $index }}.size_id" class="bg-gray-100 rounded p-2.5 w-full">
                        <option value="" disabled>Select Size</option>
                        @foreach($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->value }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full md:w-1/3">
                    <label for="color" class="block mb-2 text-sm font-medium text-gray-900">Color</label>
                    <select wire:model="variants.{{ $index }}.color_id" 
                        class="bg-gray-100 rounded p-2.5 w-full">
                        <option value="" disabled>Select Color</option>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->value }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="w-full md:w-1/3">
                    <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900">Quantiy</label>
                    <input type="number" wire:model="variants.{{ $index }}.quantity"  placeholder="Quantity"
                        class="bg-gray-100 rounded p-2.5 w-full">
                </div>
                
                <button type="button" wire:click="removeVariant({{ $index }})" 
                    class="px-2 py-1 text-white rounded mt-[22px]">
                    ❌
                </button>
            </div>
        @endforeach


        <div class="flex items-center gap-6">
            <button type="button" wire:click="addVariant()" class="bg-green-500 px-2 py-1 text-white rounded">
                + Add Variant
            </button>

            <div class="flex items-center gap-2">
                <input type="checkbox" wire:click="toggleAllSizes" id="toggle-all-sizes" 
                       class="cursor-pointer" 
                       @checked($sizesActive)>
                <label for="toggle-all-sizes" class="text-sm text-gray-900 cursor-pointer">
                    Turn-on sizes option
                </label>    
            </div>
            
            <div class="flex items-center gap-2">
                <input type="checkbox" wire:click="toggleAllColors" id="toggle-all-colors" 
                       class="cursor-pointer" 
                       @checked($colorsActive)>
                <label for="toggle-all-colors" class="text-sm text-gray-900 cursor-pointer">
                    Turn-on color option
                </label>
            </div>
        </div>
    </div>

    <div class="mb-6">
        <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Upload Item Image</label>
        <input type="file" wire:model="image" accept="image/*"
            class="bg-gray-100 text-gray-900 text-sm rounded block w-full p-2.5">

        @if ($image)
            <img class="ml-2 mt-3 w-20 h-20 object-cover rounded-lg" src="{{ $image->temporaryUrl() }}">
        @endif 

        @error('image') 
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror

        <div wire:loading wire:target="image">
            <span class="text-green-500">Uploading ...</span>
        </div>
    </div>

    <div class="mb-6">
        <label for="images" class="block mb-2 text-sm font-medium text-gray-900">Upload Item Images</label>
        <input multiple type="file" wire:model="images" 
            class="bg-gray-100 text-gray-900 text-sm rounded block w-full p-2.5">
    
        @if ($images)
            <div class="flex flex-wrap mt-3">
                @foreach ($images as $image)
                    <img class="ml-2 mt-3 w-20 h-20 object-cover rounded-lg" src="{{ $image->temporaryUrl() }}">
                @endforeach
            </div>
        @endif 
    
        @error('images') 
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
    
        <div wire:loading wire:target="images">
            <span class="text-green-500">Uploading ...</span>
        </div>
    </div>
    

    <button type="submit" class="px-4 py-2 bg-black text-white font-semibold rounded hover:bg-gray-800">
        Create +
    </button>
    <button wire:click="closeCreate()" class="px-4 py-2 bg-red-500 text-white font-semibold rounded hover:bg-gray-800">
        Cancel
    </button>


    
    @if (session('success'))
        <span class="text-green-500 text-xs">{{ session('success') }}</span>
    @endif
</form>
