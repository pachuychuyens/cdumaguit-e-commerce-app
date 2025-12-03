<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Product;

#[Title('Product Detail - E-Commerce')]
class ProductDetailPage extends Component
{
    public $slug;
        public  function mount($slug)
            {
                $this->slug =  $slug;
            }
    public function render()
    {
        return view('livewire.product-detail-page',[
            'product' => Product::where('slug', $this->slug)->firstOrfail(),
        ]);
    }
}
