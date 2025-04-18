<?php $__env->startSection('template_title'); ?>
    <?php echo e(trans('installer_messages.final.templateTitle')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <i class="fa fa-flag-checkered fa-fw" aria-hidden="true"></i>
    <?php echo e(trans('installer_messages.final.title')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('container'); ?>
    <p style="color:red;"><strong>Default Super Admin Created : superadmin@example.com / 1234</strong></p>
    <p style="color:red;"><strong>Default Admin Created : admin@example.com / 1234</strong></p>


    <p><strong><small><?php echo e(trans('installer_messages.final.console')); ?></small></strong></p>
    <pre><code><?php echo e($finalMessages); ?></code></pre>

    <p><strong><small><?php echo e(trans('installer_messages.final.log')); ?></small></strong></p>
    <pre><code><?php echo e($finalStatusMessage); ?></code></pre>

    <p><strong><small><?php echo e(trans('installer_messages.final.env')); ?></small></strong></p>
    <pre><code><?php echo e($finalEnvFile); ?></code></pre>

    <div class="buttons">
        <a href="<?php echo e(route('start')); ?>" class="button"><?php echo e(trans('installer_messages.final.exit')); ?></a>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('vendor.installer.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce-pos\resources\views/vendor/installer/finished.blade.php ENDPATH**/ ?>