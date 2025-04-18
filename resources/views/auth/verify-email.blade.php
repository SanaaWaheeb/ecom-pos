@php
$adminSetting = getSuperAdminAllSetting();
config([
    'captcha.secret' => $adminSetting['NOCAPTCHA_SECRET'] ?? '',
    'captcha.sitekey' => $adminSetting['NOCAPTCHA_SITEKEY'] ?? '',
    'options' => [
        'timeout' => 30,
    ],
]);
@endphp


@extends('layouts.guest')

@section('page-title')
    {{ __('Varify-Email') }}
@endsection
@if (isset($adminSetting['cust_darklayout']) && $adminSetting['cust_darklayout'] == 'on')
    <style>
        .g-recaptcha {
            filter: invert(1) hue-rotate(180deg) !important;
        }
    </style>
@endif
@section('content')
    <div>
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (isset($adminSetting['RECAPTCHA_MODULE']) && $adminSetting['RECAPTCHA_MODULE'] == 'yes')
            @if (isset($adminSetting['NOCAPTCHA_VERSON']) && $adminSetting['NOCAPTCHA_VERSON'] == 'v2')
                <div class="form-group col-lg-12 col-md-12 mt-3">
                    {!! NoCaptcha::display((isset($adminSetting['cust_darklayout']) && $adminSetting['cust_darklayout'] == 'on') ? ['data-theme' => 'dark'] : []) !!}
                    @error('g-recaptcha-response')
                        <span class="small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @else
                <div class="form-group col-lg-12 col-md-12 mt-3">
                    <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" class="form-control">
                    @error('g-recaptcha-response')
                        <span class="error small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @endif
        @endif

        <div class="mt-4 flex items-center justify-between">
            <div class="row">
                <div class="col-auto">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </form>
                </div>
                <div class="col-auto">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            {{ __('Logout') }}</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
@if (isset($adminSetting['RECAPTCHA_MODULE']) && $adminSetting['RECAPTCHA_MODULE'] == 'yes')
    @if (isset($adminSetting['NOCAPTCHA_VERSON']) && $adminSetting['NOCAPTCHA_VERSON'] == 'v2')
            {!! NoCaptcha::renderJs() !!}
    @else
        <script src="https://www.google.com/recaptcha/api.js?render={{ $adminSetting['NOCAPTCHA_SECRET'] }}"></script>
        <script>
            $(document).ready(function() {
                grecaptcha.ready(function() {
                    grecaptcha.execute('{{ $adminSetting['NOCAPTCHA_SECRET'] }}', {
                        action: 'submit'
                    }).then(function(token) {
                        $('#g-recaptcha-response').val(token);
                    });
                });
            });
        </script>
    @endif
@endif
@endpush
