<div>

    <!--main area-->
    <main id="main" class="main-site">

        <div class="container">

            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><a href="#" class="link">home</a></li>
                    <li class="item-link"><span>checkout</span></li>
                </ul>
            </div>
            <div class=" main-content-area">
                <form wire:submit.prevent="placeOrder">
                    <div class="wrap-address-billing">
                        <h3 class="box-title">Billing Address</h3>
                        <div class="billing-address">
                            <p class="row-in-form">
                                <label for="firstname">first name<span>*</span></label>
                                <input type="text" name="firstname" value="" placeholder="Your name" wire:model="firstname">
                                @error('firstname') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="lastname">last name<span>*</span></label>
                                <input type="text" name="lastname" value="" placeholder="Your last name" wire:model="lastname">
                                @error('lastname') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="email">Email Addreess:</label>
                                <input type="email" name="email" value="" placeholder="Type your email" wire:model="email">
                                @error('email') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="mobile">mobile number<span>*</span></label>
                                <input type="number" name="mobile" value="" placeholder="10 digits format" wire:model="mobile">
                                @error('mobile') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="add">Address:</label>
                                <input type="text" name="add" value="" placeholder="Street at apartment number" wire:model="address">
                                @error('address') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="country">Country<span>*</span></label>
                                <input type="text" name="country" value="" placeholder="United States" wire:model="country">
                                @error('country') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="zip-code">Postcode / ZIP:</label>
                                <input type="number" name="zip" value="" placeholder="Your postal code" wire:model="zip">
                                @error('zip') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="city">Town / City<span>*</span></label>
                                <input type="text" name="city" value="" placeholder="City name" wire:model="city">
                                @error('city') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form fill-wife">
                                <label class="checkbox-field">
                                    <input name="different-add" id="different-add" value="forever" type="checkbox" wire:model="ship_to_different_address">
                                    <span>Ship to a different address?</span>
                                </label>
                            </p>
                        </div>
                    </div>

                    @if ($ship_to_different_address)
                    <div class="wrap-address-billing">
                        <h3 class="box-title">Shipping Address</h3>
                        <div class="shipping-address">
                            <p class="row-in-form">
                                <label for="s_firstname">first name<span>*</span></label>
                                <input type="text" name="s_firstname" value="" placeholder="Your name" wire:model="s_firstname">
                                @error('s_firstname') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="s_lastname">last name<span>*</span></label>
                                <input type="text" name="s_lastname" value="" placeholder="Your last name" wire:model="s_lastname">
                                @error('s_lastname') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="s_email">Email Addreess:</label>
                                <input type="email" name="s_email" value="" placeholder="Type your email" wire:model="s_email">
                                @error('s_email') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="s_mobile">Phone number<span>*</span></label>
                                <input type="number" name="s_mobile" value="" placeholder="10 digits format" wire:model="s_mobile">
                                @error('s_mobile') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="s_address">Address:</label>
                                <input type="text" name="s_address" value="" placeholder="Street at apartment number" wire:model="s_address">
                                @error('s_address') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="s_country">Country<span>*</span></label>
                                <input type="text" name="s_country" value="" placeholder="United States" wire:model="s_country">
                                @error('s_country') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="s_zip">Postcode / ZIP:</label>
                                <input type="number" name="s_zip" value="" placeholder="Your postal code" wire:model="s_zip">
                                @error('s_zip') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                            <p class="row-in-form">
                                <label for="s_city">Town / City<span>*</span></label>
                                <input type="text" name="s_city" value="" placeholder="City name" wire:model="s_city">
                                @error('s_city') <span class="text-danger">{{$message}}</span> @enderror
                            </p>
                        </div>
                    </div>
                    @endif


                    <div class="summary summary-checkout">
                        <div class="summary-item payment-method">
                            <h4 class="title-box">Payment Method</h4>
                            @if ($payment_mode == 'card')
                                @if (Session::has('stripe_error'))
                                    <div class="alert alert-danger">{{Session::get('stripe_error')}}</div>
                                @endif
                                <div class="row">
                                    <p class="col-md-12 mb-3">
                                        <label for="card-no">Card Number</label>
                                        <input id="card-no" type="text" class="form-control col-md-12" name="card-no" value="" wire:model="card_no" placeholder="Card Number">
                                        @error('card_no') <span class="text-danger">{{$message}}</span> @enderror
                                    </p>
                                
                                    <p class="row-in-form col-md-4">
                                        <label for="exp-month">Expiry Month</label>
                                        <input id="exp-month" type="text" class="form-control" name="exp-month" value="" wire:model="exp_month" placeholder="MM">
                                        @error('exp_month') <span class="text-danger">{{$message}}</span> @enderror
                                    </p>
                                    <p class="row-in-form col-md-5">
                                        <label for="exp-year">Expiry Year</label>
                                        <input id="exp-year" type="text" class="form-control" name="exp-year" value="" wire:model="exp_year" placeholder="YYYY">
                                        @error('exp_year') <span class="text-danger">{{$message}}</span> @enderror
                                    </p>
                                    <p class="row-in-form col-md-3">
                                        <label for="cvc">CVC</label>
                                        <input id="cvc" type="password" class="form-control" name="cvc" value="" wire:model="cvc" placeholder="CVC">
                                        @error('cvc') <span class="text-danger">{{$message}}</span> @enderror
                                    </p>
                                </div>
                            @endif

                            @if ($payment_mode == 'paypal')

                            @endif
                            <div class="choose-payment-methods">
                                <label class="payment-method">
                                   
                                    <input name="payment-method" id="payment-method-visa" value="card" type="radio" wire:model="payment_mode" checked>
                                    <span>Stripe</span>
                                    <div class="payment-desc">
                                        Please fillup Stripe Details 
                                    </div>
                                </label>
                                <label class="payment-method">
                                    <input name="payment-method" id="payment-method-paypal" value="paypal" wire:model="payment_mode" type="radio">
                                    <span>Paypal</span>
                                    <span class="payment-desc">You can pay with your credit</span>
                                    <span class="payment-desc">card if you don't have a paypal account</span>
                                </label>
                                @error('payment_mode') <span class="text-danger">{{$message}}</span> @enderror
                                
                            </div>
                            @if(Session::has('checkout'))
                                <p class="summary-info grand-total"><span>Grand Total</span> <span class="grand-total-price">${{Session::get('checkout')['total']}}</span></p>
                            @endif
                            <button type="submit" class="btn btn-medium">Place order now</button>
                        </div>
                       
                    </div>
                </form>
            </div>
            <!--end main content area-->
        </div>
        <!--end container-->

    </main>
    <!--main area-->

</div>