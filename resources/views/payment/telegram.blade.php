<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@php
    $store    = \App\Models\Store::where('slug', $data['slug'])->first();
    $slug = $data['slug'];
    $theme_name = !empty(APP_THEME()) ? APP_THEME() : env('DATA_INSERT_APP_THEME');
    $paymentwall_public_key = \App\Models\Utility::GetValueByName('paymentwall_public_key',$theme_name,$store->id);
    $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME',$theme_name,$store->id);
    if (!\Auth::guard('customers')->user())
    {
        $encode_product = json_encode($data['product']);
        $data = json_encode($data);
    }
    else{

        $encode_product = json_encode($data['cartlist']['product_list']);
    }
    @endphp
    <input type="hidden" id="return_url">
<script src="{{ asset('public/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('public/js/jquery.form.js') }}"></script>
<script src="{{ asset('js/custom.js') }}" defer="defer"></script>
<script>
    $( document ).ready(function () {
            var product_array = '{{$encode_product}}';
            var product = JSON.parse(product_array.replace(/&quot;/g, '"'));
            var order_id = '{{$order_id = time()}}';
            var total_price = $('#Subtotal .total_price').attr('data-value');
            var coupon_id = $('.hidden_coupon').attr('data_id');
            var dicount_price = $('.dicount_price').html();
            var data = {
                type: 'telegram',
                coupon_id: coupon_id,
                dicount_price: dicount_price,
                total_price: total_price,
                product: product,
                order_id: order_id,
            }

            getWhatsappUrl(dicount_price, total_price, coupon_id, data); 


            $.ajax({
                url: '{{ route('user.telegram',$store->slug) }}',
                method: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $('#loader').fadeOut();
                    if (data.status == 'success') {
                        var queryParams = {
                            data: data.data
                        };
                        var queryString = $.param(queryParams);
                        
                        // setTimeout(function () {
                            var url = '{{ route('order.summary', [$store->slug]) }}?' + queryString;
                            window.location.href = url;
                            // }, 1000);


                    } else {
                    }
                }
            });
        });


        //for create/get Whatsapp Url
        function getWhatsappUrl(coupon = '', finalprice = '', coupon_id = '', data = '') {
            $.ajax({
                url: '{{ route('get.whatsappurl',$store->slug) }}',
                method: 'post',
                data: {dicount_price: coupon, finalprice: finalprice, coupon_id: coupon_id, data: data},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $('#loader').fadeOut();
                    $('#return_url').attr('value', data);
                    $('#return_url').val(data);
                }
            });
        }

</script>
