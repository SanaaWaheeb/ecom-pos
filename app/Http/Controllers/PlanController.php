<?php

namespace App\Http\Controllers;

use App\Models\{Addon, Plan, PlanCoupon, User, userActiveModule};
use App\Models\PlanOrder;
use App\Models\Utility;
use Illuminate\Http\Request;
use App\Facades\ModuleFacade as Module;
use App\DataTables\PlanOrderDataTable;
use Illuminate\Support\Facades\Artisan;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PlanOrderDataTable $dataTable)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Manage Plan')) {
            $setting = getSuperAdminAllSetting();
            if (auth()->user()->type == 'super admin') {
                $plans = Plan::get();
            } else {                
                $plans = Plan::where('is_disable', 1)->get();
            }
            return  $dataTable->render('plans.index', compact('plans','setting'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user() && auth()->user()->isAbleTo('Create Plan')) {
            $arrDuration = Plan::$arrDuration;
            $theme = Addon::where('status','1')->get();
            $modules = Module::all();
            $modules = array_filter($modules, function($key) {
                return $key !== 'BackupRestore';
            }, ARRAY_FILTER_USE_KEY);

            $setting = getSuperAdminAllSetting();
            return view('plans.create', compact('arrDuration','theme','setting', 'modules'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Create Plan'))
        {
            $validation = [];
            $validation['name'] = 'required|unique:plans';
            $validation['price'] = 'required|numeric|min:0';
            $validation['max_stores'] = 'required|numeric';
            $validation['max_products'] = 'required|numeric';
            $validation['max_users'] = 'required|numeric';
            $validation['storage_limit'] = 'required|numeric';
            $request->validate($validation);

            $post = $request->all();
            if(isset($request->trial))
            {
                $post['trial'] = 1;
            }
            if($request->has('themes')){
                $post['themes'] = implode(',',$request->themes);
            }

            if($request->has('modules')){
                $post['modules'] = implode(',',$request->modules);
            }

            if (Plan::create($post)) {
                return redirect()->route('plan.index')->with('success', __('Plan created Successfully!'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Edit Plan'))
        {
            $arrDuration = Plan::$arrDuration;
            $theme = Addon::where('status','1')->get();
            $modules = Module::all();
            $setting = getSuperAdminAllSetting();
            return view('plans.edit',compact('plan','arrDuration', 'theme', 'setting', 'modules'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {

        if (auth()->user() && auth()->user()->isAbleTo('Edit Plan'))
        {
            // if (\Auth::user()->type == 'super admin' || (isset($admin_payments_setting['is_stripe_enabled']) && $admin_payments_setting['is_stripe_enabled'] == 'on'))
            // {
                if ($plan) {
                    if ($plan->price > 0) {
                        $validator = \Validator::make(
                            $request->all(), [
                                'name' => 'required|unique:plans,name,' . $plan->id,
                                'price' => 'numeric|min:0',
                                'max_stores' => 'required|numeric',
                                'max_products' => 'required|numeric',
                                'max_users' => 'required|numeric',
                                'storage_limit' => 'required|numeric',
                            ]
                        );
                    } else {
                        $validator = \Validator::make(
                            $request->all(), [
                                'name' => 'required|unique:plans,name,' . $plan->id,
                                'max_stores' => 'required|numeric',
                                'max_products' => 'required|numeric',
                                'max_users' => 'required|numeric',
                                'image' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc|max:20480',
                            ]
                        );
                    }
                    {

                    }
                    if ($validator->fails()) {
                        $messages = $validator->getMessageBag();

                        return redirect()->back()->with('error', $messages->first());
                    }

                    $post = $request->all();

                    if (!isset($request->enable_domain)) {
                        $post['enable_domain'] = 'off';
                    }
                    if (!isset($request->enable_subdomain)) {
                        $post['enable_subdomain'] = 'off';
                    }
                    if (!isset($request->enable_chatgpt)) {
                        $post['enable_chatgpt'] = 'off';
                    }
                    if (!isset($request->pwa_store)) {
                        $post['pwa_store'] = 'off';
                    }

                    if (!isset($request->shipping_method)) {
                        $post['shipping_method'] = 'off';
                    }

                    if (!isset($request->enable_tax)) {
                        $post['enable_tax'] = 'off';
                    }
                    if(isset($request->trial))
                    {
                        $post['trial'] = 1;
                        $post['trial_days'] = $request->trial_days;
                    }
                    else
                    {
                        $post['trial'] = 0;
                        $post['trial_days'] = null;
                    }

                    if($request->has('themes')){
                        $post['themes'] = implode(',',$request->themes);
                    }
                    if($request->has('modules')){
                        $post['modules'] = implode(',', $request->modules);
                        $user_ids = User::where('plan_id', $plan->id)->pluck('id')->toArray();
                        userActiveModule::whereIn('user_id', $user_ids)->delete();
                        foreach ($user_ids as $user_id) {
                            foreach ($request->modules as $module) {
                                userActiveModule::create([
                                    'user_id' => $user_id,
                                    'module' => $module,
                                ]);
                            }
                        }
                    }else {
                        $post['modules'] = null;
                        $user_ids = User::where('plan_id', $plan->id)->pluck('id')->toArray();
                        userActiveModule::whereIn('user_id', $user_ids)->delete();
                    }

                    if(!$request->has('modules')){
                        $user_ids = User::where('plan_id', $plan->id)->pluck('id')->toArray();
                        userActiveModule::whereIn('user_id', $user_ids)->delete();
                    }

                    if ($plan->update($post)) {
                        Artisan::call('cache:clear');
                        return redirect()->back()->with('success', __('Plan updated Successfully!'));
                    } else {
                        return redirect()->back()->with('error', __('Something is wrong'));
                    }
                } else {
                    return redirect()->back()->with('error', __('Plan not found'));
                }
            // } else {
            //     return redirect()->back()->with('error', __('Please set atleast one payment api key & secret key for add new plan'));
            // }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $userPlan = User::where('plan_id' , $id)->first();
        if($userPlan != null)
        {
            return redirect()->back()->with('error',__('The company has subscribed to this plan, so it cannot be deleted.'));
        }
        $plan = Plan::find($id);
        if($plan->id == $id)
        {
            $plan->delete();

            return redirect()->back()->with('success' , __('Plan deleted successfully'));
        }
        else
        {
            return redirect()->back()->with('error',__('Something went wrong'));
        }
    }


    public function planPrepareAmount(Request $request)
    {

        $plan = Plan::find(\Illuminate\Support\Facades\Crypt::decrypt($request->plan_id));

        if ($plan) {
            $original_price = number_format($plan->price);
            $coupons = PlanCoupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
            $coupon_id = null;
            if (!empty($coupons)) {
                $usedCoupun = $coupons->used_coupon();
                if ($coupons->limit == $usedCoupun) {
                } else {
                    $discount_value = ($plan->price / 100) * $coupons->discount;
                    $plan_price = $plan->price - $discount_value;
                    $price = $plan->price - $discount_value;
                    $discount_value = '-' . $discount_value;
                    $coupon_id = $coupons->id;
                    return response()->json(
                        [
                            'is_success' => true,
                            'discount_price' => $discount_value,
                            'final_price' => $price,
                            'price' => $plan_price,
                            'coupon_id' => $coupon_id,
                            'message' => __('Coupon code has applied successfully.'),
                        ]
                    );
                }
            } else {
                return response()->json(
                    [
                        'is_success' => true,
                        'final_price' => $original_price,
                        'coupon_id' => $coupon_id,
                        'price' => $plan->price,
                    ]
                );
            }
        }
    }

    public function planDisable(Request $request)
    {
        $userPlan = User::where('plan_id' , $request->id)->first();
        if($userPlan != null && $request->id != 1 && $request->is_disable == 0)
        {
            return response()->json(['error' =>__('The company has subscribed to this plan, so it cannot be disabled.')]);
        }

        Plan::where('id', $request->id)->update(['is_disable' => $request->is_disable]);

        if ($request->is_disable == 1) {
            return response()->json(['success' => __('Plan successfully unable.')]);

        } else {
            return response()->json(['success' => __('Plan successfully disable.')]);
        }
    }

    public function planTrial(Request $request , $plan)
    {
        $objUser = \Auth::user();
        $planID  = \Illuminate\Support\Facades\Crypt::decrypt($plan);
        $plan    = Plan::find($planID);

        if($plan)
        {
            if($plan->price > 0)
            {
                $user = User::find($objUser->id);
                $user->trial_plan = $planID;
                $currentDate = date('Y-m-d');
                $numberOfDaysToAdd = $plan->trial_days;

                $newDate = date('Y-m-d', strtotime($currentDate . ' + ' . $numberOfDaysToAdd . ' days'));
                $user->trial_expire_date = $newDate;
                $user->save();

                $objUser->assignPlan($planID);

                return redirect()->route('plan.index')->with('success', __('Free trial plan successfully activated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Plan not found.'));
        }
    }

    public function refund(Request $request , $id , $user_id)
    {
        PlanOrder::where('id', $request->id)->update(['is_refund' => 1]);

        $user = User::find($user_id);

        $assignPlan = $user->assignPlan(1);

        return redirect()->back()->with('success' , __('We successfully planned a refund and assigned a free plan.'));
    }

}
