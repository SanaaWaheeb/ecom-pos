<section class="article-sec padding-bottom"
    style="position: relative;@if(isset($option) && $option->is_hide == 1) opacity: 0.5; @else opacity: 1; @endif"
    data-index="{{ $option->order ?? '' }}" data-id="{{ $option->order ?? '' }}" data-value="{{ $option->id ?? '' }}"
    data-hide="{{ $option->is_hide ?? '' }}" data-section="{{ $option->section_name ?? '' }}"
    data-store="{{ $option->store_id ?? '' }}" data-theme="{{ $option->theme_id ?? '' }}">
    <div class="custome_tool_bar"></div>
    <img src="{{ asset('themes/' . $currentTheme . '/assets/images/d8.png ') }}" class="d-left" style="top: 25%;">
    <img src="{{ asset('themes/' . $currentTheme . '/assets/images/left.png') }}" class="d-left" style="top: -35%;">
    <div class=" container">
        <div class="common-heading">
            <span class="sub-heading" id="{{ ($section->blog->section->sub_title->slug ?? '') }}_preview">{!!
                $section->blog->section->sub_title->text ?? "" !!}</span>
            <h2 id="{{ ($section->blog->section->title->slug ?? '') }}_preview">{!!$section->blog->section->title->text
                ?? ""!!}</h2>
        </div>
        <div class="article-slider flex-slider">
            {!! \App\Models\Blog::HomePageBlog($currentTheme ,$slug, 10) !!}
        </div>
    </div>
</section>