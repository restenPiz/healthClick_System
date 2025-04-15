<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class Categories extends Component
{
    public $data, $category, $category_name, $id, $selectedCategoryId;
    public function render()
    {
        return view('livewire.categories', [
            'categories' => Category::all()
        ])->layout('layouts.app');
    }
    public function save()
    {
        // dd($this->all());
        $data = $this->validate([
            //?User Data
            'category_name' => 'required|string|max:255',
        ]);

        Category::create([
            'category_name' => $this->category_name,
        ]);

        $this->reset([
            'category_name',
        ]);

        $this->dispatch('category-added');
    }
    public function deleteCategory()
    {
        $category = Category::find($this->selectedCategoryId);
        $category->delete();

        $this->reset('id', 'category_name');
        $this->dispatch('close-modal', 'confirm-user-deletion');
        $this->dispatch('category-deleted');
    }
    //?Method to open the modal
    public function confirmDeletion($id)
    {
        $this->selectedCategoryId = $id;
    }
    //?Method to open de edit modal
    public $editCategory = [
        'id' => null,
        'category_name' => '',
    ];
    public function setCategoryToEdit($id)
    {
        $category = Category::findOrFail($id);
        $this->editCategory = [
            'id' => $category->id,
            'category_name' => $category->category_name,
        ];
    }
    public function updateCategory()
    {
        $this->validate([
            'editCategory.category_name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($this->editCategory['id']);
        $category->update($this->editCategory);

        $this->reset([
            'category_name',
            'id',
        ]);

        $this->dispatch('close-modal', 'edit-pharmacy-modal');
        $this->dispatch('category-updated');
    }
}
