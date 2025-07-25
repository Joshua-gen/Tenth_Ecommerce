<div class="flex flex-col gap-4 w-full bg-gray-100 p-6 rounded-lg shadow-md">
    <div class="flex w-full h-auto">
        <button wire:click="openCreate" class="px-4 py-2 bg-black w-[200px] text-white font-semibold rounded hover:bg-gray-800">
            Create Item
        </button>
        <button wire:click="openCategory" class="px-4 py-2 bg-black w-[200px] text-white ml-4 font-semibold rounded hover:bg-gray-800">
            Add Category
        </button>
    </div>

    <div class="flex-1 bg-white p-4 rounded-lg shadow-md overflow-x-auto">
        @include('livewire.includes.item-table')
    </div>

    @if($isCreate)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-md flex justify-center items-center">
            <div class="bg-white p-4 rounded shadow-md w-[600px] max-w-[90%] max-h-[90vh] overflow-y-auto">
                <h2 class="text-lg font-bold mb-4">Create Item</h2>
                @include('livewire.includes.create-box')
            </div>
        </div>
    @endif

    @if($isCategory)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-md flex justify-center items-center">
            <div class="bg-white p-4 rounded shadow-md w-[600px] max-w-[90%] max-h-[90vh] overflow-y-auto">
                <div class="w-fill flex justify-between align-cneter">
                    <h2 class="text-lg font-bold mb-4">Create Category</h2>
                    <button wire:click="closeCategory">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                          </svg>                          
                    </button>
                </div>
                @livewire('category-list')
            </div>
        </div>
    @endif
</div>
