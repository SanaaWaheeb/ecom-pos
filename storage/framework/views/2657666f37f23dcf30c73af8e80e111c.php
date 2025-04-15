<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Plan')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item mb-2" aria-current="page"><a href="<?php echo e(route('plan.index')); ?>"><?php echo e(__('Plan')); ?></a></li>
    <li class="breadcrumb-item mb-2" aria-current="page"><?php echo e(__('Edit')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo e(Form::model($plan, array('route' => array('plan.update', $plan->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data'))); ?>


<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-2">
            <h3 class="h4 m-0"><?php echo e(__('Edit Plan')); ?></h3>
            <div class="d-flex align-items-center justify-content-end flex-wrap g-2">
                <?php if(auth()->user()->type == 'super admin' && isset($setting['chatgpt_key'])): ?>
                <a href="#" class="btn btn-primary btn-badge me-2 ai-btn" data-size="lg" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['plan'])); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Generate')); ?>" data-title="<?php echo e(__('Generate Content With AI')); ?>">
                    <i class="fas fa-robot"></i> <?php echo e(__('Generate with AI')); ?>

                </a>
                <?php endif; ?>
                <a href="<?php echo e(route('plan.index')); ?>"class="btn btn-badge btn-secondary ai-btn"><?php echo e(__('Back')); ?> </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group col-md-12">
                        <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('name', null, ['class' => 'form-control','placeholder' => __('Enter Name'),'required' => 'required'])); ?>

                    </div>
                    <?php if($plan->id != 1): ?>
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('price',__('Price') ,array('class'=>'form-label'))); ?>

                        <?php echo e(Form::number('price',null,array('class'=>'form-control','step'=>'0.01','placeholder'=>__('Enter Price'),'required'=>'required'))); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('duration', __('Duration'), ['class' => 'form-label'])); ?>

                        <?php echo Form::select('duration', $arrDuration, null, ['class' => 'form-control ', 'required' => 'required']); ?>

                    </div>
                    <?php endif; ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo e(Form::label('max_stores', __('Maximum Store'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::number('max_stores', null, ['class' => 'form-control','id' => 'max_stores','placeholder' => __('Enter Max Store'),'required' => 'required'])); ?>

                            <span><small class="text-danger"><?php echo e(__("Note: '-1' for Unlimited")); ?></small></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo e(Form::label('max_products', __('Maximum Products Per Store'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::number('max_products', null, ['class' => 'form-control','id' => 'max_products','placeholder' => __('Enter Max Products'),'required' => 'required'])); ?>

                            <span><small class="text-danger"><?php echo e(__("Note: '-1' for Unlimited")); ?></small></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo e(Form::label('max_users', __('Maximum Users Per Store'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::number('max_users', null, ['class' => 'form-control','id' => 'max_users','placeholder' => __('Enter Max User'),'required' => 'required'])); ?>

                            <span><small class="text-danger"><?php echo e(__("Note: '-1' for Unlimited")); ?></small></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo e(Form::label('storage_limit', __('Storage Limit'), ['class' => 'form-label'])); ?>

                            <div class ='input-group'>
                                <?php echo e(Form::number('storage_limit', null, ['class' => 'form-control','id' => 'storage_limit','placeholder' => __('Enter Storage Limit'),'required' => 'required' ,'min' => '0'])); ?>

                                <span class="input-group-text bg-transparent"><?php echo e(__('MB')); ?></span>
                            </div>
                            <span><small class="text-danger"><?php echo e(__("Note: upload size ( In MB)")); ?></small></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-4 col-sm-6">
                        <div class="custom-control form-switch pt-2 ps-0 gap-1 select-swich d-flex align-items-center">
                            <input type="checkbox" class="form-check-input" name="enable_domain" id="enable_domain"  <?php echo e($plan['enable_domain'] == 'on' ? 'checked=checked' : ''); ?>>
                                <label class="custom-control-label form-check-label"
                                    for="enable_domain"><?php echo e(__('Enable Domain')); ?></label>
                        </div>
                    </div>
                    <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-4 col-sm-6">
                        <div class="custom-control form-switch pt-2 ps-0 gap-1 select-swich d-flex align-items-center">
                            <input type="checkbox" class="form-check-input" name="enable_subdomain" id="enable_subdomain"  <?php echo e($plan['enable_subdomain'] == 'on' ? 'checked=checked' : ''); ?>>
                            <label class="custom-control-label form-check-label"
                                for="enable_subdomain"><?php echo e(__('Enable Sub Domain')); ?></label>
                        </div>
                    </div>

                    <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-4 col-sm-6">
                        <div class="custom-control form-switch pt-2 ps-0 gap-1 select-swich d-flex align-items-center">
                            <input type="checkbox" class="form-check-input" name="enable_chatgpt" id="enable_chatgpt" <?php echo e($plan['enable_chatgpt'] == 'on' ? 'checked=checked' : ''); ?>>
                            <label class="custom-control-label form-check-label"
                                for="enable_chatgpt"><?php echo e(__('Enable Chatgpt')); ?></label>
                        </div>
                    </div>

                    <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-4 col-sm-6">
                        <div class="custom-control form-switch pt-2 ps-0 gap-1 select-swich d-flex align-items-center">
                            <input type="checkbox" class="form-check-input" name="pwa_store" id="pwa_store" <?php echo e($plan['pwa_store'] == 'on' ? 'checked=checked' : ''); ?>>
                        <label class="custom-control-label form-check-label"
                            for="pwa_store"><?php echo e(__('Progressive Web App (PWA)')); ?></label>
                        </div>
                    </div>
                    <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-4 col-sm-6">
                        <div class="custom-control form-switch pt-2 ps-0 gap-1 select-swich d-flex align-items-center">
                            <input type="checkbox" class="form-check-input" name="shipping_method" id="shipping_method" <?php echo e($plan['shipping_method'] == 'on' ? 'checked=checked' : ''); ?>>
                        <label class="custom-control-label form-check-label"
                            for="shipping_method"><?php echo e(__('Shipping Method')); ?></label>
                        </div>
                    </div>
                    <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-4 col-sm-6">
                        <div class="custom-control form-switch pt-2 ps-0 gap-1 select-swich d-flex align-items-center">
                            <input type="checkbox" class="form-check-input" name="enable_tax" id="enable_tax" <?php echo e($plan['enable_tax'] == 'on' ? 'checked=checked' : ''); ?>>
                        <label class="custom-control-label form-check-label"
                            for="enable_tax"><?php echo e(__('Enable Taxes')); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-xxl-2 col-xl-4 col-lg-6 col-md-6">
                        <label class="form-check-label" for="trial"></label>
                        <div class="form-group gap-1 d-flex align-items-center trial-switch">
                            <label for="trial" class="form-label"><?php echo e(__('Trial is enable(on/off)')); ?></label>
                            <div class="form-check form-switch custom-switch-v1 float-end">
                                <input type="checkbox" name="trial" class="form-check-input input-primary pointer" value="1" id="trial" <?php echo e(($plan['trial'] == 1 || $plan['trial'] == 'on') ? 'checked=checked' : ''); ?>>
                                <label class="form-check-label" for="trial"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-10 col-xl-8 col-lg-6 col-md-6">
                        <div class="form-group plan_div  <?php echo e($plan['trial'] == 1 ? 'd-block' : 'd-none'); ?>">
                            <?php echo e(Form::label('trial_days', __('Trial Days'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::number('trial_days',null, ['class' => 'form-control trial_days','placeholder' => __('Enter Trial days'),'step' => '1','min'=>'1'])); ?>

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <?php if(isset($modules) && count($modules) > 0): ?>
                    <div class="all-plans">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="h4 m-0"><?php echo e(__('Select Module')); ?></h3>
                            <div class="col-md-2">
                                <input type="text" id="addon-search" placeholder="<?php echo e(__('Search Modules')); ?>" class="form-control btn-badge">
                            </div>
                        </div>
                        <hr>
                        <div class="plan-module">
                            <div class="row" id="addon-list">
                                <?php if(isset($modules) && count($modules)): ?>
                                    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php if(in_array($module->name, getshowModuleList())): ?>
                                            <div class="col-xl-4 col-lg-6 col-md-6 addon-item">
                                                <div class="card">
                                                    <div class="card-body p-3 border border-primary">
                                                        <div class="gap-2 d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <div class="p-3 border border-primary img-checkbox" data-checkbox="modules_<?php echo e($module->name); ?>">
                                                                    <div class="theme-avtar">
                                                                        <img src="<?php echo e($module->image); ?><?php echo e('?' . time()); ?>" alt="<?php echo e($module->name); ?>" class="img-user" style="max-width: 100%">
                                                                    </div>
                                                                </div>
                                                                <div class="ms-3">
                                                                    <label for="modules_<?php echo e($module->name); ?>">
                                                                        <h5 class="mb-0 pointer"><?php echo e(ucwords($module->alias)); ?></h5>
                                                                    </label>
                                                                    <p class="text-muted text-sm mb-0">
                                                                        <?php echo e(isset($module->description) ? $module->description : ''); ?>

                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input modules" name="modules[]" value="<?php echo e($module->name); ?>" id="modules_<?php echo e($module->name); ?>" type="checkbox"  <?php echo e(in_array($module->name,explode(',',$plan->modules)) == true ? 'checked' : ''); ?>>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="card p-5">
                                            <div class="d-flex justify-content-center">
                                                <div class="ms-3 text-center">
                                                    <h3><?php echo e(__('Add-on Not Available')); ?></h3>
                                                    <p class="text-muted"><?php echo e(__('Click ')); ?><a href="<?php echo e(route('module.index')); ?>"><?php echo e(__('here')); ?></a> <?php echo e(__('To Activate Add-on')); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="select-themes mt-4">
                        <div class="horizontal mt-3">
                            <div class="verticals twelve">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h3 class="h4 m-0"><?php echo e(__('Select Themes')); ?></h3>
                                    <div class="col-md-2">
                                        <input type="text" id="theme-search" placeholder="<?php echo e(__('Search Themes')); ?>" class="form-control btn-badge mt-3">
                                    </div>
                                </div>
                                <hr>
                                <ul class="uploaded-pics p-3" id="theme-list">
                                    <div class="row">
                                    <?php $__currentLoopData = $theme; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            if(in_array($v->theme_id,$plan->getThemes())){
                                                $checked = 'checked';
                                            }else{
                                                $checked = '';
                                            }
                                        ?>
                                        <li class="col-xxl-3 col-xl-4 col-md-6 theme-item">
                                            <input type="checkbox" id="checkthis<?php echo e($key); ?>" value="<?php echo e($v->theme_id); ?>" name="themes[]"  <?php echo e($checked); ?>/>
                                            <label for="checkthis<?php echo e($key); ?>">
                                                <span class="theme-label"><?php echo e(ucfirst($v->theme_id)); ?></span>
                                                <img src="<?php echo e(asset('themes/'.$v->theme_id.'/theme_img/img_1.png')); ?>" />
                                            </label>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <?php echo e(Form::label('description', __('Description'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::textarea('description', null, ['class' => 'form-control','id' => 'description','rows' => 2,'placeholder' => __('Enter Description')])); ?>

                    </div>
                </div>

                <div class="form-group col-12 d-flex justify-content-end form-label">
                    <a href="<?php echo e(route('plan.index')); ?>"class="btn btn-secondary"><?php echo e(__('Back')); ?> </a>
                    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary ms-2">
                </div>
            </div>
        </div>
    </div>
</div>


<?php echo Form::close(); ?>



<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-script'); ?>
    <script>
        $(document).on('change', '#trial', function() {
            if ($(this).is(':checked')) {
                $('.plan_div').removeClass('d-none');
                $('#trial_days').attr("required", true);

            } else {
                $('.plan_div').addClass('d-none');
                $('#trial_days').removeAttr("required");
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.img-checkbox').forEach(function(element) {
                element.addEventListener('click', function() {
                    const checkboxId = this.getAttribute('data-checkbox');
                    const checkbox = document.getElementById(checkboxId);
                    checkbox.checked = !checkbox.checked;
                });
            });
        });

        $(document).on('keyup','#theme-search', function() {
            var value = $(this).val().toLowerCase();
            $('#theme-list .theme-item').filter(function() {
                $(this).toggle($(this).find('.theme-label').text().toLowerCase().indexOf(value) > -1)
            });
        });

        $(document).on('keyup','#addon-search', function() {
            var value = $(this).val().toLowerCase();
            $('#addon-list .addon-item').filter(function() {
                $(this).toggle($(this).find('h5').text().toLowerCase().indexOf(value) > -1)
            });
        });
    </script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce-pos\resources\views/plans/edit.blade.php ENDPATH**/ ?>