<section class="article-sec padding-bottom"
    style="position: relative;<?php if(isset($option) && $option->is_hide == 1): ?> opacity: 0.5; <?php else: ?> opacity: 1; <?php endif; ?>"
    data-index="<?php echo e($option->order ?? ''); ?>" data-id="<?php echo e($option->order ?? ''); ?>" data-value="<?php echo e($option->id ?? ''); ?>"
    data-hide="<?php echo e($option->is_hide ?? ''); ?>" data-section="<?php echo e($option->section_name ?? ''); ?>"
    data-store="<?php echo e($option->store_id ?? ''); ?>" data-theme="<?php echo e($option->theme_id ?? ''); ?>">
    <div class="custome_tool_bar"></div>
    <img src="<?php echo e(asset('themes/' . $currentTheme . '/assets/images/d8.png ')); ?>" class="d-left" style="top: 25%;">
    <img src="<?php echo e(asset('themes/' . $currentTheme . '/assets/images/left.png')); ?>" class="d-left" style="top: -35%;">
    <div class=" container">
        <div class="common-heading">
            <span class="sub-heading" id="<?php echo e(($section->blog->section->sub_title->slug ?? '')); ?>_preview"><?php echo $section->blog->section->sub_title->text ?? ""; ?></span>
            <h2 id="<?php echo e(($section->blog->section->title->slug ?? '')); ?>_preview"><?php echo $section->blog->section->title->text
                ?? ""; ?></h2>
        </div>
        <div class="article-slider flex-slider">
            <?php echo \App\Models\Blog::HomePageBlog($currentTheme ,$slug, 10); ?>

        </div>
    </div>
</section><?php /**PATH C:\xampp\htdocs\ecommerce-pos\themes\minimarket\views/front_end/sections/homepage/blog_section.blade.php ENDPATH**/ ?>