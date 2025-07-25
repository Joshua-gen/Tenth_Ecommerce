<div class="max-w-full overflow-x-auto">
    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search users..." class="border p-2 rounded mb-2">

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td class="border px-4 py-2">{{ $user->id }}</td>
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>
                    <td class="border px-4 py-2">
                        <button wire:click="openModal({{ $user->id }})" class="px-2 py-1 bg-blue-500 text-white rounded">Edit</button>
                        <button wire:click="delete({{ $user->id }})" class="px-2 py-1 bg-red-500 text-white rounded">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="border px-4 py-2 text-center">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="mt-4">
        {{ $users->links() }}
    </div>

    @if($isOpen)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-md flex justify-center items-center">
            <div class="bg-white p-4 rounded shadow-md w-[300px] max-w-[90%]">
                <h2 class="text-lg font-bold mb-4">Edit User</h2>

                <input type="text" wire:model="name" class="w-full border p-2 rounded mb-2" placeholder="Name">
                <input type="email" wire:model="email" class="w-full border p-2 rounded mb-2" placeholder="Email">

                <button wire:click="update()" class="px-2 py-1 bg-blue-500 text-white rounded">Save</button>
                <button wire:click="closeModal()" class="px-2 py-1 bg-red-500 text-white rounded">Cancel</button>
            </div>
        </div>
    @endif
</div>
