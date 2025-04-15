<?php $__env->startSection('page-title', __('Users')); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="text-end d-flex flex-wrap all-button-box align-items-center btn-badge justify-content-md-end justify-content-center gap-1">
        <a href="<?php echo e(route('store.subdomain')); ?>" class="btn btn-sm btn-primary btn-icon" data-bs-toggle="tooltip"
            data-bs-placement="top" title="<?php echo e(__('Sub Domain')); ?>"><?php echo e(__('Sub Domain')); ?></a>

        <a href="<?php echo e(route('store.customdomain')); ?>" class="btn btn-sm btn-primary btn-badge btn-icon" data-bs-toggle="tooltip"
            data-bs-placement="top" title="<?php echo e(__('Custom Domain')); ?>"><?php echo e(__('Custom Domain')); ?></a>

        <a href="<?php echo e(route('store.list')); ?>" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('List View')); ?>" class="btn btn-sm btn-primary btn-icon ">
            <i class="ti ti-list"></i>
        </a>
        <a href="javascript::void(0)" class="btn btn-sm btn-primary btn-badge btn-icon" data-ajax-popup="true" data-size="md"
            data-title="<?php echo e(__('Create New User')); ?>" data-url="<?php echo e(route('store.user.create')); ?>" data-bs-toggle="tooltip"
            title="<?php echo e(__('Add New User')); ?>">
            <i class="ti ti-plus"></i>
        </a>
         <!-- Search Input -->
         <input type="text" id="user-search" class="form-control btn-badge user-search" placeholder="<?php echo e(__('Search Users')); ?>" style="width: 200px;">
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><?php echo e(__('Users')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="delivery-user-cards mb-4">
    <div class="row">
        <div class="col-xxl-12">
            <div class="row" id="user-list">
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-3 col-md-4 col-sm-6 col-12 user-card">
                        <div class="card text-center card-2 mb-0 h-100">
                            <div class="card-inner">
                                <div class="card-header border-0 pb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">
                                            <?php if(auth()->user()->type == 'super admin'): ?>
                                                <?php if(!empty($user->currentPlan)): ?>
                                                    <div class="badge bg-primary p-2 px-3 rounded-1">
                                                        <?php echo e(!empty($user->currentPlan) ? $user->currentPlan->name : ''); ?>

                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="badge bg-primary p-2 px-3 rounded-1">
                                                    <?php echo e(ucfirst($user->type)); ?>

                                                </div>
                                            <?php endif; ?>
                                        </h6>
                                    </div>
                                    <div class="card-header-right">
                                        <div class="btn-group card-option">
                                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-end">

                                                <?php if(auth()->user()->type == 'super admin'): ?>
                                                    <a href="#!" data-size="md"
                                                        data-url="<?php echo e(route('users.edit', $user->id)); ?>" data-ajax-popup="true"
                                                        class="dropdown-item" data-title="<?php echo e(__('Edit User')); ?>"
                                                        title="<?php echo e(\Auth::user()->type == 'super admin' ? __('Edit User') : __('Edit User')); ?>">
                                                        <i class="ti ti-pencil"></i>
                                                        <span><?php echo e(__('Edit')); ?></span>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if(auth()->user()->type == 'super admin'): ?>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'class' => 'd-inline']); ?>

                                                    <a href="#" class="dropdown-item bs-pass-para show_confirm" data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                        data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>" data-text-yes="<?php echo e(__('Yes')); ?>" data-text-no="<?php echo e(__('No')); ?>" 
                                                        data-confirm-yes="delete-form-<?php echo e($user->id); ?>">
                                                        <i class="ti ti-trash"></i>
                                                        <span> <?php echo e(__('Delete')); ?></span>
                                                    </a>
                                                    <?php echo Form::close(); ?>

                                                <?php endif; ?>

                                                <?php if(auth()->user()->type == 'super admin'): ?>
                                                    <a href="<?php echo e(route('login.with.admin', $user->id)); ?>" class="dropdown-item"
                                                        data-bs-original-title="<?php echo e(__('Login As Company')); ?>">
                                                        <i class="ti ti-replace"></i>
                                                        <span> <?php echo e(__('Login As Admin')); ?></span>
                                                    </a>
                                                <?php endif; ?>

                                                <a href="#" class="dropdown-item"
                                                    data-url="<?php echo e(route('stores.link', $user->id)); ?>" data-size="md"
                                                    data-ajax-popup="true" data-title="<?php echo e(__('Store Links')); ?>">
                                                    <i class="ti ti-unlink py-1" data-bs-toggle="tooltip"
                                                        title="Store Links"></i>
                                                    <span> <?php echo e(__('Store Link')); ?></span>
                                                </a>


                                                <a href="#"
                                                    data-url="<?php echo e(route('stores.reset.password', \Crypt::encrypt($user->id))); ?>"
                                                    data-ajax-popup="true" data-size="md" class="dropdown-item"
                                                    data-bs-original-title="<?php echo e(__('Reset Password')); ?>"
                                                    data-title="<?php echo e(__('Reset Password')); ?>"
                                                    title="<?php echo e(__('Reset Password')); ?>">
                                                    <i class="ti ti-adjustments"></i>
                                                    <span> <?php echo e(__('Reset Password')); ?></span>
                                                </a>

                                                <?php if($user->is_enable_login == 1): ?>
                                                    <a href="<?php echo e(route('users.enable.login', \Crypt::encrypt($user->id))); ?>"
                                                        class="dropdown-item">
                                                        <i class="ti ti-road-sign"></i>
                                                        <span class="text-danger"> <?php echo e(__('Login Disable')); ?></span>
                                                    </a>
                                                <?php elseif($user->is_enable_login == 0 && $user->password == null): ?>
                                                    <a href="<?php echo e(route('users.enable.login', \Crypt::encrypt($user->id))); ?>"
                                                        class="dropdown-item">
                                                        <i class="ti ti-road-sign"></i>
                                                        <span class="text-success"> <?php echo e(__('Login Enable')); ?></span>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('users.enable.login', \Crypt::encrypt($user->id))); ?>"
                                                        class="dropdown-item">
                                                        <i class="ti ti-road-sign"></i>
                                                        <span class="text-success"> <?php echo e(__('Login Enable')); ?></span>
                                                    </a>
                                                <?php endif; ?>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body full-card">
                                    <div class="img-fluid rounded-circle card-avatar">
                                        <img src="<?php echo e(!empty($user->profile_image) ? asset($user->profile_image) : asset('storage/uploads/profile/avatar.png')); ?>"
                                            class="img-user wid-80 round-img rounded-circle">
                                    </div>
                                    <h4 class=" mt-3 text-primary"><?php echo e($user->name); ?></h4>
                                    <small class="text-primary"><?php echo e($user->email); ?></small>
                                    <p></p>
                                    <div class="text-center" data-bs-toggle="tooltip" title="<?php echo e(__('Last Login')); ?>">

                                    </div>
                                    <?php if(\Auth::user()->type == 'super admin'): ?>
                                        <div class="mt-4">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-12 d-flex flex-wrap align-items-center gap-2 justify-content-center">
                                                    <div>
                                                        <a href="#" data-url="<?php echo e(route('plan.upgrade', $user->id)); ?>"
                                                            data-size="lg" data-ajax-popup="true"
                                                            class="btn btn-outline-primary btn-badge"
                                                            data-title="<?php echo e(__('Upgrade Plan')); ?>"><?php echo e(__('Upgrade Plan')); ?></a>
                                                    </div>
                                                    <div>
                                                        <a href="#" data-url="<?php echo e(route('user.info', $user->id)); ?>"
                                                            data-size="lg" data-ajax-popup="true"
                                                            class="btn btn-outline-primary btn-badge"
                                                            data-title="<?php echo e(__('Company Info')); ?>"><?php echo e(__('AdminHub')); ?></a>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <hr class="my-3">
                                                </div>
                                                <div class="col-12 text-center pb-2">
                                                    <span class="text-dark"><?php echo e(__('Plan Expired : ')); ?>

                                                        <?php echo e(!empty($user->plan_expire_date)? auth()->user()->dateFormat($user->plan_expire_date): __('Lifetime')); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <p class="text-muted text-sm mb-0" data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('Users')); ?>"><i
                                                        class="ti ti-users card-icon-text-space"></i><?php echo e($user->totalStoreUser($user->id)); ?>

                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p class="text-muted text-sm mb-0" data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('Customers')); ?>"><i
                                                        class="ti ti-users card-icon-text-space"></i><?php echo e($user->totalStoreCustomer($user->current_store)); ?>

                                                </p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if(auth()->guard('web')->check()): ?>
                    <div class="col-xl-3 col-md-4 col-sm-6 col-12">
                        <?php if (app('laratrust')->hasPermission('Create User')) : ?>
                            <a class="btn-addnew-project" data-url="<?php echo e(route('store.user.create')); ?>" data-title="<?php echo e(__('Create New User')); ?>" data-ajax-popup="true" style="cursor: pointer;" >
                                <div class="btn btn-sm btn-primary btn-badge btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Add New User')); ?>">
                                    <i class="ti ti-plus"></i>
                                </div>
                                <h6 class="mt-4 mb-2"><?php echo e(__('Create New User')); ?></h6>
                                <p class="text-muted text-center"><?php echo e(__('Click here to Add New User')); ?></p>
                            </a>
                        <?php endif; // app('laratrust')->permission ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php echo $users->links('layouts.global-pagination'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('custom-script'); ?>
<script type="text/javascript">
    function myFunction(id) {
        var copyText = document.getElementById(id);
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        show_toastr('Success', "<?php echo e(__('Link copied')); ?>", 'success');
    }

    $(document).on('change', '.active-store-index',function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var id = $(this).data('id');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "<?php echo e(route('store.active.status')); ?>",
            data: {'status': status, 'id': id},
            success: function(data){
                $('#loader').fadeOut();
                if (data.status != 'success') {
                    show_toastr('Error', data.message, 'error');
                } else {
                    show_toastr('Success', data.message, 'success');
                }
            }
        });
    });

    $(document).on('keyup', '#user-search', function() {
        var searchValue = $(this).val().toLowerCase();
        
        $('#user-list .user-card').filter(function() {
            $(this).toggle($(this).find('.card-body h4').text().toLowerCase().indexOf(searchValue) > -1 || 
                           $(this).find('.card-body small').text().toLowerCase().indexOf(searchValue) > -1);
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce-pos\resources\views/store/index.blade.php ENDPATH**/ ?>