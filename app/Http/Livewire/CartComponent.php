<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;

class CartComponent extends Component
{
    // update cart for increase quantity
    public function increaseQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        // shor cart button 
        $this->emitTo('cart-icon-component', 'refreshComponent');
    }

    // update cart for decrease quantity
    public function decreaseQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        $this->emitTo('cart-icon-component', 'refreshComponent');
    }

    // delete product from the cart
    public function destroy($id)
    {

        Cart::instance('cart')->remove($id);
        session()->flash('success_message', 'item has been removed!');
        $this->emitTo('cart-icon-component', 'refreshComponent');
    }

    // clear product from the cart
    public function clearAll()
    {

        Cart::instance('cart')->destroy();
        // session()->flash('success_message','item has been removed!');
        $this->emitTo('cart-icon-component', 'refreshComponent');
    }

    public function render()
    {
        return view('livewire.cart-component');
    }
}
