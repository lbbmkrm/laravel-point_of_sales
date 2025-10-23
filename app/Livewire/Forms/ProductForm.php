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

    public function setProduct(Product $product): void
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->image = $product->image;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string', // Later, this could be 'image|max:1024' for file uploads
        ];
    }

    public function store(): void
    {
        $this->validate();

        Product::create($this->all());
    }

    public function update(): void
    {
        $this->validate();

        $this->product->update($this->all());
    }
}
