<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\Cart;
use App\Models\Category;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\Auth;

class ItemShop extends Component
{
    public $items = [];
    public $selectedItem = null;
    public $quantity = 1;
    public $cartCount = 0;
    public $selectedSize = null;
    public $selectedColor = null;
    public $categories = [];  // 🔹 Added: Stores category list
    public $selectedCategories = []; // Array for multiple categories
    public $minPrice;
    public $maxPrice;
    public $showFilters = false;
    protected $updatesQueryString = ['selectedCategories', 'minPrice', 'maxPrice'];
    public $isOpen = false;
    public $isSearch = false;
    public $search = '';
    public $searchResults = [];


    protected $listeners = [
        'openSearch'
    ];

    public function closeSearch()
    {
        $this->isSearch = false;
    }

    public function openSearch()
    {
        $this->isSearch = true;
    }

    public function updateSearch($search)
    {
        $this->search = $search;
        $this->fetchItems();
    }

    public function updated($propertyName)
    {
        $this->fetchItems();
    }
    
    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    // -----------------------------
    

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    //search 
    public function updatedSearch()
    {
        if (!empty($this->search)) {
            $this->searchResults = Item::where('name', 'like', '%' . $this->search . '%')->get();
        } else {
            $this->searchResults = [];
        }
    }

    //-------------------------------

    public function mount()
    {
        $this->categories = Category::pluck('name', 'id')->toArray();  // 🔹 Added: Fetch categories
        $this->fetchItems();  // 🔹 Changed: Call fetchItems() instead of fetching all items
        $this->updateCartCount();
    }

    public function fetchItems()
    {
        $query = Item::with(['variants.size', 'variants.color']);

        // 🔹 Filter by selected categories (array of checked category IDs)
        if (!empty($this->selectedCategories)) {
            $query->whereIn('category_id', $this->selectedCategories);
        }

        // 🔹 Filter by price range
        if (!is_null($this->minPrice)) {
            $query->where('price', '>=', $this->minPrice);
        }
        if (!is_null($this->maxPrice)) {
            $query->where('price', '<=', $this->maxPrice);
        }

        $this->items = $query->get();
    }


    public function selectItem($id)
    {
        $this->selectedItem = Item::with(['variants.size', 'variants.color'])->find($id);
        $this->closeSearch();
    }
    
    public function clearSelectedItem()
    {
        $this->selectedItem = null;
    }


    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function updateCartCount()
    {
        $this->cartCount = Cart::where('user_id', auth()->id())->count();
    }

    public function setSelectedSize($size)
    {
        $this->selectedSize = $size;
    }

    public function setSelectedColor($color)
    {
        $this->selectedColor = $color;
    }

    public function addToCart($itemId)
    {
        $user = Auth::user();

        if (!$user) {
            session()->flash('error', 'You need to log in first.');
            return;
        }

        $item = Item::find($itemId);

        // Check if the item has size variants and ensure selection
        if ($item->variants->pluck('size.value')->filter()->unique()->isNotEmpty() && !$this->selectedSize) {
            session()->flash('error', 'Please select a size.');
            return;
        }

        // Check if the item has color variants and ensure selection
        if ($item->variants->pluck('color.value')->filter()->unique()->isNotEmpty() && !$this->selectedColor) {
            session()->flash('error', 'Please select a color.');
            return;
        }

        $sizeId = $this->selectedSize 
            ? AttributeValue::where('value', $this->selectedSize)
                            ->where('attribute_id', 1)
                            ->value('id')
            : null;

        $colorId = $this->selectedColor 
            ? AttributeValue::where('value', $this->selectedColor)
                            ->where('attribute_id', 2)
                            ->value('id')
            : null;

        $existingItem = Cart::where('user_id', $user->id)
                            ->where('item_id', $itemId)
                            ->when($sizeId, fn($query) => $query->where('size_id', $sizeId))
                            ->when($colorId, fn($query) => $query->where('color_id', $colorId))
                            ->when(!$sizeId, fn($query) => $query->whereNull('size_id'))
                            ->when(!$colorId, fn($query) => $query->whereNull('color_id'))
                            ->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $this->quantity);
        } else {
            Cart::create([
                'user_id' => $user->id,
                'item_id' => $itemId,
                'quantity' => $this->quantity,
                'size_id' => $sizeId,
                'color_id' => $colorId
            ]);
        }

        session()->flash('success', 'Item added to cart!');
    }



    public function render()
    {
        return view('livewire.item-shop', [
            'items' => $this->items,
            'searchResults' => $this->searchResults,
            'categories' => $this->categories,
        ]);
    }
}
