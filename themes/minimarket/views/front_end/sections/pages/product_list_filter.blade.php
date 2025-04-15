<div class="row">
    @foreach ($products as $product)
    <div class="col-xl-4 col-md-4 col-sm-6 col-12 product-card">
            <div class="main-card card">
                <a href="{{url($slug.'/product/'.$product->slug)}}" class="img-wrapper">
                    <img src="{{ get_file($product->cover_image_path, $currentTheme) }}" class="plant-img img-fluid" alt="plant1">
                </a>
                {!! \App\Models\Product::actionLinks($currentTheme, $slug, $product) !!}
                <div class="inner-card">
                    <div class="wishlist-wrapper">
                            <a href="JavaScript:void(0)" class="add-wishlist wishlist wishbtn wishbtn-globaly" title="Wishlist" tabindex="0"  product_id="{{$product->id}}" in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">{{__('Add to wishlist')}}
                                <span class="wish-ic">
                                    <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                </span>
                            </a>

                    </div>
                    <div class="card-heading">
                        <h3 class="product-title">
                            <a href="{{url($slug.'/product/'.$product->slug)}}" class="heading-wrapper product-title1">
                                {{$product->name}}
                            </a>
                        </h3>
                        <p class="product-type product-title1">{{ $product->ProductData->name }} </p>
                    </div>
                    <div class="variant-peice">
                    @if ($product->variant_product == 0)
                        <div class="price">

                        {!! \App\Models\Product::getProductPrice($product, $store, $currentTheme) !!}
                        </div>
                    @else
                        <div class="price">
                            <ins>{{ __('In Variant') }}</ins>
                        </div>
                    @endif
                    {!! \App\Models\Product::productSalesPage($currentTheme, $slug, $product->id) !!}
                    </div>
                    <a href="JavaScript:void(0)" class="common-btn addtocart-btn addcart-btn-globaly" product_id="{{ $product->id }}" variant_id="0" qty="1">
                        <span>{{__('Add To Cart')}}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                            viewBox="0 0 14 16" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                fill="white" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                fill="white" />
                        </svg>
                    </a>
                    {!! \App\Models\Product::ProductcardButton($currentTheme, $slug, $product) !!}
                </div>
            </div>
        </div>

    @endforeach
</div>

@php
$page_no = !empty($page) ? $page : 1;
@endphp
<div class="d-flex justify-content-end col-12">
    <nav class="dataTable-pagination">
        <ul class="dataTable-pagination-list">
            <li class="pagination">
                {{ $products->onEachSide(0)->links('pagination::bootstrap-4') }}
            </li>
        </ul>
    </nav>
</div>
