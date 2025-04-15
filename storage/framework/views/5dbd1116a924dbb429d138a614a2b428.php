<section class="couner-number-sec padding-bottom" style="position: relative;<?php if(isset($option) && $option->is_hide == 1): ?> opacity: 0.5; <?php else: ?> opacity: 1; <?php endif; ?>"
    data-index="<?php echo e($option->order ?? ''); ?>" data-id="<?php echo e($option->order ?? ''); ?>" data-value="<?php echo e($option->id ?? ''); ?>"
    data-hide="<?php echo e($option->is_hide ?? ''); ?>" data-section="<?php echo e($option->section_name ?? ''); ?>"
    data-store="<?php echo e($option->store_id ?? ''); ?>" data-theme="<?php echo e($option->theme_id ?? ''); ?>">
    <div class="custome_tool_bar"></div>
    <div class=" container">
        <div class="row numbers-row">
            <?php for($i = 0; $i < $section->logo_slider->loop_number; $i++): ?>
                <div class="col-lg-3 col-sm-3 col-12">
                    <div class="number-box">
                        <h2 id="<?php echo e($section->logo_slider->section->description->slug ?? ''); ?>_preview">
                            <?php echo $section->logo_slider->section->description->text->{$i} ?? ''; ?>+</h2>
                        <p id="<?php echo e($section->logo_slider->section->title->slug ?? ''); ?>_preview">
                            <?php echo $section->logo_slider->section->title->text->{$i} ?? ''; ?></p>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\ecommerce-pos\themes\minimarket\views/front_end/sections/homepage/logo_slider.blade.php ENDPATH**/ ?>