<style>
    .profile-header .menu-dropdown li {
        margin: 10px;
    }

    .profile-header .menu-dropdown {
        position: absolute;
        background-color: #01170e;
        z-index: 9;
        display: none;
        box-shadow: 0px 10px 40px rgba(0, 0, 0, 0.05);
        -moz-transition: all ease-in-out 0.3s;
        -ms-transition: all ease-in-out 0.3s;
        -o-transition: all ease-in-out 0.3s;
        -webkit-transition: all ease-in-out 0.3s;
        transition: all ease-in-out 0.3s;
    }

    .profile-header:hover .menu-dropdown {
        display: block;
    }
</style>

<!-- header start  -->
<header
    <?php if(\Request::route()->getName() == 'landing_page'): ?> class="site-header common-header header-style-one" <?php else: ?>
    class="site-header common-header" <?php endif; ?>
    style="<?php if(isset($option) && $option->is_hide == 1): ?> opacity: 0.5; <?php else: ?> opacity: 1; <?php endif; ?>"
    data-index="<?php echo e($option->order ?? ''); ?>" data-id="<?php echo e($option->order ?? ''); ?>" data-value="<?php echo e($option->id ?? ''); ?>"
    data-hide="<?php echo e($option->is_hide ?? ''); ?>" data-section="<?php echo e($option->section_name ?? ''); ?>"
    data-store="<?php echo e($option->store_id ?? ''); ?>" data-theme="<?php echo e($option->theme_id ?? ''); ?> ">
    <div class="custome_tool_bar"></div>
    <div class="header-top">
        <div class="container right-side-header">
            <div class="header-top-row">
                <div class="top-left-wrapper d-none d-md-block">
                    <ul class="d-flex">
                        <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($page->page_status == 'custom_page'): ?>
                                <li class="menu-lnk"><a
                                        href="<?php echo e(route('custom.page', [$slug, $page->page_slug])); ?>"><?php echo e($page->name); ?></a>
                                </li>
                            <?php else: ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <div class="header-top-time" id="<?php echo e($section->header->section->title->slug ?? ''); ?>_preview">
                    <?php echo $section->header->section->title->text ?? ''; ?>

                </div>
                <ul class="header-top-icon-list">
                    <li>
                        <a href="#" class="search-btn" title="search" id="header-search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0 3.375C0 5.23896 1.51104 6.75 3.375 6.75C4.15424 6.75 4.87179 6.48592 5.44305 6.04237C5.46457 6.08789 5.49415 6.13055 5.5318 6.1682L8.2318 8.8682C8.40754 9.04393 8.69246 9.04393 8.8682 8.8682C9.04393 8.69246 9.04393 8.40754 8.8682 8.2318L6.1682 5.5318C6.13055 5.49415 6.08789 5.46457 6.04237 5.44305C6.48592 4.87179 6.75 4.15424 6.75 3.375C6.75 1.51104 5.23896 0 3.375 0C1.51104 0 0 1.51104 0 3.375ZM0.900001 3.375C0.900001 2.0081 2.0081 0.9 3.375 0.9C4.7419 0.9 5.85 2.0081 5.85 3.375C5.85 4.7419 4.7419 5.85 3.375 5.85C2.0081 5.85 0.900001 4.7419 0.900001 3.375Z"
                                    fill="white" />
                            </svg>
                            <span class="desk-only"><?php echo e(__('Search')); ?></span>
                        </a>
                    </li>
                    <?php if(auth()->guard('customers')->check()): ?>
                        <li>
                            <a href="javascript:;" title="wish" class="wish-header">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.31473 1.76137C5.13885 1.92834 4.86115 1.92834 4.68527 1.76137L4.37055 1.46259C4.00217 1.11287 3.50452 0.899334 2.95455 0.899334C1.82487 0.899334 0.909091 1.80529 0.909091 2.92284C0.909091 3.99423 1.49536 4.87891 2.34171 5.6058C3.18878 6.33331 4.20155 6.8158 4.80666 7.06205C4.93318 7.11354 5.06682 7.11354 5.19334 7.06205C5.79845 6.8158 6.81122 6.33331 7.65829 5.6058C8.50464 4.87891 9.09091 3.99422 9.09091 2.92284C9.09091 1.80529 8.17513 0.899334 7.04545 0.899334C6.49548 0.899334 5.99783 1.11287 5.62946 1.46259L5.31473 1.76137ZM5 0.813705C4.46914 0.309733 3.74841 0 2.95455 0C1.3228 0 0 1.3086 0 2.92284C0 5.78643 3.16834 7.3678 4.46081 7.89376C4.80889 8.03541 5.19111 8.03541 5.53919 7.89376C6.83166 7.3678 10 5.78643 10 2.92284C10 1.3086 8.67721 0 7.04545 0C6.25159 0 5.53086 0.309733 5 0.813705Z"
                                        fill="white" />
                                </svg>
                                <span class="desk-only"><?php echo e(__('Wishlist')); ?></span>
                            </a>
                        </li>
                        <li class="profile-header">
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22" viewBox="0 0 16 22"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                        fill="#183A40" />
                                </svg>
                                <span class="desk-only icon-lable"><?php echo e(__('My profile')); ?></span>
                            </a>
                            <div class="menu-dropdown">
                                <ul>
                                    <li><a href="<?php echo e(route('my-account.index', $slug)); ?>"><?php echo e(__('My Account')); ?></a>
                                    </li>
                                    <li>
                                        <form method="POST" action="<?php echo e(route('customer.logout', $slug)); ?>"
                                            id="form_logout">
                                            <?php echo csrf_field(); ?>
                                            <a href="<?php echo e(route('customer.logout', $slug)); ?>"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                style="background-color: transparent; width: auto;"><?php echo e(__('Log Out')); ?>

                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <?php echo $__env->make('front_end.hooks.header_button', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endif; ?>
                    <?php if(auth()->guard('customers')->guest()): ?>
                        <li class="profile-header">
                            <a href="<?php echo e(route('customer.login', $slug)); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="22" viewBox="0 0 16 22"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.3699 21.0448H4.60183C4.11758 21.0448 3.72502 20.6522 3.72502 20.168C3.72502 19.6837 4.11758 19.2912 4.60183 19.2912H13.3699C13.8542 19.2912 14.2468 18.8986 14.2468 18.4143V14.7756C14.2026 14.2836 13.9075 13.8492 13.4664 13.627C10.0296 12.2394 6.18853 12.2394 2.75176 13.627C2.31062 13.8492 2.01554 14.2836 1.9714 14.7756V20.168C1.9714 20.6522 1.57883 21.0448 1.09459 21.0448C0.610335 21.0448 0.217773 20.6522 0.217773 20.168V14.7756C0.256548 13.5653 0.986136 12.4845 2.09415 11.9961C5.95255 10.4369 10.2656 10.4369 14.124 11.9961C15.232 12.4845 15.9616 13.5653 16.0004 14.7756V18.4143C16.0004 19.8671 14.8227 21.0448 13.3699 21.0448ZM12.493 4.38406C12.493 1.96281 10.5302 0 8.10892 0C5.68767 0 3.72486 1.96281 3.72486 4.38406C3.72486 6.80531 5.68767 8.76812 8.10892 8.76812C10.5302 8.76812 12.493 6.80531 12.493 4.38406ZM10.7393 4.38483C10.7393 5.83758 9.56159 7.01526 8.10884 7.01526C6.6561 7.01526 5.47841 5.83758 5.47841 4.38483C5.47841 2.93208 6.6561 1.75439 8.10884 1.75439C9.56159 1.75439 10.7393 2.93208 10.7393 4.38483Z"
                                        fill="#183A40" />
                                </svg>
                                <span class="desk-only icon-lable"><?php echo e(__('Login')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="mobile-only">
                        <a href="tel:+00 544-213-615" class="header-top-call" title="call">
                            <svg class="mobile-only" height="30" viewBox="0 0 48 48" width="30"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.25 21.59c2.88 5.66 7.51 10.29 13.18 13.17l4.4-4.41c.55-.55 1.34-.71 2.03-.49 2.24.74 4.65 1.14 7.14 1.14 1.11 0 2 .89 2 2v7c0 1.11-.89 2-2 2-18.78 0-34-15.22-34-34 0-1.11.9-2 2-2h7c1.11 0 2 .89 2 2 0 2.49.4 4.9 1.14 7.14.22.69.06 1.48-.49 2.03l-4.4 4.42z"
                                    fill="#fff"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="mobile-only">
                        <a href="#" class="header-top-cart cart-header" title="cart">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.91797 15.834C7.91797 17.1457 6.85465 18.209 5.54297 18.209C4.23129 18.209 3.16797 17.1457 3.16797 15.834C3.16797 14.5223 4.23129 13.459 5.54297 13.459C6.85465 13.459 7.91797 14.5223 7.91797 15.834ZM6.33464 15.834C6.33464 16.2712 5.98019 16.6257 5.54297 16.6257C5.10574 16.6257 4.7513 16.2712 4.7513 15.834C4.7513 15.3968 5.10574 15.0423 5.54297 15.0423C5.98019 15.0423 6.33464 15.3968 6.33464 15.834Z"
                                    fill="white"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M15.8346 15.834C15.8346 17.1457 14.7713 18.209 13.4596 18.209C12.148 18.209 11.0846 17.1457 11.0846 15.834C11.0846 14.5223 12.148 13.459 13.4596 13.459C14.7713 13.459 15.8346 14.5223 15.8346 15.834ZM14.2513 15.834C14.2513 16.2712 13.8969 16.6257 13.4596 16.6257C13.0224 16.6257 12.668 16.2712 12.668 15.834C12.668 15.3968 13.0224 15.0423 13.4596 15.0423C13.8969 15.0423 14.2513 15.3968 14.2513 15.834Z"
                                    fill="white"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M1.66578 2.01983C1.86132 1.62876 2.33685 1.47025 2.72792 1.66578L3.52236 2.06301C4.25803 2.43084 4.75101 3.15312 4.82547 3.97225L4.86335 4.38888C4.88188 4.59276 5.05283 4.74887 5.25756 4.74887H15.702C17.0838 4.74887 18.0403 6.12909 17.5551 7.42297L16.1671 11.1245C15.8195 12.0514 14.9333 12.6655 13.9433 12.6655H6.19479C4.96644 12.6655 3.94076 11.7289 3.82955 10.5056L3.24864 4.1156C3.22382 3.84255 3.05949 3.60179 2.81427 3.47918L2.01983 3.08196C1.62876 2.88643 1.47025 2.41089 1.66578 2.01983ZM5.47346 6.3322C5.2407 6.3322 5.05818 6.53207 5.07926 6.76388L5.40638 10.3622C5.44345 10.77 5.78534 11.0822 6.19479 11.0822H13.9433C14.2733 11.0822 14.5687 10.8775 14.6845 10.5685L16.0726 6.86702C16.1696 6.60825 15.9783 6.3322 15.702 6.3322H5.47346Z"
                                    fill="white"></path>
                            </svg>
                            <span class="count">4</span>
                        </a>
                    </li>
                    <li class="menu-lnk has-item lang-dropdown">
                        <a href="#">
                            <span class="drp-text"><?php echo e(Str::upper($currantLang)); ?></span>
                            <div class="lang-icn">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"
                                    version="1.1" id="svg2223" xml:space="preserve" width="682.66669"
                                    height="682.66669" viewBox="0 0 682.66669 682.66669">
                                    <g id="g2229" transform="matrix(1.3333333,0,0,-1.3333333,0,682.66667)">
                                        <g id="g2231">
                                            <g id="g2233" clip-path="url(#clipPath2237)">
                                                <g id="g2239" transform="translate(497,256)">
                                                    <path
                                                        d="m 0,0 c 0,-132.548 -108.452,-241 -241,-241 -132.548,0 -241,108.452 -241,241 0,132.548 108.452,241 241,241 C -108.452,241 0,132.548 0,0 Z"
                                                        style="fill:none;stroke:#FEBD2F;stroke-width:30;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                        id="path2241"></path>
                                                </g>
                                                <g id="g2243" transform="translate(376,256)">
                                                    <path
                                                        d="m 0,0 c 0,-132.548 -53.726,-241 -120,-241 -66.274,0 -120,108.452 -120,241 0,132.548 53.726,241 120,241 C -53.726,241 0,132.548 0,0 Z"
                                                        style="fill:none;stroke:#FEBD2F;stroke-width:30;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                        id="path2245"></path>
                                                </g>
                                                <g id="g2247" transform="translate(256,497)">
                                                    <path d="M 0,0 V -482"
                                                        style="fill:none;stroke:#FEBD2F;stroke-width:30;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                        id="path2249"></path>
                                                </g>
                                                <g id="g2251" transform="translate(15,256)">
                                                    <path d="M 0,0 H 482"
                                                        style="fill:none;stroke:#FEBD2F;stroke-width:30;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                        id="path2253"></path>
                                                </g>
                                                <g id="g2255" transform="translate(463.8926,136)">
                                                    <path d="M 0,0 H -415.785"
                                                        style="fill:none;stroke:#FEBD2F;stroke-width:30;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                        id="path2257"></path>
                                                </g>
                                                <g id="g2259" transform="translate(48.1079,377)">
                                                    <path d="M 0,0 H 415.785"
                                                        style="fill:none;stroke:#FEBD2F;stroke-width:30;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                        id="path2261"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </a>
                        <div class="menu-dropdown">
                            <ul>
                                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(route('change.languagestore', [$code])); ?>"
                                            class="<?php if($language == $currantLang): ?> active-language text-primary <?php endif; ?>"><?php echo e(ucFirst($language)); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <nav class="navbar-main">
                <div class="logo-col">
                    <h1>
                        <a href="<?php echo e(route('landing_page', $slug)); ?>">
                            <img src="<?php echo e(get_file(isset($theme_logo) && !empty($theme_logo) ? $theme_logo : 'themes/' . $currentTheme . '/assets/images/logo.png', $currentTheme)); ?>"
                                alt="Logo">
                        </a>
                    </h1>
                </div>
                <div
                    class="header-bottom-right-column menu-items-col d-flex align-items-center justify-content-between">
                    <div class="bottom-header-left justify-content-between" id="header-nav-links">
                        <ul class="nav-links main-nav">
                            <div class="mobile-menu-close-icon" id="mobile-menu-close-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18"
                                    viewBox="0 0 20 18">
                                    <path fill="#fff"
                                        d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z">
                                    </path>
                                </svg>
                            </div>
                            <?php if(!empty($topNavItems)): ?>
                            <?php $__currentLoopData = $topNavItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $nav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!empty($nav->children[0])): ?>
                                    <li class="menu-lnk has-item">
                                        <a href="#">
                                            <?php if($nav->title == null): ?>
                                                <?php echo e($nav->title); ?>

                                            <?php else: ?>
                                                <?php echo e($nav->title); ?>

                                            <?php endif; ?>
                                        </a>
                                        <div class="menu-dropdown">
                                            <ul>
                                                <?php $__currentLoopData = $nav->children[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childNav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($childNav->type == 'custom'): ?>
                                                        <li><a href="<?php echo e(url($childNav->slug)); ?>" target="<?php echo e($childNav->target); ?>">
                                                            <?php if($childNav->title == null): ?>
                                                                <?php echo e($childNav->title); ?>

                                                            <?php else: ?>
                                                                <?php echo e($childNav->title); ?>

                                                            <?php endif; ?>
                                                        </a></li>
                                                    <?php elseif($childNav->type == 'category'): ?>
                                                        <li><a href="<?php echo e(url($slug.'/'.$childNav->slug)); ?>" target="<?php echo e($childNav->target); ?>">
                                                            <?php if($childNav->title == null): ?>
                                                                <?php echo e($childNav->title); ?>

                                                            <?php else: ?>
                                                                <?php echo e($childNav->title); ?>

                                                            <?php endif; ?>
                                                        </a></li>
                                                    <?php else: ?>
                                                        <li><a href="<?php echo e(url($slug.'/'.$childNav->slug)); ?>" target="<?php echo e($childNav->target); ?>">
                                                            <?php if($childNav->title == null): ?>
                                                                <?php echo e($childNav->title); ?>

                                                            <?php else: ?>
                                                                <?php echo e($childNav->title); ?>

                                                            <?php endif; ?>
                                                        </a></li>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    </li>
                                <?php else: ?>
                                    <?php if($nav->type == 'custom'): ?>
                                        <li class="">
                                            <a href="<?php echo e(url($nav->slug)); ?>" target="<?php echo e($nav->target); ?>">
                                                <?php if($nav->title == null): ?>
                                                    <?php echo e($nav->title); ?>

                                                <?php else: ?>
                                                    <?php echo e($nav->title); ?>

                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php elseif($nav->type == 'category'): ?>
                                        <li class="">
                                            <a href="<?php echo e(url($slug.'/'.$nav->slug)); ?>" target="<?php echo e($nav->target); ?>" target="<?php echo e($nav->target); ?>">
                                                <?php if($nav->title == null): ?>
                                                    <?php echo e($nav->title); ?>

                                                <?php else: ?>
                                                    <?php echo e($nav->title); ?>

                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="">
                                            <a href="<?php echo e(url($slug.'/custom/'.$nav->slug)); ?>"
                                                target="<?php echo e($nav->target); ?>">
                                                <?php if($nav->title == null): ?>
                                                    <?php echo e($nav->title); ?>

                                                <?php else: ?>
                                                    <?php echo e($nav->title); ?>

                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                            <li class="menu-lnk has-item">
                                <a href="#">
                                    <span class="nav-categories"><?php echo e(__('Pages')); ?></span>
                                    <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="8"
                                        height="8" viewBox="0 0 5 5" fill="none">
                                        <path
                                            d="M3 0.499979C3 0.223848 2.77614 0 2.5 0C2.22386 0 2 0.223848 2 0.499979L2 3.29297L0.853554 2.14657C0.658291 1.95131 0.341709 1.95131 0.146447 2.14657C-0.0488155 2.34182 -0.0488156 2.65839 0.146447 2.85364L2.14645 4.85356C2.24021 4.94732 2.36739 5 2.5 5C2.63261 5 2.75978 4.94732 2.85355 4.85356L4.85355 2.85364C5.04882 2.65839 5.04882 2.34182 4.85355 2.14657C4.65829 1.95131 4.34171 1.95131 4.14645 2.14657L3 3.29297L3 0.499979Z"
                                            fill="black"></path>
                                    </svg>
                                </a>
                                <div class="menu-dropdown">
                                    <ul>
                                        <?php if(isset($pages)): ?>
                                            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><a
                                                    href="<?php echo e(route('custom.page',[$slug, $page->page_slug])); ?>"><?php echo e(ucFirst($page->name)); ?></a>
                                            </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <li><a href="<?php echo e(route('page.faq',['storeSlug' => $slug])); ?>"><?php echo e(__('FAQs')); ?></a></li>
                                        <li><a href="<?php echo e(route('page.blog',['storeSlug' => $slug])); ?>"><?php echo e(__('Blog')); ?></a></li>
                                        <li><a href="<?php echo e(route('page.product-list',['storeSlug' => $slug])); ?>"><?php echo e(__('Collection')); ?></a></li>
                                        <li><a href="<?php echo e(route('page.contact_us',['storeSlug' => $slug])); ?>"><?php echo e(__('Contact')); ?></a></li>
                                    </ul>
                                </div>
                            </li>
                            <?php echo $__env->make('front_end.hooks.header_link', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </ul>
                        <button class="mobile-menu-button" id="mobile-menu-button">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <g data-name="menu " id="menu_">
                                    <path d="M29,6H3A1,1,0,0,0,3,8H29a1,1,0,0,0,0-2Z" />
                                    <path d="M3,17H16a1,1,0,0,0,0-2H3a1,1,0,0,0,0,2Z" />
                                    <path d="M25,24H3a1,1,0,0,0,0,2H25a1,1,0,0,0,0-2Z" />
                                </g>
                            </svg>
                        </button>
                    </div>
                    <div class="bottom-header-right d-flex align-items-center">
                        <div class="header-bottom-call">
                            <span class="desk-only"
                                id="<?php echo e($section->header->section->support_title->slug ?? ''); ?>_preview">
                                <?php echo $section->header->section->support_title->text ?? '#'; ?></span>
                            <a href="tel:<?php echo e($section->header->section->support_value->text); ?>" target="_blank"
                                title="call">
                                <span class="desk-only"
                                    id="<?php echo e($section->header->section->support_value->slug ?? ''); ?>_preview">
                                    <?php echo $section->header->section->support_value->text ?? '#'; ?></span>
                            </a>
                        </div>
                        <div class="bottom-header-cart cart-header">
                            <a href="javascript:;" title="cart" class="cart-header">
                                <div class="cart-count">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                        viewBox="0 0 19 19" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M7.91797 15.834C7.91797 17.1457 6.85465 18.209 5.54297 18.209C4.23129 18.209 3.16797 17.1457 3.16797 15.834C3.16797 14.5223 4.23129 13.459 5.54297 13.459C6.85465 13.459 7.91797 14.5223 7.91797 15.834ZM6.33464 15.834C6.33464 16.2712 5.98019 16.6257 5.54297 16.6257C5.10574 16.6257 4.7513 16.2712 4.7513 15.834C4.7513 15.3968 5.10574 15.0423 5.54297 15.0423C5.98019 15.0423 6.33464 15.3968 6.33464 15.834Z"
                                            fill="white" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.8346 15.834C15.8346 17.1457 14.7713 18.209 13.4596 18.209C12.148 18.209 11.0846 17.1457 11.0846 15.834C11.0846 14.5223 12.148 13.459 13.4596 13.459C14.7713 13.459 15.8346 14.5223 15.8346 15.834ZM14.2513 15.834C14.2513 16.2712 13.8969 16.6257 13.4596 16.6257C13.0224 16.6257 12.668 16.2712 12.668 15.834C12.668 15.3968 13.0224 15.0423 13.4596 15.0423C13.8969 15.0423 14.2513 15.3968 14.2513 15.834Z"
                                            fill="white" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.66578 2.01983C1.86132 1.62876 2.33685 1.47025 2.72792 1.66578L3.52236 2.06301C4.25803 2.43084 4.75101 3.15312 4.82547 3.97225L4.86335 4.38888C4.88188 4.59276 5.05283 4.74887 5.25756 4.74887H15.702C17.0838 4.74887 18.0403 6.12909 17.5551 7.42297L16.1671 11.1245C15.8195 12.0514 14.9333 12.6655 13.9433 12.6655H6.19479C4.96644 12.6655 3.94076 11.7289 3.82955 10.5056L3.24864 4.1156C3.22382 3.84255 3.05949 3.60179 2.81427 3.47918L2.01983 3.08196C1.62876 2.88643 1.47025 2.41089 1.66578 2.01983ZM5.47346 6.3322C5.2407 6.3322 5.05818 6.53207 5.07926 6.76388L5.40638 10.3622C5.44345 10.77 5.78534 11.0822 6.19479 11.0822H13.9433C14.2733 11.0822 14.5687 10.8775 14.6845 10.5685L16.0726 6.86702C16.1696 6.60825 15.9783 6.3322 15.702 6.3322H5.47346Z"
                                            fill="white" />
                                    </svg>
                                    <span class="count"><?php echo \App\Models\Cart::CartCount($slug); ?> </span>
                                </div>
                                <span class="desk-only cart-price"> <?php echo e($currency ?? ''); ?>

                                    <span id="sub_total_main_page"><?php echo e(0); ?></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Mobile menu start here -->
    <div class="mobile-menu-wrapper">
        <div class="menu-close-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18">
                <path fill="#24272a"
                    d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z" />
            </svg>
        </div>
        <div class="mobile-menu-bar">
            <ul>
                <li class="mobile-item has-children">
                    <a href="#" class="acnav-label">
                        <?php echo e(__('Shop All')); ?>

                        <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20"
                            height="11" viewBox="0 0 20 11">
                            <path fill="#24272a"
                                d="M.268 1.076C.373.918.478.813.584.76l.21.474c.79.684 2.527 2.158 5.21 4.368 2.738 2.21 4.159 3.316 4.264 3.316.474-.053 1.158-.369 1.947-1.053.842-.631 1.632-1.42 2.474-2.368.895-.948 1.737-1.842 2.632-2.58.842-.789 1.578-1.262 2.105-1.42l.316.684c0 .21-.106.474-.316.737-.053.21-.263.421-.474.579-.053.052-.316.21-.737.474l-.526.368c-.421.263-1.105.947-2.158 2l-1.105 1.053-2.053 1.947c-1 .947-1.579 1.421-1.842 1.421-.263 0-.684-.263-1.158-.895-.526-.631-.842-1-1.052-1.105l-.737-.579c-.316-.316-.527-.474-.632-.474l-5.42-4.315L.267 2.339l-.105-.421-.053-.369c0-.157.053-.315.158-.473z" />
                        </svg>
                        <svg class="close-menu-ioc" xmlns="http://www.w3.org/2000/svg" width="20" height="18"
                            viewBox="0 0 20 18">
                            <path fill="#24272a"
                                d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z" />
                        </svg>
                    </a>
                    <?php if($has_subcategory): ?>
                        <ul class="mobile_menu_inner acnav-list">
                            <?php $__currentLoopData = $MainCategoryList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="menu-h-link">
                                    <ul>
                                        <li>
                                            <span><?php echo e($category->name); ?>

                                        </li>
                                        <li>
                                            <a
                                                href="<?php echo e(route('page.product-list', [$slug, 'main_category' => $category->id])); ?>"><?php echo e(__('All')); ?></a>
                                        </li>
                                        
                                    </ul>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php else: ?>
                        <ul class="mobile_menu_inner acnav-list">
                            <li class="menu-h-link">
                                <ul>
                                    <?php $__currentLoopData = $MainCategoryList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <a
                                                href="<?php echo e(route('page.product-list', [$slug, 'main_category' => $category->id])); ?>"><?php echo e($category->name); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </li>
                        </ul>
                    <?php endif; ?>
                </li>
                <li class="mobile-item">
                    <a href="<?php echo e(route('page.product-list', $slug)); ?>"> <?php echo e(__('Collection')); ?> </a>
                </li>
                <li class="mobile-item has-children">
                    <a href="#" class="acnav-label">
                        <?php echo e(__('Pages')); ?>

                        <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20"
                            height="11" viewBox="0 0 20 11">
                            <path fill="#24272a"
                                d="M.268 1.076C.373.918.478.813.584.76l.21.474c.79.684 2.527 2.158 5.21 4.368 2.738 2.21 4.159 3.316 4.264 3.316.474-.053 1.158-.369 1.947-1.053.842-.631 1.632-1.42 2.474-2.368.895-.948 1.737-1.842 2.632-2.58.842-.789 1.578-1.262 2.105-1.42l.316.684c0 .21-.106.474-.316.737-.053.21-.263.421-.474.579-.053.052-.316.21-.737.474l-.526.368c-.421.263-1.105.947-2.158 2l-1.105 1.053-2.053 1.947c-1 .947-1.579 1.421-1.842 1.421-.263 0-.684-.263-1.158-.895-.526-.631-.842-1-1.052-1.105l-.737-.579c-.316-.316-.527-.474-.632-.474l-5.42-4.315L.267 2.339l-.105-.421-.053-.369c0-.157.053-.315.158-.473z" />
                        </svg>
                        <svg class="close-menu-ioc" xmlns="http://www.w3.org/2000/svg" width="20" height="18"
                            viewBox="0 0 20 18">
                            <path fill="#24272a"
                                d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z" />
                        </svg>
                    </a>
                    <ul class="mobile_menu_inner acnav-list">
                        <li class="menu-h-link">
                            <ul>
                                <?php if(isset($pages)): ?>
                                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a
                                            href="<?php echo e(route('custom.page',[$slug, $page->page_slug])); ?>"><?php echo e(ucFirst($page->name)); ?></a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <li><a href="<?php echo e(route('page.faq',['storeSlug' => $slug])); ?>"><?php echo e(__('FAQs')); ?></a></li>
                                <li><a href="<?php echo e(route('page.blog',['storeSlug' => $slug])); ?>"><?php echo e(__('Blog')); ?></a></li>
                                <li><a href="<?php echo e(route('page.product-list',['storeSlug' => $slug])); ?>"><?php echo e(__('Collection')); ?></a></li>
                                <li><a href="<?php echo e(route('page.contact_us',['storeSlug' => $slug])); ?>"><?php echo e(__('Contact')); ?></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="search-popup">
        <div class="close-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"
                fill="none">
                <path
                    d="M27.7618 25.0008L49.4275 3.33503C50.1903 2.57224 50.1903 1.33552 49.4275 0.572826C48.6647 -0.189868 47.428 -0.189965 46.6653 0.572826L24.9995 22.2386L3.33381 0.572826C2.57102 -0.189965 1.3343 -0.189965 0.571605 0.572826C-0.191089 1.33562 -0.191186 2.57233 0.571605 3.33503L22.2373 25.0007L0.571605 46.6665C-0.191186 47.4293 -0.191186 48.666 0.571605 49.4287C0.952952 49.81 1.45285 50.0007 1.95275 50.0007C2.45266 50.0007 2.95246 49.81 3.3339 49.4287L24.9995 27.763L46.6652 49.4287C47.0465 49.81 47.5464 50.0007 48.0463 50.0007C48.5462 50.0007 49.046 49.81 49.4275 49.4287C50.1903 48.6659 50.1903 47.4292 49.4275 46.6665L27.7618 25.0008Z"
                    fill="white"></path>
            </svg>
        </div>
        <div class="search-form-wrapper">
            <form>
                <div class="form-inputs">
                    <input type="search" placeholder="Search Product..." class="form-control search_input"
                        list="products" name="search_product" id="product">
                    <datalist id="products">
                        <?php $__currentLoopData = $search_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro_id => $pros): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($pros); ?>"></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </datalist>
                    <button type="submit" class="btn search_product_globaly" id="btn-submit">
                        <svg>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.000169754 6.99457C0.000169754 10.8576 3.13174 13.9891 6.99473 13.9891C8.60967 13.9891 10.0968 13.4418 11.2807 12.5226C11.3253 12.6169 11.3866 12.7053 11.4646 12.7834L17.0603 18.379C17.4245 18.7432 18.015 18.7432 18.3792 18.379C18.7434 18.0148 18.7434 17.4243 18.3792 17.0601L12.7835 11.4645C12.7055 11.3864 12.6171 11.3251 12.5228 11.2805C13.442 10.0966 13.9893 8.60951 13.9893 6.99457C13.9893 3.13157 10.8577 0 6.99473 0C3.13174 0 0.000169754 3.13157 0.000169754 6.99457ZM1.86539 6.99457C1.86539 4.1617 4.16187 1.86522 6.99473 1.86522C9.8276 1.86522 12.1241 4.1617 12.1241 6.99457C12.1241 9.82743 9.8276 12.1239 6.99473 12.1239C4.16187 12.1239 1.86539 9.82743 1.86539 6.99457Z">
                            </path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Mobile menu end here -->
</header>
<?php $__env->startPush('page-script'); ?>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\ecommerce-pos\themes\minimarket\views/front_end/sections/partision/header_section.blade.php ENDPATH**/ ?>