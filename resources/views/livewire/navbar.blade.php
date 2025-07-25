<div class="bg-black text-white w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center h-16 items-center">
            <!-- Logo -->

            <!-- Desktop Navigation -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('shop') }}" class="text-white font-bold hover:text-yellow-400">SHOP</a>
                <a href="{{ route('sale') }}" class="text-white font-bold hover:text-yellow-400">SALE</a>

                <!-- Dropdown Menu -->
                <div class="relative group">
                    <a href="#" class="text-yellow-400 font-bold group-hover:text-yellow-300">COLLECTION</a>
                    <div class="absolute left-0 mt-2 bg-black text-white shadow-lg w-48 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-800">THE CLASSICS</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-800">MUNCHABLES</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-800">SPACE OUT</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-800">URBAN MISFITS</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-800">WALL BOUNCE</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-800">XOXO COLLECTION</a>
                    </div>
                </div>

                <a href="#" class="text-red-500 font-bold hover:text-red-400">COLLABORATION</a>
                <a href="#" class="text-white font-bold hover:text-gray-300">OUR STORY</a>
                <a href="#" class="text-white font-bold hover:text-gray-300">OUR STORES</a>
                <a href="#" class="text-white font-bold hover:text-gray-300">FAQ</a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button wire:click="toggleMenu" class="text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div class="md:hidden" x-data="{ open: @entangle('isOpen') }">
        <div x-show="open" class="bg-black text-white shadow-md">
            <a href="#" class="block px-4 py-2 text-white hover:bg-gray-800">SHOP</a>
            <a href="#" class="block px-4 py-2 text-white hover:bg-gray-800">SALE</a>
            <a href="#" class="block px-4 py-2 text-yellow-400 hover:bg-gray-800">COLLECTION</a>
            <a href="#" class="block px-4 py-2 text-red-500 hover:bg-gray-800">COLLABORATION</a>
            <a href="#" class="block px-4 py-2 text-white hover:bg-gray-800">OUR STORY</a>
            <a href="#" class="block px-4 py-2 text-white hover:bg-gray-800">OUR STORES</a>
            <a href="#" class="block px-4 py-2 text-white hover:bg-gray-800">FAQ</a>
        </div>
    </div>
</div>
