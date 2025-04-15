<footer class="site-footer"
    style="position: relative;<?php if(isset($option) && $option->is_hide == 1): ?> opacity: 0.5; <?php else: ?> opacity: 1; <?php endif; ?>"
    data-index="<?php echo e($option->order ?? ''); ?>" data-id="<?php echo e($option->order ?? ''); ?>" data-value="<?php echo e($option->id ?? ''); ?>"
    data-hide="<?php echo e($option->is_hide  ?? ''); ?>" data-section="<?php echo e($option->section_name  ?? ''); ?>"
    data-store="<?php echo e($option->store_id  ?? ''); ?>" data-theme="<?php echo e($option->theme_id ?? ''); ?>">
    <div class="custome_tool_bar"></div>

    
    <?php echo $__env->make('front_end.hooks.footer_link', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <img src="<?php echo e(get_file($section->footer->section->background_image->image ?? '')); ?>"
        class="<?php echo e($section->footer->section->background_image->slug ?? ''); ?>_preview" alt="footer-leaf"
        id="footer-leaf">
    <div class="footer-top">
        <div class=" container">
            <div class="row main-footer">
                <div class=" col-lg-7 col-12 col-12">
                    <div class=" row">
                        <div class=" col-md-6 col-12">
                            <div class="footer-col footer-description">
                                <div class="footer-time"
                                    id="<?php echo e($section->footer->section->title->slug ?? ''); ?>_preview">
                                    <?php echo $section->footer->section->title->text ?? ''; ?>

                                </div>
                                <p id="<?php echo e($section->footer->description->title->slug ?? ''); ?>_preview"> <?php echo $section->footer->section->description->text; ?></p>
                            </div>
                        </div>
                        <?php if(isset($section->footer->section->footer_menu_type)): ?>
                        <?php for($i = 0; $i < $section->footer->section->footer_menu_type->loop_number ?? 1; $i++): ?>
                            <?php if(isset($section->footer->section->footer_menu_type->footer_title->{$i})): ?>
                            <div class=" col-md-3 col-12">
                                <div class="footer-col footer-shop">
                                    <h2 class="footer-title">
                                        <?php echo e($section->footer->section->footer_menu_type->footer_title->{$i} ?? ''); ?>

                                    </h2>
                                    <?php
                                    $footer_menu_id = $section->footer->section->footer_menu_type->footer_menu_ids->{$i}
                                    ?? '';
                                    $footer_menu = get_nav_menu($footer_menu_id);
                                    ?>
                                    <ul>
                                        <?php if(!empty($footer_menu)): ?>
                                        <?php $__currentLoopData = $footer_menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $nav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($nav->type == 'custom'): ?>
                                        <li><a href="<?php echo e(url($nav->slug)); ?>" target="<?php echo e($nav->target); ?>">
                                                <?php if($nav->title == null): ?>
                                                <?php echo e($nav->title); ?>

                                                <?php else: ?>
                                                <?php echo e($nav->title); ?>

                                                <?php endif; ?>
                                            </a></li>
                                        <?php elseif($nav->type == 'category'): ?>
                                        <li><a href="<?php echo e(url($slug.'/'.$nav->slug)); ?>"
                                                target="<?php echo e($nav->target); ?>">
                                                <?php if($nav->title == null): ?>
                                                <?php echo e($nav->title); ?>

                                                <?php else: ?>
                                                <?php echo e($nav->title); ?>

                                                <?php endif; ?>
                                            </a></li>
                                        <?php else: ?>
                                        <li><a href="<?php echo e(url($slug.'/custom/'.$nav->slug)); ?>"
                                                target="<?php echo e($nav->target); ?>">
                                                <?php if($nav->title == null): ?>
                                                <?php echo e($nav->title); ?>

                                                <?php else: ?>
                                                <?php echo e($nav->title); ?>

                                                <?php endif; ?>
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php endfor; ?>
                            <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-5 col-12">
                    <div class=" row">
                        <div class=" col-lg-7 col-12">
                            <div class="footer-col footer-insta-gallary">
                                <h2 class="footer-title"
                                    id="<?php echo e($section->footer->section->footer_title->slug ?? ''); ?>_preview"> <?php echo $section->footer->section->footer_title->text ?? ''; ?></h2>
                                <ul class="d-flex align-items-center flex-wrap">
                                    <?php for($i=0; $i<count(objectToArray($section->footer->section->image->image)); $i++): ?>
                                        <li class="gallary-img">
                                            <img src="<?php echo e(get_file($section->footer->section->image->image->{$i} ?? '')); ?>"
                                                alt="logo">
                                        </li>
                                        <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-5 col-12">
                            <div class="footer-icons social-media">
                                <h2 class="footer-title"
                                    id="<?php echo e($section->footer->section->sub_title->slug ?? ''); ?>_preview"> <?php echo $section->footer->section->sub_title->text ?? ''; ?></h2>
                                <ul class="d-flex align-items-center">
                                    <?php if(isset($section->footer->section->footer_link)): ?>
                                    <?php for($i = 0; $i < $section->footer->section->footer_link->loop_number ?? 1;
                                        $i++): ?>
                                        <li>
                                            <a href="<?php echo e($section->footer->section->footer_link->social_link->{$i} ?? '#'); ?>"
                                                target="_blank" id="social_link_<?php echo e($i); ?>">
                                                <img src="<?php echo e(get_file($section->footer->section->footer_link->social_icon->{$i}->image ?? 'themes/' . $currentTheme . '/assets/images/youtube.svg', $currentTheme)); ?>"
                                                    class="<?php echo e('social_icon_' . $i . '_preview'); ?>" alt="icon"
                                                    id="social_icon_<?php echo e($i); ?>">
                                            </a>
                                        </li>
                                        <?php endfor; ?>
                                        <?php endif; ?>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class=" container">
            <div class="footer-copyright">
                <p>© 2024 Foodmart. All rights reserved</p>

            </div>
        </div>
    </div>
</footer>
<!-- footer end  -->
<div class="overlay cart-overlay"></div>
<div class="cartDrawer cartajaxDrawer">
</div>

<div class="overlay wish-overlay"></div>
<div class="wishDrawer wishajaxDrawer">
</div>
</body>

</html><?php /**PATH C:\xampp\htdocs\ecommerce-pos\themes\minimarket\views/front_end/sections/partision/footer_section.blade.php ENDPATH**/ ?>