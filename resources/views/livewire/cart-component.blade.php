<div>
<main id="main" class="main-site">

		<div class="container">

			<div class="wrap-breadcrumb">
				<ul>
					<li class="item-link"><a href="#" class="link">home</a></li>
					<li class="item-link"><span>login</span></li>
				</ul>
			</div>
			<div class=" main-content-area">
				@if(Cart::count() > 0)
				<div class="wrap-iten-in-cart">
					@if (Session::has('success_message'))
						<div class="alert alert-success">
							<strong>Success</strong> {{Session::get('success_message')}}
						</div>
					@endif
					<h3 class="box-title">Products Name</h3>
					<ul class="products-cart">
						@foreach (Cart::content() as $item)
						<li class="pr-cart-item">
							<div class="product-image">
								<figure><img src="{{ asset('assets/images/products') }}/{{$item->model->image}}" alt=""></figure>
							</div>
							<div class="product-name">
								<a class="link-to-product" href="#">{{$item->model->name}}</a>
							</div>
							<div class="price-field produtc-price"><p class="price">${{$item->model->regular_price}}</p></div>
							<div class="quantity">
								<div class="quantity-input">
									<input type="text" name="product-quatity" value="{{$item->qty}}" data-max="120" pattern="[0-9]*">									
									<a class="btn btn-increase" href="#" wire:click.prevent="increaseQyt('{{$item->rowId}}')"></a>
									<a class="btn btn-reduce" href="#" wire:click.prevent="decreaseQyt('{{$item->rowId}}')"></a>
								</div>
							</div>
							<div class="price-field sub-total"><p class="price">${{$item->subtotal}}</p></div>
							<div class="delete">
								<a href="#" wire:click.prevent="deleteItem('{{$item->rowId}}')" class="btn btn-delete" title="">
									<span>Delete from your cart</span>
									<i class="fa fa-times-circle" aria-hidden="true"></i>
								</a>
							</div>
						</li>
						@endforeach
					</ul>
				
				</div>

				<div class="summary">
					<div class="order-summary">
						<h4 class="title-box">Order Summary</h4>
						<p class="summary-info"><span class="title">Subtotal</span><b class="index">${{Cart::subtotal()}}</b></p>
						<p class="summary-info"><span class="title">Tax</span><b class="index">${{Cart::tax()}}</b></p>
						<p class="summary-info total-info "><span class="title">Total</span><b class="index">${{Cart::total()}}</b></p>
					</div>
					<div class="checkout-info">
						<a class="btn btn-checkout" href="#" wire:click.prevent="checkout">Check out</a>
					</div>
				</div>

				@else
					<div class="text-center">
						<h1>No Product in cart</h1>
						<a class="btn btn-success" href="/shop">Shop Now</a>
					</div>
				@endif

			</div><!--end main content area-->
		</div><!--end container-->

	</main>
</div>
