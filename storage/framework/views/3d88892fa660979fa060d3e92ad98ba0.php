<section class="hero-sec"
    style="position: relative;<?php if(isset($option) && $option->is_hide == 1): ?> opacity: 0.5; <?php else: ?> opacity: 1; <?php endif; ?>"
    data-index="<?php echo e($option->order ?? ''); ?>" data-id="<?php echo e($option->order ?? ''); ?>" data-value="<?php echo e($option->id ?? ''); ?>"
    data-hide="<?php echo e($option->is_hide ?? ''); ?>" data-section="<?php echo e($option->section_name ?? ''); ?>"
    data-store="<?php echo e($option->store_id ?? ''); ?>" data-theme="<?php echo e($option->theme_id ?? ''); ?>">
    <div class="custome_tool_bar"></div>
    <img src="<?php echo e(get_file($section->slider->section->background_image->image ?? '', $currentTheme)); ?>" id="<?php echo e(($section->slider->section->background_image->slug ?? '').'_preview'); ?>" alt="banner-img" loading="lazy" class="sixth-sec-banner">
    <div class=" container">
        <div class="hero-main-slider">
            <?php for($i = 0; $i < $section->slider->loop_number; $i++): ?>
                <div class="hero-slides common-heading">
                    <span class="sub-heading"
                        id="<?php echo e(($section->slider->section->sub_title->slug ?? '') . '_' . $i); ?>_preview">
                        <?php echo $section->slider->section->sub_title->text->{$i} ?? ''; ?></span>
                    <h2 class="h1" id="<?php echo e(($section->slider->section->title->slug ?? '') . '_' . $i); ?>_preview">
                        <?php echo $section->slider->section->title->text->{$i} ?? ''; ?> </h2>
                    <p id="<?php echo e(($section->slider->section->description->slug ?? '') . '_' . $i); ?>_preview">
                        <?php echo $section->slider->section->description->text->{$i} ?? ''; ?></p>
                    <div class="hero-btn">
                        <a href="<?php echo e(route('page.product-list', $slug)); ?>" class="common-btn">
                            <span id="<?php echo e(($section->slider->section->button_first->slug ?? '').'_'. $i); ?>_preview"><?php echo $section->slider->section->button_first->text->{$i} ?? ''; ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                    fill="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                    fill="white" />
                            </svg>
                        </a>
                        <a href="javascript:void(0)" class="play-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="45" height="44" viewBox="0 0 45 44" fill="none">
                            <rect width="45" height="44" fill="url(#pattern0)"/>
                            <defs>
                            <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                            <use xlink:href="#image0_0_2" transform="translate(-0.355556 -0.159091) scale(0.0222222 0.0227273)"/>
                            </pattern>
                            <image id="image0_0_2" width="77" height="76" xlink:href="data:image/png;base64,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"/>
                            </defs>
                            </svg>
                            <span id="<?php echo e(($section->slider->section->button_second->slug ?? '').'_'. $i); ?>_preview"><?php echo $section->slider->section->button_second->text->{$i} ?? ''; ?></span>
                        </a>
                    </div>
                </div>
                <?php endfor; ?>
        </div>
    </div>
</section>

<div id="popup-box" class="overlay-popup">
    <div class="popup-inner">
        <div class="content">
            <a class=" close-popup" href="javascript:void(0)">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="34" viewBox="0 0 35 34" fill="none">
                    <line x1="2.29695" y1="1.29289" x2="34.1168" y2="33.1127" stroke="white" stroke-width="2">
                    </line>
                    <line x1="0.882737" y1="33.1122" x2="32.7025" y2="1.29242" stroke="white" stroke-width="2">
                    </line>
                </svg>
            </a>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/9xwazD5SyVg"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen=""></iframe>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\ecommerce-pos\themes\minimarket\views/front_end/sections/homepage/slider_section.blade.php ENDPATH**/ ?>