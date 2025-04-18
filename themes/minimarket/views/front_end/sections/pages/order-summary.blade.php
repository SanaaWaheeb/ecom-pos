
@extends('front_end.layouts.app')
@section('page-title')
    {{ __('Order Page') }}
@endsection
@section('content')
@include('front_end.sections.partision.header_section')
    <section class="order-summery-page padding-bottom padding-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-12">
                    <div class="section-title text-center">
                        @if (!empty($order_data))
                            <h2>{{ __('Your order #') }}{{ $order_data->product_order_id }} {{ __('has been placed!') }}
                            </h2>
                        @else
                            <h2>{{ __('Your order #') }}{{ $order_id }}{{ __('has been placed!') }} </h2>
                        @endif
                        <p><b>{{ $order_complate_title }}</b><br>
                            {{ $order_complate_description }}  </p>
                        @if (!empty($order_data))
                            <div class="order-summery-input input-wrapper">
                                <input type="text"
                                    value="{{ env('APP_URL') .'/'. $slug . '/order/' . \Illuminate\Support\Facades\Crypt::encrypt($order_data->id) }}"
                                    aria-label="Recipient's username" aria-describedby="button-addon2" readonly="">
                                <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard(this)"
                                    id="{{ env('APP_URL').'/'. $slug . '/order/' . \Illuminate\Support\Facades\Crypt::encrypt($order_data->id) }}"><i
                                        class="far fa-copy"></i> {{ __('Copy Link') }}</button>
                            </div>
                        @else
                            <div class="order-summery-input input-wrapper">
                                <input type="text"
                                    value="{{ env('APP_URL').'/' . $slug . '/order/' . \Illuminate\Support\Facades\Crypt::encrypt($orders_data->id) }}"
                                    aria-label="Recipient's username" aria-describedby="button-addon2" readonly="">
                                <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard(this)"
                                    id="{{ env('APP_URL').'/' . $slug . '/order/' . \Illuminate\Support\Facades\Crypt::encrypt($orders_data->id) }}"><i
                                        class="far fa-copy"></i> {{ __('Copy Link') }}</button>
                            </div>
                        @endif
                        <div class="d-flex justify-content-center backbtn">
                            <a href="{{ route('landing_page', $slug) }}" class="btn">
                                <svg viewBox="0 0 10 5">
                                    <path d="M2.37755e-08 2.57132C-3.38931e-06 2.7911 0.178166 2.96928 0.397953 2.96928L8.17233 2.9694L7.23718 3.87785C7.07954 4.031 7.07589 4.28295 7.22903 4.44059C7.38218 4.59824 7.63413 4.60189 7.79177 4.44874L9.43039 2.85691C9.50753 2.78197 9.55105 2.679 9.55105 2.57146C9.55105 2.46392 9.50753 2.36095 9.43039 2.28602L7.79177 0.69418C7.63413 0.541034 7.38218 0.544682 7.22903 0.702329C7.07589 0.859976 7.07954 1.11192 7.23718 1.26507L8.1723 2.17349L0.397965 2.17336C0.178179 2.17336 3.46059e-06 2.35153 2.37755e-08 2.57132Z">
                                    </path>
                                </svg>
                                {{ __('Back to dashboard') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('front_end.sections.partision.footer_section')
@endsection
@push('scripts')
@endpush

<script>
    function copyToClipboard(element) {
        var copyText = element.id;
        document.addEventListener('copy', function(e) {
            e.clipboardData.setData('text/plain', copyText);
            e.preventDefault();
        }, true);

        document.execCommand('copy');
        show_toastr('success', 'Url copied to clipboard', 'success');
    }
</script>
