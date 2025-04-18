<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Themes\{ThemeSection, ThemeArticelBlogSection, ThemeArticelBlogSectionDraft, ThemeTopProductSection, ThemeTopProductSectionDraft,  ThemeBestProductSection, ThemeBestProductSectionDraft, ThemeModernProductSection, ThemeModernProductSectionDraft, ThemeBestProductSecondSection, ThemeBestProductSecondSectionDraft, ThemeBestSellingSection, ThemeBestSellingSectionDraft, ThemeLogoSliderSection, ThemeLogoSliderSectionDraft, ThemeBestsellerSliderSection, ThemeBestsellerSliderSectionDraft, ThemeHeaderSection, ThemeSliderSection, ThemeCategorySection, ThemeReviewSection, ThemeSectionDraft, ThemeHeaderSectionDraft, ThemeSliderSectionDraft, ThemeCategorySectionDraft, ThemeReviewSectionDraft, ThemeSectionMap, ThemeBlogSection, ThemeBlogSectionDraft, ThemeDiscountSection, ThemeDiscountSectionDraft, ThemeProductCategorySection, ThemeProductCategorySectionDraft, ThemeFooterSection, ThemeFooterSectionDraft, ThemeProductSection, ThemeProductSectionDraft, ThemeSubscribeSection, ThemeSubscribeSectionDraft, ThemeVariantBackgroundSection, ThemeVariantBackgroundSectionDraft, ThemeProductBannerSliderSection, ThemeProductBannerSliderSectionDraft, ThemeNewestCateorySectionDraft, ThemeNewestCateorySection, ThemeServiceSection, ThemeServiceSectionDraft, ThemeVideoSection, ThemeVideoSectionDraft, ThemeNewestProductSection, ThemeNewestProductSectionDraft};
use App\Models\{ProductAttributeOption, Testimonial};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Utility;
use App\Models\AppSetting;
use App\Models\Store;
use App\Models\Product;
use App\Models\Review;
use App\Models\Page;
use App\Models\Menu;
use App\Models\MainCategory;
use Storage;
use Illuminate\Support\Facades\View;
use Qirolab\Theme\Theme;
use App\Models\Addon;
use Illuminate\Support\Facades\Cache;

class ThemeSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user() && auth()->user()->isAbleTo('Manage Themes')) {
            $user = auth()->user();
            $plan = Cache::remember('plan_details_' . $user->id, 3600, function () use ($user) {
                return Plan::find($user->plan_id);
            });
            $addons = Addon::where('status', '1')->pluck('theme_id')->toArray();
            if (!empty($plan->themes)) {
                $themes =  explode(',', $plan->themes);
            } else {
                $themes = ['grocery', 'babycare'];
            }

            if ((APP_THEME() ?? $user->theme_id)) {
               array_unshift($themes, (APP_THEME() ?? $user->theme_id));
            } 
            $themes = array_unique($themes);
            $currentTheme = Theme::active();
            return view('theme_preview.index', compact('themes', 'currentTheme', 'addons'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (isset($request->theme_id)) {
            $currentTheme = $request->theme_id;
        } else {
            $currentTheme = Theme::active();
        }

        Theme::set($currentTheme);
        // Determine if the theme is published
        $mapping = ThemeSectionMap::where('theme_id', $currentTheme)
            ->where('store_id', getCurrentStore())
            ->first();

        $store = Cache::remember('store_' . getCurrentStore(), 3600, function () {
            return Store::where('id', getCurrentStore())->first();
        });
        $storeSlug = $store->slug;
        themeDefaultSection($currentTheme, $store->id);
        $is_publish = $mapping && $mapping->is_publish == 1;
        $data = getThemeSections($currentTheme, $storeSlug, $is_publish, false);

        // Get Data from database
        $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);

        return view('theme_preview.customize', $sqlData + $data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function saveThemeLayout(Request $request)
    {

        $options = $request->all();
        $sectionDraftQuery = ThemeSectionDraft::query();
        foreach ($options['array'] as $key => $item) {
            if (!isset($item['id'])) {
                continue;
            }
            if (isset($item['section']) && isset($item['store'])) {
                $exist = (clone $sectionDraftQuery)->where('store_id', $item['store'])->where('theme_id', $item['theme'])->where('section_name', $item['section'])->first();
                if ($exist) {
                    $exist->update(['order' => $item['order'], 'is_hide' => $item['is_hide']]);
                } else {
                    $lastSection = (clone $sectionDraftQuery)->where('store_id', $item['store'])->where('theme_id', $item['theme'])->orderBy('order', 'DESC')->first();
                    if ($lastSection) {
                        (clone $sectionDraftQuery)->create([
                            'section_name' => $item['section'],
                            'store_id' => $item['store'],
                            'theme_id' => $item['theme'],
                            'order' => $lastSection->order + 1,
                            'is_hide' => $item['is_hide'],
                        ]);
                    } else {
                        (clone $sectionDraftQuery)->create([
                            'section_name' => $item['section'],
                            'store_id' => $item['store'],
                            'theme_id' => $item['theme'],
                            'order' => 0,
                            'is_hide' => $item['is_hide'],
                        ]);
                    }
                }
            }
        }
        return response()->json(["msg"=>__("Theme saved successfully"),"data"=> "success", "is_publish" => 0]);
    }


    public function publishTheme(Request $request)
    {

        $mapping = ThemeSectionMap::where('theme_id', $request['theme_id'])->where('store_id', $request['store_id'])->first();
        $store = Cache::remember('store_' . getCurrentStore(), 3600, function () {
            return Store::where('id', getCurrentStore())->first();
        });
        $storeSlug = $store->slug;
        if ($mapping) {
            $mapping->is_publish = 1;
            $mapping->save();

            $this->updateOrCreateThemeSection(ThemeHeaderSectionDraft::class, ThemeHeaderSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeSliderSectionDraft::class, ThemeSliderSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeCategorySectionDraft::class, ThemeCategorySection::class, $request);

            $this->updateOrCreateThemeSection(ThemeReviewSectionDraft::class, ThemeReviewSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeBestProductSectionDraft::class, ThemeBestProductSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeBestProductSecondSectionDraft::class, ThemeBestProductSecondSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeBlogSectionDraft::class, ThemeBlogSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeSubscribeSectionDraft::class, ThemeSubscribeSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeVariantBackgroundSectionDraft::class, ThemeVariantBackgroundSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeProductCategorySectionDraft::class, ThemeProductCategorySection::class, $request);

            $this->updateOrCreateThemeSection(ThemeProductSectionDraft::class, ThemeProductSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeBestsellerSliderSectionDraft::class, ThemeBestsellerSliderSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeLogoSliderSectionDraft::class, ThemeLogoSliderSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeFooterSectionDraft::class, ThemeFooterSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeProductBannerSliderSectionDraft::class, ThemeProductBannerSliderSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeNewestCateorySectionDraft::class, ThemeNewestCateorySection::class, $request);

            $this->updateOrCreateThemeSection(ThemeBestSellingSectionDraft::class, ThemeBestSellingSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeModernProductSectionDraft::class, ThemeModernProductSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeArticelBlogSectionDraft::class, ThemeArticelBlogSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeTopProductSectionDraft::class, ThemeTopProductSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeServiceSectionDraft::class, ThemeServiceSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeVideoSectionDraft::class, ThemeVideoSection::class, $request);

            $this->updateOrCreateThemeSection(ThemeNewestProductSectionDraft::class, ThemeNewestProductSection::class, $request);

            // Create or Update Section Orders
            $this->updateOrCreateThemeSectionOrder($request);
        }

        //$data = getThemeSections($request['theme_id'], $storeSlug, true, false);
        // Get Data from database
        //$sqlData = getHomePageDatabaseSectionDataFromDatabase($data);
       // Theme::set($request['theme_id']);
        // Render the HTML view
        $html = null;//View::make('main_file', $data + $sqlData)->render();
        // Return JSON response
        return response()->json([
            "msg" => __("Theme published successfully"),
            "data" => ['content' => $html],
            "is_publish" => true,
            "token" => csrf_token()
        ]);
    }

    private function updateOrCreateThemeSection($draftSectionClass, $publishedSectionClass, $request)
    {
        $sectionDraft = $draftSectionClass::where('theme_id', $request['theme_id'])->where('store_id', $request['store_id'])->first();
        if ($sectionDraft) {
            $publishedSectionClass::updateOrCreate(
                ['theme_id' => $sectionDraft->theme_id, 'section_name' => $sectionDraft->section_name, 'store_id' => $sectionDraft->store_id],
                ['theme_id' => $sectionDraft->theme_id, 'section_name' => $sectionDraft->section_name, 'store_id' => $sectionDraft->store_id, 'theme_json' => is_array($sectionDraft->theme_json) ? json_encode($sectionDraft->theme_json) : (is_object($sectionDraft->theme_json) ? json_encode($sectionDraft->theme_json) : $sectionDraft->theme_json)]
            );
            // Remove theme Draft records
            $sectionDraft->delete();
        }
    }

    private function updateOrCreateThemeSectionOrder($request)
    {
        $sectionOrders = ThemeSectionDraft::where('theme_id', $request['theme_id'])->where('store_id', $request['store_id'])->get();
        $themeSectionQuery = ThemeSection::query();
        foreach ($sectionOrders as $sectionOrder) {
            $exist = (clone $themeSectionQuery)->where('theme_id', $request['theme_id'])->where('store_id', $request['store_id'])->where('section_name', $sectionOrder->section_name)->first();
            if ($exist) {
                if ($exist->order != $sectionOrder->order) {
                    $exist->update(['order' => $sectionOrder->order, 'is_hide' => $sectionOrder->is_hide]);
                } elseif ($exist->order == $sectionOrder->order) {
                    $exist->update(['is_hide' => $sectionOrder->is_hide]);
                }
            } else {
                (clone $themeSectionQuery)->create([
                    'section_name' => $sectionOrder->section_name,
                    'store_id' => $sectionOrder->store_id,
                    'theme_id' => $sectionOrder->theme_id,
                    'order' => $sectionOrder->order,
                    'is_hide' => $sectionOrder->is_hide,
                ]);
            }
        }
    }

    public function sidebarOption(Request $request)
    {
        try {
            $currentTheme = $request->theme_id;
            // Retrieve theme section map
            $mapping = ThemeSectionMap::where('theme_id', $request->theme_id)
                ->where('store_id', $request->store_id)
                ->first();
            // Check if mapping exists and is published
            $is_publish = ($mapping && $mapping->is_publish == 1) ? true : false;
    
            // Initialize json data from the specified section or use default
            if (isset($request->section_name)) {
                $sectionName = $request->section_name;
            } else {
                $sectionName = 'header';
            }

            // Get Published or draft json file from database or root directory
            $data = getThemeMainOrDraftSectionJson($is_publish, $currentTheme, $sectionName, $request->store_id);
            // Get Data from database
            $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);
            // Render the HTML view
            $html = View::make('theme_preview.section_form', $data + $sqlData)->render();

            // Return JSON response
            return response()->json([
                "msg" => __("Theme saved successfully"),
                "data" => ['content' => $html],
                "is_publish" => $is_publish ?? false,
                "token" => csrf_token()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "msg" => __("Theme saved successfully"),
                "data" => ['content' => null],
                "is_publish" => false,
                "token" => csrf_token()
            ]);
        }
    }

    public function pageSetting(Request $request)
    {

        $theme_id = $request->theme_id ?? APP_THEME();
        Theme::set($theme_id);
        $page_name = $request->section_name;
        $dir        = 'themes/'.$theme_id.'/uploads';
        if(empty($page_name)) {
            return response()->json(["error"=>__('Page name not found.'),"data"=> __('Page name not found.')]);
        }

        $array = $request->array;

        // Upload slider background image
        if (isset($array['section']['background_image']['text']) && gettype($array['section']['background_image']['text']) == 'object') {
            $theme_name = $theme_id;
            $theme_image = $array['section']['background_image']['text'];
            $upload = $this->uploadThemeMedia($request, $theme_id, $theme_image, $dir);
            if (!$upload['error']) {
                $array['section']['background_image']['text'] = $upload['data']['image_path'];
                $array['section']['background_image']['image'] = $upload['data']['image_path'];
            } else {
                return response()->json(["error" => __("Something went wrong"), "data" => [__("Something went wrong")]]);
            }
        }

        if (isset($array['section']['background_image_second']['text']) && gettype($array['section']['background_image_second']['text']) == 'object') {
            $theme_name = $theme_id;
            $theme_image = $array['section']['background_image_second']['text'];
            $upload = $this->uploadThemeMedia($request, $theme_id, $theme_image, $dir);
            if (!$upload['error']) {
                $array['section']['background_image_second']['text'] = $upload['data']['image_path'];
                $array['section']['background_image_second']['image'] = $upload['data']['image_path'];
            } else {
                return response()->json(["error" => __("Something went wrong"), "data" => [__("Something went wrong")]]);
            }
        }

        if (isset($array['section']['service_image']['text']) && gettype($array['section']['service_image']['text']) == 'object') {
            $theme_name = $theme_id;
            $theme_image = $array['section']['service_image']['text'];
            $upload = $this->uploadThemeMedia($request, $theme_id, $theme_image, $dir);
            if (!$upload['error']) {
                $array['section']['service_image']['text'] = $upload['data']['image_path'];
                $array['section']['service_image']['image'] = $upload['data']['image_path'];
            } else {
                return response()->json(["error" => __("Something went wrong"), "data" => [__("Something went wrong")]]);
            }
        }

        if (isset($array['section']['service_second_title']['text']) && gettype($array['section']['service_second_title']['text']) == 'object') {
            $theme_name = $theme_id;
            $theme_image = $array['section']['service_second_title']['text'];
            $upload = $this->uploadThemeMedia($request, $theme_id, $theme_image, $dir);
            if (!$upload['error']) {
                $array['section']['service_second_title']['text'] = $upload['data']['image_path'];
                $array['section']['service_second_title']['image'] = $upload['data']['image_path'];
            } else {
                return response()->json(["error" => __("Something went wrong"), "data" => [__("Something went wrong")]]);
            }
        }

        // Upload section inside image
        if (isset($array['section']['image']['text']) && !is_array($array['section']['image']['text']) && gettype($array['section']['image']['text']) == 'object') {
            $theme_image = $array['section']['image']['text'];
            $upload = $this->uploadThemeMedia($request, $theme_id, $theme_image, $dir);
            if (!$upload['error']) {
                $array['section']['image']['text'] = $upload['data']['image_path'];
                $array['section']['image']['image'] = $upload['data']['image_path'];
            } else {
                return response()->json(["error" => __("Something went wrong"), "data" => [__("Something went wrong")]]);
            }
        }

        if (isset($array['section']['image_right']['text']) && !is_array($array['section']['image_right']['text']) && gettype($array['section']['image_right']['text']) == 'object') {
            $theme_image = $array['section']['image_right']['text'];
            $upload = $this->uploadThemeMedia($request, $theme_id, $theme_image, $dir);
            if (!$upload['error']) {
                $array['section']['image_right']['text'] = $upload['data']['image_path'];
                $array['section']['image_right']['image'] = $upload['data']['image_path'];
            } else {
                return response()->json(["error" => __("Something went wrong"), "data" => [__("Something went wrong")]]);
            }
        }

        if (isset($array['section']['image_left']['text']) && !is_array($array['section']['image_left']['text']) && gettype($array['section']['image_left']['text']) == 'object') {
            $theme_image = $array['section']['image_left']['text'];
            $upload = $this->uploadThemeMedia($request, $theme_id, $theme_image, $dir);
            if (!$upload['error']) {
                $array['section']['image_left']['text'] = $upload['data']['image_path'];
                $array['section']['image_left']['image'] = $upload['data']['image_path'];
            } else {
                return response()->json(["error" => __("Something went wrong"), "data" => [__("Something went wrong")]]);
            }
        }

        if (isset($array['section']['image']['text']) && is_array($array['section']['image']['text']) && count($array['section']['image']['text']) > 0) {
            $k = 0;
            foreach ($array['section']['image']['text'] as $keys => $theme_image) {
                if (gettype($theme_image) == 'object') {
                    $upload = $this->uploadThemeMedia($request, $theme_id, $theme_image, $dir);
                    if (!$upload['error']) {
                        $array['section']['image']['text'][$k] = $upload['data']['image_path'];
                        $array['section']['image']['image'][$keys] = $upload['data']['image_path'];
                        $k++;
                    } else {
                        return response()->json(["error" => __("Something went wrong"), "data" => [__("Something went wrong")]]);
                    }
                } else {
                    $array['section']['image']['text'][$keys] = $theme_image;
                    $array['section']['image']['image'][$keys] = $theme_image;
                }
            }
        } elseif (isset($array['section']['image']['text']) && is_array($array['section']['image']['text']) && count($array['section']['image']['text'] == 0)) {
            $array['section']['image']['image']  = json_decode($array['section']['image']['image']);
        }


        // Upload footer social image
        if (isset($array['section']['footer_link']['social_icon']) && count($array['section']['footer_link']['social_icon']) > 0) {
            $social_icons = $array['section']['footer_link']['social_icon'];
            $socialImages = [];
            foreach ($social_icons as $key => $value) {
                if (isset($value['text']) && gettype($value['text']) == 'object') {
                    $theme_image = $value['text'];
                    $upload = $this->uploadThemeMedia($request, $theme_id, $theme_image, $dir);
                    if (!$upload['error']) {
                        $socialImages[$key]['text'] = $upload['data']['image_path'];
                        $socialImages[$key]['image'] = $upload['data']['image_path'];
                    } else {
                        return response()->json(["error" => "Something went wrong", "data" => ["Something went wrong"]]);
                    }
                } else {
                    $socialImages[$key]['text'] = $value['text'] ?? ($value['image'] ?? null);
                    $socialImages[$key]['image'] = $value['image'];
                }
            }
            $array['section']['footer_link']['social_icon'] = $socialImages;
        }

        // Upload Video
        if (isset($array['section']['video']['type']) && $array['section']['video']['type'] == 'file' && isset($array['section']['video']['text']) && gettype($array['section']['video']['text']) == 'object') {
            
            $theme_name = $theme_id;
            $theme_image = $array['section']['video']['text'];
            $upload = $this->uploadThemeMedia($request, $theme_id, $theme_image, $dir);
            if (!$upload['error']) {
                $array['section']['video']['text'] = $upload['data']['image_path'];
                $array['section']['video']['image'] = $upload['data']['image_path'];
            } else {
                return response()->json(["error"=>__("Something went wrong"),"data"=> [__("Something went wrong")]]);
            }
        }

        // Define a mapping between page names and model classes
        $pageNameToModel = [
            'header' => ThemeHeaderSectionDraft::class,
            'slider' => ThemeSliderSectionDraft::class,
            'review' => ThemeReviewSectionDraft::class,
            'bestseller_slider' => ThemeBestsellerSliderSectionDraft::class,
            'best_product' => ThemeBestProductSectionDraft::class,
            'best_product_second' => ThemeBestProductSecondSectionDraft::class,
            'blog' => ThemeBlogSectionDraft::class,
            'category' => ThemeCategorySectionDraft::class,
            'subscribe' => ThemeSubscribeSectionDraft::class,
            'variant_background' => ThemeVariantBackgroundSectionDraft::class,
            'product_category' => ThemeProductCategorySectionDraft::class,
            'modern_product' => ThemeModernProductSectionDraft::class,
            'product' => ThemeProductSectionDraft::class,
            'footer' => ThemeFooterSectionDraft::class,
            'logo_slider' => ThemeLogoSliderSectionDraft::class,
            'newest_category' => ThemeNewestCateorySectionDraft::class,
            'best_selling_slider' => ThemeBestSellingSectionDraft::class,
            'product_banner_slider' => ThemeProductBannerSliderSectionDraft::class,
            'top_product' => ThemeTopProductSectionDraft::class,
            'articel_blog' =>  ThemeArticelBlogSectionDraft::class,
            'service_section' => ThemeServiceSectionDraft::class,
            'video' => ThemeVideoSectionDraft::class,
            'newest_product' => ThemeNewestProductSectionDraft::class
        ];
        // Check if the page name exists in the mapping
        if (array_key_exists($page_name, $pageNameToModel)) {
            $modelClass = $pageNameToModel[$page_name];
            // Use the dynamic model class
            $modelClass::updateOrCreate(
                ['theme_id' => $theme_id, 'section_name' => $page_name, 'store_id' => getCurrentStore()],
                ['theme_id' => $theme_id, 'section_name' => $page_name, 'store_id' => getCurrentStore(), 'theme_json' => json_encode($array)]
            );
        }

        // Update or create the ThemeSectionMap
        ThemeSectionMap::updateOrCreate(
            ['theme_id' => $theme_id, 'store_id' => getCurrentStore()],
            ['theme_id' => $theme_id, 'store_id' => getCurrentStore(), 'is_publish' => 0]
        );

        $store = Cache::remember('store_' . getCurrentStore(), 3600, function () {
            return Store::where('id', getCurrentStore())->first();
        });
        $storeSlug = $store->slug;
        //$data = getThemeSections($theme_id,$storeSlug, false, false);
        // Get Data from database
       // $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);
        // Render the HTML view
        $html = null;
        // Return JSON response
        return response()->json([
            "msg" => __("Theme saved successfully"),
            "data" => ['content' => $html],
            "is_publish" => false,
            "token" => csrf_token()
        ]);
    }

    private function uploadThemeMedia($request, $theme_id, $theme_image, $dir)
    {

        $image_size = File::size($theme_image);
        $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
        if ($result == 1) {
            $fileName = rand(10, 100) . '_' . time() . "_" . $theme_image->getClientOriginalName();
            $upload = Utility::upload_file($request, $theme_image, $fileName, $dir, [], $theme_image);
            if ($upload['flag'] == '0') {
                $msg['flag'] = 'error';
                $msg['msg'] = $upload['msg'];

                return $msg;
            }
            
            $img_path = '';
            return ["error" => false, "data" => $upload];
        } else {
            return ["error" => true, "data" => []];
        }
    }


    public function landingPageSetting(Request $request)
    {
        return view('landing_page');
    }

    public function makeActiveTheme(Request $request)
    {

        if (isset($request->theme_id)) {
            auth()->user()->update(['theme_id' => $request->theme_id]);
            themeDefaultSection($request->theme_id, getCurrentStore());
            Store::where('id', getCurrentStore())->update(['theme_id' => $request->theme_id]);
        }
        return redirect()->back()->with('success', __('Theme active set successfully'));
    }

    public function page($slug, $page_slug)
    {
        if ($page_slug) {
            $page   = Page::where('page_slug', $page_slug)->where('page_status', 1)->first();
            if ($page) {

                $store = Cache::remember('store_' . $slug, 3600, function () use ($slug) {
                    return Store::where('slug', $slug)->first();
                });
                if (!$store) {
                    abort(404);
                }
                $slug = $store->slug;
                $currentTheme = $store->theme_id;
                $currantLang = \Cookie::get('LANGUAGE') ?? ($store->default_language ?? 'en');
                $data = getThemeSections($currentTheme, $slug, true);
                // Get Data from database
                $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);
                $section = (object) $data['section'];
                $topNavItems = [];
                $menu_id = [];
                if (isset($section->header) && isset($section->header->section) && isset($section->header->section->menu_type) && isset($section->header->section->menu_type->menu_ids)) {
                    $menu_id = (array) $section->header->section->menu_type->menu_ids;
                }
                $topNavItems = get_nav_menu($menu_id);
                $currency = Utility::GetValueByName('CURRENCY_NAME', $store->theme_id, $store->id);
                $languages = Utility::languages();
                return view('front_end.sections.pages.page', compact('page', 'currentTheme', 'currantLang', 'store', 'section', 'topNavItems', 'slug', 'currency', 'languages') + $data + $sqlData);
            } else {
                abort(404);
            }
        }
    }

    public function themeCustomize(Request $request, $theme_id = null)
    {
        if (isset($request->theme_id)) {
            $currentTheme = $request->theme_id;
        } elseif (!empty($theme_id)) {
            $currentTheme = $theme_id;
        } else {
            $currentTheme = Theme::active();
        }

        Theme::set($currentTheme);
        // Determine if the theme is published
        $mapping = ThemeSectionMap::where('theme_id', $currentTheme)
            ->where('store_id', getCurrentStore())
            ->first();

        $store = Cache::remember('store_' . getCurrentStore(), 3600, function () {
            return Store::where('id', getCurrentStore())->first();
        });
        $storeSlug = $store->slug;
        themeDefaultSection($currentTheme, $store->id);
        $is_publish = $mapping && $mapping->is_publish == 1;
        $data = getThemeSections($currentTheme, $storeSlug, $is_publish, false);

        // Get Data from database
        $sqlData = getHomePageDatabaseSectionDataFromDatabase($data);

        $loader_show = 'no';
        return view('main_file', compact('loader_show') + $sqlData + $data);
    }
}
