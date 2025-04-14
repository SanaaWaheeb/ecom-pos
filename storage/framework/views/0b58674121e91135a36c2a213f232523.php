<?php
    $settings = \Workdo\LandingPage\Entities\LandingPageSetting::settings();
    $logo = get_file('storage/uploads/landing_page_image', 'grocery');

    $sup_logo = get_file('storage/uploads/logo', 'grocery');
    $superadmin = \App\Models\User::where('type', 'super admin')->first();
    $setting = getSuperAdminAllSetting();
    $SITE_RTL = $setting['SITE_RTL'] ?? 'off';

    // $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

    if (!isset($setting['color'])) {
        $color = 'theme-3';
    } elseif (isset($setting['color_flag']) && $setting['color_flag'] == 'true') {
        $color = 'custom-color';
    } else {
        if (
            !in_array($setting['color'], [
                'theme-1',
                'theme-2',
                'theme-3',
                'theme-4',
                'theme-5',
                'theme-6',
                'theme-7',
                'theme-8',
                'theme-9',
                'theme-10',
            ])
        ) {
            $color = 'custom-color' ?? 'theme-3';
        } else {
            $color = $setting['color'] ?? 'theme-3';
        }
    }
    $menusettings = \Workdo\LandingPage\Entities\OwnerMenuSetting::where('created_by', $superadmin->id)->first();

    if (isset($menusettings) && $menusettings->menus_id) {
        $topNavItems = \Workdo\LandingPage\Entities\OwnerMenuSetting::get_ownernav_menu($menusettings->menus_id);
    }
?>
<!DOCTYPE html>
<html lang="en" dir="<?php echo e(isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on' ? 'rtl' : ''); ?>">

<head>
    <title>
        <?php echo e(\App\Models\Utility::GetValueByName('title_text', APP_THEME(), 1) ? \App\Models\Utility::GetValueByName('title_text', APP_THEME(), 1) : (env('APP_NAME') ?? 'Ecommercego saas')); ?>

    </title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="WorkDo.io" />
    <meta name="base-url" content="<?php echo e(URL::to('/')); ?>">

    <meta name="title" content="<?php echo e(isset($settings['metatitle']) ? $settings['metatitle'] : 'EcommerceGo'); ?>">
    <meta name="keywords" content="<?php echo e(isset($settings['metakeyword']) ? $settings['metakeyword'] : 'EcommerceGo, Store with Multi theme and Multi Store'); ?>">
    <meta name="description" content="<?php echo e(isset($settings['metadesc']) ? $settings['metadesc'] : 'Discover the efficiency of EcommerceGo, a user-friendly web application by Workdo.io.'); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="og:title" content="<?php echo e(isset($settings['metatitle']) ? $settings['metatitle'] : 'EcommerceGo'); ?>">
    <meta property="og:description" content="<?php echo e(isset($settings['metadesc']) ? $settings['metadesc'] : 'Discover the efficiency of EcommerceGo, a user-friendly web application by Workdo.io.'); ?> ">
    <meta property="og:image" content="<?php echo e(get_file(isset($settings['metaimage']) ? $settings['metaimage'] : 'storage/uploads/ecommercego-saas-preview.png')); ?><?php echo e('?'.time()); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="twitter:title" content="<?php echo e(isset($settings['metatitle']) ? $settings['metatitle'] : 'EcommerceGo'); ?>">
    <meta property="twitter:description" content="<?php echo e(isset($settings['metadesc']) ? $settings['metadesc'] : 'Discover the efficiency of EcommerceGo, a user-friendly web application by Workdo.io.'); ?> ">
    <meta property="twitter:image" content="<?php echo e(get_file(isset($settings['metaimage']) ? $settings['metaimage'] : 'storage/uploads/ecommercego-saas-preview.png')); ?><?php echo e('?'.time()); ?>">

    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo e(get_file($setting['favicon'] . '?timestamp=' . time(), 'grocery')); ?>"
        type="image/x-icon" />

    <!-- font css -->
    <link rel="stylesheet" href="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/fonts/tabler-icons.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/fonts/feather.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/fonts/fontawesome.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/fonts/material.css')); ?>" />

    <!-- vendor css -->
    <link rel="stylesheet" href="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/css/style.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/css/customizer.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/css/landing-page.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/css/custom.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/assets/swiper/dist/css/swiper-bundle.min.css')); ?>" />

    <?php if($SITE_RTL == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/css/style-rtl.css')); ?>" />
    <?php elseif(isset($setting['cust_darklayout']) && $setting['cust_darklayout'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/css/style-dark.css')); ?>" />
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/css/style.css')); ?>"
            id="main-style-link" />
    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo e(url('css/custom-color.css')); ?>" />
    <!-- notification css -->
    <link rel="stylesheet" href="<?php echo e(url('assets/css/plugins/notifier.css')); ?>" />

    <style>
        :root {
            --color-customColor: <?=$setting['color'] ?? 'linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #ffffff 99.86%)' ?>;
        }
    </style>
</head>
<?php if(isset($setting['cust_darklayout']) && $setting['cust_darklayout'] == 'on'): ?>

    <body class="<?php echo e($color); ?> landing-dark landing-page">
    <?php else: ?>

        <body class="<?php echo e($color); ?> landing-page">
<?php endif; ?>
<!-- [ Header ] start -->
<header class="main-header">
    <?php if(isset($settings['topbar_status']) && $settings['topbar_status'] == 'on'): ?>
        <div class="announcement bg-dark text-center p-2">
            <p class="mb-0"><?php echo $settings['topbar_notification_msg']; ?></p>
        </div>
    <?php endif; ?>
    <?php if(isset($settings['menubar_status']) && $settings['menubar_status'] == 'on'): ?>
        <div class="container">
            <nav class="navbar navbar-expand-md  default top-nav-collapse">
                <div class="header-left custom-header-logo">
                    <a class="navbar-brand bg-transparent logo" href="<?php echo e(\URL::to('/')); ?>">
                        <img src="<?php echo e(file_exists($settings['site_logo']) ? get_file($settings['site_logo']) . '?timestamp=' . time() : $logo . '/' . $settings['site_logo'] . '?timestamp=' . time()); ?>" class="logo"
                            alt="logo">
                    </a>
                </div>
                <?php if(isset($menusettings) &&
                        isset($menusettings->menus_id) &&
                        $menusettings->enable_header == 'on' &&
                        !empty($topNavItems)): ?>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                        <ul class="lnding-menubar p-0 m-0">
                            <?php $__currentLoopData = $topNavItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="menu-lnk has-item">
                                    <a class="dash-head-link" href="#">
                                        <span>
                                            <?php echo e($navGroup['name']); ?>

                                        </span>
                                        <i class="ti ti-chevron-down drp-arrow"></i>
                                    </a>
                                    <div class="menu-dropdown">
                                        <ul class="p-0 m-0">
                                            <?php $__currentLoopData = $navGroup['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($nav->type == 'page'): ?>
                                                    <li class="lnk-itm">
                                                        <a href="<?php echo e(url('landing-pages' . '/' . $nav->slug)); ?>"
                                                            target="<?php echo e($nav->target); ?>" class="dropdown-item">
                                                            <span><?php echo e($nav->title); ?></span>
                                                        </a>
                                                        <?php if(!empty($nav->children) && isset($nav->children)): ?>
                                                            <ul class="lnk-child">
                                                                <?php $__currentLoopData = $nav->children[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if(!empty($child)): ?>
                                                                        <li>
                                                                            <?php if($child->type == 'page'): ?>
                                                                                <a href="<?php echo e(url('landing-pages' . '/' . $child->slug)); ?>"
                                                                                    target="<?php echo e($child->target); ?>"
                                                                                    class="dropdown-item">
                                                                                    <span><?php echo e($child->title); ?></span>
                                                                                </a>
                                                                            <?php else: ?>
                                                                                <a href="<?php echo e($child->slug); ?>"
                                                                                target="<?php echo e($child->target); ?>"
                                                                                class="dropdown-item">
                                                                                    <span><?php echo e($child->title); ?></span>
                                                                                </a>
                                                                            <?php endif; ?>
                                                                        </li>
                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </ul>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php else: ?>
                                                    <li>
                                                        <a href="<?php echo e($nav->slug); ?>" target="<?php echo e($nav->target); ?>"
                                                            class="dropdown-item">
                                                            <span><?php echo e($nav->title); ?></span>
                                                        </a>
                                                        <?php if(!empty($nav->children)): ?>
                                                            <ul>
                                                                <?php $__currentLoopData = $nav->children[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if(!empty($child)): ?>
                                                                        <li>
                                                                            <?php if($child->type == 'page'): ?>
                                                                                <a href="<?php echo e(url('landing-pages' . '/' . $child->slug)); ?>"
                                                                                    target="<?php echo e($child->target); ?>"
                                                                                    class="dropdown-item">
                                                                                    <span><?php echo e($child->title); ?></span>
                                                                                </a>
                                                                            <?php else: ?>
                                                                                <a href="<?php echo e($child->slug); ?>"
                                                                                target="<?php echo e($child->target); ?>"
                                                                                class="dropdown-item">
                                                                                    <span><?php echo e($child->title); ?></span>
                                                                                </a>
                                                                            <?php endif; ?>
                                                                        </li>
                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </ul>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <button class="navbar-toggler bg-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                <?php endif; ?>
                <div class="ms-auto d-flex justify-content-end gap-2">
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-dark rounded"><span
                            class="hide-mob me-2"><?php echo e(__('Login')); ?></span> <i data-feather="log-in"></i></a>
                    <?php if($setting['SIGNUP'] == 'on'): ?>
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-dark rounded"><span
                                class="hide-mob me-2"><?php echo e(__('Register')); ?></span> <i data-feather="user-check"></i></a>
                    <?php endif; ?>
                    <button class="navbar-toggler " type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
        </div>
    <?php endif; ?>

</header>
<!-- [ Header ] End -->
<!-- [ Banner ] start -->
<?php if(isset($settings['home_status']) && $settings['home_status'] == 'on'): ?>
    <section class="main-banner bg-primary" id="home">
        <div class="container-offset">
            <div class="row gy-3 g-0 align-items-center">
                <div class="col-xxl-4 col-md-6">
                    <span class="badge py-2 px-3 bg-white text-dark rounded-pill fw-bold mb-3">
                        <?php echo e($settings['home_offer_text']); ?></span>
                    <h1 class="mb-3">
                        <?php echo e($settings['home_heading']); ?>

                    </h1>
                    <h6 class="mb-0"><?php echo e($settings['home_description']); ?></h6>
                    <div class="d-flex gap-3 mt-4 banner-btn">
                        <?php if($settings['home_live_demo_link']): ?>
                            <a href="<?php echo e($settings['home_live_demo_link']); ?>"
                                class="btn btn-outline-dark"><?php echo e(__('Live Demo')); ?>

                                <i data-feather="play-circle" class="ms-2"></i></a>
                        <?php endif; ?>
                        <?php if($settings['home_buy_now_link']): ?>
                            <a href="<?php echo e($settings['home_buy_now_link']); ?>"
                                class="btn btn-outline-dark"><?php echo e(__('Buy Now')); ?> <i data-feather="lock"
                                    class="ms-2"></i></a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-xxl-8 col-md-6">
                    <div class="dash-preview">
                        <img class="img-fluid preview-img" src="<?php echo e(file_exists($settings['home_banner']) ? get_file($settings['home_banner']) : $logo . '/' . $settings['home_banner']); ?>"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row g-0 gy-2 mt-4 align-items-center">
                <div class="col-xxl-3">
                    <p class="mb-0"><?php echo e(__('Trusted by')); ?> <b
                            class="fw-bold"><?php echo e($settings['home_trusted_by']); ?></b></p>
                </div>
                <div class="col-xxl-9">
                    <div class="row gy-3 row-cols-9">
                        <?php $__currentLoopData = explode(',', $settings['home_logo']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $home_logo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-auto custom-header-logo">
                                <img src="<?php echo e(file_exists($home_logo) ? get_file($home_logo) : $logo . '/' . $home_logo); ?>" alt="" class="img-fluid"
                                    style="width: 130px;">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- [ Banner ] start -->
<!-- [ features ] start -->
<?php if(isset($settings['feature_status']) && $settings['feature_status'] == 'on'): ?>
    <section class="features-section section-gap bg-dark" id="features">
        <div class="container">
            <div class="row gy-3">
                <div class="col-xxl-4">
                    <span class="d-block mb-2 text-uppercase text-white"><?php echo e($settings['feature_title']); ?></span>
                    <div class="title mb-4">
                        <h2><b class="fw-bold"><?php echo $settings['feature_heading']; ?></b></h2>
                    </div>
                    <p class="mb-3"><?php echo $settings['feature_description']; ?></p>
                    <?php if($settings['feature_buy_now_link']): ?>
                        <a href="<?php echo e($settings['feature_buy_now_link']); ?>"
                            class="btn btn-primary rounded-pill d-inline-flex align-items-center"><?php echo e(__('Buy Now')); ?>

                            <i data-feather="lock" class="ms-2"></i></a>
                    <?php endif; ?>
                </div>
                <div class="col-xxl-8">
                    <div class="row">
                        <?php if(is_array(json_decode($settings['feature_of_features'], true)) ||
                                is_object(json_decode($settings['feature_of_features'], true))): ?>
                            <?php $__currentLoopData = json_decode($settings['feature_of_features'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-4 col-sm-6 d-flex">
                                    <div class="card <?php echo e($key == 0 ? 'bg-primary' : ''); ?>">
                                        <div class="card-body">
                                            <span class="theme-avtar avtar avtar-xl mb-4">
                                                <img src="<?php echo e(file_exists($value['feature_logo']) ? get_file($value['feature_logo']) : $logo . '/' . $value['feature_logo']); ?>" alt="">
                                            </span>
                                            <h3 class="mb-3 <?php echo e($key == 0 ? '' : 'text-white'); ?>">
                                                <?php echo $value['feature_heading']; ?></h3>
                                            <p class=" f-w-600 mb-0 <?php echo e($key == 0 ? 'text-body' : ''); ?>">
                                                <?php echo strip_tags($value['feature_description']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="title text-center mb-4">
                        <span class="d-block mb-2 text-uppercase text-white"><?php echo e($settings['feature_title']); ?></span>
                        <h2 class="mb-4"><?php echo $settings['highlight_feature_heading']; ?></h2>
                        <p><?php echo $settings['highlight_feature_description']; ?></p>
                    </div>
                    <div class="features-preview">
                        <img class="img-fluid m-auto d-block"
                            src="<?php echo e(file_exists($settings['highlight_feature_image']) ? get_file($settings['highlight_feature_image']) : $logo . '/' . $settings['highlight_feature_image']); ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- [ features ] start -->
<!-- [ element ] start -->
<?php if(isset($settings['feature_status']) && $settings['feature_status'] == 'on'): ?>
    <section class="element-section  section-gap ">
        <div class="container">
            <?php if(is_array(json_decode($settings['other_features'], true)) ||
                    is_object(json_decode($settings['other_features'], true))): ?>
                <?php $__currentLoopData = json_decode($settings['other_features'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($key % 2 == 0): ?>
                        <div class="row align-items-center justify-content-center mb-4">
                            <div class="col-lg-4 col-md-6">
                                <div class="title mb-4">
                                    <span class="d-block fw-bold mb-2 text-uppercase"><?php echo e(__('Features')); ?></span>
                                    <h2>
                                        <?php echo $value['other_features_heading']; ?>

                                    </h2>
                                </div>
                                <p class="mb-3"><?php echo $value['other_featured_description']; ?></p>
                                <?php if($value['other_feature_buy_now_link']): ?>
                                <a href="<?php echo e($value['other_feature_buy_now_link']); ?>"
                                    class="btn btn-primary rounded-pill d-inline-flex align-items-center"><?php echo e(__('Buy Now')); ?>

                                    <i data-feather="lock" class="ms-2"></i></a>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-7 col-md-6 res-img">
                                <div class="img-wrapper">
                                    <img src="<?php echo e(file_exists($value['other_features_image']) ? get_file($value['other_features_image']) : $logo . '/' . $value['other_features_image']); ?>" alt=""
                                        class="img-fluid header-img">
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row align-items-center justify-content-center mb-4">
                            <div class="col-lg-7 col-md-6 m-bottom-img">
                                <div class="img-wrapper">
                                    <img src="<?php echo e(file_exists($value['other_features_image']) ? get_file($value['other_features_image']) : $logo . '/' . $value['other_features_image']); ?>" alt=""
                                        class="img-fluid header-img">
                                </div>
                            </div>
                            <div class="col-lg-4  col-md-6">
                                <div class="title mb-4">
                                    <span class="d-block fw-bold mb-2 text-uppercase"><?php echo e(__('Features')); ?></span>
                                    <h2>
                                        <?php echo $value['other_features_heading']; ?>

                                    </h2>
                                </div>
                                <p class="mb-3"><?php echo $value['other_featured_description']; ?></p>
                                <?php if($value['other_feature_buy_now_link']): ?>
                                <a href="<?php echo e($value['other_feature_buy_now_link']); ?>"
                                    class="btn btn-primary rounded-pill d-inline-flex align-items-center"><?php echo e(__('Buy Now')); ?>

                                    <i data-feather="lock" class="ms-2"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        </div>
    </section>
<?php endif; ?>

<!-- [ element ] end -->
<?php echo $__env->yieldPushContent('campaignsPage'); ?>
<!-- [ element ] start -->
<?php if(isset($settings['discover_status']) && $settings['discover_status'] == 'on'): ?>
    <section class="bg-dark section-gap">
        <div class="container">
            <div class="row mb-2 justify-content-center">
                <div class="col-xxl-6">
                    <div class="title text-center mb-4">
                        <span class="d-block mb-2 text-uppercase text-white"><?php echo e(__('DISCOVER')); ?></span>
                        <h2 class="mb-4"><?php echo $settings['discover_heading']; ?></h2>
                        <p><?php echo $settings['discover_description']; ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php if(is_array(json_decode($settings['discover_of_features'], true)) ||
                        is_object(json_decode($settings['discover_of_features'], true))): ?>
                    <?php $__currentLoopData = json_decode($settings['discover_of_features'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xxl-3 col-sm-6 col-lg-4 ">
                            <div class="card   border <?php echo e($key == 1 ? 'bg-primary' : 'bg-transparent'); ?>">
                                <div class="card-body text-center">
                                    <span class="theme-avtar avtar avtar-xl mx-auto mb-4">
                                        <img src="<?php echo e(file_exists($value['discover_logo']) ? get_file($value['discover_logo']) : $logo . '/' . $value['discover_logo']); ?>" alt="">
                                    </span>
                                    <h3 class="mb-3 <?php echo e($key == 1 ? '' : 'text-white'); ?> "><?php echo $value['discover_heading']; ?>

                                    </h3>
                                    <p class="<?php echo e($key == 1 ? 'text-body' : ''); ?>">
                                        <?php echo strip_tags($value['discover_description']); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

            </div>
            <div class="d-flex flex-column justify-content-center flex-sm-row gap-3 mt-3">
                <?php if(isset($settings['discover_live_demo_link']) && $settings['discover_live_demo_link']): ?>
                    <a href="<?php echo e($settings['discover_live_demo_link']); ?>"
                        class="btn btn-outline-light rounded-pill"><?php echo e(__('Live
                                                                                                                                                                        Demo')); ?>

                        <i data-feather="play-circle" class="ms-2"></i> </a>
                <?php endif; ?>

                <?php if(isset($settings['discover_buy_now_link']) && $settings['discover_buy_now_link']): ?>
                    <a href="<?php echo e($settings['discover_buy_now_link']); ?>"
                        class="btn btn-primary rounded-pill"><?php echo e(__('Buy Now')); ?>

                        <i data-feather="lock" class="ms-2"></i> </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- [ element ] end -->
<!-- [ Screenshots ] start -->
<?php if(isset($settings['screenshots_status']) && $settings['screenshots_status'] == 'on'): ?>
    <section class="screenshots section-gap">
        <div class="container">
            <div class="row mb-2 justify-content-center">
                <div class="col-xxl-6">
                    <div class="title text-center mb-4">
                        <span class="d-block mb-2 fw-bold text-uppercase"><?php echo e(__('SCREENSHOTS')); ?></span>
                        <h2 class="mb-4"><?php echo $settings['screenshots_heading']; ?></h2>
                        <p><?php echo $settings['screenshots_description']; ?></p>
                    </div>
                </div>
            </div>
            <div class="row gy-4 gx-4">
                <?php if(isset($settings['screenshots']) &&
                        (is_array(json_decode($settings['screenshots'], true)) ||
                            is_object(json_decode($settings['screenshots'], true)))): ?>
                    <?php $__currentLoopData = json_decode($settings['screenshots'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="screenshot-card">
                                <div class="img-wrapper">
                                    <img src="<?php echo e(file_exists($value['screenshots']) ? get_file($value['screenshots']) : $logo . '/' . $value['screenshots']); ?>"
                                        class="img-fluid header-img mb-4 shadow-sm" alt="">
                                </div>
                                <h5 class="mb-0"><?php echo $value['screenshots_heading']; ?></h5>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- [ Screenshots ] start -->
<!-- [ subscription ] start -->
<?php if(isset($settings['plan_status']) && $settings['plan_status']): ?>
    <section class="subscription bg-primary section-gap" id="plan">
        <div class="container">
            <div class="row mb-2 justify-content-center">
                <div class="col-xxl-6">
                    <div class="title text-center mb-4">
                        <span class="d-block mb-2 fw-bold text-uppercase"><?php echo e(__('PLAN')); ?></span>
                        <h2 class="mb-4"><?php echo $settings['plan_heading']; ?></h2>
                        <p><?php echo $settings['plan_description']; ?></p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <?php
                    $collection = \App\Models\Plan::where('is_disable', 1)->orderBy('price', 'asc')->get();
                ?>
                <?php $__currentLoopData = $collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xxl-3 col-lg-4 col-md-6 mb-5">
                        <div class="card price-card shadow-none <?php echo e($key == 2 ? 'bg-dark' : ''); ?>"
                            style="<?php echo e($key == 2 ? 'color:white !important' : ''); ?>"> 
                            <div class="card-body">
                                <span class="price-badge bg-dark"><?php echo e($value->name); ?></span>
                                <span
                                    class="mb-4 f-w-600 p-price"><?php echo e(trim(default_currency_format_with_sym($value->price))); ?><small
                                        class="text-sm">/<?php echo e($value->duration); ?></small></span>
                                <?php if($value->trial == '1'): ?>
                                    <p class="mb-0"><?php echo e(__('Free Trial Days : ')); ?><b><?php echo e($value->trial_days); ?></b>
                                    </p>
                                <?php endif; ?>
                                <p>
                                    <?php echo $value->description; ?>

                                </p>
                                <ul class="list-unstyled my-3">
                                    <li>
                                        <div class="form-check text-start">
                                            <label class="form-check-label"
                                                for="customCheckc1"><?php echo e($value->max_stores != -1 ? $value->max_stores . ' Store' : 'Unlimited'); ?>

                                                <?php echo e(__('Store')); ?></label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check text-start">
                                            <label class="form-check-label" for="customCheckc1">
                                                <?php echo e($value->max_products != -1 ? $value->max_products . ' Store' : 'Unlimited'); ?>

                                                <?php echo e(__('Products')); ?></label>
                                        </div>
                                    </li>

                                    <?php if($value->enable_domain == 'on'): ?>
                                        <li>
                                            <div class="form-check text-start">
                                                <label class="form-check-label"
                                                    for="customCheckc1"><?php echo e($value->enable_domain == 'on' ? 'Enable Custom Domain' : ''); ?></label>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                    <?php if($value->enable_subdomain == 'on'): ?>
                                    <li>
                                        <div class="form-check text-start">
                                            <label class="form-check-label"
                                                for="customCheckc1"><?php echo e($value->enable_subdomain == 'on' ? 'Enable Sub Domain' : ''); ?></label>
                                        </div>
                                    </li>
                                    <?php endif; ?>
                                    <?php if($value->pwa_store == 'on'): ?>
                                    <li>
                                        <div class="form-check text-start">
                                            <label class="form-check-label"
                                                for="customCheckc1"><?php echo e($value->pwa_store == 'on' ? 'Enable Progressive Web App (PWA)' : ''); ?></label>
                                        </div>
                                    </li>
                                    <?php endif; ?>
                                    <?php if($value->enable_chatgpt == 'on'): ?>
                                    <li>
                                        <div class="form-check text-start">
                                            <label class="form-check-label"
                                                for="customCheckc1"><?php echo e($value->enable_chatgpt == 'on' ? 'Enable Chatgpt' : ''); ?></label>
                                        </div>
                                    </li>
                                    <?php endif; ?>

                                </ul>
                                <?php if($setting['SIGNUP'] == 'on'): ?>
                                    <div class="d-grid">
                                        <a href="<?php echo e(route('register', ['plan_id' => \Illuminate\Support\Facades\Crypt::encrypt($value->id)])); ?>" class="btn btn-primary rounded-pill"><?php echo e(__('Start with Starter')); ?> <i data-feather="log-in" class="ms-2"></i> </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </section>
<?php endif; ?>
<!-- [ subscription ] end -->
<!-- [ FAqs ] start -->

<?php if(isset($settings['faq_status']) && $settings['faq_status'] == 'on'): ?>
    <section class="faqs section-gap bg-gray-100" id="faq">
        <div class="container">
            <div class="row mb-2">
                <div class="col-xxl-6">
                    <div class="title mb-4">
                        <span class="d-block mb-2 fw-bold text-uppercase"><?php echo e($settings['faq_title']); ?></span>
                        <h2 class="mb-4"><?php echo $settings['faq_heading']; ?></h2>
                        <p><?php echo $settings['faq_description']; ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <?php if(isset($settings['faqs']) &&
                                (is_array(json_decode($settings['faqs'], true)) || is_object(json_decode($settings['faqs'], true)))): ?>
                            <?php $__currentLoopData = json_decode($settings['faqs'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($key % 2 == 0): ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="<?php echo e('flush-heading' . $key); ?>">
                                            <button class="accordion-button collapsed fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="<?php echo e('#flush-' . $key); ?>"
                                                aria-expanded="false" aria-controls="<?php echo e('flush-collapse' . $key); ?>">
                                                <?php echo $value['faq_questions']; ?>

                                            </button>
                                        </h2>
                                        <div id="<?php echo e('flush-' . $key); ?>" class="accordion-collapse collapse"
                                            aria-labelledby="<?php echo e('flush-heading' . $key); ?>"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <?php echo $value['faq_answer']; ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="accordion accordion-flush" id="accordionFlushExample2">
                        <?php if(is_array(json_decode($settings['faqs'], true)) || is_object(json_decode($settings['faqs'], true))): ?>
                            <?php $__currentLoopData = json_decode($settings['faqs'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($key % 2 != 0): ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="<?php echo e('flush-heading' . $key); ?>">
                                            <button class="accordion-button collapsed fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="<?php echo e('#flush-' . $key); ?>"
                                                aria-expanded="false" aria-controls="<?php echo e('flush-collapse' . $key); ?>">
                                                <?php echo $value['faq_questions']; ?>

                                            </button>
                                        </h2>
                                        <div id="<?php echo e('flush-' . $key); ?>" class="accordion-collapse collapse"
                                            aria-labelledby="<?php echo e('flush-heading' . $key); ?>"
                                            data-bs-parent="#accordionFlushExample2">
                                            <div class="accordion-body">
                                                <?php echo $value['faq_answer']; ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php endif; ?>
<!-- [ FAqs ] end -->
<!-- [ testimonial ] start -->
<?php if(isset($settings['testimonials_status']) && $settings['testimonials_status'] == 'on'): ?>
    <section class="testimonial section-gap">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="title mb-4">
                        <span class="d-block mb-2 fw-bold text-uppercase"><?php echo e(__('TESTIMONIALS')); ?></span>
                        <h2 class="mb-2"><?php echo $settings['testimonials_heading']; ?></h2>
                        <p><?php echo $settings['testimonials_description']; ?></p>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row justify-content-center gy-3">
                        <?php if(isset($settings['testimonials']) &&
                                (is_array(json_decode($settings['testimonials'])) || is_object(json_decode($settings['testimonials'])))): ?>
                            <?php $__currentLoopData = json_decode($settings['testimonials']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-xxl-4 col-sm-6 col-lg-6 col-md-4">
                                    <div class="card bg-dark shadow-none mb-0">
                                        <div class="card-body p-3">
                                            <div class="d-flex mb-3 align-items-center justify-content-between">
                                                <span class="theme-avtar avtar avtar-sm bg-light-dark rounded-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="36"
                                                        height="23" viewBox="0 0 36 23" fill="none">
                                                        <path
                                                            d="M12.4728 22.6171H0.770508L10.6797 0.15625H18.2296L12.4728 22.6171ZM29.46 22.6171H17.7577L27.6669 0.15625H35.2168L29.46 22.6171Z"
                                                            fill="white" />
                                                    </svg>
                                                </span>
                                                <span style="color: white;">
                                                    <?php for($i = 1; $i <= (int) $value->testimonials_star; $i++): ?>
                                                        <i data-feather="star"></i>
                                                    <?php endfor; ?>
                                                </span>
                                            </div>
                                            <h3 class="text-white"><?php echo e($value->testimonials_title); ?></h3>
                                            <p class="hljs-comment">
                                                <?php echo e($value->testimonials_description); ?>

                                            </p>
                                            <div class="d-flex gap-3 align-items-center ">
                                                <img src="<?php echo e(file_exists($value->testimonials_user_avtar) ? get_file($value->testimonials_user_avtar) : $logo . '/' . $value->testimonials_user_avtar); ?>"
                                                    class="wid-40 rounded-circle" alt="">
                                                <span class="text-white">
                                                    <b class="fw-bold d-block"><?php echo e($value->testimonials_user); ?></b>
                                                    <?php echo e($value->testimonials_designation); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-12">
                    <p class="mb-0 f-w-600">
                        <?php echo $settings['testimonials_long_description']; ?>

                    </p>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- [ testimonial ] end -->
<!-- [ Footer ] start -->
<footer class="site-footer bg-gray-100">
    <div class="container">
        <div class="footer-row">
            <div class="ftr-col cmp-detail">
                <div class="footer-logo mb-3">
                    <a href="#">
                        <img src="<?php echo e(file_exists($settings['site_logo']) ? get_file($settings['site_logo']) . '?timestamp=' . time() : $logo . '/' . $settings['site_logo'] . '?timestamp=' . time()); ?>"
                            alt="logo">
                    </a>
                </div>
                <p>
                    <?php echo $settings['site_description']; ?>

                </p>

            </div>
            <?php if(isset($menusettings) && isset($menusettings->menus_id) && $menusettings->enable_footer == 'on'): ?>
                <?php $__currentLoopData = $topNavItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="ftr-col">
                        <ul class="list-unstyled">
                            <?php $__currentLoopData = $navGroup['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($nav->type == 'page'): ?>
                                    <li>
                                        <a href="<?php echo e(url('landing-pages' . '/' . $nav->slug)); ?>"
                                            target="<?php echo e($nav->target); ?>"><?php echo e($nav->title); ?></a>
                                        <?php if(!empty($nav->children) && isset($nav->children)): ?>
                                            <ul class="lnk-child">
                                                <?php $__currentLoopData = $nav->children[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(!empty($child)): ?>
                                                        <li>
                                                            <?php if($child->type == 'page'): ?>
                                                                <a href="<?php echo e(url('landing-pages' . '/' . $child->slug)); ?>"
                                                                    target="<?php echo e($child->target); ?>"
                                                                    class="dropdown-item">
                                                                    <span><?php echo e($child->title); ?></span>
                                                                </a>
                                                            <?php else: ?>
                                                                <a href="<?php echo e($child->slug); ?>"
                                                                target="<?php echo e($child->target); ?>"
                                                                class="dropdown-item">
                                                                    <span><?php echo e($child->title); ?></span>
                                                                </a>
                                                            <?php endif; ?>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <a href="<?php echo e($nav->slug); ?>"
                                            target="<?php echo e($nav->target); ?>"><?php echo e($nav->title); ?></a>
                                        <?php if(!empty($nav->children) && isset($nav->children)): ?>
                                            <ul class="lnk-child">
                                                <?php $__currentLoopData = $nav->children[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(!empty($child)): ?>
                                                        <li>
                                                            <?php if($child->type == 'page'): ?>
                                                                <a href="<?php echo e(url('landing-pages' . '/' . $child->slug)); ?>"
                                                                    target="<?php echo e($child->target); ?>"
                                                                    class="dropdown-item">
                                                                    <span><?php echo e($child->title); ?></span>
                                                                </a>
                                                            <?php else: ?>
                                                                <a href="<?php echo e($child->slug); ?>"
                                                                target="<?php echo e($child->target); ?>"
                                                                class="dropdown-item">
                                                                    <span><?php echo e($child->title); ?></span>
                                                                </a>
                                                            <?php endif; ?>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if($settings['joinus_status'] == 'on'): ?>
                <div class="ftr-col ftr-subscribe">
                    <h2><?php echo $settings['joinus_heading']; ?></h2>
                    <p><?php echo $settings['joinus_description']; ?></p>
                    <form method="post" action="<?php echo e(route('join_us_store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="input-wrapper border border-dark">
                            <input type="text" name="email" placeholder="Type your email address...">
                            <button type="submit" class="btn btn-dark rounded-pill"><?php echo e(__('Join Us!')); ?></button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="border-top border-dark text-center p-2">
        

        <p class="mb-0">
            <?php if(isset($setting['footer_text']) &&
                    (strpos($setting['footer_text'], '©') === false && strpos($setting['footer_text'], '&copy;') === false)): ?>
                &copy;
            <?php endif; ?>

            <?php echo e(date('Y')); ?>

            <?php echo e(isset($setting['footer_text']) ? $setting['footer_text'] : config('app.name', 'E-CommerceGo')); ?>

        </p>


    </div>
</footer>
<?php if(isset($setting['enable_cookie']) && $setting['enable_cookie'] == 'on'): ?>
    <?php echo $__env->make('layouts.cookie_consent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<!-- [ Footer ] end -->
<!-- Required Js -->

<script src="<?php echo e(url('js/jquery-3.6.0.min.js')); ?>"></script>
<script src="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/js/plugins/popper.min.js')); ?>"></script>
<script src="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/js/plugins/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/js/plugins/feather.min.js')); ?>"></script>
<script src="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/js/plugins/notifier.js')); ?>"></script>
<script src="<?php echo e(url('packages/workdo/LandingPage/src/Resources/assets/assets/swiper/dist/js/swiper-bundle.min.js')); ?>"></script>
<script src="<?php echo e(url('js/custom.js')); ?><?php echo e('?' . time()); ?>"></script>
<script>
    // Start [ Menu hide/show on scroll ]
    let ost = 0;
    document.addEventListener("scroll", function() {
        let cOst = document.documentElement.scrollTop;
        if (cOst == 0) {
            document.querySelector(".navbar").classList.add("top-nav-collapse");
        } else if (cOst > ost) {
            document.querySelector(".navbar").classList.add("top-nav-collapse");
            document.querySelector(".navbar").classList.remove("default");
        } else {
            document.querySelector(".navbar").classList.add("default");
            document
                .querySelector(".navbar")
                .classList.remove("top-nav-collapse");
        }
        ost = cOst;
    });
    // End [ Menu hide/show on scroll ]

    var scrollSpy = new bootstrap.ScrollSpy(document.body, {
        target: "#navbar-example",
    });
    feather.replace();
</script>
<script>
    // Function to show or hide navigation arrows based on the number of slides
    function toggleNavigationArrows(swiper) {
    const slideCount = swiper.slides.length;
    const nextEl = document.querySelector('.swiper-button-next');
    const prevEl = document.querySelector('.swiper-button-prev');
    if (slideCount <= swiper.params.slidesPerView) {
    nextEl.style.display = 'none';
    prevEl.style.display = 'none';
    } else {
    nextEl.style.display = '';
    prevEl.style.display = '';
    }
    }

    // Initialize Swiper
    var swiper = new Swiper('.campaign-slider', {
    spaceBetween: 15,
    mousewheel: false,
    keyboard: {
    enabled: true
    },
    breakpoints: {
    1199: {
    slidesPerView: 4,
    },
    991: {
    slidesPerView: 3,
    },
    768: {
    slidesPerView: 2,
    },
    0: {
    slidesPerView: 1,
    }
    },
    navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev"
    },
    on: {
    init: function () {
    toggleNavigationArrows(this);
    },
    resize: function () {
    toggleNavigationArrows(this);
    }
    }
    });

    // Initialize Feather icons
    feather.replace();
</script>

<?php if($message = Session::get('success')): ?>

    <script>
        var site_url = $('meta[name="base-url"]').attr('content');
        show_toastr('<?php echo e(__('Success')); ?>', '<?php echo $message; ?>', 'success')
    </script>
<?php endif; ?>

<?php if($message = Session::get('error')): ?>
    <script>
        var site_url = $('meta[name="base-url"]').attr('content');
        show_toastr('<?php echo e(__('Error')); ?>', '<?php echo $message; ?>', 'error')
    </script>
<?php endif; ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\ecommerce-pos\packages\workdo\LandingPage\src\Providers/../Resources/views/layouts/landingpage.blade.php ENDPATH**/ ?>