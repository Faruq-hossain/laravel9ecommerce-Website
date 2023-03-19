<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;

class CategoryComponent extends Component
{
    use WithPagination;

    // shop er show product add
    public $pageSize = 12;

    // short product
    public $orderBy = "Default Shorting";

    // category component
    public $slug;

    public function store($product_id, $product_name, $product_price)
    {
        Cart::add($product_id, $product_name, 1, $product_price)->associate('\App\Models\Product');
        session()->flash('success_message', 'Item Added in Cart');
        return redirect()->route('shop.cart');
    }

    // chenge page size
    public function changePageSize($size)
    {
        $this->pageSize = $size;
    }

    // short product
    public function changeOrderBy($order)
    {
        $this->orderBy = $order;
    }
    // category component
    public function mount($slug)
    {
        $this->slug = $slug;
    }
    public function render()
    {
        // category component
        $category = Category::where('slug',$this->slug)->first();
        $category_id = $category->id;
        $category_name = $category->name;
        // short product
        if ($this->orderBy == 'Price: Low to High') {
            $products = Product::where('category_id',$category_id)->orderBy('regular_price', 'ASC')->paginate($this->pageSize);
        } else if ($this->orderBy == 'Price: High to Low') {
            $products = Product::where('category_id',$category_id)->orderBy('regular_price', 'DESC')->paginate($this->pageSize);
        } else if ($this->orderBy == 'Sort By Newness') {
            $products = Product::where('category_id',$category_id)->orderBy('created_at', 'DESC')->paginate($this->pageSize);
        } else {
            $products = Product::where('category_id',$category_id)->paginate($this->pageSize);
        }
        // show all categories
        $categories = Category::orderBy('name', 'ASC')->get();

        return view('livewire.category-component', ['products' => $products, 'categories' => $categories,'category_name' => $category_name]);
    }
}
