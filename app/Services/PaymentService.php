<?php

namespace App\Services;

use App\Events\AddRewardClubPoint;
use Illuminate\Http\Request;
use Stripe;
use App\Events\AddAdditionalFields;
use Obydul\LaraSkrill\SkrillClient;
use Obydul\LaraSkrill\SkrillRequest;
use App\Http\Controllers\CartController;
use App\Models\Store;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Utility;
use App\Models\Cart;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\Order;
use App\Models\User;
use App\Models\City;
use App\Models\OrderBillingDetail;
use App\Models\ActivityLog;
use App\Models\OrderNote;
use App\Models\AppSetting;
use App\Models\TaxMethod;
use App\Models\Coupon;
use App\Models\ProductVariant;
use App\Models\{OrderTaxDetail, OrderCouponDetail, UserCoupon};
use Paytabscom\Laravel_paytabs\paypage;
use PaytmWallet;
use GuzzleHttp\Client;
use YooKassa\Client as YooKassaClient;
use App\Coingate\Coingate;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use App\Xendit\Xendit;
use App\Xendit\Invoice;
use App\Http\Controllers\Api\ApiController;
use Lahirulhr\PayHere\PayHere;
use App\Package\Payment;
use Dipesh79\LaravelPhonePe\LaravelPhonePe;
use App\Facades\ModuleFacade as Module;
use App\Models\Senangpay;
use Easebuzz\Easebuzz;
use Dipesh79\LaravelEsewa\LaravelEsewa as eSewa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Cache;
use App\Traits\ApiResponser;

class PaymentService
{
    use ApiResponser;
    public function paymentConfig()
    {
        if (auth()->guard('customers')->check()) {
            $payment_setting = getAdminAllSetting();
        }

        if ($payment_setting['paypal_mode'] == 'live') {
            config([
                'paypal.live.client_id' => isset($payment_setting['paypal_client_id']) ? $payment_setting['paypal_client_id'] : '',
                'paypal.live.client_secret' => isset($payment_setting['paypal_secret']) ? $payment_setting['paypal_secret'] : '',
                'paypal.mode' => isset($payment_setting['paypal_mode']) ? $payment_setting['paypal_mode'] : '',
            ]);
        } else {
            config([
                'paypal.sandbox.client_id' => isset($payment_setting['paypal_client_id']) ? $payment_setting['paypal_client_id'] : '',
                'paypal.sandbox.client_secret' => isset($payment_setting['paypal_secret']) ? $payment_setting['paypal_secret'] : '',
                'paypal.mode' => isset($payment_setting['paypal_mode']) ? $payment_setting['paypal_mode'] : '',
            ]);
        }
    }

    public function process($request, $paymentMethod, $slug, $cartList)
    {
        switch ($paymentMethod) {
            case 'stripe':
                return $this->processStripe($request, $slug, $cartList);
            case 'paypal':
                return $this->processPaypal($request, $slug, $cartList);
            case 'paystack':
                return $this->processPaystack($request, $slug, $cartList);
            case 'Razorpay':
                return $this->processRazorpay($request, $slug, $cartList);
            case 'mercado':
                return $this->processMercado($request, $slug, $cartList);
            case 'skrill':
                return $this->processSkrill($request, $slug, $cartList);
            case 'paymentwall':
                return $this->processPaymentWall($request, $slug, $cartList);
            case 'flutterwave':
                return $this->processFlutterWave($request, $slug, $cartList);
            case 'paytm':
                return $this->processPayTm($request, $slug, $cartList);
            case 'mollie':
                return $this->processMollie($request, $slug, $cartList);
            case 'coingate':
                return $this->processCoingate($request, $slug, $cartList);
            case 'Sspay':
                return $this->processSspay($request, $slug, $cartList);
            case 'toyyibpay':
                return $this->processToyyibPay($request, $slug, $cartList);
            case 'Paytabs':
                return $this->processPayTabs($request, $slug, $cartList);
            case 'iyzipay':
                return $this->processIyziPay($request, $slug, $cartList);
            case 'payfast':
                return $this->processPayFast($request, $slug, $cartList);
            case 'benefit':
                return $this->processBenefit($request, $slug, $cartList);
            case 'cashfree':
                return $this->processCashFree($request, $slug, $cartList);
            case 'aamarpay':
                return $this->processAamarPay($request, $slug, $cartList);
            case 'telegram':
                return $this->processTelegram($request, $slug, $cartList);
            case 'paytr':
                return $this->processPayTr($request, $slug, $cartList);
            case 'yookassa':
                return $this->processYookassa($request, $slug, $cartList);
            case 'Xendit':
                return $this->processXendit($request, $slug, $cartList);
            case 'midtrans':
                return $this->processMidtrans($request, $slug, $cartList);
            case 'cod':
                return $this->getProductStatus($request, $slug, $cartList);
            case 'bank_transfer':
                return $this->getProductStatus($request, $slug, $cartList);
            case 'whatsapp':
                return $this->processWhatsapp($request, $slug, $cartList);
            case 'Nepalste':
                return $this->processNepalste($request, $slug, $cartList);
            case 'khalti':
                return $this->processKhalti($request, $slug, $cartList);
            case 'PayHere':
                return $this->processPayHere($request, $slug, $cartList);
            case 'AuthorizeNet':
                return $this->processAuthorizeNet($request, $slug, $cartList);
            case 'Tap':
                return $this->processTap($request, $slug, $cartList);
            case 'PhonePe':
                return $this->processPhonePe($request, $slug, $cartList);
            case 'Paddle':
                return $this->processPaddle($request, $slug, $cartList);
            case 'Paiementpro':
                return $this->processPaiementpro($request, $slug, $cartList);
            case 'FedPay':
                return $this->processFedPay($request, $slug, $cartList);
            case 'CinetPay':
                return $this->processCinetPay($request, $slug, $cartList);
            case 'SenagePay':
                return $this->processSenagePay($request, $slug, $cartList);
            case 'CyberSource':
                return $this->processCyberSource($request, $slug, $cartList);
            case 'Ozow':
                return $this->processOzow($request, $slug, $cartList);
            case 'MyFatoorah':
                return $this->processMyfatoorah($request, $slug, $cartList);
            case 'easebuzz':
                return $this->processEasebuzz($request, $slug, $cartList);
            case 'NMI':
                return $this->getNMIProductview($request, $slug, $cartList);
            case 'payu':
                return $this->processPayU($request, $slug, $cartList);
            case 'sofort':
                return $this->processSofort($request, $slug, $cartList);
            case 'esewa':
                return $this->processESewa($request, $slug, $cartList);
            case 'Paynow':
                return $this->processPaynow($request, $slug, $cartList);
            case 'DPO':
                return $this->processDPO($request, $slug, $cartList);
            case 'Braintree':
                return $this->processBraintree($request, $slug, $cartList);
            case 'PowerTranz':
                return $this->processPowerTranz($request, $slug, $cartList);
            case 'SSLCommerz':
                return $this->processSSLCommerz($request, $slug, $cartList);
            default:
                return response()->json(['error' => 'Invalid payment method'], 422);
        }
    }

    private function processStripe($request, $slug, $response)
    {
        $theme_id = $request['theme_id'];
        $slug = $request['slug'];
        $store = Store::where('slug', $request['slug'])->first();
        $stripe_secret = \App\Models\Utility::GetValueByName('stripe_secret_key', $store->theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $store->theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $store->theme_id, $store->id);

        $orderID = $request['customer_id'] . date('YmdHis');
        $cartlist_final_price = $request['cartlist_final_price'];
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($CURRENCY, '', $cartlist_final_price)));

        if ($totalprice > 0.0) {
            $l_name = $theme_id;
            $stripe_formatted_price = in_array(
                $CURRENCY_NAME,
                [
                    'MGA',
                    'BIF',
                    'CLP',
                    'PYG',
                    'DJF',
                    'RWF',
                    'GNF',
                    'UGX',
                    'JPY',
                    'VND',
                    'VUV',
                    'XAF',
                    'KMF',
                    'KRW',
                    'XOF',
                    'XPF',
                ]
            ) ? number_format($totalprice, 2, '.', '') : number_format($totalprice, 2, '.', '') * 100;

            $return_url_parameters = function ($return_type) {
                return '&return_type=' . $return_type . '&payment_processor=stripe';
            };

            Stripe\Stripe::setApiKey($stripe_secret);
            $data = \Stripe\Checkout\Session::create(
                [
                    'payment_method_types' => ['card'],
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => $CURRENCY_NAME,
                                'unit_amount' => (int) $stripe_formatted_price,
                                'product_data' => [
                                    'name' => $store->name,
                                    'description' => 'Stipe payment',
                                ],
                            ],
                            'quantity' => 1,
                        ],
                    ],

                    'mode' => 'payment',
                    'success_url' => route(
                        'store.payment.stripe',
                        [
                            $slug,
                            $return_url_parameters('success'),
                        ]
                    ),
                    'cancel_url' => route(
                        'store.payment.stripe',
                        [
                            $slug,
                            'theme_id' => $theme_id,
                            $return_url_parameters('cancel'),
                        ]
                    ),
                ]

            );
            if (is_array($request)) {
                // Convert the array to an Illuminate\Http\Request object
                $request = Request::create('/', 'POST', $request);
            }
            $requestData = $request->except('attachment','payment_receipt');
            Session::put('request_data', $requestData);
            if (module_is_active('CheckoutAttachment')) {
                \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
            }
            $data = $data ?? false;
            try {
                $place_order_data = ($data);
                return $place_order_data->url;
            } catch (\Exception $e) {
                return redirect()->route('checkout', $slug)->with('error', __('Transaction has been failed!'));
            }
        }
        return response()->json(['message' => 'Payment processed using Stripe']);
    }

    private function processPaystack($request, $slug, $response)
    {
        $data = $request->all();
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
        $store = Store::where('slug', $request->slug)->first();
        $admin_payment_setting = getAdminAllSetting();
        return view('payment.paystack', compact('data', 'admin_payment_setting', 'store'));
    }

    private function processRazorpay($request, $slug, $response)
    {
        $data = $request->all();
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
        $store = Store::where('slug', $request->slug)->first();
        $admin_payment_setting = getAdminAllSetting();
        return view('payment.razorpay', compact('data', 'admin_payment_setting', 'store'));
    }

    private function processMercado($request, $slug, $response)
    {
        // Get the store details
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
            return Store::where('slug',$slug)->first();
        });

        $theme_id = $request->theme_id;

        // Retrieve the billing info from request
        $billing_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        // Retrieve Mercado Pago settings and other configurations
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id, $store->id);
        $mercado_mode = \App\Models\Utility::GetValueByName('mercado_mode', $store->theme_id, $store->id);
        $mercado_access_token = \App\Models\Utility::GetValueByName('mercado_access_token', $store->theme_id, $store->id);

        // Generate unique order ID based on customer_id and current date-time
        $orderID = $request->customer_id . date('YmdHis');

        // Clean the cart total price (remove any currency symbols and commas)
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($CURRENCY, '', $request->cartlist_final_price)));

        // Prepare the payment data for Mercado Pago API request
        $success_url = route('store.payment.stripe', ['flag' => 'success', $slug,]);
        $failure_url = route('checkout', [$slug, 'flag' => 'failure',]);
        $pending_url = route('checkout', [$slug, 'flag' => 'pending',]);
        try {


            $paymentData = [
                'items' => [
                    [
                        'title' => "E-com_Product",
                        'quantity' => 1,
                        'unit_price' => (float) $totalprice,
                        'currency_id' => $CURRENCY,
                    ],
                ],
                'back_urls' => [
                    'success' => $success_url,
                    'failure' => $failure_url,
                    'pending' => $pending_url,
                ],
                'auto_return' => 'approved',
                'payer' => [
                    'name' => "name",
                    'surname' => '',
                    'email' => "email@gmail.com",
                    'address' => [
                        'street_name' => '',
                        'street_number' => '',
                        'zip_code' => '',
                    ],
                    'identification' => [
                        'type' => 'CPF',
                        'number' => '19119119100',
                    ],
                ],
            ];
            $response = \Http::withToken($mercado_access_token)->post('https://api.mercadopago.com/checkout/preferences', $paymentData);

            // \Log::info('Mercado Pago Response: ' . $response->body());
            // Check if the API response is successful
            if ($response->successful() || $response->statusCode() === 201) {
                // Use the correct URL based on mode (live or sandbox)
                $initPoint = $mercado_mode === 'live' ? $response->json()['init_point'] : $response->json()['sandbox_init_point'];
                return $initPoint;


            } else {
                // Handle errors based on response code
                if (!empty($response->json()['code']) && $response->json()['code'] === 'unauthorized') {
                    return redirect()->route('checkout', $slug)->with('error', __('Invalid access token'));
                } else if (!empty($response->json()['status']) && $response->json()['status'] == 400) {
                    return redirect()->route('checkout', $slug)->with('error', __('Currency not supported'));

                } else {

                    return redirect()->route('checkout', $slug)->with('error', __('Something went wrong'));

                }
            }

        } catch (\Exception $e) {
            // Catch any exceptions and return the error message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function processSkrill($request, $slug, $response)
    {
        $payment = getAdminAllSetting();
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $skrill_email = \App\Models\Utility::GetValueByName('skrill_email', $store->theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $store->theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $store->theme_id, $store->id);

        $orderID = $request->customer_id . date('YmdHis');
        if (\Auth::check($slug)) {
            $customer_data = auth(guard: 'customers')->user();
            $pdata['phone'] = $request->billing_info["mobile"] ?? "";
            $pdata['email'] = $request->billing_info["email"] ?? "";
            $pdata['customer_id'] = $request->billing_info["id"] ?? "";
        } else {
            $pdata['phone'] = '';
            $pdata['email'] = '';
            $pdata['customer_id'] = '';
        }

        $cartlist_final_price = $request->cartlist_final_price;
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($CURRENCY, '', $cartlist_final_price)));

        $skill = new SkrillRequest();
        $skill->pay_to_email = $skrill_email;
        $skill->return_url = route('store.payment.stripe', $store->slug);
        $skill->cancel_url = route('store.payment.stripe', $store->slug);

        // Create a unique transaction ID for Skrill
        $skill->transaction_id = md5(uniqid($request['transaction_id'], true));

        $skill->amount = $totalprice;
        $skill->currency = $CURRENCY_NAME;
        $skill->language = 'EN';
        $skill->prepare_only = '0';
        $skill->merchant_fields = 'site_name, customer_email';
        $skill->site_name = $store->name;
        $skill->customer_email = $pdata['email'];

        $client = new SkrillClient($skill);
        $sidResponse = $client->generateSID(); // HTML response

        // Extract the session ID from the HTML response
        preg_match('/url=([^"]+)/', $sidResponse, $matches);

        if (isset($matches[1])) {
            $redirectUrl = $matches[1];

            // Store session data for later use
            if ($request['transaction_id']) {
                $data = [
                    'amount' => $cartlist_final_price,
                    'trans_id' => md5($request['transaction_id']),
                    'currency' => 'USD',
                    'slug' => $store->slug,
                ];
                session()->put('skrill_data', $data);
            }

            // Redirect user to Skrill payment page
            return redirect()->away($redirectUrl);

        } else {
            // Handle the error if SID is not found in the response
            \Log::error('Skrill response did not contain a valid redirect URL. Response: ' . $sidResponse);
            return redirect()->back()->with('error', 'Failed to initiate Skrill payment. Please try again.');
        }

        // If it's needed to store additional request data
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);

        // If the CheckoutAttachment module is active, store the checkout attachment
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
    }


    private function processPaymentWall($request, $slug, $response)
    {
        $data = $request->all();
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
        ;
        $store = Store::where('slug', $request->slug)->first();
        $admin_payment_setting = getAdminAllSetting();
        return view('payment.paymentwall', compact('data', 'admin_payment_setting', 'store'));
    }

    private function processPayPal($request, $slug, $response)
    {
        $payment = getAdminAllSetting();

        $slug = !empty($request->slug) ? $request->slug : '';

        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;

        $paypal_secret = \App\Models\Utility::GetValueByName('paypal_secret_key', $theme_id, $store->id);
        $paypal_client_id = \App\Models\Utility::GetValueByName('paypal_client_id', $theme_id, $store->id);
        $paypal_mode = \App\Models\Utility::GetValueByName('paypal_mode', $theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id, $store->id);

        if ($paypal_mode == 'live') {
            config(
                [
                    'paypal.live.client_id' => isset($paypal_client_id) ? $paypal_client_id : '',
                    'paypal.live.client_secret' => isset($paypal_secret) ? $paypal_secret : '',
                    'paypal.mode' => isset($paypal_mode) ? $paypal_mode : '',

                ]
            );
        } else {
            config(
                [
                    'paypal.sandbox.client_id' => isset($paypal_client_id) ? $paypal_client_id : '',
                    'paypal.sandbox.client_secret' => isset($paypal_secret) ? $paypal_secret : '',
                    'paypal.mode' => isset($paypal_mode) ? $paypal_mode : '',

                ]
            );
        }
        $provider = new PayPalClient;

        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        Session::put('paypal_payment_id', $paypalToken['access_token']);
        $objUser = \Auth::user();
        $orderID = $request->user_id . date('YmdHis');
        $cartlist_final_price = $request->cartlist_final_price;
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($CURRENCY, '', $cartlist_final_price)));

        $return_url_parameters = function ($return_type) {
            return '&return_type=' . $return_type . '&payment_processor=stripe';
        };

        try {

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => $CURRENCY_NAME,
                            "value" => $request->cartlist_final_price
                        ]
                    ]
                ],
                "application_context" => [
                    "return_url" => route('store.payment.stripe', $slug),
                    "cancel_url" => route('store.payment.stripe', $slug),
                ],

            ]);

            if (isset($response['id']) && $response['id'] != null) {
                // redirect to approve href
                if (is_array($request)) {
                    // Convert the array to an Illuminate\Http\Request object
                    $request = Request::create('/', 'POST', $request);
                }
                $requestData = $request->except('attachment','payment_receipt');
                Session::put('request_data', $requestData);
                if (module_is_active('CheckoutAttachment')) {
                    \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
                }
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return $links['href'];
                    }
                }
                return $response;

                return redirect()
                    ->route('checkout', $slug)
                    ->with('error', 'Something went wrong.');
            } else {
                return redirect()
                    ->route('checkout', $slug)
                    ->with('error', $response['message'] ?? 'Something went wrong.');
            }
        } catch (\Exception $e) {
            return redirect()->route('checkout', $slug)->with('error', __('Unknown error occurred'));
        }
    }

    private function processFlutterWave($request, $slug, $response)
    {
        if (is_array($request->get('billing_info'))) {
            $email = $request->get('billing_info')['email'];
        } else {
            $email = json_decode($request->get('billing_info'), true)['email'];
        }

        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });

        $theme_id = $store->theme_id ?? $request->theme_id;

        $flutterwave_secret = \App\Models\Utility::GetValueByName('flutterwave_secret_key', $theme_id, $store->id);
        $public_key = \App\Models\Utility::GetValueByName('flutterwave_public_key', $theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id, $store->id);

        $orderID = $request->customer_id . date('YmdHis');
        $cartlist_final_price = $request->cartlist_final_price;
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($CURRENCY, '', $cartlist_final_price)));

        $res_data['total_price'] = $cartlist_final_price;
        $res_data['currency'] = $CURRENCY_NAME;
        $res_data['flag'] = 1;
        $res_data['public_key'] = $public_key;
        $res_data['store'] = $store->slug;
        $res_data['orderID'] = $orderID;
        $res_data['email'] = $email;

        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
        return view('payment.flutterwave', compact('res_data'));

    }

    private function processPayTm($request, $slug, $response)
    {
        if (is_array($request->get('billing_info'))) {
            $email = $request->get('billing_info')['email'];
            $firstname = $request->get('billing_info')['firstname'];
            $billing_user_telephone = $request->get('billing_info')['billing_user_telephone'];
        } else {
            $email = json_decode($request->get('billing_info'), true)['email'];
            $firstname = json_decode($request->get('billing_info'), true)['firstname'];
            $billing_user_telephone = json_decode($request->get('billing_info'), true)['billing_user_telephone'];
        }

        $slug = !empty($slug) ? $slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });


        $theme_id = $store->theme_id ?? $request->theme_id;

        $paytm_mode = \App\Models\Utility::GetValueByName('paytm_mode', $theme_id, $store->id);
        $paytm_merchant_id = \App\Models\Utility::GetValueByName('paytm_merchant_id', $theme_id, $store->id);
        $paytm_merchant_key = \App\Models\Utility::GetValueByName('paytm_merchant_key', $theme_id, $store->id);
        $paytm_industry_type = \App\Models\Utility::GetValueByName('paytm_industry_type', $theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id, $store->id);

        $cutomer = Customer::where('type', 'customer')->where('store_id', $store->id)->where('theme_id', $theme_id)->get()->count();
        $user = $cutomer + 1;

        $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
        $cartlist_final_price = $request->cartlist_final_price;
        config(
            [
                'services.paytm-wallet.env' => isset($paytm_mode) ? $paytm_mode : '',
                'services.paytm-wallet.merchant_id' => isset($paytm_merchant_id) ? $paytm_merchant_id : '',
                'services.paytm-wallet.merchant_key' => isset($paytm_merchant_key) ? $paytm_merchant_key : '',
                'services.paytm-wallet.merchant_website' => 'WEBSTAGING',
                'services.paytm-wallet.channel' => 'WEB',
                'services.paytm-wallet.industry_type' => isset($paytm_industry_type) ? $paytm_industry_type : '',
            ]
        );

        try {

            $payment = PaytmWallet::with('receive');
            $payment->prepare(
                [
                    'order' => date('Y-m-d') . '-' . strtotime(date('Y-m-d H:i:s')),
                    'user' => $firstname,
                    'mobile_number' => $billing_user_telephone,
                    'email' => $email,
                    'amount' => $cartlist_final_price,
                    'callback_url' => route('store.payment.paytm', $slug),

                ]
            );
            if (is_array($request)) {
                // Convert the array to an Illuminate\Http\Request object
                $request = Request::create('/', 'POST', $request);
            }
            $requestData = $request->except('attachment','payment_receipt');
            Session::put('request_data', $requestData);
            if (module_is_active('CheckoutAttachment')) {
                \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
            }
            return $payment->receive();
        } catch (\Exception $e) {
            return redirect()->route('checkout', $slug)->with('error', __($e->getMessage()));
        }
    }

    private function processMollie(Request $request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });

        $theme_id = $store->theme_id ?? $request->theme_id;

        $mollie_api_key = \App\Models\Utility::GetValueByName('mollie_api_key', $theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id, $store->id);

        $orderID = $request->customer_id . date('YmdHis');
        $cartlist_final_price = $request->cartlist_final_price;
        $request = $request->all();
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($mollie_api_key);
        $payment = $mollie->payments->create(
            [
                "amount" => [
                    "currency" => "$CURRENCY_NAME",
                    "value" => str_replace(",", "", number_format($cartlist_final_price, 2)),
                ],
                "description" => "payment for product",
                "redirectUrl" => route(
                    'store.payment.stripe',
                    [
                        $store->slug,
                    ]
                ),

            ]
        );
        session()->put('mollie_payment_id', $payment->id);

        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }

        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);

        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }

        return $payment->getCheckoutUrl();

    }

    private function processCoingate($request, $slug, $response)
    {
        $slug = !empty($slug) ? $slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        // $theme_id = $store->theme_id;

        $theme_id = $store->theme_id ?? $request->theme_id;

        $coingate_mode = \App\Models\Utility::GetValueByName('coingate_mode', $theme_id, $store->id);
        $coingate_auth_token = \App\Models\Utility::GetValueByName('coingate_auth_token', $theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id, $store->id);

        $orderID = $request->user_id . date('YmdHis');
        $cartlist_final_price = $request->cartlist_final_price;
        try {
            CoinGate::config(
                array(
                    'environment' => $coingate_mode,
                    // sandbox OR live
                    'auth_token' => $coingate_auth_token,
                    'curlopt_ssl_verifypeer' => FALSE
                    // default is false
                )
            );

            $post_params = array(
                // 'order_id' => $order->id,
                'order_id' => time(),
                'price_amount' => $cartlist_final_price,
                'price_currency' => $CURRENCY_NAME,
                'receive_currency' => $CURRENCY_NAME,

                'callback_url' => route(
                    'store.payment.stripe',
                    [
                        $store->slug,
                    ]
                ),
                'cancel_url' => route(
                    'store.payment.stripe',
                    [
                        $store->slug,
                    ]
                ),

                'success_url' => route(
                    'store.payment.stripe',
                    [
                        $store->slug,
                    ]
                ),
                'title' => 'Order #' . time(),
            );

            if (is_array($request)) {
                // Convert the array to an Illuminate\Http\Request object
                $request = Request::create('/', 'POST', $request);
            }

            $requestData = $request->except('attachment','payment_receipt');
            Session::put('request_data', $requestData);
            if (module_is_active('CheckoutAttachment')) {
                \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
            }
            $order       = Coingate::coingatePayment($post_params, 'POST');
            if($order['status_code'] === 200) {
                $response = $order['response'];
                return (object)$response;
            }else{
                return redirect()->back()->with('error', __('opps something wren wrong.'));
            }


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    private function processSspay($request, $slug, $response)
    {
        try {
            if (auth('customers')->user()) {
                $products = Product::find($request->cartlist['product_list'][0]->product_id);
            } else {
                $products = Product::find($request->product[0]['product_id']);
            }

            $slug = $request->slug;
            $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
            $theme_id = $store->theme_id ?? $request->theme_id;
            $sspay_secret_key = \App\Models\Utility::GetValueByName('sspay_secret_key', $theme_id, $store->id);
            $sspay_category_code = \App\Models\Utility::GetValueByName('sspay_category_code', $theme_id, $store->id);
            $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id, $store->id);
            if (is_array($request->get('billing_info'))) {
                $email = $request->get('billing_info')['email'];
                $firstname = $request->get('billing_info')['firstname'];
                $billing_user_telephone = $request->get('billing_info')['billing_user_telephone'];
            } else {
                $email = json_decode($request->get('billing_info'), true)['email'];
                $firstname = json_decode($request->get('billing_info'), true)['firstname'];
                $billing_user_telephone = json_decode($request->get('billing_info'), true)['billing_user_telephone'];
            }
            $cartlist_final_price = $request->cartlist_final_price;
            $billContentEmail = "Thank you for purchasing our product!";
            $Date = date('d-m-Y');
            $billExpiryDays = 3;
            $billExpiryDate = date('d-m-Y', strtotime($Date . ' + 3 days'));

            $this->callBackUrl = route('store.payment.stripe', $store->slug);
            $this->returnUrl = route('store.payment.stripe', $store->slug);
            $some_data = array(
                'userSecretKey' => $sspay_secret_key,
                'categoryCode' => $sspay_category_code,
                'billName' => $products->name,
                'billDescription' => $products->description,
                'billPriceSetting' => 1,
                'billPayorInfo' => 1,
                'billAmount' => 100 * $cartlist_final_price,
                'billReturnUrl' => $this->returnUrl,
                'billCallbackUrl' => $this->callBackUrl,
                'billExternalReferenceNo' => 'AFR341DFI',
                'billTo' => $firstname,
                'billEmail' => $email,
                'billPhone' => $billing_user_telephone,
                'billSplitPayment' => 0,
                'billSplitPaymentArgs' => '',
                'billPaymentChannel' => '0',
                'billContentEmail' => $billContentEmail,
                'billChargeToCustomer' => 1,
                'billExpiryDate' => $billExpiryDate,
                'billExpiryDays' => $billExpiryDays
            );
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, 'https://sspay.my/index.php/api/createBill');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
            $result = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
            $obj = json_decode($result);
            return redirect('https://sspay.my/' . $obj[0]->BillCode);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', __($e->getMessage()));
        }
    }

    private function processToyyibPay($request, $slug, $response)
    {
        try {

            if (auth('customers')->user()) {
                $products = Product::find($request->cartlist['product_list'][0]->product_id);
            } else {
                $products = Product::find($request->product[0]['product_id']);
            }

            $slug = $request->slug;
            $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
            $theme_id = $store->id ?? $request->theme_id;
            $toyyibpay_secret_key = \App\Models\Utility::GetValueByName('toyyibpay_secret_key', $store->theme_id, $store->id);
            $toyyibpay_category_code = \App\Models\Utility::GetValueByName('toyyibpay_category_code', $store->theme_id, $store->id);
            $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $store->theme_id, $store->id);
            if (is_array($request->get('billing_info'))) {
                $email = $request->get('billing_info')['email'];
                $firstname = $request->get('billing_info')['firstname'];
                $billing_user_telephone = $request->get('billing_info')['billing_user_telephone'];
            } else {
                $email = json_decode($request->get('billing_info'), true)['email'];
                $firstname = json_decode($request->get('billing_info'), true)['firstname'];
                $billing_user_telephone = json_decode($request->get('billing_info'), true)['billing_user_telephone'];
            }
            $cartlist_final_price = $request->cartlist_final_price;
            $billContentEmail = "Thank you for purchasing our product!";
            $Date = date('d-m-Y');
            $billExpiryDays = 3;
            $billExpiryDate = date('d-m-Y', strtotime($Date . ' + 3 days'));

            $this->callBackUrl = route('store.payment.stripe', $store->slug);
            $this->returnUrl = route('store.payment.stripe', $store->slug);
            $some_data = array(
                'userSecretKey' => $toyyibpay_secret_key,
                'categoryCode' => $toyyibpay_category_code,
                'billName' => $products->name,
                'billDescription' => 'Description',
                'billPriceSetting' => 1,
                'billPayorInfo' => 1,
                'billAmount' => 100 * $cartlist_final_price,
                'billReturnUrl' => $this->returnUrl,
                'billCallbackUrl' => $this->callBackUrl,
                'billExternalReferenceNo' => 'AFR341DFI',
                'billTo' => $firstname,
                'billEmail' => $email,
                'billPhone' => $billing_user_telephone,
                'billSplitPayment' => 0,
                'billSplitPaymentArgs' => '',
                'billPaymentChannel' => '0',
                'billContentEmail' => $billContentEmail,
                'billChargeToCustomer' => 1,
                'billExpiryDate' => $billExpiryDate,
                'billExpiryDays' => $billExpiryDays
            );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
            $result = curl_exec($curl);

            $info = curl_getinfo($curl);
            curl_close($curl);
            $obj = json_decode($result);
            if (is_array($request)) {
                // Convert the array to an Illuminate\Http\Request object
                $request = Request::create('/', 'POST', $request);
            }
            $requestData = $request->except('attachment','payment_receipt');
            Session::put('request_data', $requestData);
            if (module_is_active('CheckoutAttachment')) {
                \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
            }
            return redirect('https://toyyibpay.com/' . $obj[0]->BillCode);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', __($e->getMessage()));
        }
    }

    private function processPayTabs($request, $slug, $response)
    {
        if (empty($slug)) {
            $slug = $request->slug;
        }
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $store->theme_id ?? $request->theme_id;
        $paytabs_profile_id = \App\Models\Utility::GetValueByName('paytabs_profile_id', $theme_id, $store->id);
        $paytabs_server_key = \App\Models\Utility::GetValueByName('paytabs_server_key', $theme_id, $store->id);
        $paytabs_region = \App\Models\Utility::GetValueByName('paytabs_region', $theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        if ($CURRENCY_NAME != 'INR') {
            return redirect()->back()->with('error', 'Currency Not Supported.Contact To Your Site Admin');
        } else {

            config(
                [
                    'paytabs.profile_id' => $paytabs_profile_id,
                    'paytabs.server_key' => $paytabs_server_key,
                    'paytabs.region' => $paytabs_region,
                    'paytabs.currency' => $CURRENCY_NAME,
                ]
            );



            $cartlist_final_price = $request->cartlist_final_price;
            $user = \Auth::user();
            $cart_list = Cart::cart_list_cookie($request->all(), $store->id);
            $paytabs = new paypage();
            $pay = $paytabs->sendPaymentCode('all')
                ->sendTransaction('sale', 'ecom')
                ->sendCart(1, $cartlist_final_price, 'plan payment')
                ->sendCustomerDetails(isset($user->name) ? $user->name : "", isset($user->email) ? $user->email : '', '', '', '', '', '', '', '')
                ->sendURLs(
                    route('store.payment.stripe', $slug),
                    route('store.payment.stripe', $slug)
                )
                ->sendLanguage('en')
                ->sendFramed($on = false)
                ->create_pay_page();

            if (is_array($request)) {
                // Convert the array to an Illuminate\Http\Request object
                $request = Request::create('/', 'POST', $request);
            }

            $requestData = $request->except('attachment','payment_receipt');
            Session::put('request_data', $requestData);
            if (module_is_active('CheckoutAttachment')) {
                \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
            }
            return $pay;
        }
    }

    private function processIyziPay($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';

        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $store->id ?? $request->theme_id;

        $iyzipay_mode = \App\Models\Utility::GetValueByName('iyzipay_mode', $theme_id, $store->id);
        $iyzipay_secret_key = \App\Models\Utility::GetValueByName('iyzipay_secret_key', $theme_id, $store->id);
        $iyzipay_private_key = \App\Models\Utility::GetValueByName('iyzipay_private_key', $theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $adminPaymentSettings = getAdminAllSetting();
        $currency = $adminPaymentSettings['CURRENCY_NAME'] ?? ($CURRENCY_NAME ?? '$');
        $cart_list = Cart::cart_list_cookie($request->all(), $store->id);
        $request_data = $request->except('attachment','payment_receipt');
        session(['cart_list' => $cart_list, 'request_data' => $request_data]);
        $objUser = \Auth::user();
        $orderID = $request->customer_id . date('YmdHis');
        $cartlist_final_price = $request->cartlist_final_price;
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));

        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;
        $address = !empty($other_info->billing_address) ? $other_info->billing_address : '';
        $setBaseUrl = ($iyzipay_mode == 'sandbox') ? 'https://sandbox-api.iyzipay.com' : 'https://api.iyzipay.com';
        $options = new \Iyzipay\Options();
        $options->setApiKey($iyzipay_private_key);
        $options->setSecretKey($iyzipay_secret_key);
        $options->setBaseUrl($setBaseUrl); // or "https://api.iyzipay.com" for production
        $ipAddress = Http::get('https://ipinfo.io/?callback=')->json();
        $address = ($address) ? $address : 'Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1';
        // create a new payment request
        $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $request->setLocale('en');
        $request->setPrice($totalprice);
        $request->setPaidPrice($totalprice);
        $request->setCurrency($currency);
        $request->setCallbackUrl(route('store.payment.iyzico', $slug));
        $request->setEnabledInstallments(array(1));
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId(!empty($objUser['id']) ? $objUser['id'] : '0');
        $buyer->setName(!empty($objUser['name']) ? $objUser['name'] : 'Guest');
        $buyer->setSurname(!empty($objUser['name']) ? $objUser['name'] : 'Guest');
        $buyer->setGsmNumber(!empty($objUser['mobile']) ? $objUser['mobile'] : '9999999999');
        $buyer->setEmail(!empty($objUser['email']) ? $objUser['email'] : 'test@gmail.com');
        $buyer->setIdentityNumber(rand(0, 99999));
        $buyer->setLastLoginDate("2023-03-05 12:43:35");
        $buyer->setRegistrationDate("2023-04-21 15:12:09");
        $buyer->setRegistrationAddress($address);
        $buyer->setIp($ipAddress['ip']);
        $buyer->setCity($ipAddress['city']);
        $buyer->setCountry($ipAddress['country']);
        $buyer->setZipCode($ipAddress['postal']);
        $request->setBuyer($buyer);
        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName(!empty($objUser['name']) ? $objUser['name'] : 'Guest');
        $shippingAddress->setCity($ipAddress['city']);
        $shippingAddress->setCountry($ipAddress['country']);
        $shippingAddress->setAddress($address);
        $shippingAddress->setZipCode($ipAddress['postal']);
        $request->setShippingAddress($shippingAddress);
        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName(!empty($objUser['name']) ? $objUser['name'] : 'Guest');
        $billingAddress->setCity($ipAddress['city']);
        $billingAddress->setCountry($ipAddress['country']);
        $billingAddress->setAddress($address);
        $billingAddress->setZipCode($ipAddress['postal']);
        $request->setBillingAddress($billingAddress);
        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId("BI101");
        $firstBasketItem->setName("Binocular");
        $firstBasketItem->setCategory1("Collectibles");
        $firstBasketItem->setCategory2("Accessories");
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice($totalprice);
        $basketItems[0] = $firstBasketItem;
        $request->setBasketItems($basketItems);

        $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, $options);

        if ($checkoutFormInitialize->getpaymentPageUrl() != null) {
            return $checkoutFormInitialize->getpaymentPageUrl();
        } else {
            return redirect()->route('checkout', $slug)->with('error', 'Something went wrong, Please try again');
        }
        return $checkoutFormInitialize->getpaymentPageUrl();

    }

    private function processPayFast($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $store->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;


        $payfast_merchant_id = \App\Models\Utility::GetValueByName('payfast_merchant_id', $theme_id, $store->id);
        $payfast_salt_passphrase = \App\Models\Utility::GetValueByName('payfast_salt_passphrase', $theme_id, $store->id);
        $payfast_merchant_key = \App\Models\Utility::GetValueByName('payfast_merchant_key', $theme_id, $store->id);
        $payfast_mode = \App\Models\Utility::GetValueByName('payfast_mode', $theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);


        $order_id = $request['customer_id'] . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($CURRENCY_NAME, '', $cartlist_final_price)));
        $name = 'test';
        $order_id = time();
        $success = Crypt::encrypt([
            'order_id' => $order_id
        ]);
        $data = array(
            // Merchant details
            'merchant_id' => !empty($payfast_merchant_id) ? $payfast_merchant_id : '',
            'merchant_key' => !empty($payfast_merchant_key) ? $payfast_merchant_key : '',
            'return_url' => route('store.payment.stripe', $slug),
            'cancel_url' => route('store.payment.stripe', $slug),
            'notify_url' => route('store.payment.stripe', $slug),
            // Buyer details
            'name_first' => isset($other_info->firstname) ? $other_info->firstname : '',
            'name_last' => isset($other_info->lastname) ? $other_info->lastname : '',
            'email_address' => isset($other_info->email) ? $other_info->email : '',
            // Transaction details
            'm_payment_id' => $order_id,
            'amount' => $cartlist_final_price,
            'item_name' => 'test',
        );
        $passphrase = !empty($payfast_salt_passphrase) ? $payfast_salt_passphrase : '';
        $signature = $this->generateSignature($data, $passphrase);
        $data['signature'] = $signature;
        $checkouthtml = '';
        foreach ($data as $name => $value) {
            $checkouthtml .= '<input name="' . $name . '" type="hidden" value=\'' . $value . '\' />';
        }

        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
        $msg = [
            'success' => true,
            'inputs' => $checkouthtml
        ];
        return $msg;
    }

    public function generateSignature($data, $passPhrase = null)
    {

        $pfOutput = '';
        foreach ($data as $key => $val) {
            if ($val !== '') {
                $pfOutput .= $key . '=' . urlencode(trim($val)) . '&';
            }
        }

        $getString = substr($pfOutput, 0, -1);
        if ($passPhrase !== null) {
            $getString .= '&passphrase=' . urlencode(trim($passPhrase));
        }
        return md5($getString);
    }

    private function processBenefit($request, $slug, $response)
    {

        $products = Product::find($request->product[0]['product_id']);

        $name = $products->name;
        $slug = !empty($request->slug) ? $request->slug : '';

        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;
        $benefit_secret_key = \App\Models\Utility::GetValueByName('benefit_secret_key', $theme_id, $store->id);
        $benefit_private_key = \App\Models\Utility::GetValueByName('benefit_private_key', $theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id, $store->id);

        $orderID = $request->customer_id . date('YmdHis');
        $cartlist_final_price = $request->cartlist_final_price;
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($CURRENCY, '', $cartlist_final_price)));
        $customerData =
            [
                "amount" => $cartlist_final_price,
                "currency" => !empty($CURRENCY_NAME) ? $CURRENCY_NAME : 'BHD',
                "customer_initiated" => true,
                "threeDSecure" => true,
                "save_card" => false,
                "description" => !empty($name) ? $name : '',
                "metadata" => ["udf1" => "Metadata 1"],
                "reference" => ["transaction" => "txn_01", "order" => "ord_01"],
                "receipt" => ["email" => true, "sms" => true],
                "customer" => ["first_name" => $other_info['firstname'], "middle_name" => "", "last_name" => $other_info['firstname'], "email" => $other_info['email'], "phone" => ["country_code" => 965, "number" => 51234567]],
                "source" => ["id" => "src_bh.benefit"],
                "post" => ["url" => "https://webhook.site/fd8b0712-d70a-4280-8d6f-9f14407b3bbd"],
                "redirect" => ["url" => route('store.payment.stripe', $slug)],

            ];
        $requestData = $request->except('attachment','payment_receipt');
        session(['request_data' => $requestData]);
        $responseData = json_encode($customerData);
        $client = new Client();
        try {
            $response = $client->request('POST', 'https://api.tap.company/v2/charges', [
                'body' => $responseData,
                'headers' => [
                    'Authorization' => 'Bearer ' . $benefit_secret_key,
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ],
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Currency Not Supported.Contact To Your Site Admin');
        }

        $data = $response->getBody();
        $res = json_decode($data);
        return $res->transaction->url;
    }

    private function processCashFree($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';

        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;
        $cashfree_secret_key = \App\Models\Utility::GetValueByName('cashfree_secret_key', $theme_id, $store->id);
        $cashfree_key = \App\Models\Utility::GetValueByName('cashfree_key', $theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id, $store->id);
        $orderID = $request->customer_id . date('YmdHis');
        $cartlist_final_price = $request->cartlist_final_price;
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($CURRENCY, '', $cartlist_final_price)));
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
        config(
            [
                'services.cashfree.key' => isset($cashfree_key) ? $cashfree_key : '',
                'services.cashfree.secret' => isset($cashfree_secret_key) ? $cashfree_secret_key : '',
            ]
        );
        $url = config('services.cashfree.url');
        $headers = array(
            "Content-Type: application/json",
            "x-api-version: 2022-01-01",
            "x-client-id: " . config('services.cashfree.key'),
            "x-client-secret: " . config('services.cashfree.secret')
        );
        $data = json_encode([
            'order_id' => $orderID,
            'order_amount' => round($cartlist_final_price),
            "order_currency" => !empty($CURRENCY_NAME) ? $CURRENCY_NAME : 'USD',
            "order_name" => $other_info->firstname ?? 'Test',
            "customer_details" => [
                    "customer_id" => 'customer_' . $request['customer_id'],
                    "customer_name" => $other_info->firstname ?? $other_info['firstname'],
                    "customer_email" => $other_info->email ?? $other_info['email'],
                    "customer_phone" => '1234567890',
                ],
            "order_meta" => [
                "return_url" => route('store.payment.stripe', $slug)
            ]
        ]);
        try {

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            $resp = curl_exec($curl);
            curl_close($curl);
            $redirect_url = json_decode($resp)->payment_link;
            return $redirect_url;
        } catch (\Throwable $th) {
            return redirect()->route('checkout', $slug)->with('error', 'Currency Not Supported.Contact To Your Site Admin');
        }

    }

    private function processAamarPay($request, $slug, $response)
    {
        $url = 'https://sandbox.aamarpay.com/request.php';
        $slug = !empty($request->slug) ? $request->slug : '';

        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;
        $aamarpay_signature_key = \App\Models\Utility::GetValueByName('aamarpay_signature_key', $theme_id, $store->id);
        $aamarpay_description = \App\Models\Utility::GetValueByName('aamarpay_description', $theme_id, $store->id);
        $aamarpay_store_id = \App\Models\Utility::GetValueByName('aamarpay_store_id', $theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id, $store->id);
        $orderID = $request->user_id . date('YmdHis');
        $response = Cart::cart_list_cookie($request->all(), $store->id);
        $response = json_decode(json_encode($response));
        $cartlist = (array) $response->data;
        $cartlist_final_price = $request->cartlist_final_price;
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($CURRENCY, '', $cartlist_final_price)));
        $requestData = $request->except('attachment','payment_receipt');
        session(['request_data' => $requestData]);
        try {

            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
            $fields = array(
                'store_id' => $aamarpay_store_id,
                'amount' => $cartlist_final_price,
                'payment_type' => '',
                'currency' => $CURRENCY_NAME,
                'tran_id' => $orderID,
                'cus_name' => $other_info['firstname'],
                'cus_email' => $other_info['email'],
                'cus_add1' => '',
                'cus_add2' => '',
                'cus_city' => '',
                'cus_state' => '',
                'cus_postcode' => '',
                'cus_country' => '',
                'cus_phone' => '1234567890',
                'success_url' => route('store.payment.aamarpay', [
                            $slug,
                            'request_data' => $request->all(),
                            'cart_data' => $cartlist
                        ]),
                //your success route
                'fail_url' => route('store.payment.aamarpay', Crypt::encrypt(['response' => 'failure', 'slug' => $slug, 'price' => $cartlist_final_price, 'order_id' => $orderID])),
                //your fail route
                'cancel_url' => route('store.payment.aamarpay', Crypt::encrypt(['response' => 'cancel'])),
                //your cancel url
                'signature_key' => $aamarpay_signature_key,
                'desc' => $aamarpay_description,
            ); //signature key will provided aamarpay, contact integration@aamarpay.com for test/live signature key

            $fields_string = http_build_query($fields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));
            curl_close($ch);
            $this->redirect_to_merchant($url_forward);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e);
        }

    }

    function redirect_to_merchant($url)
    {

        $token = csrf_token();
        ?>
        <html xmlns="http://www.w3.org/1999/xhtml">

        <head>
            <script type="text/javascript">
                function closethisasap() { document.forms["redirectpost"].submit(); }
            </script>
        </head>

        <body onLoad="closethisasap();">

            <form name="redirectpost" method="post" action="<?php echo 'https://sandbox.aamarpay.com/' . $url; ?>">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </body>

        </html>
        <?php
        exit;
    }

    private function processTelegram($request, $slug, $response)
    {
        $data = $request->all();
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
        return view('payment.telegram', compact('data'));
    }

    private function processPayTr($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });

        $theme_id = $request->theme_id;

        $paytr_merchant_id = \App\Models\Utility::GetValueByName('paytr_merchant_id', $theme_id, $store->id);
        $paytr_merchant_key = \App\Models\Utility::GetValueByName('paytr_merchant_key', $theme_id, $store->id);
        $paytr_salt_key = \App\Models\Utility::GetValueByName('paytr_salt_key', $theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);

        $cartlist_final_price = $request->cartlist_final_price;
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($CURRENCY, '', $cartlist_final_price)));
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;


        try {

            $merchant_id = $paytr_merchant_id;
            $merchant_key = $paytr_merchant_key;
            $merchant_salt = $paytr_salt_key;
            $orderID = $request->user_id . date('YmdHis');


            $email = $other_info['email'];
            $payment_amount = $cartlist_final_price;
            $merchant_oid = $orderID;
            $user_name = $other_info['firstname'];
            $user_address = 'no address';
            $user_phone = '0000000000';

            $user_basket = base64_encode(json_encode(array(
                array("Plan", $payment_amount, 1),
            )));

            if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }

            $user_ip = $ip;
            $timeout_limit = "30";
            $debug_on = 1;
            $test_mode = 0;
            $no_installment = 0;
            $max_installment = 0;
            $currency = isset($CURRENCY) ? $CURRENCY : 'USD';
            $payment_amount = $payment_amount * 100;
            $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $user_basket . $no_installment . $max_installment . $currency . $test_mode;
            $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));

            $request['orderID'] = $orderID;
            $request['amount'] = $payment_amount;
            $request['payment_status'] = 'failed';
            $payment_failed = $request->all();
            $request['payment_status'] = 'success';
            $payment_success = $request->all();
            if (is_array($request)) {
                // Convert the array to an Illuminate\Http\Request object
                $request = Request::create('/', 'POST', $request);
            }
            $requestData = $request->except('attachment','payment_receipt');
            Session::put('request_data', $requestData);
            if (module_is_active('CheckoutAttachment')) {
                \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
            }
            $post_vals = array(
                'merchant_id' => $merchant_id,
                'user_ip' => $user_ip,
                'merchant_oid' => $merchant_oid,
                'email' => $email,
                'payment_amount' => $payment_amount,
                'paytr_token' => $paytr_token,
                'user_basket' => $user_basket,
                'debug_on' => $debug_on,
                'no_installment' => $no_installment,
                'max_installment' => $max_installment,
                'user_name' => $user_name,
                'user_address' => $user_address,
                'user_phone' => $user_phone,
                'merchant_ok_url' => route('store.payment.stripe', $slug, ),
                'merchant_fail_url' => route('store.payment.stripe', $slug),
                'timeout_limit' => $timeout_limit,
                'currency' => $currency,
                'test_mode' => $test_mode
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);


            $result = @curl_exec($ch);

            if (curl_errno($ch)) {
                die("PAYTR IFRAME connection error. err:" . curl_error($ch));
            }

            curl_close($ch);

            $result = json_decode($result, 1);

            if ($result['status'] == 'success') {
                $token = $result['token'];
            } else {
                return redirect()->back()->with('error', $result['reason']);
            }
            return view('payment.pay_tr', compact('token'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e);
        }

    }

    private function processYookassa($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });

        $theme_id = $request->theme_id;

        $yookassa_shop_id_key = \App\Models\Utility::GetValueByName('yookassa_shop_id_key', $theme_id, $store->id);
        $yookassa_secret_key = \App\Models\Utility::GetValueByName('yookassa_secret_key', $theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id, $store->id);

        $orderID = $request->customer_id . date('YmdHis');
        $cartlist_final_price = $request->cartlist_final_price;
        try {
            if (is_int((int) $yookassa_shop_id_key)) {
                $client = new YooKassaClient();
                $client->setAuth((int) $yookassa_shop_id_key, $yookassa_secret_key);
                $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                $payment = $client->createPayment(
                    array(
                        'amount' => array(
                            'value' => $cartlist_final_price,
                            'currency' => !empty($CURRENCY_NAME) ? $CURRENCY_NAME : 'USD',
                        ),
                        'confirmation' => array(
                            'type' => 'redirect',
                            'return_url' => route('store.payment.stripe', $slug),
                        ),

                        'capture' => true,
                        'description' => 'Заказ №1',
                    ),
                    uniqid('', true)
                );

                $type = 'Subscription';

                Session::put('payment_id', $payment['id']);
                if (is_array($request)) {
                    // Convert the array to an Illuminate\Http\Request object
                    $request = Request::create('/', 'POST', $request);
                }
                $requestData = $request->except('attachment','payment_receipt');
                Session::put('request_data', $requestData);
                if (module_is_active('CheckoutAttachment')) {
                    \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
                }
                if ($payment['confirmation']['confirmation_url'] != null) {
                    return $payment['confirmation']['confirmation_url'];
                } else {
                    return redirect()->route('checkout', $slug)->with('error', 'Something went wrong, Please try again');
                }
            } else {
                return redirect()->back()->with('error', 'Please Enter  Valid Shop Id Key');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('Incorrect currency of payment.'));
        }

    }

    private function processXendit($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });

        $theme_id = $request->theme_id;

        $xendit_api = \App\Models\Utility::GetValueByName('Xendit_api_key', $theme_id, $store->id);
        $Xendit_token_key = \App\Models\Utility::GetValueByName('Xendit_token_key', $theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id, $store->id);

        $orderID = $request->customer_id . date('YmdHis');
        $cartlist_final_price = $request->cartlist_final_price;
        Xendit::setApiKey($xendit_api);

        $params = [
            'external_id' => $orderID,
            'description' => 'Payment for order ' . $orderID,
            'amount' => $cartlist_final_price,
            'callback_url' => route('store.payment.stripe', $slug),
            'success_redirect_url' => route('store.payment.stripe', [$slug, 'request_data' => $request->all()]),
            'failure_redirect_url' => route('store.payment.stripe', $slug),
        ];
        $invoice = Invoice::create($params);
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
        Session()->put('invoice', $invoice);

        return $invoice['invoice_url'];
    }

    private function processMidtrans($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });

        $theme_id = $request->theme_id;

        $midtrans_secret_key = \App\Models\Utility::GetValueByName('midtrans_secret_key', $theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $theme_id, $store->id);

        $orderID = $request->customer_id . date('YmdHis');
        $cartlist_final_price = $request->cartlist_final_price;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;
        try {
            \Midtrans\Config::$serverKey = $midtrans_secret_key;
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $orderID,
                    'gross_amount' => ceil($cartlist_final_price),
                ),
                'customer_details' => array(
                    'first_name' => $other_info['firstname'],
                    'last_name' => $other_info['lastname'],
                    'email' => $other_info['email'],
                    'phone' => '8787878787',
                ),
            );
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            if (is_array($request)) {
                // Convert the array to an Illuminate\Http\Request object
                $request = Request::create('/', 'POST', $request);
            }
            $requestData = $request->except('attachment','payment_receipt');
            Session::put('request_data', $requestData);
            if (module_is_active('CheckoutAttachment')) {
                \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
            }
            $data = [
                'snap_token' => $snapToken,
                'midtrans_secret' => $midtrans_secret_key,
                'order_id' => $orderID,
                'slug' => $slug,
                'amount' => $cartlist_final_price,
                'fallback_url' => 'store.payment.midtrans',
                $slug
            ];
            return view('midtras.order_payment', compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e);
        }
    }

    public function getProductStatus($request, $slug, $response)
    {
        $requests_data = $request->all();

        if($requests_data['payment_type'] && $requests_data['payment_type'] == "bank_transfer"){
            $validator = \Illuminate\Support\Facades\Validator::make($requests_data, [
                'payment_receipt' => 'required|image',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error',__('The payment receipt field is required.'));
            }

            if ($requests_data['payment_receipt']) {
                $dir = 'storage/uploads/receipt';
                if($requests_data['payment_receipt']) {
                    $fileName = $requests_data['payment_receipt']->getClientOriginalName() . '_' . time();
                    $path = Utility::upload_file($requests_data, 'payment_receipt', $fileName, $dir,[],$requests_data['payment_receipt']);
                }
                if ($path['flag'] == 1) {
                    $payment_receipt = $path['url'];
                } else {
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }
        }
        
        $slug = !empty($requests_data['slug']) ? $requests_data['slug'] : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        // Session::forget('request_data');
        $customer_id = $requests_data['customer_id'];

        if (!empty($requests_data['method_id'])) {

            $request['method_id'] = $requests_data['method_id'];
        }
        $user = Cache::remember('admin_details', 3600, function () {
            return User::where('type','admin')->first();
        });
        if ($user->type == 'admin') {
            $plan = Cache::remember('plan_details_'.$user->id, 3600, function () use ($user) {
                return Plan::find($user->plan_id);
            });
        }
        $theme_id = !empty($request->theme_id) ? $request->theme_id : $store->theme_id;
        if (module_is_active('PartialPayments')) {
            if ($plan && strpos($plan->modules, 'PartialPayments') !== false && \Auth::guard('customers')->user()) {
                if ((isset($request->partial_payment_type) || $request->partial_payment_type == 'pending_payment')) {
                    $return = \Workdo\PartialPayments\app\Models\PartialPayments::ManagePartialPayment($requests_data, $slug);
                    if ($return['status'] == 'success') {
                        return redirect()->back()->with('success', __($return['message']));
                    }
                }
            }
        }
        if (!auth('customers')->user()) {
            if ($request->coupon_code != null) {
                $coupon = Coupon::where('id', $request->coupon_info['coupon_id'])->where('store_id', $store->id)->where('theme_id', $theme_id)->first();
                $coupon_email = $coupon->PerUsesCouponCount();
                $i = 0;
                foreach ($coupon_email as $email) {
                    if ($email == $request->billing_info['email']) {
                        $i++;
                    }
                }

                if (!empty($coupon->coupon_limit_user)) {
                    if ($i >= $coupon->coupon_limit_user) {
                        return $this->error(['message' => __('This coupon has expired.')]);
                    }
                }
            }
        }
        if (!auth('customers')->user()) {
            $rules = [
                'billing_info' => 'required',
                'payment_type' => 'required',
                // 'delivery_id' => 'required',
            ];
        } else {
            $rules = [
                'customer_id' => 'required',
                'billing_info' => 'required',
                'payment_type' => 'required',
                //'delivery_id' => 'required',
            ];
        }


        $validator = \Validator::make($requests_data, $rules);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            Utility::error([
                'message' => $messages->first()
            ]);
        }

        $cartlist_final_price = 0;
        $final_price = 0;
        $tax_price = 0;
        // cart list api call


        $cartlist_final_price = !empty($response['final_price']) ? $response['final_price'] : 0;
        $product_price = !empty($response['total_final_price']) ? $response['total_final_price'] : 0;
        $final_price = $response['total_final_price'];
        $total_sub_price = $response['total_sub_price'];
        $tax_price = !empty($requests_data['tax_price']) ? $requests_data['tax_price'] : ($response['tax_price'] ?? 0);
        $billing = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;
        $products = $response['product_list'];
        $coupon_price = 0;
        // coupon api call
        if (!empty($requests_data['coupon_code'])) {
            if (isset($requests_data['coupon_info']) && $requests_data['coupon_info']) {
                $coupon_price = $requests_data['coupon_info']['coupon_discount_amount'] ?? 0;
            } else {
                $coupon_data = $requests_data['coupon_code'];
                $apply_coupon = [
                    'coupon_code' => $coupon_data,
                    'sub_total' => $product_price,
                    'theme_id' => $requests_data['theme_id'],
                    'slug' => $requests_data['slug']

                ];
                $request->merge($apply_coupon);

                $couponss = new ApiController();
                $apply_coupon_response = $couponss->apply_coupon($request, $slug);
                $apply_coupon = (array) $apply_coupon_response->getData()->data;
                $order_array['coupon']['message'] = $apply_coupon['message'];
                $order_array['coupon']['status'] = false;
                if (!empty($apply_coupon['final_price'])) {
                    $cartlist_final_price = $apply_coupon['final_price'];
                    $coupon_price = $apply_coupon['amount'];
                    $order_array['coupon']['status'] = true;
                }
            }
        } elseif (!empty($requests_data['cartlist']['coupon_code'])) {
            $coupon_info = is_object($requests_data['cartlist']['coupon_info']) ? (array) $requests_data['cartlist']['coupon_info'] : $requests_data['cartlist']['coupon_info'];
            if (isset($coupon_info) && $coupon_info) {
                $coupon_price = ($coupon_info['coupon_final_amount'] ?? 0);
            } else {
                $coupon_data = $requests_data['cartlist']['coupon_code'];
                $apply_coupon = [
                    'coupon_code' => $coupon_data,
                    'sub_total' => $product_price,
                    'theme_id' => $requests_data['theme_id'],
                    'slug' => $requests_data['slug']

                ];
                $request->merge($apply_coupon);

                $couponss = new ApiController();
                $apply_coupon_response = $couponss->apply_coupon($request, $slug);
                $apply_coupon = (array) $apply_coupon_response->getData()->data;
                $order_array['coupon']['message'] = $apply_coupon['message'];
                $order_array['coupon']['status'] = false;
                if (!empty($apply_coupon['final_price'])) {
                    $cartlist_final_price = $apply_coupon['final_price'];
                    $coupon_price = $apply_coupon['amount'];
                    $order_array['coupon']['status'] = true;
                }
            }
        }
        $delivery_price = 0;
        if ($plan->shipping_method == 'on') {
            if (isset($requests_data['shipping_final_price'])) {
                $delivery_price = $requests_data['shipping_final_price'];
            } else {
                if (!empty($request->method_id)) {
                    $del_charge = new CartController();
                    $delivery_charge = $del_charge->get_shipping_method($request, $slug);
                    $content = $delivery_charge->getContent();

                    $data = json_decode($content, true);
                    $delivery_price = $data['total_final_price'];
                    $tax_price = $requests_data['tax_price'] ?? ($content['final_tax_price'] ?? 0);
                } else {
                    return $this->error(['message' => 'Shipping Method not found']);
                }
            }
        } else {
            if (!empty($tax_price)) {
                $tax_price = $tax_price;
            } else {
                $tax_price = 0;
            }
        }

        $settings = Setting::where('theme_id', $theme_id)->where('store_id', $store->id)->pluck('value', 'name')->toArray();

        // Order stock decrease start
        $prodduct_id_array = [];
        if (!empty($products)) {
            foreach ($products as $key => $product) {
                $prodduct_id_array[] = $product->product_id;

                $product_id = $product->product_id;
                $variant_id = $product->variant_id;
                $qtyy = !empty($product->qty) ? $product->qty : 0;

                $Product = Product::where('id', $product_id)->first();
                $datas = Product::find($product_id);
                if (isset($settings['stock_management']) && $settings['stock_management'] == 'on') {
                    if (!empty($product_id) && !empty($variant_id) && $product_id != 0 && $variant_id != 0) {
                        $ProductStock = ProductVariant::where('id', $variant_id)->where('product_id', $product_id)->first();
                        $variationOptions = explode(',', $ProductStock->variation_option);
                        $option = in_array('manage_stock', $variationOptions);
                        if (!empty($ProductStock)) {
                            if ($option == true) {
                                $remain_stock = $ProductStock->stock - $qtyy;
                                $ProductStock->stock = $remain_stock;
                                $ProductStock->save();

                                if ($ProductStock->stock <= $ProductStock->low_stock_threshold) {
                                    if (!empty(json_decode($settings['notification'])) && in_array("enable_low_stock", json_decode($settings['notification']))) {
                                        if (isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] == "on") {
                                            Utility::variant_low_stock_threshold($product, $ProductStock, $theme_id, $settings);
                                        }

                                    }
                                }
                                if (isset($settings['out_of_stock_threshold']) && $ProductStock->stock <= $settings['out_of_stock_threshold']) {
                                    if (!empty(json_decode($settings['notification'])) && in_array("enable_out_of_stock", json_decode($settings['notification']))) {
                                        if (isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] == "on") {
                                            Utility::variant_out_of_stock($product, $ProductStock, $theme_id, $settings);
                                        }
                                    }
                                }
                            } else {
                                $remain_stock = $datas->product_stock - $qtyy;
                                $datas->product_stock = $remain_stock;
                                $datas->save();
                                if ($datas->product_stock <= $datas->low_stock_threshold) {
                                    if (!empty(json_decode($settings['notification'])) && in_array("enable_low_stock", json_decode($settings['notification']))) {
                                        if (isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] == "on") {
                                            Utility::variant_low_stock_threshold($product, $datas, $theme_id, $settings);
                                        }

                                    }
                                }
                                if (isset($settings['out_of_stock_threshold']) && $datas->product_stock <= $settings['out_of_stock_threshold']) {
                                    if (!empty(json_decode($settings['notification'])) && in_array("enable_out_of_stock", json_decode($settings['notification']))) {
                                        if (isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] == "on") {
                                            Utility::variant_out_of_stock($product, $datas, $theme_id, $settings);
                                        }
                                    }
                                }
                                if (isset($settings['out_of_stock_threshold']) && $datas->product_stock <= $settings['out_of_stock_threshold'] && $datas->stock_order_status == 'notify_customer') {
                                    //Stock Mail
                                    $order_email = $billing['email'];
                                    $owner = User::find($store->created_by);
                                    $ProductId = '';

                                    try {
                                        $dArr = [
                                            'item_variable' => $Product->id,
                                            'product_name' => $Product->name,
                                            'customer_name' => $billing['firstname'],
                                        ];

                                        // Send Email
                                        $resp = Utility::sendEmailTemplate('Stock Status', $order_email, $dArr, $owner, $store, $ProductId);
                                    } catch (\Exception $e) {
                                        $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                                    }
                                    try {
                                        $mobile_no = $request['billing_info']['billing_user_telephone'];
                                        $customer_name = $request['billing_info']['firstname'];
                                        $msg = __("Dear,$customer_name .Hi,We are excited to inform you that the product you have been waiting for is now back in stock.Product Name: :$Product->name. ");
                                        $resp = Utility::SendMsgs('Stock Status', $mobile_no, $msg);
                                    } catch (\Exception $e) {
                                        $smtp_error = __('Invalid OAuth access token - Cannot parse access token');
                                    }
                                }
                            }
                        } else {
                            return $this->error(['message' => 'Product not found .']);
                        }
                    } elseif (!empty($product_id) && $product_id != 0) {

                        if (!empty($Product)) {
                            $remain_stock = $Product->product_stock - $qtyy;
                            $Product->product_stock = $remain_stock;
                            $Product->save();
                            if ($Product->product_stock <= $Product->low_stock_threshold) {
                                if (!empty(json_decode($settings['notification'])) && in_array("enable_low_stock", json_decode($settings['notification']))) {
                                    if (isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] == "on") {
                                        Utility::low_stock_threshold($Product, $theme_id, $settings);
                                    }
                                }
                            }

                            if (isset($settings['out_of_stock_threshold']) && $Product->product_stock <= $settings['out_of_stock_threshold']) {
                                if (!empty(json_decode($settings['notification'])) && in_array("enable_out_of_stock", json_decode($settings['notification']))) {
                                    if (isset($settings['twilio_setting_enabled']) && $settings['twilio_setting_enabled'] == "on") {
                                        Utility::out_of_stock($Product, $theme_id, $settings);
                                    }
                                }
                            }

                            if (isset($settings['out_of_stock_threshold']) && $Product->product_stock <= $settings['out_of_stock_threshold'] && $Product->stock_order_status == 'notify_customer') {
                                //Stock Mail
                                $order_email = $billing['email'];
                                $owner = User::find($store->created_by);
                                $ProductId = '';

                                try {
                                    $dArr = [
                                        'item_variable' => $Product->id,
                                        'product_name' => $Product->name,
                                        'customer_name' => $billing['firstname'],
                                    ];

                                    // Send Email
                                    $resp = Utility::sendEmailTemplate('Stock Status', $order_email, $dArr, $owner, $store, $ProductId);
                                } catch (\Exception $e) {
                                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                                }
                                try {
                                    $mobile_no = $request['billing_info']['billing_user_telephone'];
                                    $customer_name = $request['billing_info']['firstname'];
                                    $msg = __("Dear,$customer_name .Hi,We are excited to inform you that the product you have been waiting for is now back in stock.Product Name: :$Product->name. ");
                                    $resp = Utility::SendMsgs('Stock Status', $mobile_no, $msg);
                                } catch (\Exception $e) {
                                    $smtp_error = __('Invalid OAuth access token - Cannot parse access token');
                                }
                            }

                        } else {
                            return $this->error(['message' => 'Product not found .']);
                        }
                    } else {
                        return $this->error(['message' => 'Please fill proper product json field .']);
                    }
                }
                // remove from cart
                Cart::where('customer_id', $request->customer_id)->where('product_id', $product_id)->where('variant_id', $variant_id)->where('theme_id', $theme_id)->where('store_id', $store->id)->delete();
            }
        }
        // Order stock decrease end
        if (!empty($prodduct_id_array)) {
            $prodduct_id_array = $prodduct_id_array = array_unique($prodduct_id_array);
            $prodduct_id_array = implode(',', $prodduct_id_array);
        } else {
            $prodduct_id_array = '';
        }

        $product_reward_point = 1;

        $product_order_id = '0' . date('YmdHis');
        $is_guest = 1;
        if (auth('customers')->check()) {
            $product_order_id = $request->customer_id . date('YmdHis');
            $is_guest = 0;
        }
        // add in  Order table  start
        $order = new Order();
        $order->product_order_id = $product_order_id;
        $order->order_date = date('Y-m-d H:i:s');
        $order->customer_id = !empty($request->customer_id) ? $request->customer_id : 0;
        $order->is_guest = $is_guest;
        $order->product_id = $prodduct_id_array;
        $order->product_json = json_encode($products);
        $order->product_price = $product_price;
        $order->coupon_price = $coupon_price;
        $order->delivery_price = $delivery_price;
        $order->tax_price = $tax_price;
        if (!auth('customers')->user()) {
            if ($plan->shipping_method == "on") {
                $order->final_price = $total_sub_price + $delivery_price;
            } else {
                $order->final_price = $total_sub_price;
            }

        } elseif (module_is_active('PartialPayments') && \Auth::guard('customers')->user() && (isset($settings['enable_partial_payment']) && $settings['enable_partial_payment'] == 'on')) {
            $order->final_price = $requests_data['cartlist_final_price'] ?? $total_sub_price;
            \Workdo\PartialPayments\app\Models\OrderPartialPayments::OrderPartialPayments($order, $slug, $request);
        } else {

            if (module_is_active('RewardClubPoint') && isset($requests_data['club_point_is_active']) && $requests_data['club_point_is_active'] == 'on') {
                $customerDetail = Customer::find($customer_id);
                $rewardSetting = getAdminAllSetting($store->created_by, $store->id, $store->theme_id) ?? null;
                $saveRewardPrice = ($customerDetail->total_club_point * $rewardSetting['reward_point_price'] ?? 0) / ($rewardSetting['reward_points'] ?? 0);
                if ($plan->shipping_method == "on") {
                    $order->final_price = $total_sub_price + $delivery_price - $saveRewardPrice;
                } else {
                    $order->final_price = $total_sub_price - $saveRewardPrice;
                }
            } else {
                if ($plan->shipping_method == "on") {
                    $order->final_price = $total_sub_price + $delivery_price;
                } else {
                    $order->final_price = $total_sub_price;
                }
            }
        }
        event(new AddAdditionalFields($order, $request->all(), $store));
        $order->payment_comment = !empty($requests_data['payment_comment']) ? $requests_data['payment_comment'] : '';
        $order->payment_type = $requests_data['payment_type'];
        $order->payment_status = 'Paid';
        $order->delivery_id = $requests_data['method_id'] ?? 0;
        $order->delivery_comment = !empty($requests_data['delivery_comment']) ? $requests_data['delivery_comment'] : '';
        if (module_is_active('PreOrder') && \Auth::guard('customers')->user() && isset($requests_data['order_type']) && $requests_data['order_type'] == 'pre_order') {
            $order->delivered_status = 8;
        }else{
            $order->delivered_status = 0;
        }
        $order->reward_points = SetNumber($product_reward_point);
        $order->additional_note = $request->additional_note;
        $order->payment_receipt = $payment_receipt ?? null;
        $order->theme_id = $store->theme_id;
        $order->store_id = $store->id;
        $order->save();
        // add in  Order table end
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachment($order, $slug, $request);
        }
        // Utility::paymentWebhook($order);

        $billing_city_id = $billing['billing_city'] ?? 0;
        if (!empty($billing['billing_city'])) {
            $cityy = City::where('id', $billing['billing_city'])->first();
            if (!empty($cityy)) {
                $billing_city_id = $cityy->id;
            } else {
                $new_billing_city = new City();
                $new_billing_city->name = $billing['billing_city'];
                $new_billing_city->state_id = $billing['billing_state'];
                $new_billing_city->country_id = $billing['billing_country'];
                $new_billing_city->save();
                $billing_city_id = $new_billing_city->id;
            }
        }

        $delivery_city_id = $billing['delivery_city'] ?? 0;
        if (!empty($billing['delivery_city'])) {
            $d_cityy = City::where('id', $billing['delivery_city'])->first();
            if (!empty($d_cityy)) {
                $delivery_city_id = $d_cityy->id;
            } else {
                $new_delivery_city = new City();
                $new_delivery_city->name = $billing['delivery_city'];
                $new_delivery_city->state_id = $billing['delivery_state'];
                $new_delivery_city->country_id = $billing['delivery_country'];
                $new_delivery_city->save();
                $delivery_city_id = $new_delivery_city->id;
            }
        }

        $OrderBillingDetail = new OrderBillingDetail();
        $OrderBillingDetail->order_id = $order->id;
        $OrderBillingDetail->product_order_id = $order->product_order_id;
        $OrderBillingDetail->first_name = !empty($billing['firstname']) ? $billing['firstname'] : '';
        $OrderBillingDetail->last_name = !empty($billing['lastname']) ? $billing['lastname'] : '';
        $OrderBillingDetail->email = !empty($billing['email']) ? $billing['email'] : '';
        $OrderBillingDetail->telephone = !empty($billing['billing_user_telephone']) ? $billing['billing_user_telephone'] : '';
        $OrderBillingDetail->address = !empty($billing['billing_address']) ? $billing['billing_address'] : '';
        $OrderBillingDetail->postcode = !empty($billing['billing_postecode']) ? $billing['billing_postecode'] : '';
        $OrderBillingDetail->country = !empty($billing['billing_country']) ? $billing['billing_country'] : '';
        $OrderBillingDetail->state = !empty($billing['billing_state']) ? $billing['billing_state'] : '';
        $OrderBillingDetail->city = $billing_city_id;
        $OrderBillingDetail->theme_id = $theme_id;
        $OrderBillingDetail->delivery_address = !empty($billing['delivery_address']) ? $billing['delivery_address'] : '';
        $OrderBillingDetail->delivery_city = $delivery_city_id;
        $OrderBillingDetail->delivery_postcode = !empty($billing['delivery_postcode']) ? $billing['delivery_postcode'] : '';
        $OrderBillingDetail->delivery_country = !empty($billing['delivery_country']) ? $billing['delivery_country'] : '';
        $OrderBillingDetail->delivery_state = !empty($billing['delivery_state']) ? $billing['delivery_state'] : '';
        $OrderBillingDetail->save();

        // add in Order Coupon Detail table start
        if (!empty($requests_data['coupon_info'])) {
            $coupon_data = $requests_data['coupon_info'];
            $Coupon = Coupon::find($coupon_data['coupon_id']);
            if ($Coupon) {
                // coupon stock decrease end

                // Order Coupon history
                $OrderCouponDetail = new OrderCouponDetail();
                $OrderCouponDetail->order_id = $order->id;
                $OrderCouponDetail->product_order_id = $order->product_order_id;
                $OrderCouponDetail->coupon_id = $coupon_data['coupon_id'];
                $OrderCouponDetail->coupon_name = $coupon_data['coupon_name'];
                $OrderCouponDetail->coupon_code = $coupon_data['coupon_code'];
                $OrderCouponDetail->coupon_discount_type = $coupon_data['coupon_discount_type'];
                $OrderCouponDetail->coupon_discount_number = $coupon_data['coupon_discount_number'];
                $OrderCouponDetail->coupon_discount_amount = $coupon_data['coupon_discount_amount'];
                $OrderCouponDetail->coupon_final_amount = $coupon_data['coupon_final_amount'];
                $OrderCouponDetail->theme_id = $theme_id;
                $OrderCouponDetail->save();

                // Coupon history
                $UserCoupon = new UserCoupon();
                $UserCoupon->user_id = !empty($request->customer_id) ? $request->customer_id : null;
                $UserCoupon->coupon_id = $Coupon->id;
                $UserCoupon->amount = $coupon_data['coupon_discount_amount'];
                $UserCoupon->order_id = $order->id;
                $UserCoupon->date_used = now();
                $UserCoupon->theme_id = $theme_id;
                $UserCoupon->save();
            }


            $discount_string = '-' . $coupon_data['coupon_discount_amount'];
            $CURRENCY = Utility::GetValueByName('CURRENCY');
            $CURRENCY_NAME = Utility::GetValueByName('CURRENCY_NAME');
            if ($coupon_data['coupon_discount_type'] == 'flat') {
                $discount_string .= $CURRENCY;
            } else {
                $discount_string .= '%';
            }

            $discount_string .= ' ' . __('for all products');
            $order_array['coupon']['code'] = $coupon_data['coupon_code'] ?? null;
            $order_array['coupon']['discount_string'] = $discount_string ?? null;
            $order_array['coupon']['price'] = SetNumber($coupon_data['coupon_final_amount'] ?? 0.00);
        } elseif (!empty($requests_data['cartlist']['coupon_code'])) {
            $coupon_data = is_object($requests_data['cartlist']['coupon_info']) ? (array) $requests_data['cartlist']['coupon_info'] : $requests_data['cartlist']['coupon_info'];
            $Coupon = Coupon::find($coupon_data['coupon_id']);
            if ($Coupon) {
                // coupon stock decrease end

                // Order Coupon history
                $OrderCouponDetail = new OrderCouponDetail();
                $OrderCouponDetail->order_id = $order->id;
                $OrderCouponDetail->product_order_id = $order->product_order_id;
                $OrderCouponDetail->coupon_id = $coupon_data['coupon_id'];
                $OrderCouponDetail->coupon_name = $coupon_data['coupon_name'];
                $OrderCouponDetail->coupon_code = $coupon_data['coupon_code'];
                $OrderCouponDetail->coupon_discount_type = $coupon_data['coupon_discount_type'];
                $OrderCouponDetail->coupon_discount_number = $coupon_data['coupon_discount_number'];
                $OrderCouponDetail->coupon_discount_amount = $coupon_data['coupon_discount_amount'];
                $OrderCouponDetail->coupon_final_amount = $coupon_data['coupon_final_amount'];
                $OrderCouponDetail->theme_id = $theme_id;
                $OrderCouponDetail->save();

                // Coupon history
                $UserCoupon = new UserCoupon();
                $UserCoupon->user_id = !empty($request->customer_id) ? $request->customer_id : null;
                $UserCoupon->coupon_id = $Coupon->id;
                $UserCoupon->amount = $coupon_data['coupon_discount_amount'];
                $UserCoupon->order_id = $order->id;
                $UserCoupon->date_used = now();
                $UserCoupon->theme_id = $theme_id;
                $UserCoupon->save();
            }


            $discount_string = '-' . $coupon_data['coupon_discount_amount'];
            $CURRENCY = Utility::GetValueByName('CURRENCY');
            $CURRENCY_NAME = Utility::GetValueByName('CURRENCY_NAME');
            if ($coupon_data['coupon_discount_type'] == 'flat') {
                $discount_string .= $CURRENCY;
            } else {
                $discount_string .= '%';
            }

            $discount_string .= ' ' . __('for all products');
            $order_array['coupon']['code'] = $coupon_data['coupon_code'] ?? null;
            $order_array['coupon']['discount_string'] = $discount_string ?? null;
            $order_array['coupon']['price'] = SetNumber($coupon_data['coupon_final_amount'] ?? 0.00);
        }

        // add in Order Coupon Detail table end
        if ($response['tax_id']) {
            $taxes = TaxMethod::where('tax_id', $response['tax_id'])->where('theme_id', $theme_id)->where('store_id', $store->id)->orderBy('priority', 'asc')->get();
            $other_info = is_string($requests_data['billing_info']) ? (array) json_decode($requests_data['billing_info']) : $requests_data['billing_info'];
            $country = !empty($other_info->delivery_country) ? $other_info->delivery_country : $other_info['delivery_country'];
            $state_id = !empty($other_info->delivery_state) ? $other_info->delivery_state : $other_info['delivery_state'];
            $city_id = !empty($other_info->delivery_city) ? $other_info->delivery_city : $other_info['delivery_city'];
            foreach ($taxes as $tax) {
                $countryMatch = (!$tax->country_id || $country == $tax->country_id);
                $stateMatch = (!$tax->state_id || $state_id == $tax->state_id);
                $cityMatch = (!$tax->city_id || $city_id == $tax->city_id);

                if ($countryMatch && $stateMatch && $cityMatch) {
                    $OrderTaxDetail = new OrderTaxDetail();
                    $OrderTaxDetail->order_id = $order->id;
                    $OrderTaxDetail->product_order_id = $order->product_order_id;
                    $OrderTaxDetail->tax_id = $response['tax_id'];
                    $OrderTaxDetail->tax_name = $tax->name;
                    $OrderTaxDetail->tax_discount_amount = $tax->tax_rate;
                    $OrderTaxDetail->tax_final_amount = $requests_data['tax_price'];
                    $OrderTaxDetail->theme_id = $theme_id;
                    $OrderTaxDetail->save();
                }
            }
        }
        //activity log
        ActivityLog::order_entry([
            'customer_id' => $order->customer_id,
            'order_id' => $order->product_order_id,
            'order_date' => $order->order_date,
            'products' => $order->product_id,
            'final_price' => $order->final_price,
            'payment_type' => $order->payment_type,
            'theme_id' => $order->theme_id,
            'store_id' => $order->store_id
        ]);
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        //Order Mail
        //$order_email = !empty($other_info->email) ? $other_info->email : '';
        $order_email = $OrderBillingDetail->email ?? (!empty($other_info->email) ? $other_info->email : '');
        $owner = User::find($store->created_by);
        $owner_email = $owner->email;
        $order_id = Crypt::encrypt($order->id);

        if (module_is_active('PreOrder') && \Auth::guard('customers')->user() && isset($requests_data['order_type']) && $requests_data['order_type'] == 'pre_order') {
            \Workdo\PreOrder\app\Models\PreOrderHistory::PreOrderHistory($order, $store, $request, $order_email);
        } else {
            try {
                $dArr = [
                    'order_id' => $order->product_order_id,
                ];

                // Send Email
                $resp = Utility::sendEmailTemplate('Order Created', $order_email, $dArr, $owner, $store, $order_id);
                $resp1 = Utility::sendEmailTemplate('Order Created For Owner', $owner_email, $dArr, $owner, $store, $order_id);
            } catch (\Exception $e) {
                $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
            }
        }

        foreach ($products as $product) {
            $product_data = Product::find($product->product_id);

            if ($product_data) {
                if ($product_data->variant_product == 0) {
                    if ($product_data->track_stock == 1) {
                        OrderNote::order_note_data([
                            'customer_id' => !empty($request->customer_id) ? $request->customer_id : '0',
                            'order_id' => $order->id,
                            'product_name' => !empty($product_data->name) ? $product_data->name : '',
                            'variant_product' => $product_data->variant_product,
                            'product_stock' => !empty($product_data->product_stock) ? $product_data->product_stock : '',
                            'status' => 'Stock Manage',
                            'theme_id' => $order->theme_id,
                            'store_id' => $order->store_id,
                        ]);
                    }
                } else {
                    $variant_data = ProductVariant::find($product->variant_id);
                    $variationOptions = explode(',', $variant_data->variation_option);
                    $option = in_array('manage_stock', $variationOptions);
                    if ($option == true) {
                        OrderNote::order_note_data([
                            'customer_id' => !empty($request->customer_id) ? $request->customer_id : '0',
                            'order_id' => !empty($order->id) ? $order->id : '',
                            'product_name' => !empty($product_data->name) ? $product_data->name : '',
                            'variant_product' => $product_data->variant_product,
                            'product_variant_name' => !empty($variant_data->variant) ? $variant_data->variant : '',
                            'product_stock' => !empty($variant_data->stock) ? $variant_data->stock : '',
                            'status' => 'Stock Manage',
                            'theme_id' => $order->theme_id,
                            'store_id' => $order->store_id,
                        ]);
                    }
                }
            }
        }

        OrderNote::order_note_data([
            'customer_id' => !empty($request->customer_id) ? $request->customer_id : '0',
            'order_id' => $order->id,
            'product_order_id' => $order->product_order_id,
            'delivery_status' => 'Pending',
            'status' => 'Order Created',
            'theme_id' => $order->theme_id,
            'store_id' => $order->store_id
        ]);

        try {
            $msg = __("Hello, Welcome to $store->name .Hi,your order id is $order->product_order_id, Thank you for Shopping We received your purchase request, we'll be in touch shortly!. ");
            $mess = Utility::SendMsgs('Order Created', $OrderBillingDetail->telephone, $msg);
        } catch (\Exception $e) {
            $smtp_error = __('Invalid OAuth access token - Cannot parse access token');
        }
        if (auth('customers')->user() && module_is_active('ProductAffiliate')) {
            Utility::affiliateTransaction($order);
        }
        // add in Order Tax Detail table end
        if (!empty($order) && !empty($OrderBillingDetail)) {
            $cart = Cookie::get('cart');
            $cart = Cart::where('cookie_session_id', $cart)->delete();
            // $order_array['order_id'] = $order->id;
            // $cart_array = [];
            // $cart_json = json_encode($cart_array);
            // Cookie::queue('cart', $cart_json, 1440);

            if (auth('customers')->user()) {
                event(new AddRewardClubPoint($requests_data, $order, $slug));
            }
            return redirect()->route('order.summary', $slug)->with('data', $order->product_order_id);
        } else {
            return $this->error(['message' => 'Somthing went wrong.']);
        }
    }

    public function processWhatsapp($request, $slug, $response)
    {
        $data = $request->all();
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
        //Session::put('request_data', $request->all());
        return view('payment.whatsapp', compact('data'));
    }

    private function processNepalste($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;
        $admin_payment_setting = getAdminAllSetting();

        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $api_key = isset($admin_payment_setting['nepalste_public_key']) ? $admin_payment_setting['nepalste_public_key'] : '';
        $nepalste_mode = isset($admin_payment_setting['nepalste_mode']) ? $admin_payment_setting['nepalste_mode'] : '';

        $orderID = $request->customer_id . date('YmdHis');
        $cartlist_final_price = $request->cartlist_final_price;
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));

        $requests_data = $request->all();


        $parameters = [
            'identifier' => 'DFU80XZIKS',
            'currency' => $currency,
            'amount' => $cartlist_final_price,
            'details' => 'test',
            'ipn_url' => route('store.payment.stripe', $slug),
            'cancel_url' => route('nepalste.cancel'),
            'success_url' => route('store.payment.stripe', $slug),
            'public_key' => $api_key,
            'site_logo' => 'https://nepalste.com.np/assets/images/logoIcon/logo.png',
            'checkout_theme' => 'dark',
            'customer_name' => 'John Doe',
            'customer_email' => 'john@mail.com',
        ];

        if ($nepalste_mode == 'live') {
            //live end point
            $url = "https://nepalste.com.np/payment/initiate";
        } else {
            //test end point
            $url = "https://nepalste.com.np/sandbox/payment/initiate";
        }
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        \Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);
        if (isset($result['success'])) {
            return redirect($result['url']);
        }else{
            return redirect()->back()->with('error',isset($result['message']) ? $result['message'] : 'Something went wrong');
        }
    }

    private function processKhalti($request, $slug, $response)
    {
        $data = $request->all();
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
        $store = Store::where('slug', $request->slug)->first();
        $admin_payment_setting = getAdminAllSetting();
        return view('payment.khalti', compact('data', 'admin_payment_setting', 'store'));
    }

    private function processPayHere($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;
        $admin_payment_setting = getAdminAllSetting(null, $store->id, $store->theme_id);

        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $orderID = $request->customer_id . date('YmdHis');
        $cartlist_final_price = $request->sub_total;
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));

        $requests_data = $request->all();
        try {
            $config = [
                'payhere.api_endpoint' => $admin_payment_setting['payhere_mode'] === 'sandbox'
                    ? 'https://sandbox.payhere.lk/'
                    : 'https://www.payhere.lk/',
            ];

            $config['payhere.merchant_id'] = $admin_payment_setting['payhere_merchant_id'] ?? '';
            $config['payhere.merchant_secret'] = $admin_payment_setting['payhere_merchant_secret'] ?? '';
            $config['payhere.app_secret'] = $admin_payment_setting['payhere_app_secret'] ?? '';
            $config['payhere.app_id'] = $admin_payment_setting['payhere_app_id'] ?? '';
            config($config);

            $hash = strtoupper(
                md5(
                    $admin_payment_setting['payhere_merchant_id'] .
                    $orderID .
                    number_format($cartlist_final_price, 2, '.', '') .
                    'LKR' .
                    strtoupper(md5($admin_payment_setting['payhere_merchant_secret']))
                )
            );

            $data = [
                'first_name' => $other_info['firstname'],
                'last_name' => $other_info['lastname'],
                'email' => $other_info['email'],
                'phone' => $other_info['billing_user_telephone'],
                'address' => $other_info['billing_address'],
                'city' => $other_info['billing_city'],
                'country' => $other_info['billing_country'],
                'order_id' => $orderID,
                'items' => 'test',
                'currency' => $currency,
                'amount' => $cartlist_final_price,
                'hash' => $hash,
            ];
            if (is_array($request)) {
                // Convert the array to an Illuminate\Http\Request object
                $request = Request::create('/', 'POST', $request);
            }
            $requestData = $request->except('attachment','payment_receipt');
            Session::put('request_data', $requestData);
            if (module_is_active('CheckoutAttachment')) {
                \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
            }
            return PayHere::checkOut()
                ->data($data)
                ->successUrl(route('store.payment.stripe', $slug))
                ->failUrl(route('store.payment.stripe', $slug))
                ->renderView();
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());
            return redirect()->back()->with('error', __($e->getMessage()));
        }
    }

    private function processAuthorizeNet($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;
        $admin_payment_setting = getAdminAllSetting();

        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);

        $orderID = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }

        $requests_data = $request->all();

        $data = [
            'orderID' => $orderID,
            'customer_id' => $request->customer_id,
            'slug' => $slug,
            'get_amount' => $cartlist_final_price,
        ];

        $data = json_encode($data);
        $req_data = $request->all();
        $get_amount = $cartlist_final_price;

        try {
            return view('payment.authorizenet', compact('req_data', 'admin_payment_setting', 'slug', 'data', 'get_amount'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    public function processTap($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;
        $admin_payment_setting = getAdminAllSetting();
        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $tap_secret_key = \App\Models\Utility::GetValueByName('tap_secret_key', $theme_id, $store->id);

        $orderID = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }

        $requests_data = $request->all();

        $TapPay = new Payment(['tap_secret_key' => $tap_secret_key]);

        return $TapPay->charge([
            'amount' => $cartlist_final_price,
            'currency' => $currency,
            'threeDSecure' => 'true',
            'description' => 'test description',
            'statement_descriptor' => 'sample',
            'customer' => [
                    'first_name' => $other_info['firstname'],
                    'email' => $other_info['email'],
                ],
            'source' => [
                'id' => 'src_card'
            ],
            'post' => [
                'url' => null
            ],
            // 'merchant' => [
            //    'id' => 'YOUR-MERCHANT-ID'  //Include this when you are going to live
            // ],
            'redirect' => [
                'url' => route('store.payment.stripe', $slug)
            ]
        ], true);

    }

    public function processPhonePe($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;
        $admin_payment_setting = getAdminAllSetting(null, $store->id, $store->theme_id);
        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $tap_secret_key = \App\Models\Utility::GetValueByName('tap_secret_key', $theme_id, $store->id);

        $orderID = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }

        $requests_data = $request->all();
        if ($admin_payment_setting['phonepe_mode'] == 'production') {
            config(
                [
                    'phonepe.production.merchant_id' => isset($admin_payment_setting['phonepe_merchant_key']) ? $admin_payment_setting['phonepe_merchant_key'] : '',
                    'phonepe.production.merchant_user_id' => isset($admin_payment_setting['phonepe_merchant_user_id']) ? $admin_payment_setting['phonepe_merchant_user_id'] : '',
                    'phonepe.production.salt_key' => isset($admin_payment_setting['phonepe_salt_key']) ? $admin_payment_setting['phonepe_salt_key'] : '',
                    'phonepe.env' => isset($admin_payment_setting['phonepe_mode']) ? $admin_payment_setting['phonepe_mode'] : '',
                    'phonepe.saltIndex' => '1',
                    'phonepe.callBackUrl' => route('store.payment.phonepe', $slug),
                ]
            );
        } else {
            config(
                [
                    'phonepe.merchantId' => isset($admin_payment_setting['phonepe_merchant_key']) ? $admin_payment_setting['phonepe_merchant_key'] : '',
                    'phonepe.merchantUserId' => isset($admin_payment_setting['phonepe_merchant_user_id']) ? $admin_payment_setting['phonepe_merchant_user_id'] : '',
                    'phonepe.saltKey' => isset($admin_payment_setting['phonepe_salt_key']) ? $admin_payment_setting['phonepe_salt_key'] : '',
                    'phonepe.env' => isset($admin_payment_setting['phonepe_mode']) ? $admin_payment_setting['phonepe_mode'] : '',
                    'phonepe.saltIndex' => '1',
                    'phonepe.callBackUrl' => route('store.payment.phonepe', $slug),
                ]
            );
        }

        $provider = new LaravelPhonePe();

        $response = $provider->makePayment(
            $cartlist_final_price,
            $other_info['billing_user_telephone'],
            $callback_url = route('store.payment.phonepe', $slug),
            '1'
        );
        return redirect()->away($response);

    }

    public function processPaddle($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        $admin_payment_setting = getAdminAllSetting(null, $store->id, $store->theme_id);
        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);

        $orderID = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }

        if (!auth('customers')->user()) {
            $user = auth()->user();
        } else {
            $user = Customer::find($request['customer_id']);
        }
        $requests_data = $request->all();
        config(
            [
                'cashier.vendor_id' => !empty($admin_payment_setting['paddle_vendor_id']) ? $admin_payment_setting['paddle_vendor_id'] : '',
                'cashier.vendor_auth_code' => !empty($admin_payment_setting['paddle_vendor_auth_code']) ? $admin_payment_setting['paddle_vendor_auth_code'] : '',
                'cashier.public_key' => !empty($admin_payment_setting['paddle_public_key']) ? $admin_payment_setting['paddle_public_key'] : '',
                'cashier.sandbox' => !empty($admin_payment_setting['paddle_mode']) ? $admin_payment_setting['paddle_mode'] : true
            ]
        );

        try {
            $price = $cartlist_final_price;
            $paymentData = [
                "$currency:$price"
            ];
            $priceInCents = (int) ($price);
            $printID = 'Order payment';
            $paylink = $user->charge($priceInCents, $printID, [
                'quantity_variable' => 0,
                'discountable' => 0,
                'customer_email' => $other_info['email'],
                'webhook_url' => route('store.payment.stripe', $slug),
                'return_url' => route('store.payment.stripe', $slug),
            ]);
            return redirect($paylink);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', str_replace(array('\'', '"', '`', '{', "\n"), ' ', $th->getMessage()));
        }

    }

    public function processPaiementpro($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        $admin_payment_setting = getAdminAllSetting();
        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $merchant_id = \App\Models\Utility::GetValueByName('paiementpro_merchant_id', $theme_id, $store->id);

        $orderID = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }

        $requests_data = $request->all();

        $call_back = route('store.payment.paiementpro', $slug);

        $data = array(
            'merchantId' => $merchant_id,
            'amount' => $cartlist_final_price,
            'description' => "Api PHP",
            'channel' => $request->channel,
            'countryCurrencyCode' => !empty($currency) ? $currency : '',
            'referenceNumber' => "REF-" . time(),
            'customerEmail' => $other_info['email'],
            'customerFirstName' => $other_info['firstname'],
            'customerLastname' => $other_info['lastname'],
            'customerPhoneNumber' => $request->mobile_number,
            'notificationURL' => $call_back,
            'returnURL' => $call_back,
            'returnContext' => json_encode(["requests_data" => $requests_data])
            ,
        );

        $data = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paiementpro.net/webservice/onlinepayment/init/curl-init.php");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);

        curl_close($ch);
        $response = json_decode($response);

        if (isset($response->success) && $response->success == true) {
            // redirect to approve href
            return redirect($response->url);
        } else {
            return redirect()->back()->with('error', $response->message ?? 'Something went wrong.');
        }
    }

    public function processFedPay($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        $admin_payment_setting = getAdminAllSetting();
        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $fedpay_secret_key = \App\Models\Utility::GetValueByName('fedpay_secret_key', $theme_id, $store->id);
        $fedpay_mode = \App\Models\Utility::GetValueByName('fedpay_mode', $theme_id, $store->id);

        if($currency != "XOF"){
            return redirect()->back()->with('error', __('Currency is not Supported , Fedapay Support only XOF .'));
        }


        $orderID = $request->customer_id . date('YmdHis');

        $cartlist_final_price = intval($request->cartlist_final_price);

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }


        $requests_data = $request->all();

        try {
            \FedaPay\FedaPay::setApiKey($fedpay_secret_key);
            \FedaPay\FedaPay::setEnvironment($fedpay_mode);

            $transaction = \FedaPay\Transaction::create([
                "description" => "Fedapay Payment",
                "amount" => $cartlist_final_price,
                "currency" => ["iso" => $currency],
                "callback_url" => route('store.payment.stripe', $slug),
                "cancel_url" => route('store.payment.stripe', $slug)
            ]);
            $token = $transaction->generateToken();

            return redirect($token->url);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', str_replace(array('\'', '"', '`', '{', "\n"), ' ', $th->getMessage()));
        }

    }

    public function processCinetPay($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        $cinet_pay_site_id = \App\Models\Utility::GetValueByName('cinet_pay_site_id', $theme_id, $store->id);
        $cinet_pay_api_key = \App\Models\Utility::GetValueByName('cinet_pay_api_key', $theme_id, $store->id);

        $orderID = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }

        $requests_data = $request->all();

        $call_back = route('store.payment.cinetpay', $slug);

        $merchant_id = isset($cinet_pay_site_id) ? $cinet_pay_site_id : '';
        $cinet_pay_api_key = isset($cinet_pay_api_key) ? $cinet_pay_api_key : '';
        $call_back = route('store.payment.cinetpay', [$store->slug]) . '?_token=' . csrf_token();
        $returnURL = route('store.payment.cinetpay.return', [$store->slug]) . '?_token=' . csrf_token();

        $transaction_id = strtoupper(str_replace('.', '', uniqid('', true)));

        $data = [
            "amount" => (int) $cartlist_final_price,
            "currency" => 'XOF',
            "apikey" => $cinet_pay_api_key,
            "site_id" => $merchant_id,
            "transaction_id" => $transaction_id,
            "description" => "Api PHP",
            "return_url" => $returnURL,
            "notify_url" => $call_back,
            "metadata" => "REF-" . time(),
            'customer_surname' => $other_info['lastname'],
            'customer_name' => $other_info['firstname'],
            'customer_email' => $other_info['email'],
            'customer_phone_number' => $request->mobile_number,
            'customer_address' => null,
            'customer_city' => null,
            'customer_country' => null,
            'customer_state' => null,
            'customer_zip_code' => null,
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-checkout.cinetpay.com/v2/payment',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 45,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                    "content-type:application/json"
                ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $response = json_decode($response);

        if (isset($response->code) && $response->code == '201') {
            $payment_link = $response->data->payment_url; // Retrieving the payment URL
            //Recording information in the database
            //Then redirect to the payment page
            return redirect($payment_link);
        } else {
            return redirect()->back()->with('error', $response->description ?? 'Something went wrong.');
        }
    }

    public function processSenagePay($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id);

        $orderID = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }

        $requests_data = $request->all();
        $price = $requests_data['cartlist_final_price'];
        $user = [
            'name' => $requests_data['billing_info']['firstname'],
            'email' => $requests_data['billing_info']['email'],
            'contact_number' => $requests_data['billing_info']['billing_user_telephone'],
        ];

        try {
            $transactionId = uniqid();

            $senangPaySession = [
                'slug' => $slug
            ];
            $request->session()->put('senangPaySession', $senangPaySession);

            $request = [
                'full_name' => $user['name'],
                'email' => $user['email'],
                'contact_number' => $user['contact_number']
            ];
            $senangPay = new Senangpay();
            $senangPay->setSendPaymentDetails($request, $user['name'], $orderID, $price, $theme_id);

            return redirect($senangPay->processPayment());

        } catch (\Exception $e) {
            \Log::debug($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function processCyberSource($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id);

        $orderID = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }

        $requests_data = $request->all();

        $callback_url = 'store.get.cybersource.status';

        $price = $requests_data['cartlist_final_price'];

        $user = [
            'name' => $requests_data['billing_info']['firstname'],
            'email' => $requests_data['billing_info']['email'],
            'contact_number' => $requests_data['billing_info']['billing_user_telephone'],
        ];
        $data = [
            'slug' => $slug,
            'amount' => $price,
            'theme_id' => $theme_id,
            'user' => $user
        ];
        $data = json_encode($data);

        $name = $requests_data['billing_info']['firstname'];
        try {
            return view('plans.cybersourcerequest', compact('callback_url', 'price', 'data', 'name'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    public function processOzow($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;

        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);
        // $currency = 'ZAR';
        $orderID = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }

        try {
            $siteCode = \App\Models\Utility::GetValueByName('ozow_pay_Site_key', $theme_id) ? \App\Models\Utility::GetValueByName('ozow_pay_Site_key', $theme_id) : '';
            $privateKey = \App\Models\Utility::GetValueByName('ozow_pay_private_key', $theme_id) ? \App\Models\Utility::GetValueByName('ozow_pay_private_key', $theme_id) : '';
            $apiKey = \App\Models\Utility::GetValueByName('ozow_pay_api_key', $theme_id) ? \App\Models\Utility::GetValueByName('ozow_pay_api_key', $theme_id) : '';
            $isTest = \App\Models\Utility::GetValueByName('ozow_mode', $theme_id) == 'sandbox' ? 'true' : 'false';

            $countryCode = "ZA";
            $currencyCode = $currency;
            $amount = $cartlist_final_price;
            $bankReference = time() . 'FKU';
            $transactionReference = time();


            if ($currencyCode != 'ZAR') {
                return redirect()->back()->with('error', __('currency not supported'));
            }

            $cancelUrl = route('store.get.ozow.status');

            $errorUrl = route('store.get.ozow.status');

            $successUrl = route('store.get.ozow.status');

            $notifyUrl = route('store.get.ozow.status');

            // Calculate the hash with the exact same data being sent
            $inputString = $siteCode . $countryCode . $currencyCode . $amount . $transactionReference . $bankReference . $cancelUrl . $errorUrl . $successUrl . $notifyUrl . $isTest . $privateKey;
            $hashCheck = \App\Http\Controllers\OzowController::generate_request_hash_check($inputString);

            $data = [
                "countryCode" => $countryCode,
                "amount" => $amount,
                "transactionReference" => $transactionReference,
                "bankReference" => $bankReference,
                "cancelUrl" => $cancelUrl,
                "currencyCode" => $currencyCode,
                "errorUrl" => $errorUrl,
                "isTest" => $isTest, // boolean value here is okay
                "notifyUrl" => $notifyUrl,
                "siteCode" => $siteCode,
                "successUrl" => $successUrl,
                "hashCheck" => $hashCheck,
            ];

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.ozow.com/postpaymentrequest',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                        'Accept: application/json',
                        'ApiKey: ' . $apiKey,
                        'Content-Type: application/json'
                    ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $json_attendance = json_decode($response, true);
            if (isset($json_attendance['url']) && $json_attendance['url'] != null) {
                $OzowPaySession = [
                    'slug' => $slug
                ];
                $request->session()->put('OzowPaySession', $OzowPaySession);
                return redirect()->away($json_attendance['url']);

            } else {
                return redirect()->back()->with('error', $response['message'] ?? 'Something went wrong.');
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    public function processEasebuzz($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id);
        $easebuzz_merchant_key = \App\Models\Utility::GetValueByName('easebuzz_merchant_key', $theme_id);
        $easebuzz_salt_key = \App\Models\Utility::GetValueByName('easebuzz_salt_key', $theme_id);
        $easebuzz_enviroment_name = \App\Models\Utility::GetValueByName('easebuzz_enviroment_name', $theme_id);

        $orderID = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));

        if (is_array($request)) {
            // Convert the array to an Illuminate\Http\Request object
            $request = Request::create('/', 'POST', $request);
        }
        $requests_data = $request->except('attachment','payment_receipt');
        // $requests_data = $request->all();
        // $request->session()->put('easebuzz_request_data', $requests_data);
        // session(['easebuzz_request_data' => $requests_data]);
        Session::put('easebuzz_request_data', $requests_data);
        Session::save();
        $serialized_request_data = urlencode(json_encode($request->all()));
        $call_back = route('store.payment.easebuzz', ['storeSlug' => $slug]) . '?_token=' . csrf_token() . '&request_data=' . $serialized_request_data;

        // $call_back = route('store.payment.easebuzz', ['storeSlug' => $slug]) . '?_token=' . csrf_token();
        $returnURL = route('checkout', $store->slug);

        $transaction_id = strtoupper(str_replace('.', '', uniqid('', true)));
        $easebuzzObj = new Easebuzz($easebuzz_merchant_key, $easebuzz_salt_key, $easebuzz_enviroment_name);
        $price = number_format((float) $cartlist_final_price, 2, '.', '');
        $postData = array(
            "txnid" => $transaction_id,
            "amount" => $price,
            "firstname" => $other_info['firstname'] ?? 'Test',
            "email" => $other_info['email'] ?? 'test@example.com',
            "phone" => '7878787878',
            "productinfo" => 'Test',
            "surl" => $call_back,
            "furl" => $returnURL,
            "udf1" => "aaaa",
            "udf2" => "aaaa",
            "udf3" => "aaaa",
            "udf4" => "aaaa",
            "udf5" => "aaaa",
            "address1" => "aaaa",
            "address2" => "aaaa",
            "city" => "aaaa",
            "state" => "aaaa",
            "country" => "aaaa",
            "zipcode" => "123123"
        );
        $easebuzzObj->initiatePaymentAPI($postData);
        if ($easebuzzObj) {
            return redirect()->back()->with('error', __('Something went wrong.'));
        }
    }

    public function getNMIProductview($request, $slug, $response)
    {
        $requestData = $request->except('attachment','payment_receipt');
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $currentTheme = $store->theme_id;
        $languages = Utility::languages();
        $currantLang = \Cookie::get('LANGUAGE') ?? $store->default_language;
        Session::put('request_data', $requestData);
        return view('front_end.payment.nmi-payment', compact('request', 'slug', 'response', 'currentTheme', 'currantLang'));
    }

    public function processPayU($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        $merchant_key = \App\Models\Utility::GetValueByName('payu_merchant_key', $theme_id, $store->id);
        $salt_key = \App\Models\Utility::GetValueByName('payu_salt_key', $theme_id, $store->id);
        $payu_mode = \App\Models\Utility::GetValueByName('payu_mode', $theme_id, $store->id);

        $orderID = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;
        $pay_id = $orderID . '777';

        $txnid = $orderID;

        if (is_array($request)) {
            $request = Request::create('/', 'POST', $request);
        }

        $requestData = $request->except('attachment','payment_receipt');

        \Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
        $furl = route('store.payu.status', ['data' => Crypt::encrypt(['status' => 'false', 'order_id' => $orderID])]);
        $surl = route('store.payu.status', ['data' => Crypt::encrypt(['status' => 'true', 'order_id' => $orderID])]);
        $session = ['slug' => $slug];
        $request->session()->put('\'' . $orderID . '\'', $session);
        $pay = [
            'key' => $merchant_key,
            'mode' => $payu_mode,
            'salt' => $salt_key,
            'txnid' => $txnid,
            'amount' => $cartlist_final_price,
            'firstname' => $other_info['firstname'],
            'email' => $other_info['email'],
            'surl' => $surl,
            'furl' => $furl,
            'productinfo' => 'WorkDo',
            'service_provider' => 'payu_paisa',
        ];

        // Session::put('\'' . $orderID . '\'', $pay);
        $request->session()->put('\'' . $pay_id . '\'', $pay);
        return redirect()->to(route('payu.pay', ['pay' => Crypt::encrypt($pay_id)]));
    }

    private function processSofort($request, $slug, $response)
    {
        $theme_id = $request['theme_id'];
        $slug = $request['slug'];
        $store = Store::where('slug', $request['slug'])->first();
        $sofort_secret_key = \App\Models\Utility::GetValueByName('sofort_secret_key', $store->theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $store->theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $store->theme_id, $store->id);

        $orderID = $request['customer_id'] . date('YmdHis');
        $cartlist_final_price = $request['cartlist_final_price'];
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($CURRENCY, '', $cartlist_final_price)));
        if ($totalprice > 0.0) {
            $l_name = $theme_id;
            $stripe_formatted_price = in_array(
                $CURRENCY_NAME,
                [
                    'MGA',
                    'BIF',
                    'CLP',
                    'PYG',
                    'DJF',
                    'RWF',
                    'GNF',
                    'UGX',
                    'JPY',
                    'VND',
                    'VUV',
                    'XAF',
                    'KMF',
                    'KRW',
                    'XOF',
                    'XPF',
                ]
            ) ? number_format($totalprice, 2, '.', '') : number_format($totalprice, 2, '.', '') * 100;

            $return_url_parameters = function ($return_type) {
                return '&return_type=' . $return_type . '&payment_processor=stripe';
            };

            Stripe\Stripe::setApiKey($sofort_secret_key);

            $data = StripeSession::create([
                'payment_method_types' => ['sofort'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $CURRENCY_NAME,
                            'product_data' => [
                                'name' => $store->name,
                            ],
                            'unit_amount' => (int) $stripe_formatted_price,
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route(
                    'store.payment.stripe',
                    [
                        $slug,
                        $return_url_parameters('success'),
                    ]
                ),
                'cancel_url' => route(
                    'store.payment.stripe',
                    [
                        $slug,
                    ]
                ),
            ]);
            if (is_array($request)) {
                // Convert the array to an Illuminate\Http\Request object
                $request = Request::create('/', 'POST', $request);
            }
            $requestData = $request->except('attachment','payment_receipt');
            Session::put('request_data', $requestData);
            if (module_is_active('CheckoutAttachment')) {
                \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
            }
            $data = $data ?? false;
            try {
                $place_order_data = ($data);
                return $place_order_data->url;
            } catch (\Exception $e) {
                return redirect()->route('checkout', $slug)->with('error', __('Transaction has been failed!'));
            }
        }
        return response()->json(['message' => 'Payment processed using Stripe']);
    }

    private function processESewa($request, $slug, $response)
    {
        $theme_id = $request['theme_id'];
        $slug = $request['slug'];
        $store = Store::where('slug', $request['slug'])->first();
        $esewa_merchant_key = \App\Models\Utility::GetValueByName('esewa_merchant_key', $store->theme_id, $store->id);
        $esewa_mode = \App\Models\Utility::GetValueByName('esewa_mode', $store->theme_id, $store->id);
        $CURRENCY_NAME = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $store->theme_id, $store->id);
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY', $store->theme_id, $store->id);

        $orderID = $request['customer_id'] . date('YmdHis');
        $cartlist_final_price = $request['cartlist_final_price'];
        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($CURRENCY, '', $cartlist_final_price)));

        if ($totalprice > 0.0) {
            config([
                'esewa.scd' => isset($esewa_merchant_key) ? $esewa_merchant_key : '',
                'esewa.env' => ucfirst(isset($esewa_mode) ? $esewa_mode : 'Sandbox'),
            ]);
            $payment = new eSewa();
            $successURL = route('store.payment.stripe', $slug);
            $faildURL = route('esewa.transaction.failure', $slug);
            $pay = $payment->esewaCheckout($cartlist_final_price, 0, 0, 0, $orderID, $successURL, $faildURL);
            $requestData = $request->except('attachment','payment_receipt');
            Session::put('request_data', $requestData);
            if (module_is_active('CheckoutAttachment')) {
                \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
            }
            try {
                return redirect()->away($pay);
            } catch (\Exception $e) {
                return redirect()->route('checkout', $slug)->with('error', __('Transaction has been failed!'));
            }
        }
        return response()->json(['message' => 'Payment processed using Stripe']);
    }

    public function processPaynow($request, $slug, $response)
    {
		$slug = !empty($request->slug) ? $request->slug : '';
		$store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
		$theme_id = $request->theme_id;
		$other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

		$currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);

		$orderID = $request->customer_id . date('YmdHis');

		$cartlist_final_price = $request->cartlist_final_price;

		$totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
		$requestData = $request->except('attachment','payment_receipt');
		Session::put('request_data', $requestData);

		if (module_is_active('CheckoutAttachment')) {
		    \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
		}

		try {
		    $requests_data = $request->all();
		    $user =[
		        'name' => $requests_data['billing_info']['firstname'],
		        'email' => $requests_data['billing_info']['email'],
		        'contact_number' => $requests_data['billing_info']['billing_user_telephone'],
		    ];

		        $integration_id =  \App\Models\Utility::GetValueByName('paynow_pay_integration_id',$theme_id, $store->id) ? \App\Models\Utility::GetValueByName('paynow_pay_integration_id',$theme_id, $store->id) : '';
		        $integration_key = \App\Models\Utility::GetValueByName('paynow_pay_integration_key',$theme_id, $store->id) ? \App\Models\Utility::GetValueByName('paynow_pay_integration_key',$theme_id, $store->id) : '';
		        $merchant_email = \App\Models\Utility::GetValueByName('paynow_pay_merchant_email',$theme_id, $store->id) ? \App\Models\Utility::GetValueByName('paynow_pay_merchant_email',$theme_id, $store->id) : '';
		        $mode = \App\Models\Utility::GetValueByName('paynow_mode',$theme_id, $store->id) && \App\Models\Utility::GetValueByName('paynow_mode',$theme_id, $store->id) == 'sandbox'  ? 'sandbox' : 'production';

		        $data =[
		            'slug'=>$slug,
		            'amount' => $cartlist_final_price,
		            'theme_id' =>  $theme_id,
		            'store_id' =>  $store->id,
		            'order_id' => $orderID,
		            'email' => $user['email'],
		        ];

		        $success_url = route('store.get.Paynow.status',['data'=> $data]);

		        $faild_url = route('store.get.Paynow.status',['data'=> $data]);

		        if($mode == 'sandbox'){
		            $email = $merchant_email;
		        }elseif($mode == 'production'){
		            $email = $user['email'];
		        }

		        $pay=[
		            'integration_id'=>$integration_id,
		            'integration_key'=>$integration_key,
		            'success_url'=>$success_url,
		            'faild_url'=>$faild_url,
		            'email'=>$email,
		            'order_id' => $orderID,
		            'item' => 'Item Order',
		            'amount' => $cartlist_final_price,
		        ];

		        $response= \App\Http\Controllers\PaynowController::paynowPayment($pay);
		        return $response;

		} catch (\Exception $ex) {
		    $exMessage = __('Paynow.' . $ex->getMessage());
		    return redirect()->route('checkout', $slug)->with('error', $ex->getMessage() ?? 'Something went wrong.');
		}
    }

    public function processMyfatoorah($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);

        $orderId = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        $requestData = $request->except('attachment','payment_receipt');
        \Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
        try {
            $allowedCurrencies = ['SAR', 'QAR', 'OMR', 'KWD', 'BHD', 'JOD', 'AED', 'USD'];

            if (!in_array($currency, $allowedCurrencies)) {
                return redirect()->back()->with('error', __('Selected currency is not supported for MyFatoorah payment.'));
            }

            $mfConfig = [
                'apiKey' => \App\Models\Utility::GetValueByName('myfatoorah_pay_api_key', $theme_id, $store->id) ? \App\Models\Utility::GetValueByName('myfatoorah_pay_api_key', $theme_id, $store->id) : '',
                'isTest' => \App\Models\Utility::GetValueByName('myfatoorah_mode', $theme_id, $store->id) == 'sandbox' ? true : false,
                'countryCode' => \App\Models\Utility::GetValueByName('myfatoorah_pay_country_iso', $theme_id, $store->id) ? \App\Models\Utility::GetValueByName('myfatoorah_pay_country_iso', $theme_id, $store->id) : '',
            ];

            //For example: pmid=0 for MyFatoorah invoice or pmid=1 for Knet in test mode
            $paymentId = request('pmid') ?: 0;
            $sessionId = request('sid') ?: null;
            $requests_data = $request->all();
            $callbackURL = route('store.myfatoorah.call_back');

            $curlData = [
                'CustomerName' => $requests_data['billing_info']['firstname'],
                'InvoiceValue' => $request->cartlist_final_price,
                'DisplayCurrencyIso' => $currency,
                'CustomerEmail' => $requests_data['billing_info']['email'],
                'CallBackUrl' => $callbackURL,
                'ErrorUrl' => $callbackURL,
                'MobileCountryCode' => '+965',
                'CustomerMobile' => $requests_data['billing_info']['billing_user_telephone'],
                'Language' => 'en',
                'CustomerReference' => $orderId,
                'SourceInfo' => 'Laravel ' . app()::VERSION . ' - MyFatoorah Package ' . MYFATOORAH_LARAVEL_PACKAGE_VERSION
            ];

            $mfObj = new \MyFatoorah\Library\API\Payment\MyFatoorahPayment($mfConfig);
            $payment = $mfObj->getInvoiceURL($curlData, $paymentId, $orderId, $sessionId);

            $MyFatoorahSession = [
                'slug' => $slug,
                'theme_id' => $theme_id,
                'store_id' => $store->id,
            ];
            $request->session()->put('MyFatoorahSession', $MyFatoorahSession);

            return redirect($payment['invoiceURL']);
        } catch (\Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            return redirect()->back()->with('error', $ex->getMessage() ?? 'Something went wrong.');
        }
    }

    public function processDPO($request, $slug, $response)
    {
        $slug = ! empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);

        $orderId = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);

        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }

        try {
            $currentTheme = $store->theme_id;
            $currantLang = \Cookie::get('LANGUAGE') ?? $store->default_language;
            $requests_data = $request->all();
            $user = [
                'name' => $requests_data['billing_info']['firstname'],
                'email' => $requests_data['billing_info']['email'],
                'contact_number' => $requests_data['billing_info']['billing_user_telephone'],
            ];

            return redirect()->route('store.dpo.view', [
                'slug' => $slug,
                'theme_id' => $theme_id,
                'store_id' => $store->id,
                'total_price' => $totalprice,
                'user' => $user,
                'action' => route('store.pay.with.dpo')
            ]);
        } catch (\Exception $ex) {
            $exMessage = __('DPO.' . $ex->getMessage());

            return redirect()->route('checkout', $slug)->with('error', $ex->getMessage() ?? 'Something went wrong.');
        }
    }

    public function processBraintree($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);

        $orderId = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);

        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }

        try {
            $BraintreeSession = [
                'amount' => $cartlist_final_price,
                'slug' => $slug,
                'theme_id' => $theme_id,
                'store_id' => $store->id,
            ];
            $request->session()->put('\'' . $orderId . '\'', $BraintreeSession);

            $config = new \Braintree\Configuration([
                'environment' => \App\Models\Utility::GetValueByName('braintree_mode', $theme_id, $store->id) ?? 'sandbox',
                'merchantId' => \App\Models\Utility::GetValueByName('braintree_pay_merchant_id', $theme_id, $store->id) ?? '',
                'publicKey' => \App\Models\Utility::GetValueByName('braintree_pay_public_key', $theme_id, $store->id) ?? '',
                'privateKey' => \App\Models\Utility::GetValueByName('braintree_pay_private_key', $theme_id, $store->id) ?? '',
            ]);
            $gateway = new \Braintree\Gateway($config);
            $clientToken = $gateway->clientToken()->generate();

            if (!empty($clientToken)) {
                $url = route('store.braintree.pay', [
                    'token' => $clientToken,
                    'orderID' => $orderId,
                    'action' => route('store.braintree.status'),
                    'return_url' => route('checkout', $slug),
                    'user' => ' ',
                    'amount' => $currency . ' ' . $cartlist_final_price,
                ]);
                return redirect()->away($url);
            } else {
                return redirect()->route('checkout', $slug)->with('error', __('Transaction failed'));
            }
        } catch (\Exception $ex) {
            $exMessage = __('braintree.' . $ex->getMessage());
            return redirect()->route('checkout', $slug)->with('error', $ex->getMessage() ?? 'Something went wrong.');
        }
    }

    public function processPowerTranz($request, $slug, $response)
    {
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                return Store::where('slug',$slug)->first();
            });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;

        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);

        $orderId = $request->customer_id . date('YmdHis');

        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);

        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }

        try {
            $currentTheme = $store->theme_id;
            $currantLang = \Cookie::get('LANGUAGE') ?? $store->default_language;
            $requests_data = $request->all();
            $user = [
                'name' => $requests_data['billing_info']['firstname'],
                'email' => $requests_data['billing_info']['email'],
                'contact_number' => $requests_data['billing_info']['billing_user_telephone'],
            ];

            return redirect()->route('store.Powertranz.view', [
                'slug' => $slug,
                'amount' => $cartlist_final_price,
                'theme_id' => $theme_id,
                'store_id' => $store->id,
                'currantLang' => $currantLang,
                'currentTheme' => $currentTheme,
                'user' => $user
            ]);
        } catch (\Exception $ex) {
            $exMessage = __('Powertranz.' . $ex->getMessage());
            return redirect()->route('checkout', $slug)->with('error', $ex->getMessage() ?? 'Something went wrong.');
        }
    }
    public function processSSLCommerz($request, $slug, $response)
    {
        $payment_setting        = getSuperAdminAllSetting();
        $slug = !empty($request->slug) ? $request->slug : '';
        $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
            return Store::where('slug', $slug)->first();
        });
        $theme_id = $request->theme_id;
        $other_info = is_string($request->billing_info) ? (array) json_decode($request->billing_info) : $request->billing_info;
        $currency = \App\Models\Utility::GetValueByName('CURRENCY_NAME', $theme_id, $store->id);

        $orderId = $request->customer_id . date('YmdHis');
        $cartlist_final_price = $request->cartlist_final_price;

        $totalprice = str_replace(' ', '', str_replace(',', '', str_replace($currency, '', $cartlist_final_price)));
        $requestData = $request->except('attachment','payment_receipt');
        Session::put('request_data', $requestData);
        if (module_is_active('CheckoutAttachment')) {
            \Workdo\CheckoutAttachment\app\Models\CheckoutAttachment::CheckoutAttachmentStore($slug, $request);
        }
        $user = \Auth::user();
        
        $sslcommerz_pay_store_id = $payment_setting['sslcommerz_pay_store_id'];
        $sslcommerz_pay_secret_key = $payment_setting['sslcommerz_pay_secret_key'];

        $sslcommerz_data = [
            "store_id"      => $sslcommerz_pay_store_id,
            "store_passwd"  => $sslcommerz_pay_secret_key,
            "total_amount"  => $totalprice,
            "currency"      => $currency,
            "tran_id"       => $orderId,
            "success_url"   => route('store.payment.sslcommerz', [
                'storeSlug' => $slug,
                'order_id' => $orderId,
                'amount' => $totalprice,
                'success' => 1
            ]),
            "fail_url"      => route('checkout', [
                'storeSlug' => $slug,
            ]),
            "cancel_url"    => route('checkout', [
                'storeSlug' => $slug,
            ]),
            "cus_name"          => $other_info['firstname'],
            "cus_email"         => $other_info['email'],
            "cus_add1"          => $other_info['billing_address'],
            "cus_city"          => '',
            "cus_country"       => '',
            "cus_phone"         => $other_info['billing_user_telephone'],
            "product_profile"   => 'product_purchase',
            "product_name"      => $request->product_name ?? 'Product',
            "product_category"  => 'General',
            "ship_name"         => $user->last_name ?? 'User',
            'ship_add1'         => 'Dhaka',
            'ship_city'         => 'Dhaka',
            'ship_postcode'     => '1000',
            'ship_country'      => 'Bangladesh',
            'shipping_method'   => 'yes'
        ];

        try {
            $url = $payment_setting['sslcommerz_mode'] == 'sandbox' ? 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php' : 'https://securepay.sslcommerz.com/validator/api/validationserverAPI.php';

            $client = new Client();
            $response = $client->post($url, [
                'form_params' => $sslcommerz_data,
                'timeout' => 30,
                'connect_timeout' => 30,
                'verify' => false,
            ]);
            $body = $response->getBody();
            $sslcz = json_decode($body, true);
            if (isset($sslcz['status']) && $sslcz['status'] === "SUCCESS") {
                return redirect()->to($sslcz['GatewayPageURL']);
            } else {
                return redirect()->route('checkout', $slug)->with('error', __('Transaction has been failed.'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->route('checkout', $slug)->with('error', __('Something went wrong, Please try again.'));
        }
    } 
}
