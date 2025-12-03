<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\Title;


#[Title('Home Page - E-commerce')]

class Homepage extends Component
{
    public function render()
    {
        $brands = Brand::where('is_active', 1)->get();
        $categories = Category::where('is_active', 1)->get(); 
        return view('livewire.home-page' ,[
            'brands' => $brands,
            'categories' => $categories
        ]);
    }
}
