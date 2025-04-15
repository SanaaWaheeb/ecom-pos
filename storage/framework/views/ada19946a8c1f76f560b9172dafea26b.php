<!--Mobile Menu-->
<div class="mobile-menu-wrapper">
    <div class="menu-close-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="34" viewBox="0 0 35 34" fill="none">
            <line x1="2.29695" y1="1.29289" x2="34.1168" y2="33.1127" stroke="white" stroke-width="2" />
            <line x1="0.882737" y1="33.1122" x2="32.7025" y2="1.29242" stroke="white" stroke-width="2" />
        </svg>
    </div>
    <div class="mobile-menu-bar">
        <ul class="">
            <?php if(!empty($topNavItems)): ?>
                <?php $__currentLoopData = $topNavItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $nav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!empty($nav->children[0])): ?>
                        <li class="mobile-item has-children">
                            <a href="#"  class="acnav-label">
                                <?php if($nav->title == null): ?>
                                    <?php echo e($nav->title); ?>

                                <?php else: ?>
                                    <?php echo e($nav->title); ?>

                                <?php endif; ?>
                                <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20" height="11"
                                    viewBox="0 0 20 11">
                                    <path fill="#24272a"
                                        d="M.268 1.076C.373.918.478.813.584.76l.21.474c.79.684 2.527 2.158 5.21 4.368 2.738 2.21 4.159 3.316 4.264 3.316.474-.053 1.158-.369 1.947-1.053.842-.631 1.632-1.42 2.474-2.368.895-.948 1.737-1.842 2.632-2.58.842-.789 1.578-1.262 2.105-1.42l.316.684c0 .21-.106.474-.316.737-.053.21-.263.421-.474.579-.053.052-.316.21-.737.474l-.526.368c-.421.263-1.105.947-2.158 2l-1.105 1.053-2.053 1.947c-1 .947-1.579 1.421-1.842 1.421-.263 0-.684-.263-1.158-.895-.526-.631-.842-1-1.052-1.105l-.737-.579c-.316-.316-.527-.474-.632-.474l-5.42-4.315L.267 2.339l-.105-.421-.053-.369c0-.157.053-.315.158-.473z">
                                    </path>
                                </svg>
                                <svg class="close-menu-ioc" xmlns="http://www.w3.org/2000/svg" width="20" height="18"
                                    viewBox="0 0 20 18">
                                    <path fill="#24272a"
                                        d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z">
                                    </path>
                                </svg>
                            </a>
                            <ul class="mobile_menu_inner acnav-list">
                                <?php $__currentLoopData = $nav->children[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childNav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($childNav->type == 'custom'): ?>
                                        <li class="menu-h-link"><a href="<?php echo e(url($childNav->slug)); ?>" target="<?php echo e($childNav->target); ?>">
                                            <?php if($childNav->title == null): ?>
                                                <?php echo e($childNav->title); ?>

                                            <?php else: ?>
                                                <?php echo e($childNav->title); ?>

                                            <?php endif; ?>
                                        </a></li>
                                    <?php elseif($childNav->type == 'category'): ?>
                                        <li class="menu-h-link"><a href="<?php echo e(url($slug.'/'.$childNav->slug)); ?>" target="<?php echo e($childNav->target); ?>">
                                            <?php if($childNav->title == null): ?>
                                                <?php echo e($childNav->title); ?>

                                            <?php else: ?>
                                                <?php echo e($childNav->title); ?>

                                            <?php endif; ?>
                                        </a></li>
                                    <?php else: ?>
                                        <li class="menu-h-link"><a href="<?php echo e(url($slug.'/'.$childNav->slug)); ?>" target="<?php echo e($childNav->target); ?>">
                                            <?php if($childNav->title == null): ?>
                                                <?php echo e($childNav->title); ?>

                                            <?php else: ?>
                                                <?php echo e($childNav->title); ?>

                                            <?php endif; ?>
                                        </a></li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <?php if($nav->type == 'custom'): ?>
                            <li class="mobile-item">
                                <a href="<?php echo e(url($nav->slug)); ?>" target="<?php echo e($nav->target); ?>">
                                    <?php if($nav->title == null): ?>
                                        <?php echo e($nav->title); ?>

                                    <?php else: ?>
                                        <?php echo e($nav->title); ?>

                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php elseif($nav->type == 'category'): ?>
                            <li class="mobile-item">
                                <a href="<?php echo e(url($slug.'/'.$nav->slug)); ?>" target="<?php echo e($nav->target); ?>" target="<?php echo e($nav->target); ?>">
                                    <?php if($nav->title == null): ?>
                                        <?php echo e($nav->title); ?>

                                    <?php else: ?>
                                        <?php echo e($nav->title); ?>

                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="mobile-item">
                                <a href="<?php echo e(url($slug.'/custom/'.$nav->slug)); ?>"
                                    target="<?php echo e($nav->target); ?>">
                                    <?php if($nav->title == null): ?>
                                        <?php echo e($nav->title); ?>

                                    <?php else: ?>
                                        <?php echo e($nav->title); ?>

                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>           

            <li class="mobile-item has-children">
                <a href="javascript:void(0)" class="acnav-label">
                    <?php echo e(__('Pages')); ?>

                    <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20" height="11"
                        viewBox="0 0 20 11">
                        <path fill="#24272a"
                            d="M.268 1.076C.373.918.478.813.584.76l.21.474c.79.684 2.527 2.158 5.21 4.368 2.738 2.21 4.159 3.316 4.264 3.316.474-.053 1.158-.369 1.947-1.053.842-.631 1.632-1.42 2.474-2.368.895-.948 1.737-1.842 2.632-2.58.842-.789 1.578-1.262 2.105-1.42l.316.684c0 .21-.106.474-.316.737-.053.21-.263.421-.474.579-.053.052-.316.21-.737.474l-.526.368c-.421.263-1.105.947-2.158 2l-1.105 1.053-2.053 1.947c-1 .947-1.579 1.421-1.842 1.421-.263 0-.684-.263-1.158-.895-.526-.631-.842-1-1.052-1.105l-.737-.579c-.316-.316-.527-.474-.632-.474l-5.42-4.315L.267 2.339l-.105-.421-.053-.369c0-.157.053-.315.158-.473z">
                        </path>
                    </svg>
                    <svg class="close-menu-ioc" xmlns="http://www.w3.org/2000/svg" width="20" height="18"
                        viewBox="0 0 20 18">
                        <path fill="#24272a"
                            d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z">
                        </path>
                    </svg>
                </a>
                <ul class="mobile_menu_inner acnav-list">
                    <li class="menu-h-link">
                        <ul>
                            <?php if(isset($pages)): ?>
                                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a
                                        href="<?php echo e(route('custom.page',[$slug, $page->page_slug])); ?>"><?php echo e(ucFirst($page->name)); ?></a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <li><a href="<?php echo e(route('page.faq',['storeSlug' => $slug])); ?>"><?php echo e(__('FAQs')); ?></a></li>
                            <li><a href="<?php echo e(route('page.blog',['storeSlug' => $slug])); ?>"><?php echo e(__('Blog')); ?></a></li>
                            <li><a href="<?php echo e(route('page.product-list',['storeSlug' => $slug])); ?>"><?php echo e(__('Collection')); ?></a></li>
                            <li><a href="<?php echo e(route('page.contact_us',['storeSlug' => $slug])); ?>"><?php echo e(__('Contact')); ?></a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <?php echo $__env->make('front_end.hooks.header_link', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <li class="mobile-item has-children lang-dropdown">
                <a href="javascript:void(0)" class="acnav-label">
                <?php echo e(Str::upper($currantLang)); ?>

                    <svg class="menu-open-arrow" xmlns="http://www.w3.org/2000/svg" width="20" height="11"
                        viewBox="0 0 20 11">
                        <path fill="#24272a"
                            d="M.268 1.076C.373.918.478.813.584.76l.21.474c.79.684 2.527 2.158 5.21 4.368 2.738 2.21 4.159 3.316 4.264 3.316.474-.053 1.158-.369 1.947-1.053.842-.631 1.632-1.42 2.474-2.368.895-.948 1.737-1.842 2.632-2.58.842-.789 1.578-1.262 2.105-1.42l.316.684c0 .21-.106.474-.316.737-.053.21-.263.421-.474.579-.053.052-.316.21-.737.474l-.526.368c-.421.263-1.105.947-2.158 2l-1.105 1.053-2.053 1.947c-1 .947-1.579 1.421-1.842 1.421-.263 0-.684-.263-1.158-.895-.526-.631-.842-1-1.052-1.105l-.737-.579c-.316-.316-.527-.474-.632-.474l-5.42-4.315L.267 2.339l-.105-.421-.053-.369c0-.157.053-.315.158-.473z">
                        </path>
                    </svg>
                    <svg class="close-menu-ioc" xmlns="http://www.w3.org/2000/svg" width="20" height="18"
                        viewBox="0 0 20 18">
                        <path fill="#24272a"
                            d="M19.95 16.75l-.05-.4-1.2-1-5.2-4.2c-.1-.05-.3-.2-.6-.5l-.7-.55c-.15-.1-.5-.45-1-1.1l-.1-.1c.2-.15.4-.35.6-.55l1.95-1.85 1.1-1c1-1 1.7-1.65 2.1-1.9l.5-.35c.4-.25.65-.45.75-.45.2-.15.45-.35.65-.6s.3-.5.3-.7l-.3-.65c-.55.2-1.2.65-2.05 1.35-.85.75-1.65 1.55-2.5 2.5-.8.9-1.6 1.65-2.4 2.3-.8.65-1.4.95-1.9 1-.15 0-1.5-1.05-4.1-3.2C3.1 2.6 1.45 1.2.7.55L.45.1c-.1.05-.2.15-.3.3C.05.55 0 .7 0 .85l.05.35.05.4 1.2 1 5.2 4.15c.1.05.3.2.6.5l.7.6c.15.1.5.45 1 1.1l.1.1c-.2.15-.4.35-.6.55l-1.95 1.85-1.1 1c-1 1-1.7 1.65-2.1 1.9l-.5.35c-.4.25-.65.45-.75.45-.25.15-.45.35-.65.6-.15.3-.25.55-.25.75l.3.65c.55-.2 1.2-.65 2.05-1.35.85-.75 1.65-1.55 2.5-2.5.8-.9 1.6-1.65 2.4-2.3.8-.65 1.4-.95 1.9-1 .15 0 1.5 1.05 4.1 3.2 2.6 2.15 4.3 3.55 5.05 4.2l.2.45c.1-.05.2-.15.3-.3.1-.15.15-.3.15-.45z">
                        </path>
                    </svg>
                </a>

                <ul class="mobile_menu_inner acnav-list">
                    <li class="menu-h-link">
                        <ul>
                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(route('change.languagestore', [$code])); ?>"
                                        class="<?php if($language == $currantLang): ?> active-language text-primary <?php endif; ?>"><?php echo e(ucFirst($language)); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!--End Mobile Menu-->
    <div class="modal modal-popup" id="commanModel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-inner lg-dialog" role="document">
            <div class="modal-content">
                <div class="popup-content">
                    <div class="modal-header  popup-header align-items-center">
                        <div class="modal-title">
                            <h6 class="mb-0" id="modelCommanModelLabel"></h6>
                        </div>
                        <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <link rel="stylesheet" href="<?php echo e(asset('css/loader.css')); ?><?php echo e('?v=' . time()); ?>" >

        <!-- [ Main Content ] start -->
        <div class="wrapper">
            <div class="pct-customizer">
                <div class="pct-c-btn">
                    <button class="btn btn-primary" id="pct-toggler" data-toggle="tooltip"
                        data-bs-original-title="Order Track" aria-label="Order Track">
                        <i class='fas fa-shipping-fast' style='font-size:24px;'></i>
                    </button>
                </div>
                <div class="pct-c-content">
                    <div class="pct-header bg-primary">
                        <h5 class="mb-0 f-w-500"><?php echo e('Order Tracking'); ?></h5>
                    </div>
                    <div class="pct-body">
                        <?php echo e(Form::open(['route' => ['order.track', $slug], 'method' => 'POST', 'id' => 'choice_form', 'enctype' => 'multipart/form-data'])); ?>

                        <div class="form-group col-md-12">
                            <?php echo Form::label('order_number', __('Order Number'), ['class' => 'form-label']); ?>

                            <?php echo Form::text('order_number', null, ['class' => 'form-control', 'placeholder' => 'Enter Your Order Id']); ?>

                        </div>
                        <div class="form-group col-md-12">
                            <?php echo Form::label('email', __('Email Address'), ['class' => 'form-label']); ?>

                            <?php echo Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email']); ?>

                        </div>
                        <button type="submit" class="btn justify-contrnt-end"><?php echo e(__('Submit')); ?></button>

                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>

         <!--serch popup ends here-->
        <div class="search-popup">
            <div class="close-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
                    <path
                        d="M27.7618 25.0008L49.4275 3.33503C50.1903 2.57224 50.1903 1.33552 49.4275 0.572826C48.6647 -0.189868 47.428 -0.189965 46.6653 0.572826L24.9995 22.2386L3.33381 0.572826C2.57102 -0.189965 1.3343 -0.189965 0.571605 0.572826C-0.191089 1.33562 -0.191186 2.57233 0.571605 3.33503L22.2373 25.0007L0.571605 46.6665C-0.191186 47.4293 -0.191186 48.666 0.571605 49.4287C0.952952 49.81 1.45285 50.0007 1.95275 50.0007C2.45266 50.0007 2.95246 49.81 3.3339 49.4287L24.9995 27.763L46.6652 49.4287C47.0465 49.81 47.5464 50.0007 48.0463 50.0007C48.5462 50.0007 49.046 49.81 49.4275 49.4287C50.1903 48.6659 50.1903 47.4292 49.4275 46.6665L27.7618 25.0008Z"
                        fill="white"></path>
                </svg>
            </div>
            <div class="search-form-wrapper">
                <form>
                    <div class="form-inputs">
                        <input type="search" placeholder="Search Product..." class="form-control search_input" list="products"
                            name="search_product" id="product">
                        <datalist id="products">
                            <?php $__currentLoopData = $search_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro_id => $pros): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($pros); ?>"></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </datalist>
                        <button type="submit" class="btn search_product_globaly">
                            <svg>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.000169754 6.99457C0.000169754 10.8576 3.13174 13.9891 6.99473 13.9891C8.60967 13.9891 10.0968 13.4418 11.2807 12.5226C11.3253 12.6169 11.3866 12.7053 11.4646 12.7834L17.0603 18.379C17.4245 18.7432 18.015 18.7432 18.3792 18.379C18.7434 18.0148 18.7434 17.4243 18.3792 17.0601L12.7835 11.4645C12.7055 11.3864 12.6171 11.3251 12.5228 11.2805C13.442 10.0966 13.9893 8.60951 13.9893 6.99457C13.9893 3.13157 10.8577 0 6.99473 0C3.13174 0 0.000169754 3.13157 0.000169754 6.99457ZM1.86539 6.99457C1.86539 4.1617 4.16187 1.86522 6.99473 1.86522C9.8276 1.86522 12.1241 4.1617 12.1241 6.99457C12.1241 9.82743 9.8276 12.1239 6.99473 12.1239C4.16187 12.1239 1.86539 9.82743 1.86539 6.99457Z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!--serch popup ends here-->
        <div class="addon-side-btn">
            <?php echo $__env->yieldPushContent('couponListButton'); ?>
            <?php echo $__env->yieldPushContent('SpinwheelButton'); ?>
        </div>
        <?php if((isset($loader_show) && $loader_show != 'no') || !isset($loader_show)): ?>
        <div id="loader" class="loader-wrapper" style="display: none;">
        <span class="site-loader"> </span>
        <h3 class="loader-content"> <?php echo e(__('Loading . . .')); ?> </h3>
        </div>
        <?php endif; ?>

        <div class="overlay cart-overlay"></div>
        <div class="cartDrawer cartajaxDrawer"></div>
        <div class="overlay wish-overlay"></div>
        <div class="wishajaxDrawer"></div>

    <!-- [ Main Content ] end -->
   <!--  jQuery Validation  -->
   <script src="<?php echo e(asset('assets/js/jquery.validate.min.js')); ?>"></script>
   <script src="<?php echo e(asset('js/jquery-cookie.min.js')); ?>"></script>
   <script src="<?php echo e(asset('js/loader.js')); ?>"></script>
<?php echo $__env->yieldPushContent('recentViewModelPopup'); ?>

<?php echo $__env->yieldPushContent('subscribeStorePopup'); ?>
<?php echo $__env->yieldPushContent('countDownPopup'); ?>
<?php echo $__env->yieldPushContent('tawktoModelPopup'); ?>
<?php echo $__env->yieldPushContent('purchaseNotificationPopup'); ?>
<?php echo $__env->yieldPushContent('wizzchatModelPopup'); ?>
<!--scripts end here-->
<?php if(isset($storejs)): ?>
<?php echo $storejs; ?>

<?php endif; ?>
<!--scripts start here-->
<script>
    var guest = '<?php echo e(Auth::guest()); ?>';
    var filterBlog = "<?php echo e(route('blogs.filter.view',$store->slug)); ?>";
    var cartlistSidebar = "<?php echo e(route('cart.list.sidebar',$store->slug)); ?>";
    var ProductCart = "<?php echo e(route('product.cart',$store->slug)); ?>";
    var addressbook_data = "<?php echo e(route('get.addressbook.data', $store->slug)); ?>";
    var shippings_data = "<?php echo e(route('get.shipping.data', $store->slug)); ?>";
    var get_shippings_data = "<?php echo e(route('get.shipping.data', $store->slug)); ?>";
    var shippings_methods = "<?php echo e(route('shipping.method', $store->slug)); ?>";
    var apply_coupon = "<?php echo e(route('applycoupon', $store->slug)); ?>";
    var paymentlist = "<?php echo e(route('paymentlist', $store->slug)); ?>";
    var additionalnote = "<?php echo e(route('additionalnote', $store->slug)); ?>";
    var state_list = "<?php echo e(route('states.list', $store->slug)); ?>";
    var city_list = "<?php echo e(route('city.list', $store->slug)); ?>";
    var changeCart = "<?php echo e(route('change.cart', $store->slug)); ?>";
    var wishListSidebar = "<?php echo e(route('wish.list.sidebar', $store->slug)); ?>";
    var removeWishlist = "<?php echo e(route('delete.wishlist', $store->slug)); ?>";
    var addProductWishlist = "<?php echo e(route('product.wishlist', $store->slug)); ?>";
    var isAuthenticated = "<?php echo e(auth('customers')->check() ? 'true' : 'false'); ?>";
    var removeCart = "<?php echo e(route('cart.remove', $store->slug)); ?>";
    var productPrice = "<?php echo e(route('product.price', $store->slug)); ?>";
    var wishList = "<?php echo e(route('wish.list',$store->slug)); ?>";
    var whatsappNumber = "<?php echo e($whatsapp_contact_number ?? ''); ?>";
    var taxes_data = "<?php echo e(route('get.tax.data', $store->slug)); ?>";
    var searchProductGlobaly = "<?php echo e(route('search.product', $store->slug)); ?>";
    var loginUrl = "<?php echo e(route('customer.login', $store->slug)); ?>";
    var payfast_payment_guest = "<?php echo e(route('place.order.guest', $store->slug)); ?>";
    var payfast_payment = "<?php echo e(route('payment.process', $store->slug)); ?>";
    var site_url = $('meta[name="base-url"]').attr('content');
    var size_module_active = <?php echo e(module_is_active('SizeGuideline') ? 'true' : 'false'); ?>;
    var site_url = $('meta[name="base-url"]').attr('content');
    var theme404Page = "<?php echo e(route('theme.404', $store->slug)); ?>";
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://d3js.org/d3.v3.min.js"></script>

<script src="<?php echo e(asset('public/js/flipdown.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/front-theme.js')); ?>" defer="defer"></script>
    <?php if(isset($store->enable_pwa_store) && $store->enable_pwa_store == 'on'): ?>
        <script type="text/javascript">
            const container = document.querySelector("body")

            const coffees = [];

            if ("serviceWorker" in navigator) {
                window.addEventListener("load", function() {
                    navigator.serviceWorker
                        .register("<?php echo e(asset('serviceWorker.js')); ?>")
                        .then(res => console.log("service worker registered"))
                        .catch(err => console.log("service worker not registered", err))

                })
            }
        </script>
    <?php endif; ?>

    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($google_analytic ?? ''); ?>"></script>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '<?php echo e($google_analytic ?? ''); ?>');
    </script>


    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?php echo e($fbpixel_code ?? ''); ?>');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=0000&ev=PageView&noscript=<?php echo e($fbpixel_code ?? ''); ?>" /></noscript>

<?php if(\Request::route()->getName() == 'page.contact_us'): ?>
    <script>
        $(document).ready(function() {
            // Assuming $slug is defined somewhere in your Blade template
            var slug = "<?php echo e($slug); ?>"; // Replace with actual value
            var mobile = "<?php echo e($store->user->mobile ?? '+123 456-78-90'); ?>";
            var tel = "tel:<?php echo e($store->user->mobile ?? '+1234567890'); ?>";
            var email = "<?php echo e($store->user->email ?? 'shop@company.com'); ?>";
            var mailto = "mailto:<?php echo e($store->user->email ?? 'shop@company.com'); ?>";
            var storeAddress = "<?php echo e(\App\Models\Utility::GetValueByName('store_address', $store->theme_id, $store->id) ?? '123 New Street, New City, NY, 10001'); ?>";
            // Update form action attribute
            var newAction = "<?php echo e(route('contacts.store')); ?>/" + slug;
            $('.contact-form').attr('action', newAction);

            $('ul.col-sm-6.col-12 li:eq(0) p a').text(mobile); // New phone number
            $('ul.col-sm-6.col-12 li:eq(0) p a').attr('href', tel); // New tel link

            // Change "Email"
            $('ul.col-sm-6.col-12 li:eq(1) p a').text(email); // New email address
            $('ul.col-sm-6.col-12 li:eq(1) p a').attr('href', mailto); // New mailto link

            // Change "Address"
            $('ul.col-sm-6.col-12:eq(1) li p.address').text(storeAddress); // New address
        });
    </script>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\ecommerce-pos\resources\views/front_end/jQueryRoute.blade.php ENDPATH**/ ?>