<?php

namespace Workdo\LandingPage\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\LandingPage\Entities\LandingPageSetting;

class ScreenshotsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(\Auth::user()->type == 'super admin'){

            $settings = LandingPageSetting::settings();
            $screenshots = json_decode($settings['screenshots'], true) ?? [];


            return view('landing-page::landingpage.screenshots.index',compact('settings','screenshots'));
        }else{
            return redirect()->back()->with('error', __('Permission Denied.'));

        }

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('landing-page::landingpage.screenshots.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data['screenshots_status']= 'on';
        $data['screenshots_heading']= $request->screenshots_heading;
        $data['screenshots_description']= $request->screenshots_description;

        foreach($data as $key => $value){
            LandingPageSetting::updateOrCreate(['name' =>  $key],['value' => $value]);
        }

        return redirect()->back()->with(['success'=> __('Setting update successfully')]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('landing-page::landingpage.screenshots.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('landing-page::landingpage.screenshots.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }






    public function screenshots_create(){
        $settings = LandingPageSetting::settings();
        return view('landing-page::landingpage.screenshots.create');
    }



    public function screenshots_store(Request $request){

        $settings = LandingPageSetting::settings();
        $data = json_decode($settings['screenshots'], true);

        if( $request->screenshots){
            $screenshots = time()."-screenshots." . $request->screenshots->getClientOriginalExtension();
            $dir        = 'uploads/landing_page_image/';
            $path = LandingPageSetting::upload_file($request,'screenshots',$screenshots,$dir,[]);
            if($path['flag']==0){
                return redirect()->back()->with('error', __($path['msg']));
            }
            $datas['screenshots'] = $path['url'] ?? $screenshots;
        }

        $datas['screenshots_heading']= $request->screenshots_heading;

        $data[] = $datas;
        $data = json_encode($data);
        LandingPageSetting::updateOrCreate(['name' =>  'screenshots'],['value' => $data]);

        return redirect()->back()->with(['success'=> __('screenshots add successfully')]);
    }



    public function screenshots_edit($key){
        $settings = LandingPageSetting::settings();
        $screenshots = json_decode($settings['screenshots'], true);
        $screenshot = $screenshots[$key];
        return view('landing-page::landingpage.screenshots.edit', compact('screenshot','key'));
    }



    public function screenshots_update(Request $request, $key){

        $settings = LandingPageSetting::settings();
        $data = json_decode($settings['screenshots'], true);

        if( $request->screenshots){
            $screenshots = time()."-screenshots." . $request->screenshots->getClientOriginalExtension();
            $dir        = 'uploads/landing_page_image/';
            $path = LandingPageSetting::upload_file($request,'screenshots',$screenshots,$dir,[]);
            if($path['flag']==0){
                return redirect()->back()->with('error', __($path['msg']));
            }
            $data[$key]['screenshots'] = $path['url'] ?? $screenshots;
        }

        $data[$key]['screenshots_heading'] = $request->screenshots_heading;


        $data = json_encode($data);
        LandingPageSetting::updateOrCreate(['name' =>  'screenshots'],['value' => $data]);

        return redirect()->back()->with(['success'=> __('screenshots update successfully')]);
    }



    public function screenshots_delete($key){
        $settings = LandingPageSetting::settings();
        $pages = json_decode($settings['screenshots'], true);
        unset($pages[$key]);
        LandingPageSetting::updateOrCreate(['name' =>  'screenshots'],['value' => $pages]);

        return redirect()->back()->with(['success'=> __('Screenshots delete successfully')]);
    }


}
