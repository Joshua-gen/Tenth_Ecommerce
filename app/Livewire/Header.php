<?php

namespace App\Livewire;
use App\Livewire\Actions\Logout;
use App\Models\Item;
use App\Models\Cart;

use Livewire\Component;

class Header extends Component
{
    public $cartCount = 0;
    public $isOpen = false;

    public function openSearch()
    {
        $this->dispatch('openSearch'); // Livewire 3 uses `dispatch()`, not `emit()`
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function openModal()
    {
        $this->isOpen = true;
    }
    //-------------------------------

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function mount()
    {
        $this->items = Item::with(['variants.size', 'variants.color'])->get();
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        $this->cartCount = Cart::where('user_id', auth()->id())->count();
    }

    public function render()
    {
        return view('livewire.header');
    }
}
