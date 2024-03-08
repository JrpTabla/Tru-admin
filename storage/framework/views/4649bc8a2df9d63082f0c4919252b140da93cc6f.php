<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tru Admin | Profile</title>

    <link rel="stylesheet" href="<?php echo e(asset ('assets/css/bootstrap.css')); ?>">

</head>
<body>


<link rel="stylesheet" href="<?php echo e(asset ('assets/css/dashboard/user_profile.css')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">



    <div class="main mx-auto">
        <div class="w-100 p-3">
            <nav aria-label="breadcrumb m-3 ">
                <ol class="breadcrumb p-3">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/members">Members Management</a></li>
                    <li class="breadcrumb-item active fw-bold" aria-current="page">User Profile</li>
                </ol>
            </nav>

            <div class="user-details row my-5">
                <div class="col-4 profile-nav-div p-5">
                    <div class="w-100 d-flex profile-img-div">
                        <img class="mx-auto profile-img" src="<?php echo e(asset ('assets/images/user_profile/user_profile_img.png')); ?>" alt="user-male-circle--v1"/>
                    </div>
                    <div class="mt-3">
                        <h2 class="text-white fw-bold text-center Fullname" id="Fullname"></h2>
                    </div>
                    <div class="mt-5 navigation-div w-100">
                        <div class="navigation-link text-white fw-bold ms-5 mb-2 nav-active">User Profile Management</div>
                        <div class="navigation-link text-white fw-bold ms-5 mb-2">Additional Details</div>
                        <div class="navigation-link text-white fw-bold ms-5 mb-2">Security Management</div>
                    </div>

                    <div class="text-center mt-5">
                        <button type="button" class="btn btn-danger fw-bold text-white">DELETE USER</button>
                    </div>

                </div>

                <?php echo $__env->yieldContent('content'); ?>   

            </div>
        </div>
    </div>

    
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            UserData();
        })

        // Get the current URL
        const url = window.location.href;

        // Split the URL by '/'
        const parts = url.split('/');

        // Get the last part of the URL which should be the id
        const id = parts[parts.length - 1];


        function UserData() {
            fetch(`/api/members/user-profile/${id}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data.user);
                    const fullName = data.user.full_name.split(' ');
                    const firstName = fullName.slice(0, -1).join(' ');
                    const lastName = fullName.slice(-1).join(' ');

                    const fullNameElement = document.getElementById('Fullname');
                    fullNameElement.textContent = firstName + ' ' + lastName;
                })
                .catch(error => console.error('Error fetching members:', error));
        }

    </script>

    <script src="<?php echo e(asset ('assets/js/bootstrap.js')); ?>"></script>
</body>
</html><?php /**PATH C:\Users\Admin-IT\Desktop\tru-international\example-app\resources\views/header/user_profile_header.blade.php ENDPATH**/ ?>