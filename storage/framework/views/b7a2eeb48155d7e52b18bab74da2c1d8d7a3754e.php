<?php $__env->startSection('content'); ?>
    <div class="row">
    <div class="starter-template">
        <h1>Bootstrap starter template</h1>
        <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>