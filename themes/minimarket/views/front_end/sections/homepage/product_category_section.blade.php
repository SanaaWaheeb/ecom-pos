<section class="fifth-sec"
    style="position: relative;@if(isset($option) && $option->is_hide == 1) opacity: 0.5; @else opacity: 1; @endif"
    data-index="{{ $option->order ?? '' }}" data-id="{{ $option->order ?? '' }}" data-value="{{ $option->id ?? '' }}"
    data-hide="{{ $option->is_hide ?? '' }}" data-section="{{ $option->section_name ?? '' }}"
    data-store="{{ $option->store_id ?? '' }}" data-theme="{{ $option->theme_id ?? '' }}">
    <div class="custome_tool_bar"></div>
    <img src=" {{ asset('themes/' . $currentTheme . '/assets/images/d5.png') }}" class="d-right">
    <div class=" container">
        <div class="row align-items-end">
            <div class=" col-lg-6 col-12">
                <div class=" common-heading">
                    <span class="sub-heading"
                        id="{{ ($section->product_category->section->sub_title->slug ?? '') }}_preview"> {!!
                        $section->product_category->section->sub_title->text ?? "" !!}</span>
                    <h2 id="{{ ($section->product_category->section->title->slug ?? '') }}_preview">{!!
                        $section->product_category->section->title->text ?? "" !!} </h2>
                    <p id="{{ ($section->product_category->section->description->slug ?? '') }}_preview">{!!
                        $section->product_category->section->description->text !!}</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="{{ route('page.product-list', $slug) }}" class="common-btn">
                            <span id="{{ ($section->product_category->section->button->slug ?? '') }}_preview">{!!
                                $section->product_category->section->button->text !!}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                    fill="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                    fill="white" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @foreach ( $home_page_products as $data)
            <div class="main-card card product-card col-lg-3 col-sm-6 col-12">
                <div class="pro-card-inner">
                    <a href="{{ url($slug.'/product/'.$data->slug) }}" class="img-wrapper">
                        <img src="{{ get_file($data->cover_image_path, $currentTheme) }}"
                        class="plant-img img-fluid" alt="plant1">
                    </a>
                    <div class="inner-card">
                        <div class="wishlist-wrapper">
                            <a href="JavaScript:void(0)" class="add-wishlist wishlist wishbtn wishbtn-globaly" title="Wishlist" tabindex="0"
                                product_id="{{ $data->id }}" in_wishlist="{{ $data->in_whishlist ? 'remove' : 'add' }}">{{ __('Add to wishlist') }}
                                <span class="wish-ic">
                                    <i class="{{ $data->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                </span>
                            </a>
                            {!! \App\Models\Product::productSalesPage($currentTheme, $slug, $data->id) !!}
                        </div>
                        {!! \App\Models\Product::actionLinks($currentTheme, $slug, $data) !!}
                        <div class="card-heading">
                            <h3>
                                <a href="{{ url($slug.'/product/'.$data->slug) }}"
                                    class="heading-wrapper product-title1">
                                    {{ $data->name }}
                                </a>
                            </h3>

                            <p>{{ $data->ProductData->name }}</p>
                        </div>
                        @if ($data->variant_product == 0)
                            <div class="price">
                            {!! \App\Models\Product::getProductPrice($data, $store, $currentTheme) !!}
                            </div>
                        @else
                            <div class="price">
                                <ins>{{ __('In Variant') }}</ins>
                            </div>
                        @endif
                        <a href="JavaScript:void(0)"
                            class="common-btn addtocart-btn addcart-btn-globaly"
                            product_id="{{ $data->id }}"
                            variant_id="0" qty="1">
                            <span>{{ __('Add To Cart') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                height="16" viewBox="0 0 14 16" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                    fill="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                    fill="white" />
                            </svg>
                        </a>
                        {!! \App\Models\Product::ProductcardButton($currentTheme, $slug, $data) !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
