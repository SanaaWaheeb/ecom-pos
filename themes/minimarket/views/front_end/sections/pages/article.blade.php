@extends('front_end.layouts.app')
@section('page-title')
{{ __('Article Page') }}
@endsection
@section('content')
@include('front_end.sections.partision.header_section')
@foreach ($blogs as $blog)

<section class="top-bg-wrapper blog-wrapper"
style="background-image:url({{ get_file( $page_json->article_page->section->image->image ?? 'themes/' . $currentTheme . '/assets/images/article-pic.png', $currentTheme)}});">
    <div class=" container">

        <div class="col-md-6 col-12">
            <div class="common-banner-content">
                <ul class="blog-cat">
                    <li class="active"><a href="#">{{__('Featured')}}</a></li>
                    <li><a href="#"><b>{{__('Category:')}}</b>{{$blog->category->name}}</a></li>
                    <li><a href="#"><b>{{__('Date:')}}</b> {{$blog->created_at->format('d M, Y ')}}</a></li>
                </ul>
                <div class="section-title common-heading">
                    <h2>{{$blog->title}}</h2>
                    <p>{{$blog->short_description}}</p>
                </div>
                <a href="{{ route('landing_page',$slug) }}" class="common-btn2 white-btn" tabindex="0">
                    {{ $page_json->article_page->section->button->text ?? __('Back to Home') }}
                </a>
            </div>
        </div>
    </div>
</section>

<section class="article-section padding-top" style="color:black;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="about-user d-flex align-items-center">
                    <div class="abt-user-img">
                        <img src="{{ asset('themes/' . $currentTheme . '/assets/images/article-user.png')}}">
                    </div>
                    <h3>
                        <span>{{__('John Doe,')}}</span>
                        {{__('company.com')}}
                    </h3>
                    <div class="post-lbl"><b>{{__('Category:')}}</b> {{$blog->category->name}}</div>
                    <div class="post-lbl"><b>{{__('Date:')}}</b> {{$blog->created_at->format('d M, Y ')}}</div>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="aticleleftbar">
                    {!! html_entity_decode($blog->content) !!}
                    <div class="art-auther"><b>{{__('Tags:')}}</b>{{$blog->category->name}}</div>

                    <ul class="article-socials d-flex align-items-center">
                        <li><span>{{__('Share:') }}</span></li>

                        @for($i=0 ; $i < $section->footer->section->footer_link->loop_number ?? 1;$i++) <li>
                                <a href="{!!$section->footer->section->footer_link->social_link->{$i} ?? '#' !!}">
                                    <img src="{{ get_file($section->footer->section->footer_link->social_icon->{$i}->image ?? 'themes/' . $currentTheme . '/assets/images/youtube.svg', $currentTheme) }}"
                                        alt="youtube">
                                </a>

                            </li>
                            @endfor
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="articlerightbar">
                    <div class="section-title">
                        <h3>{{__('Related articles')}}</h3>
                    </div>
                    @foreach ($datas->take(2) as $data)

                    <div class="row blog-grid">
                        <div class="col-md-12 col-sm-6 col-12 blog-widget">
                            <div class="article-card blog-caption">
                                <a href="{{route('page.article',[$slug,$data->id])}}" class="img-wraper">
                                    <img src="{{ get_file($data->cover_image_path, $currentTheme) }}" alt="card-img">
                                </a>
                                <div class="card-content">
                                    <span>{{$blog->category->name}}</span>
                                    <h4><a href="#">{{$data->title}}</a></h4>
                                    <p>{{$data->short_description}}</p>
                                    <span class="date"> <a href="{{route('page.article',[$slug,$data->id])}}">@john</a>
                                        • {{$blog->created_at->format('d M, Y ')}}</span>
                                    <a href="{{route('page.article',[$slug,$data->id])}}" class="common-btn2">Read
                                        More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endforeach
<div class="container">
    <hr class="hr-line">
</div>
<section class="blog-grid-section padding-top  padding-bottom ">
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
                    <li class="tab-link on-tab-click {{ $cat_key == 0 ? 'active' : '' }}" data-tab="{{ $cat_key }}">
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

                            <img src="{{ get_file($blog->cover_image_path, $currentTheme) }}" alt="card-img"
                                class="cover_img{{ $blog->id }}">
                        </a>
                        <div class="card-content blog-caption">
                            <span>{{ $blog->category->name }}</span>
                            <h3><a href="{{ route('page.article', [$slug,$blog->id]) }}"> {{ $blog->title }} </a>
                            </h3>
                            <p class="description">{{ $blog->short_description }}</p>
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
