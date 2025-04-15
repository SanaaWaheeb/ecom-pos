<form class="subscribe-form" action='{{ route("newsletter.store",$slug) }}' method="post">
    @csrf
    <div class="form-inputs">
        <input type="email" placeholder="Type your email address..." class="form-control border-radius-50" name="email">
        <button type="submit" class="btn">
            {{ __('Subscribe')}}
        </button>
    </div>
        <label for="subscribecheck" id="{{ $section->subscribe->section->sub_title->slug ?? '' }}_preview">
            {!! $section->subscribe->section->sub_title->text ?? '' !!}
        </label>
</form>
