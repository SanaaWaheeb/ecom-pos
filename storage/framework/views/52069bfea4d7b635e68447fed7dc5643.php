<?php if($currentTheme != null): ?>

<?php endif; ?>
<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Home Page')); ?>

<?php $__env->stopSection(); ?>

<?php if(!(\Request::route()->getName() == 'login' || \Request::route()->getName() == 'register')): ?>
<?php $__env->startSection('content'); ?>

<?php if(isset($theme_section) && count($theme_section) > 0): ?>
    <?php $__currentLoopData = $theme_section; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($option->section_name == 'header'): ?>
        <?php echo $__env->make('front_end.sections.partision.header_section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php elseif($option->section_name == 'slider'): ?>
            <?php echo $__env->make('front_end.sections.homepage.slider_section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php elseif($option->section_name == 'category'): ?>
            <?php echo $__env->make('front_end.sections.homepage.category_section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php elseif($option->section_name == 'logo_slider'): ?>
             <?php echo $__env->make('front_end.sections.homepage.logo_slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php elseif($option->section_name == 'variant_background'): ?>
            <?php echo $__env->make('front_end.sections.homepage.variant_section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php elseif($option->section_name == 'bestseller_slider'): ?>
             <?php echo $__env->make('front_end.sections.homepage.bestseller_slider_section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php elseif($option->section_name == 'best_product'): ?>
            <?php echo $__env->make('front_end.sections.homepage.best_product_section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php elseif($option->section_name == 'subscribe'): ?>
            <?php echo $__env->make('front_end.sections.homepage.subscribe_section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php elseif($option->section_name == 'product_category'): ?>
            <?php echo $__env->make('front_end.sections.homepage.product_category_section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php elseif($option->section_name == 'product'): ?>
            <?php echo $__env->make('front_end.sections.homepage.product_section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php elseif($option->section_name == 'review'): ?>
            <?php echo $__env->make('front_end.sections.homepage.review_section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php elseif($option->section_name == 'blog'): ?>
            <?php echo $__env->make('front_end.sections.homepage.blog_section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            
        <?php elseif($option->section_name == 'footer'): ?>
        <?php echo $__env->make('front_end.sections.partision.footer_section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php $__env->stopSection(); ?>
<?php endif; ?>
<?php echo $__env->make('front_end.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce-pos\themes\minimarket\views/main_file.blade.php ENDPATH**/ ?>