<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoryList extends Component
{
    public $name;
    public $editCategoryId = null;
    public $isEdit = false;

    protected $rules = [
        'name' => 'required|unique:categories,name|max:50'
    ];

    // Create Category
    public function createCategory()
    {
        $this->validate();

        Category::create(['name' => $this->name]);

        $this->reset('name');
        session()->flash('success', 'Category created successfully!');
    }

    // Edit Category
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->editCategoryId = $category->id;
        $this->name = $category->name;
        $this->isEdit = true;
    }

    public function updateCategory()
    {
        $this->validate();

        $category = Category::findOrFail($this->editCategoryId);
        $category->update(['name' => $this->name]);

        $this->reset('name', 'editCategoryId', 'isEdit');
        session()->flash('success', 'Category updated successfully!');
    }

    public function cancelEdit()
    {
        $this->reset('name', 'editCategoryId', 'isEdit');
    }

    // Delete Category
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        session()->flash('success', 'Category deleted successfully!');
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.category-list', compact('categories'));
    }
}
