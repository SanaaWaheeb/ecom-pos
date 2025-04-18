<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php if(trim($__env->yieldContent('template_title'))): ?><?php echo $__env->yieldContent('template_title'); ?> | <?php endif; ?> <?php echo e(__('EcommerceGo-SaaS')); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('installer/img/favicon/favicon.png')); ?>" sizes="32x32"/>
    <link href="<?php echo e(asset('installer/css/style.min.css')); ?>" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo e(asset('css/loader.css')); ?><?php echo e('?v=' . time()); ?>" >
    <?php echo $__env->yieldContent('style'); ?>
    <script>
       window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>;
       
    </script>
</head>
<body>
<div class="master">
    <div class="box">
        <div class="header">
            <h1 class="header__title"><?php echo $__env->yieldContent('title'); ?></h1>
        </div>
        <ul class="step">

            <li class="step__divider"></li>
            <li class="step__item <?php echo e(isActive('LaravelInstaller::default_module')); ?> <?php echo e(isActive('LaravelInstaller::final')); ?>">
                <i class="step__icon fa fa-server" aria-hidden="true"></i>
            </li>
            <li class="step__divider"></li>
            <li class="step__item <?php echo e(isActive('LaravelInstaller::environment')); ?> <?php echo e(isActive('LaravelInstaller::environmentWizard')); ?> <?php echo e(isActive('LaravelInstaller::environmentClassic')); ?>">
                <?php if(Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') ): ?>
                    <a href="<?php echo e(route('LaravelInstaller::environment')); ?>">
                        <i class="step__icon fa fa-cog" aria-hidden="true"></i>
                    </a>
                <?php else: ?>
                    <i class="step__icon fa fa-cog" aria-hidden="true"></i>
                <?php endif; ?>
            </li>
            <li class="step__divider"></li>
            <li class="step__item <?php echo e(isActive('LaravelInstaller::permissions')); ?>">
                <?php if(Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') ): ?>
                    <a href="<?php echo e(route('LaravelInstaller::permissions')); ?>">
                        <i class="step__icon fa fa-key" aria-hidden="true"></i>
                    </a>
                <?php else: ?>
                    <i class="step__icon fa fa-key" aria-hidden="true"></i>
                <?php endif; ?>
            </li>
            <li class="step__divider"></li>
            <li class="step__item <?php echo e(isActive('LaravelInstaller::requirements')); ?>">
                <?php if(Request::is('install') || Request::is('install/requirements') || Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') ): ?>
                    <a href="<?php echo e(route('LaravelInstaller::requirements')); ?>">
                        <i class="step__icon fa fa-list" aria-hidden="true"></i>
                    </a>
                <?php else: ?>
                    <i class="step__icon fa fa-list" aria-hidden="true"></i>
                <?php endif; ?>
            </li>
            <li class="step__divider"></li>
            <li class="step__item <?php echo e(isActive('LaravelInstaller::welcome')); ?>">
                <?php if(Request::is('install') || Request::is('install/requirements') || Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') ): ?>
                    <a href="<?php echo e(route('LaravelInstaller::welcome')); ?>">
                        <i class="step__icon fa fa-home" aria-hidden="true"></i>
                    </a>
                <?php else: ?>
                    <i class="step__icon fa fa-home" aria-hidden="true"></i>
                <?php endif; ?>
            </li>
            <li class="step__divider"></li>
        </ul>
        <div class="main">
            <?php if(session('message')): ?>
                <p class="alert text-center">
                    <strong>
                        <?php if(is_array(session('message'))): ?>
                            <?php echo e(session('message')['message']); ?>

                        <?php else: ?>
                            <?php echo e(session('message')); ?>

                        <?php endif; ?>
                    </strong>
                </p>
                <?php (Session::forget('message')); ?>
            <?php endif; ?>
            <?php if($message = Session::get('error_message')): ?>
                <p class="alert text-center alert-danger">
                    <strong>
                        <?php echo e($message); ?>

                    </strong>
                </p>
                <?php (Session::forget('error_message')); ?>
            <?php endif; ?>
            <?php if(session()->has('errors')): ?>
                <div class="alert alert-danger" id="error_alert">
                    <button type="button" class="close" id="close_alert" data-dismiss="alert" aria-hidden="true">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </button>
                    <h4>
                        <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                        <?php echo e(trans('installer_messages.forms.errorTitle')); ?>

                    </h4>
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php (Session::forget('errors')); ?>
            <?php endif; ?>
            <?php echo $__env->yieldContent('container'); ?>
        </div>
    </div>
</div>
<div id="loader" class="loader-wrapper" style="display: none;">
    <span class="site-loader"> </span>
    <h3 class="loader-content"> <?php echo e(__('Installing . . .')); ?> </h3>
</div>
<?php echo $__env->yieldContent('scripts'); ?>

<?php if(session()->has('errors')): ?>
    <script type="text/javascript">
        var x = document.getElementById('error_alert');
        var y = document.getElementById('close_alert');
        y.onclick = function() {
            x.style.display = "none";
        };
    </script>
<?php endif; ?>
<script src="<?php echo e(asset('js/jquery-3.6.0.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/loader.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\ecommerce-pos\resources\views/vendor/installer/layouts/master.blade.php ENDPATH**/ ?>