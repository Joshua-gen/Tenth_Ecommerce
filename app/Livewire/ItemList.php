<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class ItemList extends Component
    {
    use WithPagination, WithFileUploads;

    public $editItem, $name, $description, $price, $quantity, $image;
    public $images = [];
    public $search = '';
    public $category_id = null;
    public $selectedAttributes = [];
    public $variants = [];
    public $sizesActive;
    public $colorsActive;

    public function addVariant()
    {
        $this->variants[] = [
            'size_id' => null,
            'color_id' => null,
            'quantity' => 1,
        ];
    }

    // Modal states
    public $isOpen = false, $isCreate = false, $isCategory = false;

    public function closeCategory() { $this->isCategory = false; }
    public function openCategory() { $this->isCategory = true; }
    public function closeCreate() { 
        $this->isCreate = false; 
        $this->reset('name', 'description', 'price', 'category_id', 'image', 'images', 'variants');
    }
    public function openCreate() { $this->isCreate = true; }

    protected $rules = [
        'name' => 'required|min:3|max:50',
        'description' => 'required|min:3|max:255',
        'price' => 'required|numeric|min:1',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|max:2048',
        'images.*' => ['required', 'image', 'max:2048'],
        'selectedAttributes' => 'nullable|array',
    ];

    public function removeVariant($index)
    {
        unset($this->variants[$index]);
        $this->variants = array_values($this->variants); // Reindex array
    }


    public function mount()
    {
        $this->sizesActive = Attribute::where('name', 'Size')->value('is_active');
        $this->colorsActive = Attribute::where('name', 'Color')->value('is_active');

        $sizeAttribute = Attribute::where('name', 'Size')->first();
        if ($sizeAttribute && $sizeAttribute->is_active) {
            $this->sizesActive = AttributeValue::whereHas('attribute', function ($q) {
                $q->where('name', 'Size');
            })->get();
        } else {
            $this->sizesActive = collect(); // Empty collection if not active
        }

        // Check if Color attribute is active
        $colorAttribute = Attribute::where('name', 'Color')->first();
        if ($colorAttribute && $colorAttribute->is_active) {
            $this->colorsActive = AttributeValue::whereHas('attribute', function ($q) {
                $q->where('name', 'Color');
            })->get();
        } else {
            $this->colorsActive = collect(); // Empty collection if not active
        }
    }

    public function toggleAllSizes()
    {
        Attribute::where('name', 'Size')->update([
            'is_active' => DB::raw('NOT is_active')
        ]);

        $this->sizesActive = !$this->sizesActive; // Update Livewire state
    }

    public function toggleAllColors()
    {
        Attribute::where('name', 'Color')->update([
            'is_active' => DB::raw('NOT is_active')
        ]);

        $this->colorsActive = !$this->colorsActive; // Update Livewire state
    }
    
    public function create()
    {
        $this->validate();
        $imagePath = $this->image ? $this->image->store('items', 'public') : null;

        $imagePaths = array_map(fn($img) => $img->store('items', 'public'), $this->images ?? []);

        // Calculate total quantity
        $totalQuantity = array_sum(array_column($this->variants, 'quantity'));

        $item = Item::create([
            'category_id' => $this->category_id,
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $totalQuantity,
            'price' => $this->price,
            'image' => $imagePath,
            'images' => json_encode($imagePaths),
        ]);

        foreach ($this->variants as $variant) {
            $item->variants()->create([
                'size_id' => $variant['size_id'],
                'color_id' => $variant['color_id'],
                'quantity' => $variant['quantity'],
            ]);
        }

        $this->reset('name', 'description', 'price', 'category_id', 'image', 'images', 'variants');
        session()->flash('success', 'Created successfully.');
        $this->isCreate = false;
    }

    public function delete($itemID)
    {
        try {
            Item::findOrFail($itemID)->delete();
        } catch (Exception $e) {
            session()->flash('error', 'Failed to delete.');
        }
    }

    public function cancelEdit()
    {
        $this->reset('editingitemID');
    }

    public function edit($id)
    {
        $this->editItem = Item::with(['variants.size', 'variants.color'])->findOrFail($id);
        
        $this->name = $this->editItem->name;
        $this->description = $this->editItem->description;
        $this->price = $this->editItem->price;
        $this->quantity = $this->editItem->quantity;
        $this->category_id = $this->editItem->category_id;

        // Load variants (sizes & colors)
        $this->variants = $this->editItem->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'size_id' => $variant->size_id,
                'color_id' => $variant->color_id,
                'quantity' => $variant->quantity,
            ];
        })->toArray();

        $this->isOpen = true;
    }


    public function update()
    {
        if (!$this->editItem) {
            session()->flash('error', 'No item selected for update.');
            return;
        }

        $this->validate([
            'name' => 'required|min:3|max:50',
            'description' => 'required|min:3|max:255',
            'price' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () {
            if ($this->image) {
                $imagePath = $this->image->store('items', 'public');
                $this->editItem->update(['image' => $imagePath]);
            }

            if (!empty($this->images)) {
                $imagePaths = array_map(fn($img) => $img->store('items', 'public'), $this->images);
                $this->editItem->update(['images' => json_encode($imagePaths)]);
            }

            // Calculate total quantity from variants
            $totalQuantity = array_sum(array_column($this->variants, 'quantity'));

            // Update the item
            $this->editItem->update([
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'quantity' => $totalQuantity, // Update quantity based on variants
                'category_id' => $this->category_id,
            ]);

            // Update or create variants
            foreach ($this->variants as $variant) {
                if (!empty($variant['id'])) {
                    \App\Models\ItemVariant::where('id', $variant['id'])->update([
                        'size_id' => $variant['size_id'],
                        'color_id' => $variant['color_id'],
                        'quantity' => $variant['quantity'],
                    ]);
                } else {
                    $this->editItem->variants()->create([
                        'size_id' => $variant['size_id'],
                        'color_id' => $variant['color_id'],
                        'quantity' => $variant['quantity'],
                    ]);
                }
            }
        });

        session()->flash('success', 'Item updated successfully.');
        $this->closeModal();
    }




    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        $items = Item::with(['category', 'variants.size', 'variants.color'])
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $categories = Category::all();

        $sizes = AttributeValue::whereHas('attribute', function ($query) {
            $query->where('name', 'Size')->where('is_active', true);
        })->get();

        $colors = AttributeValue::whereHas('attribute', function ($query) {
            $query->where('name', 'Color')->where('is_active', true);
        })->get();

        $attributes = Attribute::with('values')->get();

        return view('livewire.item-list', compact('items', 'categories', 'sizes', 'colors', 'attributes'));
    }
}
