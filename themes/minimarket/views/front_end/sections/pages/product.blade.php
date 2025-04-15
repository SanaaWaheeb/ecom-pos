@extends('front_end.layouts.app')
@section('page-title')
{{ __('Products') }}
@endsection
@php

@endphp

@section('content')
@include('front_end.sections.partision.header_section')
@php
$latestSales = \App\Models\Product::productSalesTag($currentTheme, $slug, $product->id);
@endphp
<div class="main-parent-top">
    <img src="{{ asset('themes/' . $currentTheme . '/assets/images/circle-design.png') }}" class="desk-only"
        id="circle-design7" alt="circle-design">
    <!-- product slider sec start  -->
    <section class="product-sec padding-top">

        <div class=" container">
            <div class=" row">
                <div class=" col-md-6 col-12">
                    <div class="product-left-inner">
                        <div class="top-row">
                            <a href="{{ route('page.product-list',$slug) }}" class="back-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31"
                                    fill="none">
                                    <circle cx="15.5" cy="15.5" r="15.0441" stroke="white" stroke-width="0.911765" />
                                    <g clip-path="url(#clip0_318_284)">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M20.5867 15.7639C20.5867 15.9859 20.4067 16.1658 20.1848 16.1658L12.3333 16.1659L13.2777 17.0834C13.4369 17.2381 13.4406 17.4925 13.2859 17.6517C13.1313 17.8109 12.8768 17.8146 12.7176 17.66L11.0627 16.0523C10.9848 15.9766 10.9409 15.8727 10.9409 15.7641C10.9409 15.6554 10.9848 15.5515 11.0627 15.4758L12.7176 13.8681C12.8768 13.7135 13.1313 13.7172 13.2859 13.8764C13.4406 14.0356 13.4369 14.29 13.2777 14.4447L12.3333 15.3621L20.1848 15.362C20.4067 15.362 20.5867 15.5419 20.5867 15.7639Z"
                                            fill="white" />
                                    </g>
                                </svg>
                                <span> {{__('Back to category')}}</span>
                            </a>
                            <a href="javascript:void(0)" class="wishbtn variant_form wishbtn-globaly"
                                product_id="{{$product->id}}"
                                in_wishlist="{{ $product->in_whishlist ? 'remove' : 'add'}}">
                                <span>{{__('Add to wishlist')}}</span>
                                <span class="wish-ic">
                                    <i class="{{ $product->in_whishlist ? 'fa fa-heart' : 'ti ti-heart' }}"></i>
                                </span>
                            </a>

                        </div>

                        <div class="common-heading">
                            <span class="sub-heading "> {{$product->name}}</span>
                            <h2>{{ $product->ProductData->name }} </h2>
                            <p class="product-variant-description">{{ strip_tags($product->description) }}</p>
                            <div class="price product-price-amount">
                                <ins class="min_max_price" style="display: inline;">
                                    {{ $currency_icon }}{{ $mi_price }} -
                                    {{ $currency_icon }}{{ $ma_price }}
                                </ins>
                            </div>
                        </div>
                        <div class="pdp-counter">
                            <div class="count-right">
                                <div class="count-right-inner">
                                    @if ($latestSales)
                                    @foreach ($latestSales as $productId => $saleData)
                                    <input type="hidden" class="flash_sale_start_date" value={{ $saleData['start_date'] }}>
                                    <input type="hidden" class="flash_sale_end_date" value={{ $saleData['end_date'] }}>
                                    <input type="hidden" class="flash_sale_start_time" value={{ $saleData['start_time'] }}>
                                    <input type="hidden" class="flash_sale_end_time" value={{ $saleData['end_time'] }}>
                                    <div id="flipdown" class="flipdown"></div>
                                    @endforeach
                                    @endif
                                    @if (!empty($product->custom_field))
                                    @foreach (json_decode($product->custom_field, true) as $item)
                                    <div class="pdp-detail d-flex  align-items-center">
                                        <b>{{ $item['custom_field'] }} :</b>
                                        <span class="lbl">{{ $item['custom_value'] }}</span>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="count-left">
                                @if ($product->variant_product == 1)
                                <h6 class="enable_option">
                                    @if ($product->product_stock > 0)
                                    <span
                                        class="stock">{{ $product->product_stock }}</span><small>{{ __(' in stock') }}</small>
                                    @endif
                                </h6>
                                @else
                                <h6>
                                    @if ($product->track_stock == 0)
                                    @if ($product->stock_status == 'out_of_stock')
                                    <span>{{ __('Out of Stock') }}</span>
                                    @elseif ($product->stock_status == 'on_backorder')
                                    <span>{{ __('Available on backorder') }}</span>
                                    @else
                                    <span></span>
                                    @endif
                                    @else
                                    @if ($product->product_stock > 0)
                                    <span>{{ $product->product_stock }}
                                        {{ __('  in stock') }}</span>
                                    @endif
                                    @endif
                                </h6>
                                @endif
                                <span class="product-price-error"></span>
                                <form class="variant_form w-100">
                                    @csrf
                                    @if ($product->track_stock == 0 && $product->stock_status == 'out_of_stock')
                                    @else
                                    <div class="top-content">
                                        <div class="prorow-lbl-qntty">
                                            <div class="product-labl ">{{__('quantity')}}</div>
                                            <div class="qty-spinner">
                                                <button type="button" data-product="{{ $product->id }}"  class="quantity-decrement change_price">
                                                    <svg width="12" height="2" viewBox="0 0 12 2" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <input type="text" class="quantity" data-cke-saved-name="quantity"
                                                    name="qty" value="01" min="01" max="100">
                                                <button type="button" data-product="{{ $product->id }}"  class="quantity-increment change_price">
                                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z"
                                                            fill="#61AFB3"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="select-container">
                                            @if ($product->variant_product == 1)
                                            @php
                                            $variant = json_decode($product->product_attribute);
                                            $varint_name_array = [];
                                            if(!empty($product->DefaultVariantData->variant)) {

                                            $varint_name_array = explode('-', $product->DefaultVariantData->variant);

                                            }
                                            @endphp
                                            @foreach ($variant as $key => $value)
                                            @php
                                            $p_variant = App\Models\Utility::ProductAttribute($value->attribute_id);
                                            $attribute = json_decode($p_variant);
                                            $propertyKey = 'for_variation_' . $attribute->id;
                                            $variation_option = $value->$propertyKey;
                                            @endphp
                                            @if ($variation_option == 1)
                                            <p><b>{{$attribute->name}}:</b></p>
                                            <div class="text-checkbox checkbox-radio d-flex align-items-center">
                                                <select data-product="{{ $product->id }}" class="custom-select-btn product_variatin_option variant_loop"  data-product="{{ $product->id}}"
                                                    name="varint[{{ $attribute->name }}]">
                                                    @php
                                                    $optionValues = [];
                                                    @endphp

                                                    @foreach ($value->values as $variant1)
                                                    @php
                                                    $parts = explode('|', $variant1);
                                                    @endphp
                                                    @foreach ($parts as $p)
                                                    @php
                                                    $id = App\Models\ProductAttributeOption::where('id', $p)->first();
                                                    if (isset($id->terms)) {
                                                                                $optionValues[] = $id->terms;
                                                                            }
                                                    @endphp
                                                    @endforeach
                                                    @endforeach
                                                    <option value="">
                                                        {{ __('Select an option') }}
                                                    </option>

                                                    @if (is_array($optionValues))
                                                    @foreach ($optionValues as $optionValue)
                                                    <option>{{ $optionValue }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            @endif
                                            @endforeach
                                            @endif
                                            {{-- <div class="details">Height: 78cm </div> --}}
                                        </div>
                                    </div>
                                    @endif
                                    <div class="price-div d-flex align-items-center variant-price">
                                        <div class="price d-flex align-items-end product-price-amount price-value">
                                        {!! \App\Models\Product::getProductPrice($product, $store, $currentTheme) !!}
                                        </div>
                                    </div>

                                    <div class="product-hook">
                                    @if ($product->track_stock == 0 && $product->stock_status == 'out_of_stock')
                                        @else    
                                    <a href="javascript:void(0)"
                                        class="addtocart-btn addcart-btn variant_form addcart-btn-globaly common-btn price-wise-btn product_var_option"
                                        product_id="{{ $product->id }}"
                                        variant_id="{{ $product->default_variant_id }}" qty="1">
                                        <span> {{__('Add to cart')}}</span>
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
                                    @endif
                                        @include('front_end.hooks.product_detail_info_button')
                                    </div>
                                </form>
                                <div class="stock_status"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="slider-wrapper">
                        <div class="product-thumb-slider">
                            @foreach ($product->Sub_image($product->id)['data'] as $item)
                            <div class="product-thumb-item">
                                <div class="thumb-img">
                                    <img src="{{ get_file($item->image_path, $currentTheme) }}" class="product-img">

                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="product-main-slider lightbox">
                            @foreach ($product->Sub_image($product->id)['data'] as $item)
                            <div class="product-main-item">
                                <div class="product-item-img">
                                    <img src="{{ get_file($item->image_path, $currentTheme) }}" class="product-img">

                                    @foreach ($latestSales as $productId => $saleData)
                                    <div class="custom-output sale-tag-product">
                                        <div class="sale_tag_icon rounded col-1 onsale">
                                            <div>{{ __('Sale!') }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <a href="{{ get_file($item->image_path, $currentTheme) }}" data-caption="{{$product->name}}"
                                        class="open-lightbox ">
                                        <div class="img-prew-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="20"
                                                viewBox="0 0 25 25" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M0 9.375C0 14.5527 4.19733 18.75 9.375 18.75C11.5395 18.75 13.5328 18.0164 15.1196 16.7843C15.1794 16.9108 15.2615 17.0293 15.3661 17.1339L22.8661 24.6339C23.3543 25.122 24.1457 25.122 24.6339 24.6339C25.122 24.1457 25.122 23.3543 24.6339 22.8661L17.1339 15.3661C17.0293 15.2615 16.9108 15.1794 16.7844 15.1196C18.0164 13.5328 18.75 11.5395 18.75 9.375C18.75 4.19733 14.5527 0 9.375 0C4.19733 0 0 4.19733 0 9.375ZM2.5 9.375C2.5 5.57804 5.57804 2.5 9.375 2.5C13.172 2.5 16.25 5.57804 16.25 9.375C16.25 13.172 13.172 16.25 9.375 16.25C5.57804 16.25 2.5 13.172 2.5 9.375Z"
                                                    fill="white" />
                                            </svg>
                                        </div>
                                        <span class="img-prew-text">{{__('click to preview')}}</span>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- tab section  --}}
    <section class="tab-vid-section padding-top">
        <div class="container">
            <div class="tabs-wrapper">
                <div class="blog-head-row tab-nav d-flex justify-content-between">
                    <div class="blog-col-left ">
                        <ul class="d-flex tabs">
                            <li class="tab-link on-tab-click active" data-tab="0"><a
                                    href="javascript:(0);">{{ __('Description') }}</a>
                            </li>
                            @if($product->preview_content != '')
                            <li class="tab-link on-tab-click" data-tab="1"><a href="javascript:(0);">{{ __('Video') }}</a>
                            </li>
                            @endif
                            @if ($product->product_attribute != '')
                            <li class="tab-link on-tab-click" data-tab="3"><a
                                    href="javascript:(0);">{{ __('Additional Information') }}</a>
                            </li>
                            @endif
                            <li class="tab-link on-tab-click" data-tab="2"><a
                                    href="javascript:(0);">{{ __('Question & Answer') }}</a>
                            </li>
                            @include('front_end.hooks.product_tab')

                        </ul>
                    </div>
                </div>
                <div class="tabs-container">
                    <div id="0" class="tab-content active">
                        <section class="description-sec">
                            <div>
                                <div class=" row align-items-center">
                                    <div class=" col-md-6 col-12">
                                        <div class="description-box common-heading">
                                            <span class="sub-heading">{{__('Fruit & Vegetables')}}</span>
                                            <h2>{{__('Description')}}</h2>
                                            <p>{!! html_entity_decode($product->description) !!} </p>
                                        </div>
                                    </div>
                                    <div class=" col-md-6 col-12">
                                        <div class="methods common-heading">
                                            {!! html_entity_decode($product->detail) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    @if($product->preview_content != '')
                    <div id="1" class="tab-content">
                        <div class="video-wrapper">
                            @if ($product->preview_type == 'Video Url')
                            @if (str_contains($product->preview_content, 'youtube') ||
                            str_contains($product->preview_content, 'youtu.be'))
                            @php
                            if (strpos($product->preview_content, 'src') !== false) {
                            preg_match('/src="([^"]+)"/', $product->preview_content, $match);
                            $url = $match[1];
                            $video_url = str_replace('https://www.youtube.com/embed/', '', $url);
                            } elseif (strpos($product->preview_content, 'src') == false &&
                            strpos($product->preview_content, 'embed') !== false) {
                            $video_url = str_replace('https://www.youtube.com/embed/', '', $product->preview_content);
                            } else {
                            $video_url = str_replace('https://youtu.be/', '',
                            str_replace('https://www.youtube.com/watch?v=', '', $product->preview_content));
                            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $product->preview_content, $matches);
                            if (count($matches) > 0) {
                            $videoId = $matches[1];
                            $video_url = strtok($videoId, '&');
                            }
                            }
                            @endphp
                            <iframe class="video-card-tag" width="100%" height="100%"
                                src="{{ 'https://www.youtube.com/embed/' }}{{ $video_url }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                            @elseif(str_contains($product->preview_content, 'vimeo'))
                            @php
                            if (strpos($product->preview_content, 'src') !== false) {
                            preg_match('/src="([^"]+)"/', $product->preview_content, $match);
                            $url = $match[1];
                            $video_url = str_replace('https://player.vimeo.com/video/', '', $url);
                            } else {
                            $video_url = str_replace('https://vimeo.com/', '', $product->preview_content);
                            }
                            @endphp
                            <iframe class="video-card-tag" width="100%" height="350"
                                src="{{ 'https://player.vimeo.com/video/' }}{{ $video_url }}" frameborder="0"
                                allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            @else
                            @php
                            $video_url = $product->preview_content;
                            @endphp
                            <iframe class="video-card-tag" width="100%" height="100%" src="{{ $video_url }}"
                                title="Video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                            @endif
                            @elseif($product->preview_type == 'iFrame')
                            @if (str_contains($product->preview_content, 'youtube') ||
                            str_contains($product->preview_content, 'youtu.be'))
                            @php
                            if (strpos($product->preview_content, 'src') !== false) {
                            preg_match('/src="([^"]+)"/', $product->preview_content, $match);
                            $url = $match[1];
                            $iframe_url = str_replace('https://www.youtube.com/embed/', '', $url);
                            } else {
                            $iframe_url = str_replace('https://youtu.be/', '',
                            str_replace('https://www.youtube.com/watch?v=', '', $product->preview_content));
                            }
                            @endphp
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $iframe_url }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                            @elseif(str_contains($product->preview_content, 'vimeo'))
                            @php
                            if (strpos($product->preview_content, 'src') !== false) {
                            preg_match('/src="([^"]+)"/', $product->preview_content, $match);
                            $url = $match[1];
                            $iframe_url = str_replace('https://player.vimeo.com/video/', '', $url);
                            } else {
                            $iframe_url = str_replace('https://vimeo.com/', '', $product->preview_content);
                            }
                            @endphp
                            <iframe class="video-card-tag" width="100%" height="350"
                                src="{{ 'https://player.vimeo.com/video/' }}{{ $iframe_url }}" frameborder="0"
                                allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            @else
                            @php
                            $iframe_url = $product->preview_content;
                            @endphp
                            <iframe class="video-card-tag" width="100%" height="100%" src="{{ $iframe_url }}"
                                title="Video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                            @endif
                            @else
                            <video controls="">
                                <source src="{{ get_file($product->preview_content ?? '', $currentTheme) }}" type="video/mp4">
                            </video>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div id="2" class="tab-content ">
                        <div class="queary-div">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4>{{ __('Have doubts regarding this product?') }}</h4>
                                <a href="javascript:void(0)" class="btn btn-sm btn-primary Question"
                                    @if (auth('customers')->check())
                                        data-ajax-popup="true"
                                    @else
                                        data-ajax-popup="false"
                                    @endif
                                    data-size="xs"
                                    data-title="Post your question"
                                    data-url="{{ route('question', [$slug, $product->id]) }}"
                                    data-toggle="tooltip">
                                    <i class="ti ti-plus"></i>
                                    <span class="lbl">{{ __('Post Your Question') }}</span>
                                    </a>
                            </div>
                            <div class="qna">
                                <br>
                                <ul>
                                    @foreach ($question->take(4) as $que)
                                    <li>
                                        <div class="quetion">
                                            <span class="icon que">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="305" height="266"
                                                    viewBox="0 0 305 266" fill="none"
                                                    class="__web-inspector-hide-shortcut__">
                                                    <path
                                                        d="M152.4 256.4C222.8 256.4 283.6 216.2 300.1 158.6C303 148.8 304.4 138.6 304.4 128.4C304.4 57.7999 236.2 0.399902 152.4 0.399902C68.6004 0.399902 0.400391 57.7999 0.400391 128.4C0.600391 154.8 10.0004 180.3 27.0004 200.5C28.8004 202.7 29.3004 205.7 28.3004 208.4L6.70039 265.4L68.2004 238.4C70.4004 237.4 72.9004 237.5 75.0004 238.6C95.8004 248.9 118.4 254.9 141.5 256.1C145.2 256.3 148.8 256.4 152.4 256.4ZM104.4 120.4C104.4 85.0999 125.9 56.3999 152.4 56.3999C178.9 56.3999 200.4 85.0999 200.4 120.4C200.5 134.5 196.8 148.5 189.7 160.6L204.5 169.5C207 170.9 208.5 173.6 208.5 176.5C208.5 179.4 206.9 182 204.3 183.4C201.7 184.8 198.7 184.7 196.2 183.2L179.4 173.1C172.1 180.1 162.4 184.1 152.3 184.3C125.9 184.4 104.4 155.7 104.4 120.4Z"
                                                        fill="black" />
                                                    <path
                                                        d="M164.9 164.4L156.3 159.2C152.6 156.9 151.4 152 153.7 148.3C156 144.6 160.8 143.3 164.6 145.5L176 152.4C181.6 142.7 184.6 131.6 184.4 120.4C184.4 94.3999 169.7 72.3999 152.4 72.3999C135.1 72.3999 120.4 94.3999 120.4 120.4C120.4 146.4 135.1 168.4 152.4 168.4C156.8 168.3 161.2 166.9 164.9 164.4Z"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <div class="text">
                                                <p>
                                                    {{ $que->question }}
                                                </p>
                                                <span class="user">{{ __($que->users->name ?? '') }}</span>
                                            </div>
                                        </div>
                                        <div class="answer">
                                            <span class="icon ans">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="304" height="273"
                                                    viewBox="0 0 304 273" fill="none">
                                                    <path
                                                        d="M304 127.3C304 126.8 304 126.2 304 125.7C304 125.2 304 124.7 303.9 124.2C301.4 55.5002 234.2 0.200195 152 0.200195C68.5 0.200195 0.6 57.1002 0 127.3C0 127.7 0 128 0 128.4C0.2 154.7 9.6 180.2 26.6 200.4C27.2 201.1 27.6 201.9 27.9 202.7C39.6 216.7 54.6 228.5 71.9 237.6C72.8 237.7 73.7 238 74.6 238.4C95.4 248.7 118 254.7 141.1 255.9C144.8 256.2 148.4 256.3 152 256.3C222.4 256.3 283.2 216.1 299.7 158.5C301.2 153.4 302.3 148.3 303 143.1C303.1 142.4 303.2 141.7 303.3 141C303.4 140.5 303.4 140.1 303.5 139.6C303.6 139 303.6 138.4 303.7 137.9C303.7 137.3 303.8 136.7 303.8 136.1C303.8 135.9 303.8 135.8 303.8 135.6C303.8 135.1 303.9 134.5 303.9 134C303.9 133.3 304 132.6 304 132C304 131.6 304 131.2 304 130.8C304 130.4 304 130 304 129.7C304 129.4 304 129.2 304 128.9V128.5C304 128.1 304 127.7 304 127.3ZM204 183.3C201.5 184.7 198.4 184.6 195.9 183.1L193.7 181.8L199.5 198.2C201 202.4 198.8 206.9 194.7 208.4C190.5 209.9 186 207.7 184.5 203.6L174.9 176.6C168.3 181.4 160.3 184.1 152.1 184.3C143.9 184.3 136.1 181.5 129.3 176.6L119.7 203.6C118.2 207.8 113.6 209.9 109.5 208.4C105.3 206.9 103.2 202.3 104.7 198.2L117 163.7C109.1 152.3 104.2 137 104.2 120.3C104.2 85.0002 125.7 56.3002 152.2 56.3002C178.7 56.3002 200.2 85.0002 200.2 120.3C200.4 134.4 196.6 148.3 189.5 160.5L204.3 169.4C206.8 170.9 208.3 173.5 208.3 176.4C208.1 179.3 206.5 181.9 204 183.3Z"
                                                        fill="black" />
                                                    <path
                                                        d="M304 127.3C304 126.8 304 126.2 304 125.7C304 125.2 304 124.7 303.9 124.2C301.2 61.1002 243.4 8.7002 169.1 1.7002C168.8 2.7002 168.3 3.60019 168 4.50019C167.3 6.40019 166.6 8.20019 165.8 10.1002C165 12.0002 164.1 13.9002 163.2 15.8002C162.3 17.7002 161.4 19.4002 160.5 21.2002C159.5 23.0002 158.5 24.8002 157.5 26.5002C156.5 28.3002 155.4 30.0002 154.3 31.7002C153.2 33.4002 152 35.1002 150.8 36.7002C149.6 38.3002 148.4 40.0002 147.1 41.7002C145.8 43.3002 144.5 44.8002 143.2 46.4002C141.9 47.9002 140.5 49.5002 139.1 51.1002C137.7 52.6002 136.2 54.0002 134.8 55.5002C133.3 56.9002 131.8 58.4002 130.3 59.8002C128.8 61.2002 127.2 62.6002 125.5 63.9002C123.9 65.2002 122.3 66.6002 120.6 67.9002C118.9 69.2002 117.2 70.4002 115.4 71.7002C113.7 72.9002 112 74.1002 110.2 75.3002C108.4 76.5002 106.5 77.6002 104.6 78.7002C102.7 79.8002 101 80.9002 99.2 81.9002C97.3 82.9002 95.2 84.0002 93.2 85.0002C91.3 85.9002 89.5 86.9002 87.6 87.8002C85.5 88.8002 83.3 89.6002 81.2 90.5002C79.3 91.3002 77.4 92.1002 75.5 92.9002C73.3 93.7002 70.9 94.5002 68.6 95.2002C66.7 95.8002 64.7 96.5002 62.8 97.1002C60.4 97.8002 57.9 98.4002 55.4 99.0002C53.5 99.5002 51.6 100 49.6 100.4C47 101 44.3 101.4 41.6 101.9C39.8 102.2 37.9 102.6 36.1 102.9C33.1 103.3 30 103.6 26.9 103.9C25.3 104.1 23.8 104.3 22.2 104.4C17.5 104.7 12.7 104.9 8 104.9C6.2 104.9 4.5 104.9 2.7 104.8C0.999997 112.2 0.1 119.8 0 127.3C0 127.7 0 128 0 128.4V128.8C0 156.3 10.3 181.7 27.9 202.6C39.6 216.6 54.6 228.4 71.9 237.5C95.2 249.7 122.6 256.8 152 256.8C176.6 256.9 201 251.8 223.5 241.8C225.6 240.8 228.1 240.8 230.2 241.8L296.4 272.7L271.6 214.8C270.4 211.9 270.9 208.6 273 206.3C289.5 188.8 299.9 166.7 303 143.1C303.1 142.4 303.2 141.7 303.3 141C303.4 140.5 303.4 140.1 303.5 139.6C303.6 139 303.6 138.4 303.7 137.9C303.7 137.3 303.8 136.7 303.8 136.1C303.8 135.9 303.8 135.8 303.8 135.6C303.8 135.1 303.9 134.5 303.9 134C303.9 133.3 304 132.6 304 132C304 131.6 304 131.2 304 130.8C304 130.4 304 130 304 129.7C304 129.4 304 129.2 304 128.9V128.5C304 128.1 304 127.7 304 127.3ZM119.5 203.5C118 207.7 113.4 209.8 109.3 208.3C105.1 206.8 103 202.2 104.5 198.1L116.8 163.6L144.5 86.1002C145.6 82.9002 148.7 80.8002 152 80.8002C155.3 80.8002 158.4 82.9002 159.5 86.1002L193.7 181.7L199.5 198.1C201 202.3 198.8 206.8 194.7 208.3C190.5 209.8 186 207.6 184.5 203.5L174.9 176.5L172.1 168.8H132L129.2 176.5L119.5 203.5Z"
                                                        fill="black" />
                                                    <path d="M152 112.6L137.6 152.8H166.3L152 112.6Z" fill="black" />
                                                </svg>
                                            </span>
                                            <div class="text">
                                                <p>
                                                    {{ !empty($que->answers) ? $que->answers : 'We will provide the answer to your question shortly!' }}
                                                </p>
                                                <span
                                                    class="user">{{ !empty($que->admin->name) ? $que->admin->name : '' }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                @if ($question->count() >= '4')
                                <div class="text-center">
                                    <a href="javascript:void(0)" class="load-more-btn btn" data-ajax-popup="true"
                                        data-size="xs" data-title="Questions And Answers"
                                        data-url="{{ route('more_question', [$slug, $product->id]) }} "
                                        data-toggle="tooltip" title="{{ __('Questions And Answers') }}">
                                        {{ __('Load More') }}
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($product->product_attribute != '')
                    <div id="3" class="tab-content ">
                        <div class="queary-div">
                            <div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>{{ __('Additional Information about that Product..') }}</h4>
                                </div>

                                @foreach (json_decode($product->product_attribute) as $key => $choice_option)
                                @php
                                $value = implode(',', $choice_option->values);
                                $idsArray = explode('|', $value);
                                $get_datas = \App\Models\ProductAttributeOption::whereIn('id', $idsArray)
                                ->get()
                                ->pluck('terms')
                                ->toArray();

                                $attribute_id = $choice_option->attribute_id;
                                $visible_attribute = isset($choice_option->{'visible_attribute_' . $attribute_id}) ?
                                $choice_option->{'visible_attribute_' . $attribute_id} : 0;
                                @endphp
                                @if ($visible_attribute == 1)
                                <div class="row row-gap">
                                    <div class="col-md-6 col-12">
                                        <div class="pro-descrip-contente-left">
                                            <div class="section-title">
                                                <h6>{{ \App\Models\ProductAttribute::find($choice_option->attribute_id)->name }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="pro-descrip-contente-right">
                                            <div class="badge-wrapper">
                                                @foreach ($get_datas as $f)
                                                <div class="badge">
                                                    {{ $f }}
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    @include('front_end.hooks.product_tab_form')

                </div>
            </div>
        </div>
    </section>
    @include('front_end.hooks.product_detail_slider')

    <!-- description sec end  -->
</div>

<div class="main-parent-bottom">

    <img src="{{asset('themes/'.$currentTheme.'/assets/images/right.png')}}" class="d-right" style="top: -15%;">

    <!-- testimonials slider start  -->
    @include('front_end.sections.homepage.review_section')
    <!-- testimonials slider end  -->
    <!-- filter gallary start -->
    @include('front_end.sections.homepage.product_section')
    <!-- filter gallary end -->

    <!-- subcscribe banner start  -->
    @include('front_end.sections.homepage.subscribe_section')
    <!-- subcscribe banner end  -->
</div>

@include('front_end.sections.partision.footer_section')
@endsection

@push('page-script')
<script src="{{ asset('public/js/flipdown.js') }}"></script>
@endpush
