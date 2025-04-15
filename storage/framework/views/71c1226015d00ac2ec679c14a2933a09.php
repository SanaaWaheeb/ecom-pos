<section class=" subscribe-sec padding-bottom"
    style="position: relative;<?php if(isset($option) && $option->is_hide == 1): ?> opacity: 0.5; <?php else: ?> opacity: 1; <?php endif; ?>"
    data-index="<?php echo e($option->order ?? ''); ?>" data-id="<?php echo e($option->order ?? ''); ?>" data-value="<?php echo e($option->id ?? ''); ?>"
    data-hide="<?php echo e($option->is_hide ?? ''); ?>" data-section="<?php echo e($option->section_name ?? ''); ?>"
    data-store="<?php echo e($option->store_id ?? ''); ?>" data-theme="<?php echo e($option->theme_id ?? ''); ?>">
    <div class="custome_tool_bar"></div>
    <img src="<?php echo e(asset('themes/' . $currentTheme . '/assets/images/d7.png ')); ?>" class="d-right" style="top: 28%;">
    <div class="container">
        <div class="bg-sec">
            <img src="<?php echo e(get_file($section->subscribe->section->image->image, $currentTheme)); ?>" class="banner-img" alt="plant1">
            <div class="contnent">
                <div class="common-heading">
                    <span class="sub-heading"
                        id="<?php echo e(($section->subscribe->section->sub_title->slug ?? '')); ?>_preview"><?php echo $section->subscribe->section->sub_title->text ?? ""; ?></span>
                    <h2 id="<?php echo e(($section->subscribe->section->title->slug ?? '')); ?>_preview"><?php echo $section->subscribe->section->title->text ?? ""; ?></h2>
                    <p id="<?php echo e(($section->subscribe->section->description->slug ?? '')); ?>_preview"><?php echo $section->subscribe->section->description->text ?? ""; ?></p>
                </div>
                <form action="<?php echo e(route('newsletter.store', $slug)); ?>" class="form-subscribe-form" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="input-box">
                        <input type="email" placeholder="Type your email address..." name="email">
                        <button>
                            <img src="<?php echo e(asset('themes/' . $currentTheme . '/assets/images/icons/right-arrow.svg')); ?>"
                                alt="right-arrow">
                        </button>
                    </div>
                    <div class="form-check">
                        <p id="<?php echo e(($section->subscribe->section->sub_description->slug ?? '')); ?>_preview"><?php echo $section->subscribe->section->sub_description->text ?? ""; ?></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\ecommerce-pos\themes\minimarket\views/front_end/sections/homepage/subscribe_section.blade.php ENDPATH**/ ?>