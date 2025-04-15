@extends('front_end.layouts.app')
@section('page-title')
    {{ __('Blog Page') }}
@endsection
@section('content')
    @include('front_end.sections.partision.header_section')
    <section class="top-bg-wrapper blog-wrapper"
          style="background-image:url({{ get_file( $page_json->blog_page->section->image->image ?? 'themes/' . $currentTheme . '/assets/images/article-pic.png', $currentTheme)}});">

          <div class=" container">
                <div class="col-md-6 col-12">
                    <div class="common-banner-content">
                        <ul class="blog-cat">
                            <li class="active"><a href="#">{{ __('Featured') }}</a></li>
                        </ul>
                        <div class="section-title">
                            <h2>{{ $page_json->blog_page->section->title->text ?? __('Blog & Articles') }}</h2>
                            <p>{{$page_json->blog_page->section->description->text ?? __('The blog and article section serves as a treasure trove of valuable information.') }}</p>
                        </div>
                        <a href="#" class="common-btn2 white-btn" tabindex="0">
                            {{ __('Read More') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="blog-grid-section padding-top padding-bottom">
            <div class="container">
                <div class="section-title d-flex justify-content-between align-items-end ">
                    <div class="blog-title">
                        <span>{{ __('ALL PRODUCTS') }}</span>
                        <h2>{{ __('From our blog') }}</h2>
                    </div>
                    <a href="#" class="common-btn2 white-btn" tabindex="0">
                        {{ __(' Read More') }}
                    </a>
                </div>
                <div class="blog-head-row d-flex justify-content-between">
                    <div class="blog-col-left">
                        <ul class="d-flex tabs">
                            @foreach ($BlogCategory as $cat_key => $category)
                                <li class="tab-link on-tab-click {{ $cat_key == 0 ? 'active' : '' }}"
                                    data-tab="{{ $cat_key }}">
                                    <a href="javascript:;">{{ $category }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="blog-col-right d-flex align-items-center justify-content-end">
                        <span class="select-lbl"> {{ __('Sort by') }} </span>
                        <select class="position">
                            <option value="lastest"> {{ __('Lastest') }} </option>
                            <option value="new"> {{ __('new') }} </option>
                        </select>
                    </div>
                </div>
                @foreach ($BlogCategory as $cat_k => $category)
                    <div id="{{ $cat_k }}" class="tab-content tab-cat-id {{ $cat_k == 0 ? 'active' : '' }}">
                        <div class="row blog-grid f_blog">
                            @foreach ($blogs as $blog)
                                @if ($cat_k == '0' || $blog->category_id == $cat_k)

                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 blog-card">
                                        <div class="article-card">
                                            <a href="{{ route('page.article', [$slug,$blog->id]) }}" class="img-wraper">
                                                <img src="{{ get_file($blog->cover_image_path, $currentTheme) }}"
                                                    alt="card-img" class="cover_img{{ $blog->id }}">
                                            </a>
                                            <div class="card-content blog-caption">
                                                <span>{{ $blog->category->name }}</span>
                                                <h3><a href="{{ route('page.article', [$slug,$blog->id]) }}"> {{ $blog->title }} </a>
                                                </h3>
                                                <p>{{ $blog->short_description }}</p>
                                                <span class="date"> <a href="#">@john</a> •
                                                    {{ $blog->created_at->format('d M,Y ') }}</span>
                                                <a href="{{ route('page.article', [$slug,$blog->id]) }}"
                                                    class="common-btn2">{{ __('Read More') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    @include('front_end.sections.partision.footer_section')
@endsection

