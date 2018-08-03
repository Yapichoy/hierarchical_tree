<?php $__env->startSection('title', 'Главная страница'); ?>
<?php $__env->startSection('content'); ?>
        <?php $__currentLoopData = $first_layers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $first_layer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row mt-1">
            <div class="employee">
                <?php echo $__env->make('template.employee',['_layer'=>$first_layer], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
               <?php if(isset($second_layers[$first_layer['id']])): ?>
                    <?php $__currentLoopData = $second_layers[$first_layer['id']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $second_layer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="employee cli" id = <?php echo e($second_layer['id']); ?>>
                           <?php echo $__env->make('template.employee',['_layer'=>$second_layer], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>

        </div>
        <hr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php echo e($first_layers->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>