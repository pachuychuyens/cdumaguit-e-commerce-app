<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Product;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert as SweetAlert;
use App\Helpers\CartManagement;


#[Title('Product Detail - E-Commerce')]
class ProductDetailPage extends Component
{
    public $slug;
    public$quantity = 1;

        public  function mount($slug)
            {
                $this->slug =  $slug;
            }

        public function increaseQty()
        {
            $this->quantity++;
        }
        public function decreaseQty()
        {
            if($this->quantity > 1)
            {
                $this->quantity--;
            }
        }

    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id);
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

    $alert = new SweetAlert($this);

    $alert
        ->success()
        ->title('Success!')
        ->text('Product added to the cart successfully!')
        ->toast()
        ->position('bottom-end')
        ->timer(3000)
        ->show();

    }
    public function render()
    {
        return view('livewire.product-detail-page',[
            'product' => Product::where('slug', $this->slug)->firstOrfail(),
        ]);
    }
}
