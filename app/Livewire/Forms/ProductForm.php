<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Livewire\Form;

class ProductForm extends Form
{
    public ?Product $product;

    public string $name = '';
    public string $description = '';
    public string $price = '';
    public ?string $image = null;
    public int $category_id = 1; // Default to 1, adjust as needed

    public function setProduct(Product $product): void
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->image = $product->image;
        $this->category_id = $product->category_id;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string',
            'category_id' => 'required|exists:categories,id'
        ];
    }
}
