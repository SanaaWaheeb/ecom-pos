<?php
    $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : $currentTheme;
    $is_checkout_login_required = \App\Models\Utility::GetValueByName('is_checkout_login_required', $theme_name);
?>
<div class="container">
    <div class="section-title">
        <a href="<?php echo e(route('page.product-list',$slug)); ?>" class="back-btn">
            <span class="svg-ic">
                <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none">
                    <circle cx="15.5" cy="15.5" r="15.0441" stroke="white" stroke-width="0.911765"></circle>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5867 15.7639C20.5867 15.9859 20.4067 16.1658 20.1848 16.1658L12.3333 16.1659L13.2777 17.0834C13.4369 17.2381 13.4406 17.4925 13.2859 17.6517C13.1313 17.8109 12.8768 17.8146 12.7176 17.66L11.0627 16.0523C10.9848 15.9766 10.9409 15.8727 10.9409 15.7641C10.9409 15.6554 10.9848 15.5515 11.0627 15.4758L12.7176 13.8681C12.8768 13.7135 13.1313 13.7172 13.2859 13.8764C13.4406 14.0356 13.4369 14.29 13.2777 14.4447L12.3333 15.3621L20.1848 15.362C20.4067 15.362 20.5867 15.5419 20.5867 15.7639Z" fill="white"></path>
                </svg>
            </span>
            <?php echo e($page_json->cart_page->section->button->text ?? __('Back to category')); ?>

        </a>
     <h2> <?php echo e($page_json->cart_page->section->title->text ?? __('Shopping cart')); ?> <span>(<?php echo e($response->data->cart_total_product); ?>)</span></h2>
    </div>

    <div class="row">
        <div class="col-lg-9 col-12">
            <div class="order-historycontent">
                <table class="cart-tble">
                    <thead>
                        <tr>
                            <th scope="col"> <?php echo e(__('Product')); ?> </th>
                            <th scope="col"> <?php echo e(__('Name')); ?> </th>
                            <?php echo $__env->make('front_end.hooks.cart_table_head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <th scope="col"> <?php echo e(__('date')); ?> </th>
                            <th scope="col"> <?php echo e(__('quantity')); ?> </th>
                            <th scope="col"> <?php echo e(__('Price')); ?> </th>
                            <th scope="col"> <?php echo e(__('Total')); ?> </th>
                            <th scope="col"> <?php echo e(__('Delete')); ?> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($response->data->cart_total_product)): ?>
                            <?php $__currentLoopData = $response->data->product_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td data-label="Product">
                                    <a href="<?php echo e(url($slug.'/product/'. getProductSlug($item->product_id))); ?>">
                                        <img src="<?php echo e(get_file($item->image, $currentTheme)); ?>" alt="img">
                                    </a>
                                </td>

                                <td data-label="Name">
                                    <a href="<?php echo e(url($slug.'/product/'. getProductSlug($item->product_id))); ?>"><?php echo e($item->name); ?></a>
                                    <?php if($item->variant_id != 0): ?>
                                        <div class="mt-5">
                                            <?php echo \App\Models\ProductVariant::variantlist($item->variant_id); ?>

                                        </div>
                                    <?php endif; ?>
                                </td>
                                <?php echo $__env->make('front_end.hooks.cart_table_body', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                <td data-label="date"> <?php echo e(SetDateFormat($item->cart_created)); ?> </td>

                                <td data-label="quantity">
                                    <div class="qty-spinner">
                                        <button type="button" class="quantity-decrement change-cart-globaly" cart-id="<?php echo e($item->cart_id); ?>" quantity_type="decrease">
                                            <svg width="12" height="2" viewBox="0 0 12 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3">
                                                </path>
                                            </svg>
                                        </button>

                                        <input type="text" class="quantity 45_quatity" data-cke-saved-name="quantity" name="quantity" value="<?php echo e($item->qty); ?>" min="01" id="cart_list_quantity<?php echo e($item->qty); ?>">

                                        <button type="button" class="quantity-increment change-cart-globaly"  cart-id="<?php echo e($item->cart_id); ?>" quantity_type="increase">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z" fill="#61AFB3"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <?php echo \App\Models\Product::ManageCartListPrice($item, $store, $store->theme_id); ?>


                                <td>

                                <a href="javascript:void(0)" class="remove_item_from_cart" title="Remove item" href="JavaScript:void(0)" data-id="<?php echo e($item->cart_id); ?>">
                                        <i class="ti ti-trash text-white py-1" data-bs-toggle="tooltip" title="delete"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">
                                    <h3 class="text-center"> <?php echo e(__('You have no items in your shopping cart.')); ?> </h3>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>

        </div>

        <div class="col-lg-3 col-12">
            <div class="cart-summery">
                <ul>
                    <li>
                        <span class="cart-sum-left"><?php echo e($response->data->cart_total_product); ?> <?php echo e(__('item')); ?></span>
                        <span class="cart-sum-right"><?php echo e(currency_format_with_sym(($response->data->final_price ?? 0) , $store->id, $currentTheme) ??  SetNumberFormat($response->data->final_price ?? ($response->data->sub_total ?? 0))); ?></span>
                    </li>
                    <li>
                        <span class="cart-sum-left"><?php echo e(__('Taxes')); ?>: </span>
                        <span class="cart-sum-right"><?php echo e(currency_format_with_sym(($response->data->tax_price ?? 0) , $store->id, $currentTheme) ??  SetNumberFormat($response->data->tax_price)); ?></span>
                    </li>
                    <li>
                        <span class="cart-sum-left"><?php echo e(__('Discount')); ?>: </span>
                        <span class="cart-sum-right coupon_discount_amount"><?php echo e(currency_format_with_sym((0 ?? 0) , $store->id, $currentTheme) ?? SetNumberFormat()); ?></span>
                    </li>
                    <?php
                        $final = $response->data->sub_total+$response->data->tax_price;
                    ?>
                    <li>
                        <span class="cart-sum-left"><?php echo e(__('Total')); ?> (<?php echo e(__('tax incl.')); ?>)</span>
                        <span class="cart-sum-right discount_final_price"><?php echo e(currency_format_with_sym(($final ?? 0) , $store->id, $currentTheme) ?? SetNumberFormat($final)); ?></span>
                    </li>
                </ul>

                <?php if($is_checkout_login_required == 'on' && !auth('customers')->user()): ?>
                <a class="btn checkout-btn" href="<?php echo e(route('customer.login',['storeSlug'=>$slug])); ?>">
                    <?php echo e(__('Proceed to checkout')); ?>

                </a>
                <?php else: ?>
                <a class="btn checkout-btn" href="<?php echo e(route('checkout',['storeSlug'=>$slug])); ?>">
                    <?php echo e(__('Proceed to checkout')); ?>

                </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>


<?php /**PATH C:\xampp\htdocs\ecommerce-pos\themes\minimarket\views/front_end/sections/pages/cart-list.blade.php ENDPATH**/ ?>