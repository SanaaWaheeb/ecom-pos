<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Add-on Manager')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Add-on Manager')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <style>
        .product-img {
            padding-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .system-version h5 {
            position: absolute;
            bottom: -44px;
            right: 27px;
        }

        .center-text {
            display: flex;
            flex-direction: column;
        }

        .center-text .text-primary {
            font-size: 14px;
            margin-top: 5px;
        }

        .theme-main {
            display: flex;
            align-items: center;
        }

        .theme-main .theme-avtar {
            margin-right: 15px;
        }

        .product-img .checkbox-custom .card-option {
            border: 0;
            outline: 0;
        }

        .product-img .checkbox-custom .card-option .btn.show {
            color: #000;
            border: 0;
        }

        .product-img .checkbox-custom .card-option .btn:focus {
            border: 0;
        }

        @media only screen and (max-width: 575px) {
            .system-version h5 {
                position: unset;
                margin-bottom: 0px;
            }

            .system-version {
                text-align: center;
                margin-bottom: -22px;
            }
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-action'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-3">
        <div class="card sticky-top " style="top:60px">
            <div class="list-group list-group-flush addon-set-tab" id="useradd-sidenav">
                <ul class="nav nav-pills flex-column w-100 gap-1" id="pills-tab" role="tablist">
                    <li class="nav-item " role="presentation">
                        <a href="#premiuem"
                            class="nav-link <?php if(isset($addon_tab) && ($addon_tab == 'pills-premium-tab')): ?> active <?php endif; ?> list-group-item list-group-item-action border-0 rounded-1 text-center f-w-600"
                            id="pills-premium-tab" data-bs-toggle="pill" data-bs-target="#pills-premium" type="button"
                            role="tab" aria-controls="pills-premium" aria-selected="true">
                            <?php echo e(__('Add-On Premium')); ?>

                        </a>

                        </li>
                        <li class="nav-item " role="presentation">
                            <a href="#themes"
                                class="nav-link <?php if(isset($addon_tab) && $addon_tab == 'pills-themes-tab'): ?> active <?php endif; ?> list-group-item list-group-item-action border-0 rounded-1 text-center f-w-600"
                                id="pills-themes-tab" data-bs-toggle="pill" data-bs-target="#pills-themes" type="button"
                                role="tab" aria-controls="pills-themes" aria-selected="true">
                                <?php echo e(__('Add-On Themes')); ?>

                            </a>

                        </li>
                        <li class="nav-item " role="presentation">
                            <a href="#mobile-app"
                                class="nav-link <?php if(isset($addon_tab) && $addon_tab == 'pills-mobile-app-tab'): ?> active <?php endif; ?> list-group-item list-group-item-action border-0 rounded-1 text-center f-w-600"
                                id="pills-mobile-app-tab" data-bs-toggle="pill" data-bs-target="#pills-mobile-app"
                                type="button" role="tab" aria-controls="pills-mobile-app" aria-selected="true">
                                <?php echo e(__('Add-On Mobile Apps')); ?>

                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-9">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade <?php if(isset($addon_tab) && $addon_tab == 'pills-premium-tab'): ?> show active <?php endif; ?>" id="pills-premium"
                    role="tabpanel" aria-labelledby="pills-premium-tab">
                    <div id="premium">
                        <div class="col-md-12">
                            <div class="row justify-content-center px-0">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body package-card-inner gap-3 flex-wrap d-flex align-items-center">
                                            <div class="package-itm">
                                                <a href="https://workdo.io/?utm_source=demo&utm_medium=ecommercego&utm_campaign=btn"
                                                    target="new">
                                                    <img src="https://workdo.io/wp-content/uploads/2023/04/Logo.svg"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="package-content flex-grow-1">
                                                <h4><?php echo e(__('Buy More Add-on')); ?></h4>
                                                <div class="text-muted">
                                                    <?php echo e('+' . count($theme['add_ons'] ?? []) . ' ' . __('Premium Add-On')); ?>

                                                </div>
                                            </div>
                                            <div class="d-flex  gap-2">
                                                <div class="price">
                                                    <a class="btn btn-primary btn-badge" title="<?php echo e(__('Buy More Add-on')); ?>" data-bs-toggle="tooltip"
                                                        href="https://workdo.io/product-category/theme-addon/ecommercego-addon/?utm_source=demo&utm_medium=ecommercego&utm_campaign=btn"
                                                        target="new">
                                                        <?php echo e(__('Buy More Add-on')); ?>

                                                    </a>
                                                </div>
                                                <div title="<?php echo e(__('Add More Add-ons')); ?>" data-bs-toggle="tooltip" class="text-end d-flex all-button-box justify-content-md-end justify-content-center">
                                                    <a href="<?php echo e(route('module.add')); ?>" class="btn btn-primary btn-badge d-flex align-items-center justify-content-center">
                                                        <i class="ti ti-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Input -->
                            <div class="row mb-3">
                                <div class="col-8">
                                    <h4 class="mb-3"><?php echo e(__('Installed Add-on')); ?></h4>
                                </div>
                                <div class="col-4">
                                    <input type="text" id="moduleSearch" class="form-control"
                                        placeholder="<?php echo e(__('Search Add-ons...')); ?>">
                                </div>
                            </div>
                            <!-- Installed Add-ons -->
                            <div class="event-cards row px-0">
                                <?php
                                    $module_array = [];
                                ?>
                                <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $module_name = $module->name;
                                        $id = strtolower(preg_replace('/\s+/', '_', $module_name));
                                        $module_array[] = $module->alias;
                                    ?>
                                    <?php if(
                                        (!isset($module->display) || $module->display == true || $module_name == 'GoogleCaptcha') &&
                                            $module_name != 'LandingPage'): ?>
                                        <div class="col-xl-3 col-md-4 col-sm-6 product-card h-auto module-card"
                                            data-name="<?php echo e(strtolower($module->alias)); ?>">
                                            <div
                                                class="card <?php echo e($module->isEnabled() ? 'enable_module' : 'disable_module'); ?> mb-0 h-100 justify-content-between">
                                                <div class="product-img">
                                                    <div class="theme-main">
                                                        <div class="theme-avtar">
                                                            <img src="<?php echo e($module->image ?? ''); ?>"
                                                                alt="<?php echo e($module->name); ?>" class="img-user"
                                                                style="max-width: 100%">
                                                        </div>
                                                        <div class="center-text">
                                                            <small class="text-muted">
                                                                <?php if($module->isEnabled()): ?>
                                                                    <span
                                                                        class="badge bg-success"><?php echo e(__('Enable')); ?></span>
                                                                <?php else: ?>
                                                                    <span
                                                                        class="badge bg-danger"><?php echo e(__('Disable')); ?></span>
                                                                <?php endif; ?>
                                                            </small>
                                                            <small class="text-primary"><?php echo e(__('V')); ?>

                                                                <?php echo e(sprintf('%.1f', $module->version ?? '1.0')); ?></small>
                                                        </div>
                                                    </div>
                                                    <div class="checkbox-custom">
                                                        <div class="btn-group card-option">
                                                            <button type="button" class="btn p-0" data-bs-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                <i class="ti ti-dots-vertical"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end" style="">
                                                                <?php if($module->isEnabled()): ?>
                                                                    <a href="#!" class="dropdown-item module_change"
                                                                        data-id="<?php echo e($id); ?>">
                                                                        <span><?php echo e(__('Disable')); ?></span>
                                                                    </a>
                                                                <?php else: ?>
                                                                    <a href="#!" class="dropdown-item module_change"
                                                                        data-id="<?php echo e($id); ?>">
                                                                        <span><?php echo e(__('Enable')); ?></span>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <form action="<?php echo e(route('module.enable')); ?>"
                                                                    method="POST" id="form_<?php echo e($id); ?>">
                                                                    <?php echo csrf_field(); ?>
                                                                    <input type="hidden" name="name"
                                                                        value="<?php echo e($module->name); ?>">
                                                                </form>
                                                                <form action="<?php echo e(route('module.remove', $module->name)); ?>" method="POST" id="form_<?php echo e($id); ?>">
                                                                    <?php echo csrf_field(); ?>
                                                                    <button type="button" class="dropdown-item show_confirm"
                                                                        data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                                        data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                                        data-confirm-yes="delete-form-<?php echo e($id); ?>" data-text-yes="<?php echo e(__('Yes')); ?>" data-text-no="<?php echo e(__('No')); ?>">
                                                                        <span class="text-danger"><?php echo e(__("Remove")); ?></span>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-content">
                                                    <h4 class="text-capitalize"> <?php echo e($module->alias); ?></h4>
                                                    <p class="text-muted text-sm mb-0">
                                                        <?php echo e($module->description ?? ''); ?>

                                                    </p>
                                                    <a href="<?php echo e(route('software.details', $module->alias)); ?>"
                                                        class="btn  btn-outline-primary w-100 mt-2"><?php echo e(__('View Details')); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <!-- Installed Add-ons End -->

                            <!-- Available Add-ons -->
                            <div class="col-md-4">
                                <h4 class="mb-3"> <?php echo e(__('Buy More Add-On')); ?></h4>
                            </div>
                            <div class="event-cards row px-0">
                                <?php if(isset($theme['add_ons'])): ?>
                                    <?php $__currentLoopData = $theme['add_ons']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!in_array(strtolower($value['name']), array_map('strtolower', $module_array))): ?>
                                            <div class="col-xl-3 col-md-4 col-sm-6 product-card h-auto module-card"
                                                data-name="<?php echo e(strtolower($value['name'])); ?>">
                                                <div class="card mb-0 h-100 justify-content-between">
                                                    <div class="product-img">
                                                        <div class="theme-main">
                                                            <div class="theme-avtar">
                                                                <img src="<?php echo e($value['image']); ?>"
                                                                    alt="<?php echo e($value['name']); ?>" class="img-user"
                                                                    style="max-width: 100%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product-content">
                                                        <h4 class="text-capitalize"> <?php echo e(ucwords($value['name'])); ?></h4>
                                                        <p class="text-muted text-sm mb-0">
                                                            <?php echo e(isset($json['description']) ? $json['description'] : ''); ?>

                                                        </p>
                                                        <a href="<?php echo e($value['url']); ?>?utm_source=demo&utm_medium=ecommercego&utm_campaign=btn"
                                                            class="btn  btn-outline-primary w-100 mt-2"><?php echo e(__('View Details')); ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                            <!-- Available Add-ons End -->
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade <?php if(isset($addon_tab) && $addon_tab == 'pills-themes-tab'): ?> show active <?php endif; ?>" id="pills-themes"
                    role="tabpanel" aria-labelledby="pills-themes-tab">
                    <div id="themes">

                        <div class="col-md-12">
                            

                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <h4 class="mb-3"> <?php echo e(__('Installed Theme')); ?></h4>
                                </div>
                                <div class="col-md-4 text-end">
                                    <input type="text" id="searchThemes" class="form-control"
                                        placeholder="<?php echo e(__('Search Themes...')); ?>">
                                </div>
                            </div>
                            <div class="event-cards row px-0">
                                <?php
                                    $theme_array = [];
                                ?>
                                <?php $__currentLoopData = $addon_themes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $theme_array[] = $value->theme_id;
                                    ?>
                                    <div class="col-lg-4 col-md-4 col-sm-6 card-wrapper">
                                        <div class="product-card ">
                                            <div class="product-card-inner border-primary">
                                                <div class="product-card-image img-wrapper">
                                                    <a href="<?php echo e(asset('themes/' . $value->theme_id . '/theme_img/img_1.png')); ?>"
                                                        class="pdp-img" target="_blank" tabindex="0">
                                                        <img
                                                            src="<?php echo e(asset('themes/' . $value->theme_id . '/theme_img/img_1.png')); ?>">
                                                    </a>

                                                    <div class="checkbox-custom">
                                                        <div class="btn-group card-option">
                                                            <button type="button" class="btn"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <i class="ti ti-dots-vertical"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end" style="">
                                                                <?php if($value->status == '1'): ?>
                                                                    <a href="#!" class="dropdown-item module_change"
                                                                        data-id="<?php echo e($value->theme_id); ?>">
                                                                        <span><?php echo e(__('Disable')); ?></span>
                                                                    </a>
                                                                <?php else: ?>
                                                                    <a href="#!" class="dropdown-item module_change"
                                                                        data-id="<?php echo e($value->theme_id); ?>">
                                                                        <span><?php echo e(__('Enable')); ?></span>
                                                                    </a>
                                                                <?php endif; ?>

                                                                <form action="<?php echo e(route('theme.enable')); ?>" method="POST"
                                                                    id="form_<?php echo e($value->theme_id); ?>">
                                                                    <?php echo csrf_field(); ?>
                                                                    <input type="hidden" name="name"
                                                                        value="<?php echo e($value->theme_id); ?>">
                                                                </form>

                                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['addon.destroy', $value->theme_id], 'class' => 'd-inline']); ?>

                                                                <button type="button" class="dropdown-item show_confirm" data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                                data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>" data-text-yes="<?php echo e(__('Yes')); ?>" data-text-no="<?php echo e(__('No')); ?>" >
                                                                    <span class="text-danger"><?php echo e(__('Remove')); ?></span>
                                                                </button>
                                                                <?php echo Form::close(); ?>


                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="product-content">
                                                    <div class="product-content-top">
                                                        <small class="text-muted">
                                                            <?php if($value->status == '1'): ?>
                                                                <span class="badges bg-success  enable-label"><?php echo e(__('Enable')); ?></span>
                                                            <?php else: ?>
                                                                <span class="badges bg-danger  enable-label"><?php echo e(__('Disable')); ?></span>
                                                            <?php endif; ?>
                                                        </small>
                                                        <h4 class="text-capitalize"><?php echo e($value->theme_id); ?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade  <?php if(isset($addon_tab) && $addon_tab == 'pills-mobile-app-tab'): ?> show active <?php endif; ?>" id="pills-mobile-app" role="tabpanel" aria-labelledby="pills-mobile-app-tab">
                    <div id="mobile-app">
                        <div class="col-md-12">
                            <div class="row justify-content-between px-0">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body package-card-inner gap-3 flex-wrap d-flex align-items-center">
                                            <div class="package-itm ">
                                                <a href="https://workdo.io/?utm_source=demo&utm_medium=ecommercego&utm_campaign=btn"
                                                    target="new">
                                                    <img src="https://workdo.io/wp-content/uploads/2023/04/Logo.svg"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="package-content flex-grow-1">
                                                <h4><?php echo e(__('Buy More Android & iOS Apps Addon')); ?></h4>
                                                <div class="text-muted">
                                                    <?php echo e(__('+2 Premium Android & iOS Native Apps Addon')); ?></div>
                                            </div>
                                            <div class="price text-end">
                                                <a class="btn btn-primary btn-badge" title="<?php echo e(__('Buy More Mobile Apps Add-on')); ?>" data-bs-toggle="tooltip"
                                                    href="https://workdo.io/product-category/ecommercego-saas-addon/ecommercego-mobile-apps/?utm_source=demo&utm_medium=ecommercego&utm_campaign=btn"
                                                    target="new">
                                                    <?php echo e(__('Buy More Mobile Apps Add-on')); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-8">
                                    <h4 class="mb-3"> <?php echo e(__('Buy More Apps')); ?></h4>
                                </div>
                                <div class="col-4">
                                    <input type="text" id="searchMobileApp" class="form-control"
                                        placeholder="<?php echo e(__('Search Mobile Apps...')); ?>">
                                </div>
                            </div>

                            <!-- Rest of the content -->
                            <div class="event-cards row px-0">
                                <?php
                                    $theme_array = [];
                                ?>
                                <?php if(isset($theme['apps'])): ?>
                                    <?php $__currentLoopData = $theme['apps']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-lg-4 col-md-4 col-sm-6 card-wrapper">
                                            <div class="product-card">
                                                <div class="product-card-inner border-primary">
                                                    <div class="product-card-image img-wrapper">
                                                        <a href="<?php echo e($value[1]); ?>" target="_new" class="pdp-img"
                                                            tabindex="0">
                                                            <img src="<?php echo e($value[1]); ?>">
                                                        </a>
                                                    </div>
                                                    <div class="product-content">
                                                        <div class="product-content-top">
                                                            <small class="text-muted">
                                                                <span class="badges bg-success"><?php echo e(__('Buy Now')); ?></span>
                                                            </small>
                                                            <h4 class="text-capitalize"><?php echo e($value[0]); ?>

                                                                (<?php echo e(__('Premium Addon')); ?>)
                                                            </h4>
                                                        </div>
                                                        <?php if(!in_array($value[0], $theme_array)): ?>
                                                            <div class="product-content-bottom d-flex gap-2">
                                                                <a href="<?php echo e($value[2]); ?>?utm_source=demo&utm_medium=ecommercego&utm_campaign=btn"
                                                                    target="_new"
                                                                    class="btn btn-primary w-100 mt-2"><?php echo e(__('Mobile App')); ?></a>
                                                            </div>
                                                        <?php else: ?>
                                                            <a href="<?php echo e($value[2]); ?>?utm_source=demo&utm_medium=ecommercego&utm_campaign=btn"
                                                                target="_new"
                                                                class="btn btn-primary w-100 mt-2"><?php echo e(__('Buy Now')); ?></a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).on('click', '.module_change', function() {
            var id = $(this).attr('data-id');
            $('#loader').show();
            $('#form_' + id).submit();
        });

        document.getElementById('moduleSearch').addEventListener('keyup', function() {
            let query = this.value.toLowerCase();
            let modules = document.querySelectorAll('.module-card');

            modules.forEach(function(module) {
                let moduleName = module.getAttribute('data-name');
                if (moduleName.includes(query)) {
                    module.style.display = 'block';
                } else {
                    module.style.display = 'none';
                }
            });
        });

        document.getElementById('searchMobileApp').addEventListener('keyup', function() {
            var value = $(this).val().toLowerCase();
            $("#mobile-app .card-wrapper").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        document.getElementById('searchThemes').addEventListener('keyup', function() {
            var value = $(this).val().toLowerCase();
            $("#themes .card-wrapper").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce-pos\resources\views/module/index.blade.php ENDPATH**/ ?>