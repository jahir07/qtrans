<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;
use Illuminate\Support\Facades\Auth;

class CartComponent extends Component
{
   
    public function render()
    {
        $this->setAmountForCheckout();
        return view('livewire.cart-component')->layout("layouts.base");
    }
    
    public function increaseQyt($rowId)
    {
        $product = Cart::get($rowId);
        $qty= $product->qty + 1;
        Cart::update($rowId,$qty);
    }

    public function decreaseQyt($rowId)
    {
        $product = Cart::get($rowId);
        $qty= $product->qty - 1;
        Cart::update($rowId,$qty);
    }

    public function deleteItem($rowId)
    {
        Cart::remove($rowId);
        return redirect()->back()->with('success_message', 'Product Remove from cart');
    }

    public function checkout()
    {
        if (Auth::check())
        {
            return redirect()->to('/checkout');
        }
        else {
            return redirect()->route('login');
        }
    }

    public function setAmountForCheckout()
    {
        if( !Cart::count() > 0 )
        {
            session()->forget('checkout');
            return;
        }
        $subtotal = str_replace(',', '', Cart::subtotal());
        $tax = str_replace(',', '', Cart::tax());
        $total = str_replace(',', '', Cart::total());
        session()->put('checkout', [
            'subtotal'  => $subtotal,
            'tax'  => $tax,
            'total'  => $total
        ]);
    }

    
}
