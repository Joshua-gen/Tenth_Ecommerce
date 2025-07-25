<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartComponents extends Component
{
    protected $listeners = ['refreshCart' => '$refresh']; // Listen for refresh event

    public function getCartsProperty()
    {
        return Cart::with('item')->where('user_id', auth()->id())->get();
    }

    public function increaseQuantity($id)
    {
        $cart = Cart::find($id);
        if ($cart) {
            try {
                $cart->increment('quantity');
            } catch (\Exception $e) {
                \Log::error('Error incrementing quantity: ' . $e->getMessage());
                session()->flash('error', 'Failed to update quantity.');
            }
            $this->dispatch('refreshCart');
        }
    }

    public function decreaseQuantity($id)
    {
        $cart = Cart::find($id);
        if ($cart) {
            if ($cart->quantity > 1) {
                $cart->decrement('quantity');
            } else {
                $this->removeItem($id);
            }
        }
        $this->dispatch('refreshCart'); // Updated method
    }


    public function removeItem($id)
    {
        Cart::where('id', $id)->delete();
        $this->dispatch('refreshCart'); // Use dispatch() instead of emit()
    }


    public function render()
    {
        return view('livewire.cart-components', [
            'carts' => $this->getCartsProperty()
        ]);
    }
}
