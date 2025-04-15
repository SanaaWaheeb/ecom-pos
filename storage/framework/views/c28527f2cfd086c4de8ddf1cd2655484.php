<div class="external-btns">
    <?php echo $__env->yieldPushContent('CommmetIconView'); ?>
    <?php if(isset($whatsapp_setting_enabled) && !empty($whatsapp_setting_enabled)): ?>
        <div class="floating-wpp"></div>
    <?php endif; ?>
</div>
<div class="external-left-btn">
    <div class="show-btn btn"><i class="fas fa-sun"></i></div>
    <div class="left-btn-inner">
        <?php echo $__env->yieldPushContent('addCompareButton'); ?>
        <?php echo $__env->yieldPushContent('addCatelogRequestButton'); ?>
        <?php echo $__env->yieldPushContent('DonationFormButton'); ?>
        <?php echo $__env->yieldPushContent('freeShippingPopupButton'); ?>
        <?php echo $__env->yieldPushContent('boostSalesModelPopup'); ?>
        <?php echo $__env->yieldPushContent('couponRequestbutton'); ?>
    </div>
</div>

<?php $__env->startPush('page-script'); ?>
<script>
    $(document).ready(function() {
        // Check if .left-btn-inner contains any children
        if ($('.left-btn-inner').children().length > 0) {
            // If there are children, show the parent container
            $('.external-left-btn').show();
        } else {
            // If there are no children, hide the parent container
            $('.external-left-btn').hide();
        }
    });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\ecommerce-pos\resources\views/front_end/hooks/footer_link.blade.php ENDPATH**/ ?>