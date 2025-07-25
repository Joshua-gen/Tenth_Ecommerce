<form wire:submit.prevent="createUser">
    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">User Name</label>
    <div class="mb-6">
        <input wire:model="name" type="text" id="name" placeholder="User Name"
            class="bg-gray-100 text-gray-900 text-sm rounded block w-full p-2.5">
        @error('name') <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span> @enderror
    </div>

    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email Address</label>
    <div class="mb-6">
        <input wire:model="email" type="email" id="email" placeholder="Email Address"
            class="bg-gray-100 text-gray-900 text-sm rounded block w-full p-2.5">
        @error('email') <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span> @enderror
    </div>

    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
    <div class="mb-6">
        <input wire:model="password" type="password" id="password" placeholder="Password"
            class="bg-gray-100 text-gray-900 text-sm rounded block w-full p-2.5">
        @error('password') <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span> @enderror
    </div>

    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm Password</label>
    <div class="mb-6">
        <input wire:model="password_confirmation" type="password" id="password_confirmation" placeholder="Confirm Password"
            class="bg-gray-100 text-gray-900 text-sm rounded block w-full p-2.5">
        @error('password_confirmation') <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span> @enderror
    </div>

    <div class="mb-6">
        <label for="role" class="block mb-2 text-sm font-medium text-gray-900">User Role</label>
        <select wire:model="role" id="role"
            class="bg-gray-100 text-gray-900 text-sm rounded block w-full p-2.5">
            <option value="" disabled>Select Role</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
        @error('role') <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span> @enderror
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
