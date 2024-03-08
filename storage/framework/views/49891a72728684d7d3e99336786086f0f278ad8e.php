

<?php $__env->startSection('content'); ?>


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
                        <div class="navigation-link text-white fw-bold ms-5 mb-2" onclick="toggleToUserProfile()">User Profile Management</div>
                        <div class="navigation-link text-white fw-bold ms-5 mb-2" onclick="toggleToUserDetails()">Additional Details Management</div>
                        <div class="navigation-link text-white fw-bold ms-5 mb-2 nav-active">Security Management</div>
                    </div>

                    <div class="text-center mt-5">
                        <button type="button" class="btn btn-danger fw-bold text-white">DELETE USER</button>
                    </div>

                </div>

                <div class="col-8 profile-info-div py-3 px-5">
                    <h1>Security Management</h1>
                    <hr>
                    <div class="row p-3">

                        <div class="input-form mb-3 col-12">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control password-input" id="password" name="password" aria-describedby="emailHelp" required autofocus placeholder="password" disabled>
                        </div>

                        <div class="input-form mb-3 col-12">
                            <label for="email" class="form-label">Security Question 1</label>
                            <input type="email" class="form-control email-input" id="email" name="email" aria-describedby="emailHelp" required autofocus placeholder="email" disabled>
                        </div>

                        <div class="input-form mb-3 col-12">
                            <label for="email" class="form-label">Security Question 2</label>
                            <input type="email" class="form-control email-input" id="email" name="email" aria-describedby="emailHelp" required autofocus placeholder="email" disabled>
                        </div>


                        <div class="d-flex btn-update-div">
                            <button id="toggleUpdateButton" onclick="toggleToUpdate()" class="btn btn-warning text-white fw-bold ms-auto">Update</button>
                        </div>
                        <div class="d-flex gap-2 d-none btn-update-save-div">
                            <button id="CancelButton" onclick="UpdateCancel()" class="btn btn-secondary text-white fw-bold ms-auto">Cancel</button>
                            <button id="SaveButton" onclick="SaveUpdate()" class="btn btn-primary text-white fw-bold">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script src="<?php echo e(asset ('assets/js/country.js')); ?>"></script>

<script>

    document.addEventListener("DOMContentLoaded", () => {
        handleUserData();
    })

    // Get the current URL
    const url = window.location.href;

    // Split the URL by '/'
    const parts = url.split('/');

    // Get the last part of the URL which should be the id
    const id = parts[parts.length - 1];


    function handleUserData() {
        fetch(`/api/members/user-profile/${id}`)
            .then(response => response.json())
            .then(data => {
                console.log(data.user)
                document.getElementById('first_name').value = data.user.first_name;
                document.getElementById('last_name').value = data.user.last_name;
                document.getElementById('email').value = data.user.email;
                document.getElementById('date_of_birth').value = data.user.date_of_birth;
                document.getElementById('country').value = data.user.country;
                document.getElementById('phone').value = data.user.phone;

                // Handle User Management radio buttons
                if (data.user.block_flg === 0) {
                    document.getElementById('flexRadioDefault1').checked = true;
                } else {
                    document.getElementById('flexRadioDefault2').checked = true;
                }
            })
            .catch(error => console.error('Error fetching members:', error));
    }

    function toggleToUpdate() {
        // Hide the update button and show the save/cancel buttons
        document.querySelector('.btn-update-div').classList.add('d-none');
        document.querySelector('.btn-update-save-div').classList.remove('d-none');
        
        // Enable input fields
        document.querySelectorAll('.input-form input, .input-form select').forEach(input => {
            input.removeAttribute('disabled');
        });
    }

    function UpdateCancel() {
        // Show the update button and hide the save/cancel buttons
        document.querySelector('.btn-update-div').classList.remove('d-none');
        document.querySelector('.btn-update-save-div').classList.add('d-none');
        
        // Reset input fields to their original values
        handleUserData();
        
        // Disable input fields
        document.querySelectorAll('.input-form input, .input-form select').forEach(input => {
            input.setAttribute('disabled', 'disabled');
        });
    }


    function SaveUpdate() {
        // Gather values from input fields
        const firstName = document.getElementById('first_name').value;
        const lastName = document.getElementById('last_name').value;
        const email = document.getElementById('email').value;
        const dateOfBirth = document.getElementById('date_of_birth').value;
        const country = document.getElementById('country').value;
        const phone = document.getElementById('phone').value;

        // Get the value of the selected radio button
        let blockFlag;
        if (document.getElementById('flexRadioDefault1').checked) {
            blockFlag = 0;
        } else {
            blockFlag = 1;
        }

        // Prepare data object to send to the server
        const userData = {
            first_name: firstName,
            last_name: lastName,
            email: email,
            date_of_birth: dateOfBirth,
            country: country,
            phone: phone,
            block_flg: blockFlag
        };

        console.table(userData);

        fetch(`/api/members/user-update/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json', // Set content type to JSON
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(userData) // Convert userData to JSON string before sending
        })
        .then(response => response.json())
        .then(data => {
            // Handle success
            console.log(data);
            // Remove red border from email input
            document.getElementById('email').style.border = '';
            // Remove red border from phone input
            document.getElementById('phone').style.border = '';

            if (data == 0) {
                alert("The User Information is Successfully Changed.");
                UpdateCancel();
            } else if (data == 1) {
                alert("Email already exists.");
                // Add red border to email input
                document.getElementById('email').style.border = '1px solid red';
            } else if (data == 2) {
                alert("Phone number already exists.");
                // Add red border to phone input
                document.getElementById('phone').style.border = '1px solid red';
            }
            // If you want to redirect or do something else after successful update
        })
        .catch(error => {
            // Handle error
            console.error('Error updating user:', error);
        });
    }

    function toggleToUserProfile() {
        console.log(id);
        // Extract the user ID from the URL
        // Navigate to the user details page
        window.location.href = `/members/user-profile/${id}`;
    }

    function toggleToUserDetails() {
        console.log(id);
        // Extract the user ID from the URL
        // Navigate to the user details page
        window.location.href = `/members/user-details/${id}`;
    }

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('header.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin-IT\Desktop\tru-international\example-app\resources\views/member/user_security.blade.php ENDPATH**/ ?>