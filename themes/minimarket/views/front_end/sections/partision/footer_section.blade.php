<footer class="site-footer"
    style="position: relative;@if(isset($option) && $option->is_hide == 1) opacity: 0.5; @else opacity: 1; @endif"
    data-index="{{ $option->order ?? '' }}" data-id="{{ $option->order ?? '' }}" data-value="{{ $option->id ?? '' }}"
    data-hide="{{ $option->is_hide  ?? '' }}" data-section="{{ $option->section_name  ?? '' }}"
    data-store="{{ $option->store_id  ?? '' }}" data-theme="{{ $option->theme_id ?? '' }}">
    <div class="custome_tool_bar"></div>

    
    @include('front_end.hooks.footer_link')

    <img src="{{ get_file($section->footer->section->background_image->image ?? '') }}"
        class="{{ $section->footer->section->background_image->slug ?? '' }}_preview" alt="footer-leaf"
        id="footer-leaf">
    <div class="footer-top">
        <div class=" container">
            <div class="row main-footer">
                <div class=" col-lg-7 col-12 col-12">
                    <div class=" row">
                        <div class=" col-md-6 col-12">
                            <div class="footer-col footer-description">
                                <div class="footer-time"
                                    id="{{ $section->footer->section->title->slug ?? '' }}_preview">
                                    {!! $section->footer->section->title->text ?? '' !!}
                                </div>
                                <p id="{{ $section->footer->description->title->slug ?? '' }}_preview"> {!!
                                    $section->footer->section->description->text !!}</p>
                            </div>
                        </div>
                        @if(isset($section->footer->section->footer_menu_type))
                        @for ($i = 0; $i < $section->footer->section->footer_menu_type->loop_number ?? 1; $i++)
                            @if(isset($section->footer->section->footer_menu_type->footer_title->{$i}))
                            <div class=" col-md-3 col-12">
                                <div class="footer-col footer-shop">
                                    <h2 class="footer-title">
                                        {{ $section->footer->section->footer_menu_type->footer_title->{$i} ?? '' }}
                                    </h2>
                                    @php
                                    $footer_menu_id = $section->footer->section->footer_menu_type->footer_menu_ids->{$i}
                                    ?? '';
                                    $footer_menu = get_nav_menu($footer_menu_id);
                                    @endphp
                                    <ul>
                                        @if (!empty($footer_menu))
                                        @foreach ($footer_menu as $key => $nav)
                                        @if ($nav->type == 'custom')
                                        <li><a href="{{ url($nav->slug) }}" target="{{ $nav->target }}">
                                                @if ($nav->title == null)
                                                {{ $nav->title }}
                                                @else
                                                {{ $nav->title }}
                                                @endif
                                            </a></li>
                                        @elseif($nav->type == 'category')
                                        <li><a href="{{ url($slug.'/'.$nav->slug) }}"
                                                target="{{ $nav->target }}">
                                                @if ($nav->title == null)
                                                {{ $nav->title }}
                                                @else
                                                {{ $nav->title }}
                                                @endif
                                            </a></li>
                                        @else
                                        <li><a href="{{ url($slug.'/custom/'.$nav->slug) }}"
                                                target="{{ $nav->target }}">
                                                @if ($nav->title == null)
                                                {{ $nav->title }}
                                                @else
                                                {{ $nav->title }}
                                                @endif
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            @endif
                            @endfor
                            @endif
                    </div>
                </div>
                <div class="col-lg-5 col-12">
                    <div class=" row">
                        <div class=" col-lg-7 col-12">
                            <div class="footer-col footer-insta-gallary">
                                <h2 class="footer-title"
                                    id="{{ $section->footer->section->footer_title->slug ?? '' }}_preview"> {!!
                                    $section->footer->section->footer_title->text ?? '' !!}</h2>
                                <ul class="d-flex align-items-center flex-wrap">
                                    @for($i=0; $i<count(objectToArray($section->footer->section->image->image)); $i++)
                                        <li class="gallary-img">
                                            <img src="{{ get_file($section->footer->section->image->image->{$i} ?? '') }}"
                                                alt="logo">
                                        </li>
                                        @endfor
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-5 col-12">
                            <div class="footer-icons social-media">
                                <h2 class="footer-title"
                                    id="{{ $section->footer->section->sub_title->slug ?? '' }}_preview"> {!!
                                    $section->footer->section->sub_title->text ?? '' !!}</h2>
                                <ul class="d-flex align-items-center">
                                    @if (isset($section->footer->section->footer_link))
                                    @for ($i = 0; $i < $section->footer->section->footer_link->loop_number ?? 1;
                                        $i++)
                                        <li>
                                            <a href="{{ $section->footer->section->footer_link->social_link->{$i} ?? '#' }}"
                                                target="_blank" id="social_link_{{ $i }}">
                                                <img src="{{ get_file($section->footer->section->footer_link->social_icon->{$i}->image ?? 'themes/' . $currentTheme . '/assets/images/youtube.svg', $currentTheme) }}"
                                                    class="{{ 'social_icon_' . $i . '_preview' }}" alt="icon"
                                                    id="social_icon_{{ $i }}">
                                            </a>
                                        </li>
                                        @endfor
                                        @endif
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class=" container">
            <div class="footer-copyright">
                <p>© 2024 Foodmart. All rights reserved</p>

            </div>
        </div>
    </div>
</footer>
<!-- footer end  -->
<div class="overlay cart-overlay"></div>
<div class="cartDrawer cartajaxDrawer">
</div>

<div class="overlay wish-overlay"></div>
<div class="wishDrawer wishajaxDrawer">
</div>
</body>

</html>