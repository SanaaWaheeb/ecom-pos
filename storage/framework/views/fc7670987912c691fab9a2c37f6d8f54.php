<?php
    $user = App\Models\User::where('type','admin')->first();
    if ($user->type == 'admin') {
        $plan = App\Models\Plan::find($user->plan_id);
    }
?>
<?php echo $__env->yieldPushContent('ManageDepositAmountValue'); ?>
<div class="order-paycol-inner">
    <div class="d-flex align-items-center justify-content-between payment-ttl-row">
        <div class="payment-ttl-left">
            <?php if($plan->shipping_method == 'on'): ?>
                <span>
                <?php echo e(__('Shipping')); ?> :
                    <span class="payment-shipping">
                        <span class="CURRENCY"></span>
                        <span class="shipping_final_price"> - <b><?php echo e(currency_format_with_sym((0 ?? 0) , $store->id, $currentTheme) ??  SetNumberFormat(0)); ?></b>
                        </span>
                    </span>
                </span>
            <?php endif; ?>
            <span>
                <?php echo e(__('Sub-total')); ?>:
                <b> <?php echo e(currency_format_with_sym(($response->data->final_price ?? 0) , $store->id, $currentTheme) ??  SetNumberFormat($response->data->final_price ?? ($response->data->sub_total ?? 0))); ?></b>
            </span>
            <span>
                <?php echo e(__('Tax')); ?> :
                <b>
                    <span class="payment-shipping">
                        <?php if($plan->shipping_method == 'on'): ?>
                        <span class="CURRENCY"></span>
                        <?php endif; ?>
                        <span class="final_tax_price"> - <?php echo e(currency_format_with_sym(($response->data->tax_price ?? 0) , $store->id, $currentTheme) ??  SetNumberFormat($response->data->tax_price)); ?> </span>
                    </span>
                </b>
            </span>

            <span>
                <?php echo e(__('Coupon')); ?>:
                <b class="discount_amount_currency">- <?php echo e(currency_format_with_sym((0 ?? 0) , $store->id, $currentTheme) ??  SetNumberFormat(0)); ?></b>
            </span>
        </div>
        <div class="payment-ttl-left">
            <h5> <?php echo e(__('Total')); ?> :</h5>
            <div class="ttl-amount">
                <span <?php if($plan->shipping_method == 'on'): ?> class="CURRENCY" <?php else: ?> class="" <?php endif; ?>></span>
                <div class="ttl-pric final_amount_currency1 shipping_total_price">
                    <?php echo e(currency_format_with_sym(($response->data->final_price ?? 0) , $store->id, $currentTheme) ??  SetNumberFormat($response->data->final_price)); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce-pos\themes\minimarket\views/front_end/sections/pages/checkout-amount.blade.php ENDPATH**/ ?>