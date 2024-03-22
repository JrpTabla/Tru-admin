

<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="<?php echo e(asset ('assets/css/education/education.css')); ?>">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<div class="main mx-auto">
    <div class="w-100 p-3">
        
        <nav aria-label="breadcrumb mt-3 ">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page">Choose a Topic</li>
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
                <button id="toggleBlockedButton" class="btn btn-add-level text-white fw-bold" data-bs-toggle="modal" data-bs-target="#AddEducationTopic">Add Education Topic</button>
            </div>
        </div>
        
        <table id="membersTable" class="table table-striped table-bordered my-3">
            <thead>
                <tr>
                    <th class="text-center align-middle">ID</th>
                    <th class="text-center align-middle">Topic</th>
                    <th class="text-center" width="25%"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="AddEducationTopic" tabindex="-1" aria-labelledby="AddEducationTopic" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Topic</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="EducationTopicName" class="form-label">Topic:</label>
            <input type="text" class="form-control" id="EducationTopicName" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Kindly  input the Topic name here.</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="AddEducationTopic()">Save</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="EditEducationtopic" tabindex="-1" aria-labelledby="EditEducationtopic" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Education Topic</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="EditEducationtopicName" class="form-label">Education Topic:</label>
            <input type="hidden" id="EditEducationtopicId"> <!-- Hidden input field for ID -->
            <input type="text" class="form-control" id="EditEducationtopicName" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Kindly  input the education Topic name here.</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="UpdateEducationTopic()">Save</button>
      </div>
    </div>
  </div>
</div>

<script>

    document.addEventListener("DOMContentLoaded", () => {
        handleTableData();
    })

    function handleTableData() {
        const membersTableBody = document.querySelector('#membersTable tbody');

        fetch(`/api/view-education-topic`)
            .then(response => response.json())
            .then(data => {
                console.table(data);

                if (data.length === 0) {
                    // If there are no registered users, display a message
                    membersTableBody.innerHTML = `
                        <tr>
                            <td colspan="3" class="align-middle text-center">No Data.</td>
                        </tr>
                    `;
                } else {
                    // Clear existing table content
                    membersTableBody.innerHTML = '';

                    data.forEach((EducationTopic, index) => {

                        // console.log(user);
                        const row = `
                            <tr>
                                <td class="text-center align-middle fw-bold">${EducationTopic.id}</td>
                                <td class="text-start align-middle">${EducationTopic.name_topic}</td>
                                <td class="text-center align-middle">
                                    <button class="btn btn-view" onclick="ViewEducationTopic(${EducationTopic.id})">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21 6V18C21 19.0609 20.5786 20.0783 19.8284 20.8284C19.0783 21.5786 18.0609 22 17 22H7C5.93913 22 4.92178 21.5786 4.17163 20.8284C3.42149 20.0783 3 19.0609 3 18V14.89C3 11.4714 4.35811 8.1928 6.77545 5.77545C9.1928 3.35811 12.4714 2 15.89 2H17C18.0609 2 19.0783 2.42149 19.8284 3.17163C20.5786 3.92178 21 4.93913 21 6Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 15.06C3 9.9 8.50004 14.0599 11.73 10.8199C14.96 7.57995 10.83 2 15.98 2" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M7 16H17" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M15 12H17" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M16 8H17" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                    </button>

                                    <button class="btn btn-edit" onclick="EditEducationTopic(${EducationTopic.id}, '${EducationTopic.name_topic}')" data-bs-toggle="modal" data-bs-target="#EditEducationtopic">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier"> 
                                                <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                                <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                            </g>
                                        </svg>
                                    </button>
                                <button class="btn btn-block" onclick="DeleteEducationTopic(${EducationTopic.id})">
                                        <svg width="18" height="18" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="DeleteEducationLevel(${EducationTopic.id}">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier"> 
                                                <path d="M4 8.78998V18.56C4 19.6209 4.42149 20.6383 5.17163 21.3884C5.92178 22.1386 6.93913 22.56 8 22.56H16C17.0609 22.56 18.0783 22.1386 18.8284 21.3884C19.5786 20.6383 20 19.6209 20 18.56V8.78003" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                                <path d="M9 13.56H15" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                                <path d="M22 6.56C22 5.49913 21.5786 4.48171 20.8284 3.73157C20.0783 2.98142 19.0609 2.56 18 2.56H6C4.93913 2.56 3.92178 2.98142 3.17163 3.73157C2.42149 4.48171 2 5.49913 2 6.56C2 7.09043 2.21074 7.59917 2.58582 7.97424C2.96089 8.34932 3.46957 8.56 4 8.56H20C20.5304 8.56 21.0392 8.34932 21.4142 7.97424C21.7893 7.59917 22 7.09043 22 6.56Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                            </g>
                                        </svg>
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

    /* Redirect to Course View */
    function ViewEducationTopic(id) {
        // Construct the URL with the provided ID
        var url = `/education_level/${id}`;
        
        // Redirect the browser to the constructed URL
        window.location.href = url;
    }

    /* Create */
    function AddEducationTopic () {
        var educationTopic = document.getElementById("EducationTopicName").value;

        // Send POST request to create a new Education Level
        fetch('/api/add-education-topic', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' // Add CSRF token if CSRF protection is enabled
        },
        body: JSON.stringify({
            name_topic: educationTopic
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
        /* alert(data);   */
        document.getElementById("EducationTopicName").value = ""; // Clear input field

        // Close modal using jQuery
        $('#AddEducationTopic').modal('hide');


        handleTableData();
        // alert('Education level added successfully');
        // Optionally, you can close the modal or perform any other action here
        })
        .catch(error => {
        // Handle error
        console.error('There was a problem with the fetch operation:', error);
        alert('Failed to add education level');
        });
    }

    /* Retrive - Info in to Edit Modal */
    function EditEducationTopic(id, name) {
        document.getElementById("EditEducationtopicId").value = id;
        document.getElementById("EditEducationtopicName").value = name;
    }

    /* Update */
    function UpdateEducationTopic() {
        const educationTopicId = document.getElementById("EditEducationtopicId").value;
        const editedEducationTopic = document.getElementById("EditEducationtopicName").value;

        // Send PUT request to update the Education Level
        fetch(`/api/update-education-topic/${educationTopicId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' // Add CSRF token if CSRF protection is enabled
            },
            body: JSON.stringify({
                name_topic: editedEducationTopic
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
                document.getElementById("EditEducationtopicName").value = ""; // Clear input field
                document.getElementById("EditEducationtopicId").value = ""; // Clear input field

                // Close modal using jQuery
                $('#EditEducationtopic').modal('hide');

                handleTableData();

            } else if(data == 1){
                alert("Education Topic Name is Already Exist! Please Try different Name.");
            }
        })
        .catch(error => {
            // Handle error
            console.error('There was a problem with the fetch operation:', error);
            alert('Failed to update education Topic');
        });
    }

    /* Delete */
    function DeleteEducationTopic(id) {
        // Send DELETE request to delete the Education Level
        fetch(`/api/delete-education-topic/${id}`, {
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
            alert('Failed to delete education Topic');
        });
    }
 
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('header.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin-IT\Desktop\tru-international\tru-CMS\resources\views/education/educationtopic.blade.php ENDPATH**/ ?>