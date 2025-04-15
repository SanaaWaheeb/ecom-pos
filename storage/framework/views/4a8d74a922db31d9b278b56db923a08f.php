<div class="table-responsive ecom-data-table">
<table class="table dataTable">
    <thead>
        <tr>
            <th><?php echo e(__('Store Name')); ?></th>
            <th><?php echo e(__('Active/Deactive')); ?></th>
            <th class="text-end"><?php echo e(__('Store Links')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($store->name); ?></td>
                <td>
                    <div class="form-check form-switch">
                        <input type="checkbox" data-id="<?php echo e($store->id); ?>"  class="form-check-input active-store-index" name="is_popular"
                        id="active_store_<?php echo e($store->id); ?>" value="<?php echo e($store->is_active); ?>" <?php echo e($store->is_active ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="active_store_<?php echo e($store->id); ?>"></label>
                    </div>
                </td>
                <td class="text-end">
                    <input type="text" value="<?php echo e(route('landing_page', $store->slug)); ?>" id="myInput_<?php echo e($store->slug); ?>"
                        class="form-control d-inline-block theme-link" aria-label="Recipient's username"
                        aria-describedby="button-addon2" readonly>
                    <button class="btn btn-outline-primary btn-badge" type="button"
                        onclick="myFunction('myInput_<?php echo e($store->slug); ?>')" id="button-addon2"><i
                            class="far fa-copy"></i>
                        <?php echo e(__('Store Link')); ?></button>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</div>
<?php /**PATH C:\xampp\htdocs\ecommerce-pos\resources\views/store/view-storelinks.blade.php ENDPATH**/ ?>