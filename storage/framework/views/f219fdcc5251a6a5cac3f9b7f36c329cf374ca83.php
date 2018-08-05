<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title'); ?></title>

    <!-- Styles -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="/css/main.css">


    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
    <body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Hierarchical Tree</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a class="nav-link" href="<?php echo e(url('/')); ?>">Главная</a></li>
                    <?php if(auth()->guard()->guest()): ?>

                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('login')); ?>">Войти</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('register')); ?>">Регистрация</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/list')); ?>">Список</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/employee/create')); ?>">Добавить сотрудника</a></li>
                        <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('logout')); ?>"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <?php echo e(__('Logout')); ?>

                                </a>

                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                    <?php echo csrf_field(); ?>
                                </form>
                        </li>
                        <?php endif; ?>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    <!-- Scripts -->
 
    <script
            src="http://code.jquery.com/jquery-1.7.2.min.js"
            integrity="sha256-R7aNzoy2gFrVs+pNJ6+SokH04ppcEqJ0yFLkNGoFALQ="
            crossorigin="anonymous"></script>
        <script src="/js/bootstrap.min.js"></script>
        
    <script src="/js/main.js"></script>
    </body>
</html>