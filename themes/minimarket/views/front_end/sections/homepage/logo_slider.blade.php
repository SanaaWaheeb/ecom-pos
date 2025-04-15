<section class="couner-number-sec padding-bottom" style="position: relative;@if (isset($option) && $option->is_hide == 1) opacity: 0.5; @else opacity: 1; @endif"
    data-index="{{ $option->order ?? '' }}" data-id="{{ $option->order ?? '' }}" data-value="{{ $option->id ?? '' }}"
    data-hide="{{ $option->is_hide ?? '' }}" data-section="{{ $option->section_name ?? '' }}"
    data-store="{{ $option->store_id ?? '' }}" data-theme="{{ $option->theme_id ?? '' }}">
    <div class="custome_tool_bar"></div>
    <div class=" container">
        <div class="row numbers-row">
            @for ($i = 0; $i < $section->logo_slider->loop_number; $i++)
                <div class="col-lg-3 col-sm-3 col-12">
                    <div class="number-box">
                        <h2 id="{{ $section->logo_slider->section->description->slug ?? '' }}_preview">
                            {!! $section->logo_slider->section->description->text->{$i} ?? '' !!}+</h2>
                        <p id="{{ $section->logo_slider->section->title->slug ?? '' }}_preview">
                            {!! $section->logo_slider->section->title->text->{$i} ?? '' !!}</p>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
