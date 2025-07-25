<div class="max-w-lg mx-auto p-4 bg-white shadow-md rounded-md">
    <!-- Create Category -->
    <form wire:submit.prevent="createCategory" class="mb-4 space-y-3">
        <input 
            type="text" 
            wire:model="name" 
            placeholder="Category Name"
            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <button 
            type="submit"
            class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition"
        >
            Create Category
        </button>
    </form>

    <!-- Category List -->
    <ul class="space-y-2">
        @foreach($categories as $category)
            <li class="flex justify-between items-center p-2 bg-gray-100 rounded-md">
                <span class="text-gray-800 font-medium">{{ $category->name }}</span>

                <div class="space-x-2">
                    <!-- Edit Button -->
                    <button 
                        wire:click="edit({{ $category->id }})" 
                        class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                    >
                        Edit
                    </button>

                    <!-- Delete Button -->
                    <button 
                        wire:click="delete({{ $category->id }})"
                        onclick="return confirm('Are you sure?')"
                        class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600"
                    >
                        Delete
                    </button>
                </div>
            </li>
        @endforeach
    </ul>

    <!-- Edit Form -->
    @if($isEdit)
        <div class="mt-4 p-4 bg-blue-100 border-l-4 border-blue-500 rounded-md">
            <form wire:submit.prevent="updateCategory" class="space-y-3">
                <input 
                    type="text" 
                    wire:model="name" 
                    placeholder="Edit Category Name"
                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                />
                <div class="flex justify-end space-x-2">
                    <button 
                        type="submit"
                        class="px-4 py-2 bg-black text-white rounded-md hover:bg-grey-300"
                    >
                        Update
                    </button>
                    <button 
                        wire:click="cancelEdit"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
