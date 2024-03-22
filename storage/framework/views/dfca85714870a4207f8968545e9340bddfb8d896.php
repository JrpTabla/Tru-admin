

<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="<?php echo e(asset ('assets/css/education/education.css')); ?>">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<div class="main mx-auto">
    <div class="w-100 p-3">
        
        <nav aria-label="breadcrumb mt-3 ">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item previous-topic"><a href="/education"></a></li>
                <li class="breadcrumb-item previous-level"><a></a></li>
                <li class="breadcrumb-item previous-course"><a></a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page">Choose a Module</li>
            </ol>
        </nav>

        <!-- <h1 class="text-center my-3 fw-bold">MEMBERS MANAGEMENT</h1> -->

        <div class="d-flex mb-3">
            <select class="form-select selection-table" aria-label="Default select example">
                <option value="100">All</option>
                <option value="20" selected>20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <div class="ms-auto">
                <button id="toggleBlockedButton" class="btn btn-add-level text-white fw-bold" data-bs-toggle="modal" data-bs-target="#AddEducationModule">Add Education Course Module</button>
            </div>
        </div>
        
        <table id="membersTable" class="table table-striped table-bordered my-3">
            <thead>
                <tr>
                    <th class="text-center align-middle">ID</th>
                    <th class="text-center align-middle">Module</th>
                    <th class="text-center align-middle">Course</th>
                    <th class="text-center" width="25%"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="AddEducationModule" tabindex="-1" aria-labelledby="AddEducationModule" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Education Course Module</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="EducationModuleCourse" class="form-label">Course:</label>
            <select class="form-select" aria-label="Default select example" id="EducationModuleCourse" disabled>
            </select>
        </div>

        <div class="mb-3">
            <label for="EducationModuleName" class="form-label">Module:</label>
            <input type="text" class="form-control" id="EducationModuleName" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Kindly  input the education Course Module name here.</div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="AddEducationCourseModule()">Save</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="EditEducationModule" tabindex="-1" aria-labelledby="EditEducationModule" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Course Module</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="EditEducationCourseModule" class="form-label">Course:</label>
            <select class="form-select" aria-label="Default select example" id="EditEducationCourseModule">
                <!-- <option value="0" selected>Select Course</option> -->
            </select>
        </div>

        <div class="mb-3">
            <label for="EditEducationModuleCourseName" class="form-label">Module:</label>
            <input type="hidden" id="EditEducationModuleCourseId">
            <input type="text" class="form-control" id="EditEducationModuleCourseName" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Kindly  input the education Course Module name here.</div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="UpdateEducationCourseModule()">Save</button>
      </div>
    </div>
  </div>
</div>

<script>

    // Get the current URL
    var currentUrl = window.location.href;

    // Split the URL by '/' to get individual parts
    var urlParts = currentUrl.split('/');

    // The second-to-last part of the URL will be the ID before the last one
    var Topic_id = urlParts[urlParts.length - 3];

    // The second-to-last part of the URL will be the ID before the last one
    var Difficulty_id = urlParts[urlParts.length - 2];

    // The last part of the URL will be the last ID
    var Course_id = urlParts[urlParts.length - 1];

    // console.log("First ID:", Topic_id);
    // console.log("Second ID:", Difficulty_id);

    // Now, 'id' variable holds the ID extracted from the URL
    // console.log(page_id); // Output: 393216

    document.addEventListener("DOMContentLoaded", () => {
        handleCourseData();
        handleTableData();

        handleBreadcumbTopicData();
        handleBreadcumbLevelData();
        handleBreadcumbCourseData();
    })


    function handleBreadcumbTopicData() {

        fetch(`/api/page-education-topic/${Topic_id}`)
            .then(response => response.json())
            .then(data => {
                /* console.log(data); */
                // Update breadcrumb with name_topic
                const breadcrumbItem = document.querySelector('.breadcrumb-item.previous-topic a');
                breadcrumbItem.textContent = data.name_topic;
            })
        .catch(error => console.error('Error fetching members:', error));
    }

    function handleBreadcumbLevelData() {
        fetch(`/api/page-education-level/${Difficulty_id}`)
            .then(response => response.json())
            .then(data => {
                /* console.log(data); */
                // Update breadcrumb with name_topic
                const breadcrumbItem = document.querySelector('.breadcrumb-item.previous-level a');
                breadcrumbItem.textContent = data.name_level;
                breadcrumbItem.href = `/education_level/${Topic_id}`;
            })
        .catch(error => console.error('Error fetching members:', error));
    }

    function handleBreadcumbCourseData() {
        fetch(`/api/page-education-course/${Course_id}`)
            .then(response => response.json())
            .then(data => {
                /* console.log(data); */
                // Update breadcrumb with name_topic
                const breadcrumbItem = document.querySelector('.breadcrumb-item.previous-course a');
                breadcrumbItem.textContent = data.name_course;
                breadcrumbItem.href = `/education_course/${Topic_id}/${Difficulty_id}`;
            })
        .catch(error => console.error('Error fetching members:', error));
    }

    /* Fetch Level Data on the Select Form Input */
     /* Fetch Course Data on the Table */

    function handleCourseData() {
        const educationCourseSelect = document.getElementById("EducationModuleCourse");
        const editEducationCourseSelect = document.getElementById("EditEducationCourseModule");

        fetch(`/api/view-education-course/${Topic_id}/${Difficulty_id}`)
            .then(response => response.json())
            .then(data => {
                /* console.log(data); */

                data.forEach(course => {
                    const option = document.createElement('option');
                    option.value = course.id;
                    option.textContent = course.name_course;
                    educationCourseSelect.appendChild(option);

                    const editoption = document.createElement('option');
                    editoption.value = course.id;
                    editoption.textContent = course.name_course;
                    editEducationCourseSelect.appendChild(editoption);

                    // Select the option based on Difficulty_id
                    if (course.id == Course_id) {
                        option.selected = true;
                    }

                });
            })
        .catch(error => console.error('Error fetching members:', error));
    }

    

    /* Fetch Course Data on the Table */

    function handleTableData() {
        const membersTableBody = document.querySelector('#membersTable tbody');

        fetch(`/api/view-education-module/${Course_id}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);

                /* handleBreadcrumbData(data[0]?.education_level_id, data[0]?.level_name, data[0]?.education_topic_id, data[0]?.topic_name ); */

                if (data.length === 0) {
                    // If there are no registered users, display a message
                    membersTableBody.innerHTML = `
                        <tr>
                            <td colspan="5" class="align-middle text-center">No Data.</td>
                        </tr>
                    `;
                } else {
                    // Clear existing table content
                    membersTableBody.innerHTML = '';
                    data.forEach((EducationCourseModule, index) => {
                        const row = `
                            <tr>
                                <td class="text-center align-middle fw-bold">${EducationCourseModule.id}</td>
                                <td class="text-start align-middle">${EducationCourseModule.name_module}</td>
                                <td class="text-start align-middle">${EducationCourseModule.course_name}</td>
                                <td class="text-center align-middle">
                                    <button class="btn btn-view" onclick="ViewEducationCourseModule(${EducationCourseModule.id})">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21 6V18C21 19.0609 20.5786 20.0783 19.8284 20.8284C19.0783 21.5786 18.0609 22 17 22H7C5.93913 22 4.92178 21.5786 4.17163 20.8284C3.42149 20.0783 3 19.0609 3 18V14.89C3 11.4714 4.35811 8.1928 6.77545 5.77545C9.1928 3.35811 12.4714 2 15.89 2H17C18.0609 2 19.0783 2.42149 19.8284 3.17163C20.5786 3.92178 21 4.93913 21 6Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 15.06C3 9.9 8.50004 14.0599 11.73 10.8199C14.96 7.57995 10.83 2 15.98 2" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M7 16H17" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M15 12H17" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M16 8H17" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                    </button>
                                    
                                    <button class="btn btn-edit" onclick="EditEducationCourseModule(${EducationCourseModule.id}, '${EducationCourseModule.name_module}', ${EducationCourseModule.education_course_id})" data-bs-toggle="modal" data-bs-target="#EditEducationModule">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.6008 17.34L16.5008 22.44C16.0008 22.94 14.5008 23.18 14.1608 22.84C13.8208 22.5 14.0508 21 14.5608 20.49L19.6508 15.4C19.7738 15.2541 19.9257 15.1354 20.0969 15.0512C20.2681 14.967 20.4549 14.9192 20.6455 14.9109C20.8362 14.9025 21.0264 14.9338 21.2043 15.0027C21.3822 15.0716 21.5439 15.1767 21.6791 15.3113C21.8144 15.4458 21.9203 15.607 21.9901 15.7845C22.0599 15.9621 22.0922 16.1522 22.0848 16.3428C22.0775 16.5335 22.0307 16.7205 21.9474 16.8921C21.8641 17.0638 21.7461 17.2163 21.6008 17.34V17.34Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M10.2798 22H7.00977C5.9489 22 4.93148 21.5785 4.18134 20.8284C3.43119 20.0782 3.00977 19.0609 3.00977 18V14.89C3.00977 11.4713 4.36781 8.19273 6.78516 5.77539C9.2025 3.35805 12.4811 2 15.8997 2H17.0098C18.0706 2 19.0881 2.42142 19.8382 3.17157C20.5883 3.92172 21.0098 4.93913 21.0098 6 V11.4399" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 15.06C3 9.9 8.50001 14.0599 11.73 10.8199C14.96 7.57995 10.83 2 15.98 2" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                    </button>

                                    <button class="btn btn-block" onclick="DeleteEducationCourseModule(${EducationCourseModule.id})">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M11.2798 22H7.00977C5.9489 22 4.93148 21.5785 4.18134 20.8284C3.43119 20.0782 3.00977 19.0609 3.00977 18V14.89C3.00977 11.4713 4.36781 8.19273 6.78516 5.77539C9.2025 3.35805 12.4811 2 15.8998 2H17.0098C18.0706 2 19.0881 2.42142 19.8382 3.17157C20.5883 3.92172 21.0098 4.93913 21.0098 6 V11.4399" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 15.06C3 9.9 8.50004 14.0599 11.73 10.8199C14.96 7.57995 10.83 2 15.98 2" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M15.2793 22L21.2793 16" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M15.2793 16L21.2793 22" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                    </button>
                                </td>
                            </tr>
                        `;
                        membersTableBody.innerHTML += row;
                    });
                }
            })
        .catch(error => console.error('Error fetching members:', error));
    }


    /* ---------------------------------------------------------- CRUD METHOD ---------------------------------------------- */

    /* Create */
    function AddEducationCourseModule() {

        // Get the Values
        const educationCourseModuleName = document.getElementById("EducationModuleName").value;
        const EducationModuleCourse = document.getElementById("EducationModuleCourse").value;

        // alert(educationCourseModuleName);
        // alert(EducationModuleCourse);

        // Now you can use these values as needed, such as sending them in a fetch request

        // Example of how to send a POST request using fetch:

        fetch('/api/add-education-module', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                name_module: educationCourseModuleName,
                education_course_id: EducationModuleCourse,
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            /* console.log(data); */

            if(data == 0) {

                document.getElementById("EducationModuleName").value = ""; // Clear input field
                // Close modal using jQuery
                $('#AddEducationModule').modal('hide');

                handleTableData();

            } else if(data == 1){
                alert("Education Course Name is Already Exist! Please Try different Name.");
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('Failed to add education course');
        });
    }

    // /* Redirect to Course View */
    function ViewEducationCourseModule(id) {
        // Construct the URL with the provided ID
        var url = `/education_lesson/${Topic_id}/${Difficulty_id}/${Course_id}/${id}`;
        
        // Redirect the browser to the constructed URL
        window.location.href = url;
    }


    // /* Retrive - Info in to Edit Modal */
    function EditEducationCourseModule(id, name, course_id) {
        document.getElementById("EditEducationModuleCourseId").value = id;
        document.getElementById("EditEducationModuleCourseName").value = name;

        // Set selected option for Course dropdown
        const CourseSelect = document.getElementById("EditEducationCourseModule");
        Array.from(CourseSelect.options).forEach(option => {
            if (option.value == course_id) {
                option.selected = true;
            }
        });
    }


    // /* Update */
    function UpdateEducationCourseModule() {
        
        const editEducationModuleCourseId = document.getElementById("EditEducationModuleCourseId").value;
        const editEducationCourseModule = document.getElementById("EditEducationCourseModule").value;
        const editEducationModuleCourseName = document.getElementById("EditEducationModuleCourseName").value;

        console.log(editEducationModuleCourseId);
        console.log(editEducationCourseModule);
        console.log(editEducationModuleCourseName);

        // Send PUT request to update the Education Level
        fetch(`/api/update-education-module/${editEducationModuleCourseId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' // Add CSRF token if CSRF protection is enabled
            },
            body: JSON.stringify({
                name_module: editEducationModuleCourseName,
                education_Course_id: editEducationCourseModule,
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Handle success response
            if(data == 0) {
                // document.getElementById("EditEducationCourseName").value = ""; // Clear input field
                // document.getElementById("EditEducationCourseId").value = ""; // Clear input field


                // Close modal using jQuery
                $('#EditEducationModule').modal('hide');

                handleTableData();

            } else if(data == 1){
                alert("Education Course Module Name is Already Exist! Please Try different Name.");
            }
        })
        .catch(error => {
            // Handle error
            console.error('There was a problem with the fetch operation:', error);
            alert('Failed to update education level');
        });
    }

    // /* Delete */
    function DeleteEducationCourseModule(id) {

        // Send DELETE request to delete the Education Level
        fetch(`/api/delete-education-module/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' // Add CSRF token if CSRF protection is enabled
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Handle success response
            /* alert(data); // Display success message */

            // Optionally, you can perform any other action here, such as refreshing the table
            handleTableData();
        })
        .catch(error => {
            // Handle error
            console.error('There was a problem with the fetch operation:', error);
            alert('Failed to delete education level');
        });
    }

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('header.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin-IT\Desktop\tru-international\example-app\resources\views/education/educationmodule.blade.php ENDPATH**/ ?>