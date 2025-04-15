<!--Start System Setting-->
<div class="card" id="System_Setting">
    <div class="card-header">
        <h5 class=""> <?php echo e(__('System Settings')); ?> </h5>
    </div>
    <?php echo e(Form::open(['route' => 'system.settings', 'method' => 'post', 'enctype' => 'multipart/form-data'])); ?>

    <?php echo e(Form::model($setting, ['route' => 'system.settings', 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

    <div class="card-body p-4">
        
            <div class="row">
                <div class="col-md-6 col-12 form-group">
                    <?php echo e(Form::label('default_language', __('Default Language'), ['class' => 'form-label'])); ?>

                    <div class="changeLanguage">
                        <select name="default_language" id="default_language" class="form-control" data-toggle="select">
                            <?php $__currentLoopData = \App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php if(\Auth::user()['default_language']==$code): ?> selected <?php endif; ?> value="<?php echo e($code); ?>">
                                <?php echo e(ucFirst($language)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class=" col-md-6 col-12 form-group">
                    <?php echo e(Form::label('defult_timezone', __('Default Timezone'), ['class' => 'form-label'])); ?>

                    <select name="defult_timezone" id="defult_timezone" class="form-control">
                        <option value="" <?php if(isset($setting['defult_timezone']) && $setting['defult_timezone']=='' ): ?> selected="selected" <?php endif; ?>>
                            <?php echo e(__('Select Timezone')); ?></option>
                            <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php if(isset($setting['defult_timezone']) && $setting['defult_timezone'] == $key ): ?> selected="selected" <?php endif; ?>>
                            <?php echo e(ucFirst($timezone)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class=" col-md-6 col-12 form-group">
                    <label for="site_date_format" class="form-label"><?php echo e(__('Date Format')); ?></label>
                    <select type="text" name="site_date_format" class="form-control" data-toggle="select" id="site_date_format">
                        <option value="M j, Y" <?php if(isset($setting['site_date_format']) && $setting['site_date_format']=='M j, Y' ): ?> selected="selected" <?php endif; ?>>
                            <?php echo e(__('Jan 1,2015')); ?></option>
                        <option value="d-m-Y" <?php if(isset($setting['site_date_format']) && $setting['site_date_format']=='d-m-Y' ): ?> selected="selected" <?php endif; ?>>
                            <?php echo e(__('DD-MM-YYYY')); ?></option>
                        <option value="m-d-Y" <?php if(isset($setting['site_date_format']) && $setting['site_date_format']=='m-d-Y' ): ?> selected="selected" <?php endif; ?>>
                            <?php echo e(__('MM-DD-YYYY')); ?></option>
                        <option value="Y-m-d" <?php if(isset($setting['site_date_format']) && $setting['site_date_format']=='Y-m-d' ): ?> selected="selected" <?php endif; ?>>
                            <?php echo e(__('YYYY-MM-DD')); ?></option>
                    </select>
                </div>

                <div class="col-md-6 col-12 form-group">
                    <label for="site_time_format" class="form-label"><?php echo e(__('Time Format')); ?></label>
                    <select type="text" name="site_time_format" class="form-control" data-toggle="select" id="site_time_format">
                        <option value="g:i A" <?php if(isset($setting['site_time_format']) && $setting['site_time_format']=='g:i A' ): ?> selected="selected" <?php endif; ?>>
                            <?php echo e(__('10:30 PM')); ?></option>
                        <option value="g:i a" <?php if(isset($setting['site_time_format']) && $setting['site_time_format']=='g:i a' ): ?> selected="selected" <?php endif; ?>>
                            <?php echo e(__('10:30 pm')); ?></option>
                        <option value="H:i" <?php if(isset($setting['site_time_format']) && $setting['site_time_format']=='H:i' ): ?> selected="selected" <?php endif; ?>>
                            <?php echo e(__('22:30')); ?></option>
                    </select>
                </div>
            </div>        
    </div>
    <div class="card-footer d-flex justify-content-end flex-wrap ">
        <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn-badge btn-submit btn btn-primary">
    </div>
    <?php echo Form::close(); ?>

</div>
<!--End System Setting--><?php /**PATH C:\xampp\htdocs\ecommerce-pos\resources\views/setting/system_setting.blade.php ENDPATH**/ ?>