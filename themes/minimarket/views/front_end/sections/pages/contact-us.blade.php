@extends('front_end.layouts.app')
@section('page-title')
{{ __('Contact Us Page') }}
@endsection
@section('content')
@include('front_end.sections.partision.header_section')
    <section class="common-banner-section top-bg-section">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-12">
                    <div class="heading-wrapper">
                        <a href="{{ route('landing_page',$slug) }}" class="back-btn">
                            <span class="svg-ic">
                                <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none">
                                    <circle cx="15.5" cy="15.5" r="15.0441" stroke="#000" stroke-width="0.911765"></circle>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5867 15.7639C20.5867 15.9859 20.4067 16.1658 20.1848 16.1658L12.3333 16.1659L13.2777 17.0834C13.4369 17.2381 13.4406 17.4925 13.2859 17.6517C13.1313 17.8109 12.8768 17.8146 12.7176 17.66L11.0627 16.0523C10.9848 15.9766 10.9409 15.8727 10.9409 15.7641C10.9409 15.6554 10.9848 15.5515 11.0627 15.4758L12.7176 13.8681C12.8768 13.7135 13.1313 13.7172 13.2859 13.8764C13.4406 14.0356 13.4369 14.29 13.2777 14.4447L12.3333 15.3621L20.1848 15.362C20.4067 15.362 20.5867 15.5419 20.5867 15.7639Z" fill="#000"></path>
                                </svg>
                            </span>
                            {{$page_json->contact_page->section->button->text ??__('Back to Home') }}
                        </a>
                        <div class="section-title">
                            <h2> {{$page_json->contact_page->section->title->text ??__('Contact Us')}}  </h2>
                        </div>
                        <p>{{$page_json->contact_page->section->description->text ??__('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown.')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-page padding-bottom padding-top">
        <div class="container">
            <div class="row">
                @php
                    $customer = auth('customers')->user();
                    if($customer)
                    {
                        $DeliveryAddress = \App\Models\DeliveryAddress::where('customer_id', auth('customers')->user()->id)->orderBy('id', 'desc')->first();
                    }
                @endphp
                <div class="col-md-5 col-12 contact-left-column">
                    <div class="contact-left-inner row">
                        <ul class="col-sm-6 col-12">
                            <li>
                                <h3> {{ __('Call us:')}} </h3>
                                <p><a href="tel:+48 0021-32-12">{{isset($customer->mobile) ? $customer->mobile : '+48 0021-32-12'}}</a></p>

                            </li>
                            <li>
                                <h3> {{ __('Email:')}} </h3>
                                <p><a href="mailto:shop@company.com">{{isset($customer->email) ? $customer->email : 'shop@company.com'}}</a></p>
                            </li>
                        </ul>
                        <ul class="col-sm-6 col-12">
                            <li>
                                <h3> {{ __('Address:')}} </h3>
                                <p class="address">{{isset($DeliveryAddress->address) ? $DeliveryAddress->address : 'Marigold Lane,Coral Way, Miami,Florida, 33169'}}</p>
                            </li>
                        </ul>
                    </div>
                    @include('front_end.hooks.contact_us')
                </div>
                <div class="col-md-7 col-12 contact-right-column">
                    <div class="contact-right-inner">
                            <form class="contact-form" action="{{ route('contacts.store') }}" method="post">
                                @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label> {{ _('First Name') }} <sup aria-hidden="true">*</sup>:</label>
                                                <input type="text" name="first_name" class="form-control"  placeholder="John" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label> {{ __('Last Name') }} <sup aria-hidden="true">*</sup>:</label>
                                                <input type="text" name="last_name" class="form-control"  placeholder="Doe" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label> {{ __('E-mail') }} <sup aria-hidden="true">*</sup>:</label>
                                                <input type="email" name="email" class="form-control" placeholder="shop@company.com" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label> {{ __('Telephone') }} <sup aria-hidden="true">*</sup>:</label>
                                                <input type="number"  name="contact" class="form-control"  placeholder="1234567890" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label> {{ __('Subject:') }} </label>
                                                <input type="text" name="subject" class="form-control"  placeholder="Doe" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label> {{ __('Description:') }} </label>
                                                <textarea  class="form-control" name="description"  placeholder="How can we help?" rows="8"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                <div class="row align-items-center">
                                    <div class="col-lg-8   col-12">
                                        <div class="checkbox-custom">
                                            <input type="checkbox" id="ch1">
                                            <label for="ch1">
                                                <span> {{ __('I have read and agree to the') }} <a href=""> {{ __('Terms & Conditions.') }} </a>  </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-12">
                                        <button class="btn submit-btn" type="submit">
                                            {{ __('Send message') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14" viewBox="0 0 35 14" fill="none">
                                                <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('front_end.sections.partision.footer_section')
@endsection
@push('scripts')
@endpush

