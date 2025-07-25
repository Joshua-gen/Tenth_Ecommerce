<div class="flex flex-col gap-4 w-full bg-gray-100 p-6 rounded-lg shadow-md">
    <button wire:click="openCreate()" class="px-4 py-2 bg-black w-[200px] text-white font-semibold rounded hover:bg-gray-800">create</button>
    <div class="flex-1 bg-white p-4 rounded-lg shadow-md overflow-x-auto">
       @include('livewire.includes.user-table')
    </div>

    @if($isUser)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-md flex justify-center items-center">
            <div class="bg-white p-4 rounded shadow-md w-[600px] max-w-[90%] max-h-[90vh] overflow-y-auto">
                <h2 class="text-lg font-bold mb-4">Create User</h2>
                @include('livewire.includes.create-user')
            </div>
        </div>
    @endif
</div>
