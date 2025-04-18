<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\User;
use App\Models\{Plan, PlanOrder};
use Illuminate\Support\Facades\Auth;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Page;
use App\Models\AppSetting;
use App\Models\Blog;
use App\Models\Order;
use App\Models\Tax;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\Newsletter;
use App\Models\Testimonial;
use App\Models\Setting;
use App\Models\Shipping;
use App\Models\ProductVariant;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Lab404\Impersonate\Impersonate;
use Session;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cache;
use App\DataTables\StoreDataTable;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user() && auth()->user()->type == 'super admin') {
            $users = User::select(
                [
                    'users.*',
                ]
            )->join('stores', 'stores.created_by', '=', 'users.id')->where('users.created_by', \Auth::user()->creatorId())->where('users.type', '=', 'admin')->groupBy('users.id')->paginate(7);

            return view('store.index', compact('users'));
        } else {
            return redirect()->back()->with('error', __('Something went wrong'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user() && auth()->user()->type == 'admin') {
            $themes = ['grocery'];
            $plan = Plan::find(auth()->user()->plan_id);
            if (!empty($plan->themes)) {
                $themes = explode(',', $plan->themes);
            }
            return view('store.create', compact('themes', 'plan'));
        } elseif (auth()->user() && auth()->user()->type == 'super admin') {
            $setting = getSuperAdminAllSetting();

            return view('store.create', compact('setting'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function userCreate()
    {
        if (auth()->user() && auth()->user()->type == 'super admin') {
            $setting = getSuperAdminAllSetting();

            return view('store.user-create', compact('setting'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (auth()->user() && auth()->user()->type == 'admin') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'storename' => 'required',
                ]
            );
        } else {
            $validator = \Validator::make(
                $request->all(),
                [
                    'storename' => 'required',
                    'name' => 'required',
                    'email' => 'required|unique:users,email',
                    'password' => 'required',
                ]
            );
        }

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        if (auth()->user() && auth()->user()->type == 'admin') {
            $user = auth()->user();
            $total_store = $user->countStore();

            $plan = Cache::remember('plan_details_'.$user->id, 3600, function () use ($user) {
                return Plan::find($user->plan_id);
            });
            if ($total_store < $plan->max_stores || $plan->max_stores == -1)
            {
                $slug = User::slugs($request->storename);

                $store = Store::create([
                    'name' => $request->storename,
                    'email' => $user->email,
                    'theme_id' => $request->theme_id ?? $user->theme_id,
                    'slug' => $slug,
                    'default_language' => $user->default_language ?? 'en',
                    'created_by' => $user->id,
                ]);

                // create Default Setting
                defaultSetting($user->theme_id, $store->id, 'admin', $user);
                themeDefaultSection($store->theme_id, $store->id);
                return redirect()->back()->with('success', 'Store successfully created.');
            } else {
                return redirect()->back()->with('error', __('Your Store limit is over, Please upgrade plan'));
            }
        }
        else
        {
            if(auth()->user() && auth()->user()->type == 'super admin')
            {
                $superAdmin = Cache::remember('super_admin_details', 3600, function () {
                    return User::where('type','super admin')->first();
                });

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'profile_image' => 'uploads/profile/avatar.png',
                    'type' => 'admin',
                    'email_verified_at' => date("Y-m-d H:i:s"),
                    'password' => Hash::make($request->password),
                    'mobile' => '7878787878',
                    'register_type' => 'email',
                    'language' => $superAdmin->default_language ?? 'en',
                    'default_language' => $superAdmin->default_language ?? 'en',
                    'plan_id' => '1',
                    // 'plan' => Plan::first()->id,
                    'created_by' => 1,
                    'theme_id' => $request->theme_id ?? 'grocery',

                ]);
                $slug = User::slugs($request->storename);

                $store = Store::create([
                    'name' => $request->storename,
                    'email' => $request->email,
                    'theme_id' => $user->theme_id,
                    'slug' => $slug,
                    'default_language' => $user->default_language,
                    'created_by' => $user->id,
                ]);
                $user->current_store = $store->id;
                $user->save();
                $user->assignPlan(1);
                // create Default Setting
                defaultSetting($user->theme_id, $store->id, 'admin', $user);
                themeDefaultSection($store->theme_id, $store->id);
                Utility::userDefaultData($user->id);
                $role_r = Role::where('name', 'admin')->first();
                $user->addRole($role_r);
                $setting = getSuperAdminAllSetting();
                if ($setting['email_verification'] == "on") {
                    $user->email_verified_at = null;
                    $user->save();
                    config(
                        [
                            'mail.driver' => $setting['MAIL_DRIVER'] ?? '',
                            'mail.host' => $setting['MAIL_HOST'] ?? '',
                            'mail.port' => $setting['MAIL_PORT'] ?? '',
                            'mail.encryption' => $setting['MAIL_ENCRYPTION'] ?? '',
                            'mail.username' => $setting['MAIL_USERNAME'] ?? '',
                            'mail.password' => $setting['MAIL_PASSWORD'] ?? '',
                            'mail.from.address' => $setting['MAIL_FROM_ADDRESS'] ?? '',
                            'mail.from.name' => $setting['MAIL_FROM_NAME'] ?? '',
                        ]
                    );
                    try {

                        event(new Registered($user));

                    } catch (\Exception $e) {
                    }
                }
                return redirect()->back()->with('success', 'User successfully created.');
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (auth()->user() && auth()->user()->type == 'super admin') {
            $user = User::find($id);
            $store = Store::where('created_by', $user->id)->first();
            $setting = getSuperAdminAllSetting();

            return view('store.edit', compact('store', 'user', 'setting'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        if (auth()->user() && auth()->user()->type == 'super admin') {
            $store = Store::find($id);
            $user = User::find($store->created_by);

            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:120',
                    'storename' => 'required|max:120',
                    'email' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $slug = User::slugs($request->storename);

            $store->name = $request->storename;
            $store->slug = $slug;
            $store->email = $request->email;
            $store->update();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->update();

            return redirect()->back()->with('success', __('User Successfully Updated!'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        if (auth()->user() && auth()->user()->type == 'super admin') {
            $user = User::find($id);
            Setting::where('created_by', $user->id)->delete();
            $user->delete();
            return redirect()->back()->with('success', __('Store Successfully Deleted!'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function pwaSetting(Request $request, $id)
    {
        session()->put(['setting_tab' => 'pwa_setting']);
        //$company_favicon = Utility::getValByName('company_favicon');
        $store = Store::find($id);
        $favicon = \App\Models\Utility::GetValueByName('favicon', APP_THEME(), getCurrentStore());
        $theme_name = APP_THEME();
        // $favicon = \App\Models\Utility::GetValueByName('theme_favicon', $store->theme_id ?? APP_THEME(), $store->id ?? getCurrentStore());
        // $theme_name = $store->theme_id ?? APP_THEME();
        $favicon = get_file($favicon, $theme_name);
        $store['enable_pwa_store'] = $request->pwa_store ?? 'off';
        if ($request->pwa_store == 'on') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'pwa_app_title' => 'required|max:100',
                    'pwa_app_name' => 'required|max:50',
                    'pwa_app_background_color' => 'required|max:15',
                    'pwa_app_theme_color' => 'required|max:15',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $enable_storelink = Utility::GetValueByName('enable_storelink', $store->theme_id, $store->id);
            $enable_domain = Utility::GetValueByName('enable_domain', $store->theme_id, $store->id);
            $enable_subdomain = Utility::GetValueByName('enable_subdomain', $store->theme_id, $store->id);
            $domains = Utility::GetValueByName('domains', $store->theme_id, $store->id);
            $subdomain = Utility::GetValueByName('subdomain', $store->theme_id, $store->id);

            if ($enable_domain == 'on') {
                $start_url = 'https://' . $domains;
            } elseif ($enable_subdomain == 'on') {
                $start_url = 'https://' . $subdomain;
            } elseif ($enable_storelink) {
                $start_url = route('landing_page', $store->slug);
            } else {
                $start_url = route('landing_page', $store->slug);
            }

            list($width, $height) = getimagesize($favicon);
            $mainfest =
                '{
                    "lang": "' . $store['lang'] . '",
                    "name": "' . $request->pwa_app_title . '",
                    "short_name": "' . $request->pwa_app_name . '",
                    "start_url": "' . $start_url.'",
                    "display": "standalone",
                    "background_color": "' . $request->pwa_app_background_color . '",
                    "theme_color": "' . $request->pwa_app_theme_color . '",
                    "orientation": "portrait",
                    "categories": [
                        "shopping"
                    ],
                    "icons": [
                        {
                            "src": "' . $favicon . '",
                            "sizes": "128x128",
                            "type": "image/png",
                            "purpose": "any"
                        },
                        {
                            "src": "' . $favicon . '",
                            "sizes": "144x144",
                            "type": "image/png",
                            "purpose": "any"
                        },
                        {
                            "src": "' . $favicon . '",
                            "sizes": "152x152",
                            "type": "image/png",
                            "purpose": "any"
                        },
                        {
                            "src": "' . $favicon . '",
                            "sizes": "192x192",
                            "type": "image/png",
                            "purpose": "any"
                        },
                        {
                            "src": "' . $favicon . '",
                            "sizes": "256x256",
                            "type": "image/png",
                            "purpose": "any"
                        },
                        {
                            "src": "' . $favicon . '",
                            "sizes": "512x512",
                            "type": "image/png",
                            "purpose": "any"
                        },
                        {
                            "src": "' . $favicon . '",
                            "sizes": "1024x1024",
                            "type": "image/png",
                            "purpose": "any"
                        },
                        {
                            "src": "' . $favicon . '",
                            "sizes": "' . ($width ?? 30) . 'x' . ($height ?? 30) . '",
                            "type": "image/png",
                            "purpose": "any"
                        }
                    ]
                }';
            if (!file_exists('storage/uploads/customer_app/store_' . $id)) {
                mkdir(storage_path('uploads/customer_app/store_' . $id), 0777, true);
            }
            if (!file_exists('storage/uploads/customer_app/store_' . $id . '/manifest.json')) {
                fopen('storage/uploads/customer_app/store_' . $id . "/manifest.json", "w");
            }
            \File::put('storage/uploads/customer_app/store_' . $id . '/manifest.json', $mainfest);
        }
        $store->update();
        return redirect()->back()->with('success', __('PWA setting successfully Update.'));
    }

    public function changeStore($id)
    {
        $store = Store::find($id);
        if ($store && $store->is_active = 1) {
            $user = auth()->user();
            $user->current_store = $id;
            $user->theme_id = $store->theme_id;
            $user->update();

            return redirect()->back()->with('success', __('Store Change Successfully!'));
        } else {
            return redirect()->back()->with('error', __('Store is locked'));
        }
    }

    public function storeResetPassword($id)
    {
        $eId = \Crypt::decrypt($id);
        $user = User::find($eId);

        return view('store.reset', compact('user'));
    }

    public function storeResetPasswordUpdate(Request $request, $id)
    {

        $validator = \Validator::make(
            $request->all(),
            [
                'password' => 'required|confirmed|same:password_confirmation',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $user = User::find($id);

        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        return redirect()->back()->with('success', 'User Password successfully updated.');
    }

    public function ownerstoredestroy($id)
    {

        $user = auth()->user();
        $store = Store::find($id);
        $user_stores = Store::where('created_by', $user->id)->count();

        if ($user_stores > 1) {
            Page::where('store_id', $store->id)->delete();
            Order::where('store_id', $store->id)->delete();
            AppSetting::where('store_id', $store->id)->delete();
            Blog::where('store_id', $store->id)->delete();
            Contact::where('store_id', $store->id)->delete();
            Coupon::where('store_id', $store->id)->delete();
            MainCategory::where('store_id', $store->id)->delete();
            Newsletter::where('store_id', $store->id)->delete();
            PlanOrder::where('store_id', $store->id)->delete();
            Testimonial::where('store_id', $store->id)->delete();
            Setting::where('store_id', $store->id)->delete();
            Shipping::where('store_id', $store->id)->delete();
            SubCategory::where('store_id', $store->id)->delete();
            Tax::where('store_id', $store->id)->delete();
            ProductVariant::where('store_id', $store->id)->delete();
            // Wishlist::where('store_id', $store->id)->delete();

            DB::table('shetabit_visits')->where('store_id', $store->id)->delete();

            $products = Product::where('store_id', $store->id)->get();
            $pro_img = new ProductController();
            foreach ($products as $pro) {
                $pro_img->destroy($pro);
            }
            // Product::where('store_id', $store->id)->delete();

            $store->delete();
            $userstore = Store::where('created_by', $user->id)->first();

            $user->current_store = $userstore->id;
            $user->save();

            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error', __('You have only one store'));
        }
    }

    public function LoginWithAdmin(Request $request, $id)
    {
        $user = User::find($id);
        if ($user && auth()->check()) {
            Impersonate::take($request->user(), $user);
            return redirect('dashboard');
        }
    }

    public function ExitAdmin(Request $request)
    {
        Auth::user()->leaveImpersonation($request->user());
        //return redirect('dashboard');
        return redirect('stores');
    }

    public function StoreLinks(Request $request, $id)
    {
        $user = User::find($id);
        $stores = Store::where('created_by', $user->id)->get();

        return view('store.view-storelinks', compact('stores'));
    }

    public function upgradePlan($user_id)
    {
        if (auth()->user()->type == 'super admin') {
            $user = User::find($user_id);
            $plans = Plan::get();

            return view('store.plan', compact('user', 'plans'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function activePlan($user_id, $plan_id)
    {
        if (auth()->user()->type == 'super admin') {

            $plan = Plan::find($plan_id);
            if ($plan->is_disable == 0) {
                return redirect()->back()->with('error', __('You are unable to upgrade this plan because it is disabled.'));
            }

            $user = User::find($user_id);
            $assignPlan = $user->assignPlan($plan->id);
            if ($assignPlan['is_success'] == true && !empty($plan)) {
                $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                PlanOrder::create(
                    [
                        'order_id' => $orderID,
                        'name' => null,
                        'card_number' => null,
                        'card_exp_month' => null,
                        'card_exp_year' => null,
                        'plan_name' => $plan->name,
                        'plan_id' => $plan->id,
                        'price' => $plan->price,
                        'price_currency' => Utility::GetValueByName('CURRENCY_NAME'),
                        'txn_id' => '',
                        'payment_type' => __('Manually'),
                        'payment_status' => 'succeeded',
                        'receipt' => null,
                        'user_id' => $user->id,
                        'store_id' => getCurrentStore(),
                    ]
                );

                return redirect()->back()->with('success', __('Plan successfully upgraded.'));
            } else {
                return redirect()->back()->with('error', __('Plan fail to upgrade.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function customDomain()
    {
        if (auth()->user() && auth()->user()->type == 'super admin') {
            $serverName = str_replace(
                [
                    'http://',
                    'https://',
                ],
                '',
                env('APP_URL')
            );
            $serverIp = gethostbyname($serverName);

            if ($serverIp == $_SERVER['SERVER_ADDR']) {
                $serverIp;
            } else {
                $serverIp = request()->server('SERVER_ADDR');
            }
            $users = User::where('created_by', '=', auth()->user()->creatorId())->where('type', '=', 'admin')->get();
            $stores = Store::select('stores.*', 'settings.value as domains')->join('settings', 'settings.store_id', '=', 'stores.id')->where('settings.name', 'domains')->get();

            return view('store.custom_domain', compact('users', 'stores', 'serverIp'));
        } else {
            return redirect()->back()->with('error', __('permission Denied'));
        }
    }

    public function subDomain()
    {
        if (auth()->user() && auth()->user()->type == 'super admin') {
            $serverName = str_replace(
                [
                    'http://',
                    'https://',
                ],
                '',
                env('APP_URL')
            );
            $serverIp = gethostbyname($serverName);

            if ($serverIp != $serverName) {
                $serverIp;
            } else {
                $serverIp = request()->server('SERVER_ADDR');
            }
            $users = User::where('created_by', '=', auth()->user()->creatorId())->where('type', '=', 'admin')->get();
            $stores = Store::select('stores.*', 'settings.value as subdomain')->join('settings', 'settings.store_id', '=', 'stores.id')->where('settings.name', 'subdomain')->get();

            return view('store.subdomain', compact('users', 'stores', 'serverIp'));
        } else {
            return redirect()->back()->with('error', __('permission Denied'));
        }

    }

    public function changeStatus(Request $request)
    {
        $store = Store::find($request->id);
        $adminId = $store->created_by;
        $activeStoresCount = Store::where('is_active', 1)->where('created_by', $adminId)->count();

        if ($activeStoresCount == 1 && $request->status == 0) {
            $return['status'] = 'error';
            $return['message'] = __('You cannot deactivate this store as it is the last active store.');
            return response()->json($return);
        }
     
        if ($store) {
            $store->is_active = $request->status;
            $store->save();
            $return['status'] = 'success';
            $return['message'] = __('Status change successfully.');
            return response()->json($return);
        } else {
            $return['status'] = 'error';
            $return['message'] = __('Something went wrong!!');
            return response()->json($return);
        }
    }

    public function list(Request $request, StoreDataTable $dataTable)
    {
        if (auth()->user() && auth()->user()->type == 'super admin') {
            return $dataTable->render('store.list');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
