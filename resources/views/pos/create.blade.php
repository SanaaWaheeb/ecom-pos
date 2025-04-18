
@php
    $logo= get_file('uploads/logo');
    $store_id = \App\Models\Store::where('id', getCurrentStore())->first();
    $Tax =  \App\Models\Tax::where('store_id', getCurrentStore())->where('theme_id', APP_THEME())->first();
@endphp
@if (!empty($sales) && count($sales['data']) > 0)
    <div class="card">
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-6">
                </div>

            </div>
            <div id="printableArea">
                <div class="row mt-3">
                    <div class="col-6">
                        <h1 class="invoice-id h6">#{{ $details['pos_id'] }}</h1>
                        <div class="date"><b>{{ __('Date') }}: </b>{{ $details['date'] }}</div>
                    </div>
                    <div class="col-6 text-end">
                        <div class="text-dark "><b>{{ __('Store Name') }}: </b>
                            {!! $details['store']['name'] !!}
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col contacts billed-details d-flex justify-content-between pb-4">
                        <div class="invoice-to billed-to">
                            <div class="text-dark  h6"><b>{{ __('Billed To :') }}</b>
                                {!! $details['customer']['details'] !!}
                            </div>
                        </div>
                        @if(!empty( $details['customer']['shippdetails']))
                            <div class="invoice-to billed-to ">
                                <div class="text-dark h6"><b>{{ __('Shipped To :') }}</b></div>
                            {!! $details['customer']['shippdetails'] !!}
                            </div>
                        @endif
                        <div class="company-details  ">
                            <div class="text-dark h6 me-2"><b>{{ __('From:') }}</b> {!! $details['user']['details'] !!}</div>


                        </div>
                    </div>
                </div>
                <div class="row" style="overflow-x: auto ">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-left">{{ __('Items') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th class="text-right">{{ __('Price') }}</th>
                            <th class="text-right">{{ __('Tax') }}</th>
                            <th class="text-right">{{ __('Tax Amount') }}</th>
                            <th class="text-right">{{ __('Total') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($sales['data'] as $key => $value)
                            <tr>
                                <td class="cart-summary-table text-left">
                                    {{ $value['name'] }}
                                </td>
                                <td class="cart-summary-table">
                                    {{ $value['quantity'] }}
                                </td>
                                <td class="text-right cart-summary-table">
                                    {{ $value['orignal_price'] }}
                                </td>
                                <td class="text-right cart-summary-table">
                                    @if(!empty($value['tax']))
                                        {!! $value['tax'] !!}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-right cart-summary-table">
                                    {{ $value['tax_amount'] }}
                                </td>

                                <td class="text-right cart-summary-table">
                                    {{ $value['total_orignal_price'] }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td class="">{{ __('Sub Total') }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right">{{ $sales['sub_total'] }}</td>
                        </tr>
                        <tr>
                            <td class="">{{ __('Discount') }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right">{{ $sales['discount'] }}</td>
                        </tr>
                        <tr class="pos-header">
                            <td class="">{{ __('Total') }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right">{{ $sales['total'] }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @if ($details['pay'] == 'show')
                <button class="btn btn-success payment-done-btn rounded mt-2 float-right" data-url="{{ route('pos.printview') }}" data-pos-ajax-popup="true" data-size="sm"
                    data-bs-toggle="tooltip" data-title="{{ __('POS Invoice') }}">
                    {{ __('Cash Payment') }}
                </button>
            @endif
        </div>
    </div>

@endif


