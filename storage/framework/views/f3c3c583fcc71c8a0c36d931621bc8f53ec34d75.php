

<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="<?php echo e(asset ('assets/css/dashboard/dashboard.css')); ?>">

<div class="main">
    
    <div class="row m-auto p-3">
        <h1 class="text-center">Admin Dashboard</h1>
        <div class="col-sm-6 col-xl-4 p-3">
            <a href="/members" class="card navigation-section p-3">
                <img class="card-img-icon" width="64" height="64" src="https://img.icons8.com/external-flaticons-lineal-color-flat-icons/64/external-members-agile-flaticons-lineal-color-flat-icons.png" alt="external-members-agile-flaticons-lineal-color-flat-icons"/>
                <div class="card-body">
                    <h5 class="card-title">Members Management</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-4 p-3">
            <a href="/contents" class="card navigation-section p-3">
                <img class="card-img-icon" width="64" height="64" src="https://img.icons8.com/dusk/64/overview-pages-1.png" alt="overview-pages-1"/>
                <div class="card-body">
                    <h5 class="card-title">Content Management</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-4 p-3">
            <a href="/education" class="card navigation-section p-3">
                <img class="card-img-icon" width="64" height="64" src="https://img.icons8.com/bubbles/50/book-and-pencil.png" alt="external-members-agile-flaticons-lineal-color-flat-icons"/>
                <div class="card-body">
                    <h5 class="card-title">Education Management</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-4 p-3">
            <div class="card navigation-section p-3">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4 p-3">
            <div class="card navigation-section p-3">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4 p-3">
            <div class="card navigation-section p-3">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('header.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin-IT\Desktop\tru-international\tru-CMS\resources\views/dashboard.blade.php ENDPATH**/ ?>