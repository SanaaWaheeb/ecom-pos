<div class="mini-cart-header">
    <h4>{{ __('My Cart') }}</h4>
    <div class="cart-tottl-itm">{{ $response->data->cart_total_product }} {{ __('Items') }}</div>
    <a href="#" class="closecart">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path
                d="M20 1.17838L18.8216 0L10 8.82162L1.17838 0L0 1.17838L8.82162 10L0 18.8216L1.17838 20L10 11.1784L18.8216 20L20 18.8216L11.1784 10L20 1.17838Z"
                fill="white"></path>
        </svg>
    </a>
</div>
<div id="cart-body" class="mini-cart-has-item">
    <div class="mini-cart-body">
        @if (!empty($response->data->cart_total_product))
            @foreach ($response->data->product_list as $item)
            <div class="mini-cart-item">
                <div class="mini-cart-image">

                    <a href="{{url($slug.'/product/'. getProductSlug($item->product_id))}}">
                        <img src="{{ get_file($item->image, $currentTheme) }}" alt="img">
                    </a>
                </div>
                <div class="mini-cart-details">
                    <p class="mini-cart-title"><a href="{{url($slug.'/product/'. getProductSlug($item->product_id))}}">{{ $item->name }}</a></p>
                    @if ($item->variant_id != 0)
                        {!! \App\Models\ProductVariant::variantlist($item->variant_id) !!}
                    @endif
                    <div class="qty-spinner">
                        <button type="button" class="quantity-decrement change-cart-globaly" cart-id="{{ $item->cart_id }}" quantity_type="decrease" data-product-id = "{{ $item->product_id }}" data-variant-id = "{{ $item->variant_id }}">
                            <svg width="12" height="2" viewBox="0 0 12 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3">
                                </path>
                            </svg>
                        </button>

                        <input type="hidden" name="product_id" value="45">
                        <input type="text" class="quantity 45_quatity" data-cke-saved-name="quantity" name="quantity" value="{{ $item->qty }}" min="01" id="cart_list_sidebar_quantity_{{ $item->variant_id ?? '-' }}_{{ $item->qty }}" data-id="463" disabled>
                        <button type="button" class="quantity-increment change-cart-globaly"  cart-id="{{ $item->cart_id }}" quantity_type="increase" data-product-id = "{{ $item->product_id }}" data-variant-id = "{{ $item->variant_id }}">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z" fill="#61AFB3"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="pvarprice d-flex align-items-center justify-content-between">
                        <div class="price">
                            {!! \App\Models\Product::ManageCartPrice($item, $store, $store->theme_id) !!}
                        </div>
                        <a class="remove_item remove_item_from_cart" title="Remove item" href="#" data-id="{{ $item->cart_id }}" data-product-id = "{{ $item->product_id }}" data-variant-id = "{{ $item->variant_id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path
                                    d="M12.7589 7.24609C12.5002 7.24609 12.2905 7.45577 12.2905 7.71448V16.5669C12.2905 16.8255 12.5002 17.0353 12.7589 17.0353C13.0176 17.0353 13.2273 16.8255 13.2273 16.5669V7.71448C13.2273 7.45577 13.0176 7.24609 12.7589 7.24609Z"
                                    fill="#61AFB3"></path>
                                <path
                                    d="M7.23157 7.24609C6.97286 7.24609 6.76318 7.45577 6.76318 7.71448V16.5669C6.76318 16.8255 6.97286 17.0353 7.23157 17.0353C7.49028 17.0353 7.69995 16.8255 7.69995 16.5669V7.71448C7.69995 7.45577 7.49028 7.24609 7.23157 7.24609Z"
                                    fill="#61AFB3"></path>
                                <path
                                    d="M3.20333 5.95419V17.4942C3.20333 18.1762 3.45344 18.8168 3.89035 19.2764C4.32525 19.7373 4.93049 19.9989 5.56391 20H14.4259C15.0594 19.9989 15.6647 19.7373 16.0994 19.2764C16.5363 18.8168 16.7864 18.1762 16.7864 17.4942V5.95419C17.6549 5.72366 18.2177 4.8846 18.1016 3.99339C17.9852 3.10236 17.2261 2.43583 16.3274 2.43565H13.9293V1.85017C13.932 1.35782 13.7374 0.885049 13.3888 0.537238C13.0403 0.18961 12.5668 -0.00396362 12.0744 6.15416e-05H7.91533C7.42298 -0.00396362 6.94948 0.18961 6.60093 0.537238C6.25239 0.885049 6.05772 1.35782 6.06046 1.85017V2.43565H3.66238C2.76367 2.43583 2.00456 3.10236 1.8882 3.99339C1.77202 4.8846 2.33481 5.72366 3.20333 5.95419ZM14.4259 19.0632H5.56391C4.76308 19.0632 4.14009 18.3753 4.14009 17.4942V5.99536H15.8497V17.4942C15.8497 18.3753 15.2267 19.0632 14.4259 19.0632ZM6.99723 1.85017C6.99412 1.60628 7.08999 1.37154 7.26307 1.19938C7.43597 1.02721 7.67126 0.932619 7.91533 0.936827H12.0744C12.3185 0.932619 12.5538 1.02721 12.7267 1.19938C12.8998 1.37136 12.9956 1.60628 12.9925 1.85017V2.43565H6.99723V1.85017ZM3.66238 3.37242H16.3274C16.793 3.37242 17.1705 3.74987 17.1705 4.21551C17.1705 4.68114 16.793 5.05859 16.3274 5.05859H3.66238C3.19674 5.05859 2.81929 4.68114 2.81929 4.21551C2.81929 3.74987 3.19674 3.37242 3.66238 3.37242Z"
                                    fill="#61AFB3"></path>
                                <path
                                    d="M9.99523 7.24609C9.73653 7.24609 9.52686 7.45577 9.52686 7.71448V16.5669C9.52686 16.8255 9.73653 17.0353 9.99523 17.0353C10.2539 17.0353 10.4636 16.8255 10.4636 16.5669V7.71448C10.4636 7.45577 10.2539 7.24609 9.99523 7.24609Z"
                                    fill="#61AFB3"></path>
                                <defs>
                                    <clipPath>
                                        <rect width="20" height="20" fill="white"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <p class="emptyCart text-center">{{ __('You have no items in your shopping cart.') }}</p>
        @endif
    </div>
    <div class="mini-cart-footer mini-cart-footer1">
        @if (!empty($response->data->cart_total_product))
            <div class="u-save d-flex justify-end">
                {{ __("Subtotal") }}: {{ currency_format_with_sym(($response->data->final_price ?? 0), $store->id, $currentTheme) ?? SetNumberFormat($response->data->final_price ?? ($response->data->sub_total ?? 0)) }}
            </div>
            <div class="u-save d-flex justify-end">
                {{ __("Tax") }}: {{ currency_format_with_sym(($response->data->tax_price ?? 0), $store->id, $currentTheme) ?? SetNumberFormat($response->data->tax_price) }}
            </div>
            @php
                $final = $response->data->sub_total+$response->data->tax_price ?? 0;
            @endphp
            <div class="mini-cart-footer-total-row d-flex align-items-center justify-content-between">
                <div class="mini-total-lbl">
                    {{ __('Total') }} :
                </div>
                <div class="mini-total-price">
                    {{ currency_format_with_sym($final, $store->id, $currentTheme) ?? SetNumberFormat($final) }}
                </div>
            </div>
            <a href="{{ route('page.cart',$slug) }}">
                <center>
                    <button class="btn checkout-btn">
                        {{ __('Proceed to checkout') }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M9.99991 11.2133C9.077 11.2145 8.18225 10.8948 7.46802 10.3089C6.75378 9.72305 6.26423 8.90709 6.08273 8.00001C6.06826 7.90447 6.07469 7.80691 6.10157 7.7141C6.12845 7.62129 6.17514 7.53544 6.2384 7.46252C6.30166 7.38959 6.37998 7.33132 6.46794 7.29175C6.55589 7.25218 6.65138 7.23225 6.74778 7.23335C6.90622 7.23104 7.06027 7.28551 7.1822 7.38696C7.30413 7.4884 7.38592 7.63015 7.41284 7.78668C7.53809 8.38596 7.86526 8.92378 8.33939 9.3098C8.81351 9.69582 9.40572 9.90653 10.0165 9.90653C10.6273 9.90653 11.2196 9.69582 11.6937 9.3098C12.1678 8.92378 12.495 8.38596 12.6202 7.78668C12.6472 7.63015 12.7289 7.4884 12.8509 7.38696C12.9728 7.28551 13.1268 7.23104 13.2853 7.23335C13.3817 7.23225 13.4772 7.25218 13.5651 7.29175C13.6531 7.33132 13.7314 7.38959 13.7947 7.46252C13.8579 7.53544 13.9046 7.62129 13.9315 7.7141C13.9584 7.80691 13.9648 7.90447 13.9503 8.00001C13.7678 8.91273 13.2733 9.73303 12.5522 10.3196C11.8311 10.9061 10.9285 11.2222 9.99991 11.2133Z"
                                fill="#2C2C2C"></path>
                            <path
                                d="M15.9189 20H4.08092C3.8103 20.0003 3.54244 19.9455 3.29363 19.8388C3.04483 19.7321 2.82028 19.5758 2.63364 19.3793C2.44701 19.1829 2.30219 18.9504 2.208 18.6961C2.11381 18.4418 2.07222 18.1709 2.08575 17.9L2.62444 6.40663C2.64674 5.89136 2.86675 5.40464 3.23852 5.04811C3.6103 4.69158 4.10511 4.4928 4.61961 4.49329H15.3802C15.8947 4.4928 16.3895 4.69158 16.7613 5.04811C17.1331 5.40464 17.3531 5.89136 17.3754 6.40663L17.9141 17.9C17.9276 18.1709 17.886 18.4418 17.7918 18.6961C17.6976 18.9504 17.5528 19.1829 17.3662 19.3793C17.1796 19.5758 16.955 19.7321 16.7062 19.8388C16.4574 19.9455 16.1895 20.0003 15.9189 20ZM4.61961 5.83329C4.44323 5.83329 4.27407 5.90353 4.14935 6.02855C4.02462 6.15358 3.95456 6.32315 3.95456 6.49996L3.41586 17.9667C3.41135 18.057 3.42522 18.1473 3.45661 18.232C3.48801 18.3168 3.53628 18.3943 3.59849 18.4598C3.6607 18.5252 3.73555 18.5774 3.81849 18.6129C3.90142 18.6485 3.99071 18.6668 4.08092 18.6667H15.9189C16.0091 18.6668 16.0984 18.6485 16.1813 18.6129C16.2643 18.5774 16.3391 18.5252 16.4013 18.4598C16.4636 18.3943 16.5118 18.3168 16.5432 18.232C16.5746 18.1473 16.5885 18.057 16.584 17.9667L16.0453 6.47329C16.0453 6.29648 15.9752 6.12691 15.8505 6.00189C15.7258 5.87686 15.5566 5.80662 15.3802 5.80662L4.61961 5.83329Z"
                                fill="#2C2C2C"></path>
                            <path
                                d="M13.9902 5.16668H12.6601V4.00001C12.6601 3.29276 12.3798 2.61449 11.8809 2.11439C11.382 1.61429 10.7054 1.33334 9.99986 1.33334C9.29432 1.33334 8.61768 1.61429 8.11879 2.11439C7.61991 2.61449 7.33963 3.29276 7.33963 4.00001V5.16668H6.00952V4.00001C6.00952 2.93914 6.42993 1.92172 7.17826 1.17158C7.9266 0.421428 8.94155 0 9.99986 0C11.0582 0 12.0731 0.421428 12.8215 1.17158C13.5698 1.92172 13.9902 2.93914 13.9902 4.00001V5.16668Z"
                                fill="#2C2C2C"></path>
                        </svg>
                    </button>
                </center>
            </a>
        @endif

        <a href="{{ route('page.product-list',$slug) }}" class="link-btn">
            {{ __('Continue Shopping') }}
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14" viewBox="0 0 35 14" fill="none">
                <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z"></path>
            </svg>
        </a>

    </div>
</div>
