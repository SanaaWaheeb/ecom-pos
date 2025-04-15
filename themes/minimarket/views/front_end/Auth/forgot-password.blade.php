@extends('front_end.layouts.app')
@section('page-title')
    {{ __('Login Page') }}
@endsection

@section('content')
    @include('front_end.sections.partision.header_section')
    <section class="register-page forgot-page padding-bottom padding-top">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-12">
                <div class="d-flex justify-content-center back-toshop">
                    <a href="{{route('page.product-list',$slug)}}" class="back-btn">
                    <span class="svg-ic">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none">
                                        <circle cx="15.5" cy="15.5" r="15.0441" stroke="white" stroke-width="0.911765"></circle>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5867 15.7639C20.5867 15.9859 20.4067 16.1658 20.1848 16.1658L12.3333 16.1659L13.2777 17.0834C13.4369 17.2381 13.4406 17.4925 13.2859 17.6517C13.1313 17.8109 12.8768 17.8146 12.7176 17.66L11.0627 16.0523C10.9848 15.9766 10.9409 15.8727 10.9409 15.7641C10.9409 15.6554 10.9848 15.5515 11.0627 15.4758L12.7176 13.8681C12.8768 13.7135 13.1313 13.7172 13.2859 13.8764C13.4406 14.0356 13.4369 14.29 13.2777 14.4447L12.3333 15.3621L20.1848 15.362C20.4067 15.362 20.5867 15.5419 20.5867 15.7639Z" fill="white"></path>
                                </svg>
                            </span>
                        {{ __('Back to Shop') }}
                    </a>
                </div>
                <div class="section-title text-center">
                    <h2>{{ __('Forgot Password') }}</h2>
                </div>
                <div class="form-wrapper">
                    {{-- <x-auth-session-status class="mb-4" :status="session('status')" />               --}}
                    <form method="POST" action="{{ route('customer.password.email',$slug) }}">
                        @csrf
                        <div class="form-container">
                            <div class="form-heading">
                                <h3>{{ __('Forgot Password') }}</h3>
                            </div>
                        </div>
                        <div class="form-container">
                            <div class="row">
                                <div class="col-12">
                                    <p> {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }} </p>
                                    <br>

                                    <!-- password sent Session Status -->
                                    @if(!empty(trim(session('status'))))
                                    <p> {{ session('status') }}  </p> <br>
                                    @endif

                                    <!-- Validation Errors -->
                                    @if ($errors->any())
                                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                            @foreach ($errors->all() as $error)
                                                <li class="text-sm text-danger text-600">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <br>
                                    @endif
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>{{ __('E-mail') }}<sup aria-hidden="true">*</sup>:</label>
                                        <input type="email" name="email" class="form-control" placeholder="shop@company.com" required="">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex align-items-end justify-content-end mobile-direction-column">
                                    <div class="form-group">
                                        {{-- <label class="opacity-0"></label> <br>
                                        {!! Form::hidden('type', 'customer') !!} --}}
                                        <button type="submit" class="btn submit-btn w-auto common-btn">
                                            {{ __('Email Password Reset Link') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="14" viewBox="0 0 35 14" fill="none">
                                                <path d="M25.0749 14L35 7L25.0805 0L29.12 6.06667H0V7.93333H29.12L25.0749 14Z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
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