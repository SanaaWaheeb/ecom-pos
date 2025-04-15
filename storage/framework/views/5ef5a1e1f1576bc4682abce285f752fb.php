     <?php $__currentLoopData = $landing_blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <div class="article-card card">

             <div class="article-card-inner">
                 <a href="<?php echo e(route('page.article', ['storeSlug' => $slug, 'id' => $blog->id])); ?>" class="img-wraper">
                     <img src="<?php echo e(get_file($blog->cover_image_path, $currentTheme)); ?>" alt="card-img">
                 </a>
                 <div class="card-content blog-caption">
                 <span><?php echo e($blog->category->name); ?></span>
                     <h3><a href="<?php echo e(route('page.article', ['storeSlug' => $slug, 'id' => $blog->id])); ?>">
                             <?php echo e($blog->title); ?></b> </a></h3>
                     <p class="description"><?php echo e($blog->short_description); ?></p>
                     <span class="date"> <a href="#">@john</a> • <?php echo e($blog->created_at->format('d M, Y ')); ?></span>
                     <a href="<?php echo e(route('page.article', ['storeSlug' => $slug, 'id' => $blog->id])); ?>"
                         class="common-btn"><?php echo e(__(' Read More')); ?></a>
                 </div>
             </div>
         </div>
     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\xampp\htdocs\ecommerce-pos\themes\minimarket\views/front_end/sections/homepage/blog_slider.blade.php ENDPATH**/ ?>