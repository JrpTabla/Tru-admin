<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tru Admin | Profile</title>

    <link rel="stylesheet" href="{{ asset ('assets/css/bootstrap.css') }}">

</head>
<body>


<link rel="stylesheet" href="{{ asset ('assets/css/dashboard/user_profile.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">



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
                        <img class="mx-auto profile-img" src="{{ asset ('assets/images/user_profile/user_profile_img.png') }}" alt="user-male-circle--v1"/>
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

                <div class="col-8 profile-info-div py-3 px-5">
                    <h1>Personal Information</h1>
                    <hr>
                    <div class="row p-3">

                        <div class="input-form mb-3 col-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" aria-describedby="emailHelp" required autofocus placeholder="First Name" disabled>
                        </div>

                        <div class="input-form mb-3 col-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" aria-describedby="emailHelp" required autofocus placeholder="Last Name" disabled>
                        </div>

                        <div class="input-form mb-3 col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control email-input" id="email" name="email" aria-describedby="emailHelp" required autofocus placeholder="email" disabled>
                        </div>

                        <div class="input-form mb-3 col-3">
                            <label for="date_of_birth" class="form-label">Date of birth</label>
                            <input type="date"  class="form-control" id="date_of_birth" name="date_of_birth" required disabled>
                        </div>

                        <div class="input-form mb-3 col-5">
                            <label for="country" class="form-label">Country</label>
                            <div class="d-flex">
                                <select class="form-select form-control" id="country" name="country" required disabled>
                                    <option value="" selected>Select Country</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-form mb-3 col-4">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="phone" name="phone" aria-describedby="" required autofocus disabled>
                        </div>

                        <div class="input-form mb-3 col-12">
                            <label for="phone" class="form-label">User Management</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" disabled>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    User is Regular
                                </label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" disabled>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    User is Blocked
                                </label>
                            </div>
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

    <script src="{{ asset ('assets/js/bootstrap.js') }}"></script>
</body>
</html>