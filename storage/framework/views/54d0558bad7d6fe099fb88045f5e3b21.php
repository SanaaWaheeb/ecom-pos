<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Add New Modules')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Modules')); ?>,<?php echo e(__('Add New Addon')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/dropzone.css')); ?>" type="text/css" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('module.index')); ?>"><?php echo e(__('Add-on Manager')); ?></a></li>    
    <li class="breadcrumb-item"><?php echo e(__('Add New Addon')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-xxl-8">
            <div class="card">
                <div class="card-body">
                    <section>
                        <!-- Add the dropdown for selecting the upload type -->
                        <div class="form-group">
                            <label class="form-label" for="uploadType"><?php echo e(__('Select Upload Type')); ?></label>
                            <select id="uploadType" class="form-control">
                                <option value="<?php echo e(route('module.install')); ?>"><?php echo e(__('Add Addon')); ?></option>
                                <option value="<?php echo e(route('addon.theme')); ?>"><?php echo e(__('Add New Theme')); ?></option>
                            </select>
                        </div>

                        <div id="dropzone">
                            <form class="dropzone needsclick" id="demo-upload">
                                <div class="dz-message needsclick">
                                    <?php echo e(__('Drop files here or click to upload and install.')); ?><br>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/dropzone.js')); ?>"></script>

    <script>
        Dropzone.autoDiscover = false;
        
        // Initialize Dropzone
        var dropzone = new Dropzone('#demo-upload', {
            thumbnailHeight: 120,
            thumbnailWidth: 120,
            maxFilesize: 500,
            acceptedFiles: '.zip',
            url: $('#uploadType').val(), // Initial URL based on default selection
            success: function(file, response) {
                $('#loader').fadeOut();
                if (response.status == 'success') {
                    show_toastr('Success', response.message, 'success');
                    // setTimeout(() => {
                    //     window.location.href = "<?php echo e(route('module.index')); ?>";
                    // }, 1000);
                } else {
                    show_toastr('Error', response.message, 'error');
                }
            }, 
            error: function(file, errorResponse) {
                $('#loader').fadeOut(); // Ensure the loader is hidden

                // Show appropriate error message
                let errorMessage = (errorResponse?.message || "<?php echo e(__('An error occurred during file upload.')); ?>");
                show_toastr('Error', errorMessage, 'error');
            }
        });

        // Update URL when the selected option changes
        $('#uploadType').change(function() {
            dropzone.options.url = $(this).val();
        });

        dropzone.on('sending', function(file, xhr, formData) {
            formData.append('_token', "<?php echo e(csrf_token()); ?>");
            $('#loader').fadeIn();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce-pos\resources\views/module/add.blade.php ENDPATH**/ ?>