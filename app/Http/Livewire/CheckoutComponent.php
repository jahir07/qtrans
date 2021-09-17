<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Cart;
use Stripe;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
// use Srmklive\PayPal\Services\ExpressCheckout;
use Omnipay\Omnipay;


class CheckoutComponent extends Component
{
    public $ship_to_different_address;

    public $firstname;
    public $lastname;
    public $email;
    public $mobile;
    public $address;
    public $country;
    public $zip;
    public $city;

    public $s_firstname;
    public $s_lastname;
    public $s_email;
    public $s_mobile;
    public $s_address;
    public $s_country;
    public $s_zip;
    public $s_city;

    public $payment_mode;
    public $card_no;
    public $exp_month;
    public $exp_year;
    public $cvc;

    public $thankyou;
    public $gateway;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'address' => 'required',
            'country' => 'required',
            'zip' => 'required',
            'city' => 'required',
            'payment_mode'=> 'required'
        ]);

        if($this->ship_to_different_address)
        {
            $this->validateOnly($fields, [
                's_firstname' => 'required',
                's_lastname' => 'required',
                's_email' => 'required|email',
                's_mobile' => 'required|numeric',
                's_address' => 'required',
                's_country' => 'required',
                's_zip' => 'required',
                's_city' => 'required'
            ]);
        }

        if($this->payment_mode == 'card')
        {
            $this->validateOnly($fields, [
                'card_no' => 'required|numeric',
                'exp_month' => 'required|numeric',
                'exp_year' => 'required|numeric',
                'cvc' => 'required|numeric',
            ]);
        }

    }

    /**
     * Place Order
     *
     * @return mix
     */
    public function placeOrder()
    {
        $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'address' => 'required',
            'country' => 'required',
            'zip' => 'required',
            'city' => 'required',
            'payment_mode'=> 'required'
        ]);

        if($this->payment_mode == 'card')
        {
            $this->validate([
                'card_no' => 'required|numeric',
                'exp_month' => 'required|numeric',
                'exp_year' => 'required|numeric',
                'cvc' => 'required|numeric',
            ]);
        }

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->subtotal = session()->get('checkout')['subtotal'];
        $order->tax = session()->get('checkout')['tax'];
        $order->total = session()->get('checkout')['total'];
        $order->firstname = $this->firstname;
        $order->lastname = $this->lastname;
        $order->email = $this->email;
        $order->mobile = $this->mobile;
        $order->address = $this->address;
        $order->country = $this->country;
        $order->zip = $this->zip;
        $order->city = $this->city;
        $order->status = 'ordered';
        $order->is_shipping_different = $this->ship_to_different_address ? 1 : 0;

        $order->save();

        foreach (Cart::content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;

            $orderItem->save();
        }

        if($this->ship_to_different_address)
        {
            $this->validateOnly($field, [
                's_firstname' => 'required',
                's_lastname' => 'required',
                's_email' => 'required|email',
                's_mobile' => 'required|numeric',
                's_address' => 'required',
                's_country' => 'required',
                's_zip' => 'required',
                's_city' => 'required'
            ]);

            $shipping = new Shipping();
            $shipping->order_id = $order->id;
            $shipping->firstname = $this->s_firstname;
            $shipping->lastname = $this->s_lastname;
            $shipping->email = $this->s_email;
            $shipping->mobile = $this->s_mobile;
            $shipping->address = $this->s_address;
            $shipping->country = $this->s_country;
            $shipping->zip = $this->s_zip;
            $shipping->city = $this->s_city;

            $shipping->save();
        }

        if($this->payment_mode == 'cod')
        {
            $this->makePayment($order->id, 'pending');
            $this->resetCart();
        } else if($this->payment_mode == 'paypal') {
            // $this->makePaypalPayment();
            $this->makeAnotherPaypal($order->id);
        } else if($this->payment_mode == 'card') {
           $this->makeCardPayment($order->id);
        }

    }

    /**
     * Reset Cart
     *
     * @return null
     */
    public function resetCart()
    {
        
        $this->thankyou = 1;
        Cart::destroy();
        session()->forget('checkout');
    }

    /**
     * Card Payment
     *
     * @return null
     */
    public function makeCardPayment($order_id)
    {
        $stripe = Stripe::make('sk_test_rHyTcE6WXT7AjconkvkRfsGG');

        try {
            $token = $stripe->tokens()->create([
                'card' => [
                    'number' => $this->card_no,
                    'exp_month' => $this->exp_month,
                    'exp_year' => $this->exp_year,
                    'cvc' => $this->cvc,
                ]
            ]);
            // print_r($token);

            if(!isset($token['id']))
            {
                session()->flash('stripe_error', 'The stripe token was wrong');
                $this->thankyou = 0;
            }

            $customer = $stripe->customers()->create([
                'name'  => $this->firstname . ' ' . $this->lastname,
                'email' => $this->email,
                'phone' => $this->mobile,
                'address' => [
                    'line1' => $this->address,
                    'postal_code' => $this->zip,
                    'city' => $this->city,
                    // 'state' => $this->state,
                    'country' => $this->country,
                ],
                'shipping' => [
                    'name'  => $this->firstname . ' ' . $this->lastname,
                    'address' => [
                        'line1' => $this->address,
                        'postal_code' => $this->zip,
                        'city' => $this->city,
                        // 'state' => $this->state,
                        'country' => $this->country,
                    ],
                ],
                'source' => $token['id']
            ]);

            $charge = $stripe->charges()->create([
                'customer'  => $customer['id'],
                'currency'  => 'USD',
                'amount'  => session()->get('checkout')['total'],
                'description'  => 'Payment for order no '. $order_id,
            ]);

            if( $charge['status'] == 'succeeded' )
            {
                $this->makePayment($order_id, 'approved');
                $this->resetCart();
            }
            else {
                session()->flash('stripe_error', 'Error in transection.');
                $this->thankyou = 0;
            }

        } catch (Exception $e) {
            session()->flash('stripe_error', $e->getMessage());
            $this->thankyou = 0;
        }
    }

    /**
     * Make Payment.
     *
     * @param $order_id
     * @param $status
     * @return save
     */
    public function makePayment( $order_id, $status )
    {
        $payment = new Payment();
            $payment->user_id = Auth::user()->id;
            $payment->order_id = $order_id;
            $payment->mode = $this->payment_mode;
            $payment->status = $status;
            $payment->save();
    }

    public function makePaypalPayment()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_SANDBOX_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_SANDBOX_CLIENT_SECRET'));
        $this->gateway->setTestMode(true); //set it to 'false' when go live
        try {
            $response = $this->gateway->purchase(array(
                'amount' => session()->get('checkout')['total'],
                'currency' => 'USD',
                'returnUrl' => route('checkout'),
                'cancelUrl' => route('thankyou'),
            ))->send();
            // dd($response);
            
            // if ($response->isSuccessful()) {
            //     // payment is complete
            // dd('sucess');

            // } else
            if ($response->isRedirect()) {
                // dd('redirect');
                $response->redirect($response['links'][1]['href']); // this will automatically forward the customer
            } else {
                // not successful
                return $response->getMessage();
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * Paypal another example  
    */
    public function makeAnotherPaypal($order_id)
    {
        $paypalProvider = new PayPalClient;
        $paypalProvider->setApiCredentials(config('paypal'));
        $paypalProvider->setAccessToken($paypalProvider->getAccessToken());

        // dd($paypalProvider);

        // Prepare Order
        $pporder = $paypalProvider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => session()->get('checkout')['total']
                ]
            ]],
            'application_context' => [
                'cancel_url' => route('checkout'),
                'return_url' => route('thankyou', $order_id)
            ]
        ]);

        // Store Token so we can retrieve after PayPal sends them back to us
        // $this->resetCart();
        // dd($pporder);

        // Send user to PayPal to confirm payment
        return redirect($pporder['links'][1]['href']);
    }
    
    public function verifyForCheckout()
    {
       if(!Auth::check())
       {
           return redirect()->route('login');
       }
       else if($this->thankyou)
       {
            return redirect()->route('thankyou');
       }
       else if(!session()->get('checkout'))
       {
            return redirect()->route('product.cart');
       }
    }

    public function render()
    {
        $this->verifyForCheckout();
        return view('livewire.checkout-component')->layout("layouts.base");
    }

}
