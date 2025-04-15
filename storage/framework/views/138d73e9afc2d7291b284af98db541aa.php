<?php echo Form::open(['route' => 'stores.store', 'method' => 'post', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']); ?>


    <?php if((auth()->user()->type == 'super admin') && (!empty($setting['chatgpt_key']))): ?>
        <div class="d-flex justify-content-end">
            <a href="#" class="btn btn-primary ai-btn btn-badge" data-size="lg" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['store'])); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Generate')); ?>" data-title="<?php echo e(__('Generate Content With AI')); ?>">
                <i class="fas fa-robot"></i> <?php echo e(__('Generate with AI')); ?>

            </a>
        </div>
    <?php endif; ?>

    <?php if((auth()->user()->type == 'admin') && $plan && ($plan->enable_chatgpt == 'on')): ?>
        <div class="d-flex justify-content-end">
            <a href="#" class="btn btn-primary ai-btn btn-badge" data-size="lg" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['store'])); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Generate')); ?>" data-title="<?php echo e(__('Generate Content With AI')); ?>">
                <i class="fas fa-robot"></i> <?php echo e(__('Generate with AI')); ?>

            </a>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="form-group col-md-12">
            <?php echo Form::label('storename', __('Store Name'), ['class' => 'form-label']); ?>

            <?php echo Form::text('storename', null, ['class' => 'form-control', 'id' => 'storename', 'placeholder' =>__('Enter Store Name'), 'required' => 'true']); ?>

        </div>

        <?php if(auth()->user()->type == 'super admin'): ?>
            <div class="form-group col-md-12">
                <?php echo Form::label('name', __('Name'), ['class' => 'form-label']); ?>

                <?php echo Form::text('name', null, ['class' => 'form-control','id'=>'name','placeholder'=>__('Enter Name'), 'required' => 'true']); ?>

            </div>
            <div class="form-group col-md-12">
                <?php echo Form::label('email', __('Email'), ['class' => 'form-label']); ?>

                <?php echo Form::email('email', null, ['class' => 'form-control','id'=>'email','placeholder' =>__('Enter Email'), 'required' => 'true']); ?>

            </div>
            <div class="form-group col-md-12">
                <?php echo Form::label('password', __('Password'), ['class' => 'form-label']); ?>

                <?php echo e(Form::password('password',array('class'=>'form-control','id'=>'password','placeholder' =>__('Enter Password'), 'required' => 'true'))); ?>

            </div>
        <?php endif; ?>

        <div class="modal-footer pb-0">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-badge btn-secondary" data-bs-dismiss="modal">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn btn-badge btn-primary mx-1">
        </div>
    </div>
<?php echo Form::close(); ?>

<?php /**PATH C:\xampp\htdocs\ecommerce-pos\resources\views/store/user-create.blade.php ENDPATH**/ ?>