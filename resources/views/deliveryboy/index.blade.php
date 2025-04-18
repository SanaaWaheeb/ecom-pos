@extends('layouts.app')

@section('page-title')
    {{ __('DeliveryBoy') }}
@endsection

@php
    $logo = asset(Storage::url('uploads/profile/'));
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">{{ __('DeliveryBoy') }}</li>
@endsection

@section('action-button')
    <div class="text-end d-flex all-button-box justify-content-md-end justify-content-center">
        <a href="{{ route('deliveryboy.list') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('List View') }}" class="btn btn-sm btn-primary btn-icon ">
                <i class="ti ti-list"></i>
            </a>
        @permission('Create DeliveryBoy')
        <a href="#" class="btn btn-sm btn-primary btn-badge mx-1" data-ajax-popup="true" data-size="md" data-title="{{__('Create DeliveryBoy')}}"
            data-url="{{ route('deliveryboy.create') }}" data-bs-toggle="tooltip" title="{{ __('Add DeliveryBoy') }}">
            <i class="ti ti-plus"></i>
        </a>
        @endpermission
    </div>
@endsection
@section('content')
    <div class="delivery-user-cards">
        <div class="row">
            @foreach ($deliveryboys as $deliveryboy)
                <div class="col-lg-3 col-sm-6 col-md-6">
                    <div class="card text-center">
                        <div class="card-inner">
                            <div class="card-header border-0 pb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <div class="badge p-2 px-3 rounded bg-primary">{{ ucfirst($deliveryboy->type) }}</div>
                                    </h6>
                                </div>
                                    <div class="card-header-right">
                                        <div class="btn-group card-option">
                                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="feather icon-more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                @permission('Edit Deliveryboy')
                                                    <a href="#" class="dropdown-item"
                                                        data-url="{{ route('deliveryboy.edit', $deliveryboy->id) }}" data-size="md"
                                                        data-ajax-popup="true" data-title="{{ __('Update DeliveryBoy') }}">
                                                        <i class="ti ti-edit"></i>
                                                        <span class="ms-2">{{ __('Edit') }}</span>
                                                    </a>
                                                @endpermission
                                                @permission('Reset password Deliveryboy')
                                                    <a href="#" class="dropdown-item"
                                                        data-url="{{ route('deliveryboy.reset', \Crypt::encrypt($deliveryboy->id)) }}"
                                                        data-ajax-popup="true" data-size="md" data-title="{{ __('Change Password') }}">
                                                        <i class="ti ti-key"></i>
                                                        <span class="ms-2">{{ __('Reset Password') }}</span>
                                                    </a>
                                                @endpermission
                                                @permission('Delete Deliveryboy')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['deliveryboy.destroy', $deliveryboy->id], 'class' => 'd-inline']) !!}
                                                    <a href="#" class="bs-pass-para dropdown-item show_confirm" data-confirm="{{ __('Are You Sure?') }}"
                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-text-yes="{{ __('Yes') }}" data-text-no="{{ __('No') }}" 
                                                        data-confirm-yes="delete-form-{{ $deliveryboy->id }}"><i class="ti ti-trash"></i>
                                                        <span class="ms-2">{{ __('Delete') }}</span>
                                                    </a>
                                                    {!! Form::close() !!}
                                                @endpermission
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="card-body">
                                <div class="img-fluid rounded-circle card-avatar">
                                    <a href="{{ !empty($deliveryboy->profile_image) ? asset($deliveryboy->profile_image) : asset('storage/uploads/profile/avatar.png') }}"
                                        target="_blank">
                                        <img src="{{ !empty($deliveryboy->profile_image) ? asset($deliveryboy->profile_image) : asset('storage/uploads/profile/avatar.png') }}"
                                            class="img-user wid-80 round-img rounded-circle">
                                    </a>
                                </div>
                                <h4 class="mt-2 text-primary">{{ $deliveryboy->name }}</h4>
                                <small class="">{{ $deliveryboy->email }}</small>
                            </div>
                        </div>
                    
                    </div>
                </div>
            @endforeach
            <div class="col-lg-3 col-sm-6 col-md-6">
                @permission('Create DeliveryBoy')
                    <a class="btn-addnew-project" data-url="{{ route('deliveryboy.create') }}" data-title="{{ __('Create DeliveryBoy') }}"
                        data-ajax-popup="true" style="cursor: pointer; ">
                        <div class="btn btn-sm btn-primary btn-badge" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Add DeliveryBoy') }}">
                            <i class="ti ti-plus"></i>
                        </div>
                        <h6 class="mt-4 mb-2">{{ __('Create New DeliveryBoy') }}</h6>
                        <p class="text-muted text-center">{{ __('Click here to Create New DeliveryBoy') }}</p>
                    </a>
                @endpermission
            </div>
        </div>
    </div>
   
@endsection
