<?php $__env->startSection('page-title', __('Manage Themes')); ?>

<?php $__env->startSection('action-button'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><?php echo e(__('Manage Themes')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- [ Main Content ] start -->
<div class="row">
    <div class="d-flex align-items-center justify-content-end">
        <div class="col-md-2">
            <input type="text" id="theme-search" placeholder="<?php echo e(__('Search Themes')); ?>" class="form-control mb-3">
        </div>
    </div>
    <!-- [ basic-table ] start -->
    <div class="col-md-12">
   <div class="border border-primary rounded p-3">
        <?php
            $user =auth()->user();
            $store = App\Models\Store::where('id', getCurrentStore())->first();
        ?>
        <div class="row uploaded-picss gy-4" id="theme-list">
            <?php $__currentLoopData = $themes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $folder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(!in_array($folder, $addons)): ?>
                <?php continue; ?>
            <?php endif; ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 theme-item">
                        <div class="theme-card border-primary theme1  selected h-100">
                            <label for="themes_<?php echo e(!empty($folder)?$folder:''); ?>" class="h-100 d-flex flex-column justify-content-between">
                                <img src="<?php echo e(asset('themes/'.$folder.'/theme_img/img_1.png')); ?>" class="front-img">

                                <div class="theme-bottom-content" >
                                   <div class="theme-card-lable"><b><?php echo e(Str::ucfirst($folder)); ?></b></div>
                                    <div class="theme-card-button flex-wrap">
                                    <a class="btn btn-sm btn-primary text-end" href="<?php echo e(route('theme-preview.create', ['theme_id' => $folder])); ?>">
                                    <?php echo e(__('Customize')); ?>

                                    </a>
                                    <?php if((APP_THEME() ?? auth()->user()->theme_id) != $folder): ?>
                                        <?php echo Form::open(['method' => 'POST', 'route' => ['theme-preview.make-active'], 'class' => 'd-inline']); ?>

                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="theme_id" value="<?php echo e($folder); ?>">
                                            <button type="submit" class="btn btn-sm text-end" <?php echo e(((APP_THEME() ?? auth()->user()->theme_id) == $folder ? 'disabled' : '')); ?>>
                                            <?php echo e(__('Make Active')); ?>

                                            </button>
                                        <?php echo Form::close(); ?>

                                    <?php endif; ?>
                                    </div>

                                </div>
                            </label>
                        </div>
                    </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
   </div>
    </div>
    <!-- [ basic-table ] end -->
</div>
<!-- [ Main Content ] end -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('custom-script'); ?>
<script type="text/javascript">

    $(".email-template-checkbox").click(function(){

        var chbox = $(this);
        $.ajax({
            url: chbox.attr('data-url'),
            data: {_token: $('meta[name="csrf-token"]').attr('content'), status: chbox.val()},
            type: 'post',
            success: function (response) {
                $('#loader').fadeOut();
                if (response.is_success) {
                    show_toastr('Success', response.success, 'success');
                    if (chbox.val() == 1) {
                        $('#' + chbox.attr('id')).val(0);
                    } else {
                        $('#' + chbox.attr('id')).val(1);
                    }
                } else {
                    show_toastr('Error', response.error, 'error');
                }
            },
            error: function (response) {
                $('#loader').fadeOut();
                response = response.responseJSON;
                if (response.is_success) {
                    show_toastr('Error', response.error, 'error');
                } else {
                    show_toastr('Error', response, 'error');
                }
            }
        })
    });

    $(document).on('keyup','#theme-search', function() {
        var value = $(this).val().toLowerCase();
        $('#theme-list .theme-item').filter(function() {
            $(this).toggle($(this).find('.theme-card-lable').text().toLowerCase().indexOf(value) > -1)
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce-pos\resources\views/theme_preview/index.blade.php ENDPATH**/ ?>