<section class="testimonials-sec padding-bottom"
    style="position: relative;<?php if(isset($option) && $option->is_hide == 1): ?> opacity: 0.5; <?php else: ?> opacity: 1; <?php endif; ?>"
    data-index="<?php echo e($option->order ?? ''); ?>" data-id="<?php echo e($option->order ?? ''); ?>" data-value="<?php echo e($option->id ?? ''); ?>"
    data-hide="<?php echo e($option->is_hide ?? ''); ?>" data-section="<?php echo e($option->section_name ?? ''); ?>"
    data-store="<?php echo e($option->store_id ?? ''); ?>" data-theme="<?php echo e($option->theme_id ?? ''); ?>">
    <div class="custome_tool_bar"></div>
    <img src=" <?php echo e(asset('themes/' . $currentTheme . '/assets/images/right.png ')); ?>" class="d-right" style="top: -15%;">
    <div class="container">
        <div class="common-heading">
            <span class="sub-heading" id="<?php echo e($section->review->section->sub_title->slug ?? ''); ?>_preview"> <?php echo $section->review->section->sub_title->text ?? ''; ?></span>
            <h2 id="<?php echo e($section->review->section->title->slug ?? ''); ?>_preview"><?php echo $section->review->section->title->text ?? ''; ?></h2>
        </div>
        <div class="row align-items-end">
            <div class=" col-lg-9 col-12">
                <div class="testi-slider-container">
                    <div class="testi-slider">
                        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="testi-content">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="29" viewBox="0 0 32 29"
                                fill="none">
                                <path
                                    d="M32 0V3.76895H31.0526C29.0175 3.76895 27.3333 4.15283 26 4.92058C24.7368 5.61853 23.7895 6.90975 23.1579 8.79422C22.5965 10.6089 22.3158 13.1215 22.3158 16.3321V22.4043L20.9474 20.1011C21.2982 19.8219 21.7895 19.5776 22.4211 19.3682C23.0526 19.1588 23.7544 19.0541 24.5263 19.0541C26 19.0541 27.193 19.5078 28.1053 20.4152C29.0175 21.3225 29.4737 22.5439 29.4737 24.0794C29.4737 25.5451 29.0526 26.7316 28.2105 27.639C27.3684 28.5463 26.1404 29 24.5263 29C23.3333 29 22.2807 28.7208 21.3684 28.1625C20.4561 27.6041 19.7193 26.6619 19.1579 25.3357C18.5965 23.9398 18.3158 22.0554 18.3158 19.6823V17.6931C18.3158 12.8773 18.807 9.213 19.7895 6.70036C20.8421 4.11793 22.3158 2.37305 24.2105 1.4657C26.1754 0.488568 28.4561 0 31.0526 0H32ZM13.6842 0V3.76895H12.7368C10.7018 3.76895 9.01754 4.15283 7.68421 4.92058C6.42105 5.61853 5.47368 6.90975 4.84211 8.79422C4.2807 10.6089 4 13.1215 4 16.3321V22.4043L2.63158 20.1011C2.98246 19.8219 3.47368 19.5776 4.10526 19.3682C4.73684 19.1588 5.4386 19.0541 6.21053 19.0541C7.68421 19.0541 8.87719 19.5078 9.78947 20.4152C10.7018 21.3225 11.1579 22.5439 11.1579 24.0794C11.1579 25.5451 10.7368 26.7316 9.89474 27.639C9.05263 28.5463 7.82456 29 6.21053 29C5.01754 29 3.96491 28.7208 3.05263 28.1625C2.14035 27.6041 1.40351 26.6619 0.842105 25.3357C0.280702 23.9398 0 22.0554 0 19.6823V17.6931C0 12.8773 0.491228 9.213 1.47368 6.70036C2.52632 4.11793 4 2.37305 5.89474 1.4657C7.85965 0.488568 10.1404 0 12.7368 0H13.6842Z"
                                    fill="#B5C547" />
                            </svg>
                            <p class="descriptions"><?php echo e($review->description); ?></p>
                            <div class=" d-flex align-items-center">
                                <div class="client-name">
                                    <a href="#"><?php echo e(!empty($review->UserData) ? $review->UserData->first_name : ''); ?></a>
                                    <span><?php echo e(__('Client')); ?></span>
                                </div>
                                <div class="rating d-flex align-items-center">
                                    <div class="review-stars">
                                        <?php for($i = 0; $i < 5; $i++): ?> <i
                                            class="ti ti-star <?php echo e($i < $review->rating_no ? 'text-warning' : ''); ?> "></i>
                                            <?php endfor; ?>
                                    </div>
                                    <div class="rating-number"><?php echo e($review->rating_no); ?>.0 / 5.0</div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="right-slide-slider">
                    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="main-card product-card card">
                            <div class="card-inner">
                                <a href="<?php echo e(url($slug.'/product/'. $review->ProductData->slug)); ?>" class="img-wrapper">
                                    <img src="<?php echo e(get_file($review->ProductData->cover_image_path ?? '', $currentTheme)); ?>"
                                        class="plant-img img-fluid" alt="plant1">
                                </a>
                                <div class="inner-card">
                                    <div class="wishlist-wrapper">
                                        <a href="JavaScript:void(0)"
                                            class="add-wishlist wishlist wishbtn wishbtn-globaly"
                                            title="Wishlist" tabindex="0"
                                            product_id="<?php echo e($review->ProductData->id); ?>"
                                            in_wishlist="<?php echo e($review->ProductData->in_whishlist ? 'remove' : 'add'); ?>"><?php echo e(__('Add to wishlist')); ?>

                                            <span class="wish-ic">
                                                <i
                                                    class="<?php echo e($review->ProductData->in_whishlist ? 'fa fa-heart' : 'ti ti-heart'); ?>"></i>
                                            </span>
                                        </a>
                                        <?php echo \App\Models\Product::actionLinks($currentTheme, $slug, $review->ProductData); ?>

                                        <?php echo \App\Models\Product::productSalesPage($currentTheme, $slug, $review->ProductData->id); ?>

                                    </div>
                                    <div class="card-heading">
                                        <h3>
                                            <a href="<?php echo e(url($slug.'/product/'. $review->ProductData->slug)); ?>"
                                                class="heading-wrapper product-title1">
                                                <?php echo e($review->ProductData->name); ?>

                                            </a>
                                        </h3>
                                    </div>
                                    <?php if($review->ProductData->variant_product == 0): ?>
                                        <div class="price">
                                        <?php echo \App\Models\Product::getProductPrice($review->ProductData, $store, $currentTheme); ?>

                                        </div>
                                    <?php else: ?>
                                        <div class="price">
                                            <ins><?php echo e(__('In Variant')); ?></ins>
                                        </div>
                                    <?php endif; ?>
                                    <a href="javascript:void(0)" class="btn-secondary addcart-btn-globaly common-btn"
                                        product_id="<?php echo e($review->ProductData->id); ?>"
                                        variant_id="0"
                                        qty="1">
                                        <span><?php echo e(__('Add To Cart')); ?></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                            height="16" viewBox="0 0 14 16" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M11.1258 5.12596H2.87416C2.04526 5.12596 1.38823 5.82533 1.43994 6.65262L1.79919 12.4007C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4007L12.5601 6.65262C12.6118 5.82533 11.9547 5.12596 11.1258 5.12596ZM2.87416 3.68893C1.21635 3.68893 -0.0977 5.08768 0.00571155 6.74226L0.364968 12.4904C0.459638 14.0051 1.71574 15.1851 3.23342 15.1851H10.7666C12.2843 15.1851 13.5404 14.0051 13.635 12.4904L13.9943 6.74226C14.0977 5.08768 12.7837 3.68893 11.1258 3.68893H2.87416Z"
                                                fill="white" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.40723 4.40744C3.40723 2.42332 5.01567 0.81488 6.99979 0.81488C8.9839 0.81488 10.5923 2.42332 10.5923 4.40744V5.84447C10.5923 6.24129 10.2707 6.56298 9.87384 6.56298C9.47701 6.56298 9.15532 6.24129 9.15532 5.84447V4.40744C9.15532 3.21697 8.19026 2.2519 6.99979 2.2519C5.80932 2.2519 4.84425 3.21697 4.84425 4.40744V5.84447C4.84425 6.24129 4.52256 6.56298 4.12574 6.56298C3.72892 6.56298 3.40723 6.24129 3.40723 5.84447V4.40744Z"
                                                fill="white" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</section><?php /**PATH C:\xampp\htdocs\ecommerce-pos\themes\minimarket\views/front_end/sections/homepage/review_section.blade.php ENDPATH**/ ?>