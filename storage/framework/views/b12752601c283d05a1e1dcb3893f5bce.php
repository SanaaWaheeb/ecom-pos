<div class="order-confirm-details">
    <h5> <?php echo e(__('Product informations')); ?> :</h5>
    <ul>
        <?php if(!empty($response->data->cart_total_product)): ?>
            <?php $__currentLoopData = $response->data->product_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo \App\Models\Product::ManageCheckoutProductPrice($item, $store, $store->theme_id); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </ul>
</div><?php /**PATH C:\xampp\htdocs\ecommerce-pos\themes\minimarket\views/front_end/sections/pages/checkout-product-list.blade.php ENDPATH**/ ?>