

<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="<?php echo e(asset ('assets/css/education/education.css')); ?>">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<style>
    #container {
        width: 928px;
        margin: 0px auto;
    }
    .ck-editor__editable[role="textbox"] {
        /* Editing area */
        min-height: 200px;
    }
    .ck-content ul {
        /* Adjust margin to control indentation */
        margin-left: 20px; /* Change this value as needed */
    }
    .ck-content .image {
        /* Block images */
        max-width: 80%;
        margin: 20px auto;
    }

</style>

<div class="main mx-auto">
    <div class="w-100 p-3">
        
        <nav aria-label="breadcrumb mt-3 ">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item previous-topic"><a href="/education"></a></li>
                <li class="breadcrumb-item previous-level"><a></a></li>
                <li class="breadcrumb-item previous-course"><a></a></li>
                <li class="breadcrumb-item previous-module"><a></a></li>
                <li class="breadcrumb-item active fw-bold previous-lesson"><a></a></li>
            </ol>
        </nav>

        <!-- <h1 class="text-center my-3 fw-bold">MEMBERS MANAGEMENT</h1> -->

        <div class="d-flex mb-3">

            <div class="ms-auto">
                <button id="toggleBlockedButton" class="btn btn-block text-white fw-bold" onclick=BackToLessonPage()>Back to Course Lesson</button>
            </div>
        </div>
        
       
        <div class="addLessonContent" >
            <h1 class="lesson-title text-center mb-5 fw-bold"></h1>

            <div class="row">
                <div class="mb-3 col-3">
                    <label for="EducationModule" class="form-label">Course Module:</label>
                    <select class="form-select" aria-label="Default select example" id="EducationModule" disabled>
                    </select>
                </div>
                
                <div class="mb-3 col-3">
                    <label for="EducationLessonTime" class="form-label">Reading Time (Minutes):</label>
                    <input type="Number" class="form-control" id="EducationLessonTime" aria-describedby="emailHelp" disabled>
                </div>

                <div class="mb-3 col-3">
                    <label for="EducationLessonTime" class="form-label">Publish Date:</label>
                    <input type="datetime-local" class="form-control" id="PublishDate" aria-describedby="emailHelp" disabled>
                </div>

                <div class="mb-3 col-3">
                    <label for="EducationLessonTime" class="form-label">Update Date :</label>
                    <input type="datetime-local" class="form-control" id="UpdateDate" aria-describedby="emailHelp" disabled>
                </div>
            </div>

            <div class="mb-3">
                <label for="EducationLessonName" class="form-label">Lesson:</label>
                <input type="text" class="form-control" id="EducationLessonName" aria-describedby="emailHelp" disabled>
            </div>

            <div class="mb-3">
                <label for="editor" class="form-label">Lesson Content:</label>
                <hr>
                <div id="container">
                    <div id="editor"></div>
                </div>
                <hr>
            </div>
        </div>

        <div class="gap-2 division-cancel-submit">
            <button id="toggleBlockedButton" class="btn btn-block text-white fw-bold" onclick="BackToLessonPage()">Back To Course Lesson</button>
            <button id="toggleBlockedButton" class="btn btn-add-level text-white fw-bold" onclick="UpdateEducationLesson()">Update Lesson Content</button>
        </div>
    </div>
</div>

<script>

    /* ---------------------------------------------------------- Page METHOD ---------------------------------------------- */

    // Get the current URL
    var currentUrl = window.location.href;

    // Split the URL by '/' to get individual parts
    var urlParts = currentUrl.split('/');

    // The second-to-last part of the URL will be the ID before the last one
    var Topic_id = urlParts[urlParts.length - 5];

    // The second-to-last part of the URL will be the ID before the last one
    var Difficulty_id = urlParts[urlParts.length - 4];

    // The last part of the URL will be the last ID
    var Course_id = urlParts[urlParts.length - 3];

    // The last part of the URL will be the last ID
    var Module_id = urlParts[urlParts.length - 2];

    // The last part of the URL will be the last ID
    var lesson_id = urlParts[urlParts.length - 1];

    // console.log("Topic ID:", Topic_id);
    // console.log("Difficulty ID:", Difficulty_id);

    // console.log("Course ID:", Course_id);
    // console.log("Module ID:", Module_id);

    // Now, 'id' variable holds the ID extracted from the URL
    // console.log(page_id); // Output: 393216

    function BackToLessonPage() {

        // Construct the URL with the provided ID
        var url = `/education_lesson/${Topic_id}/${Difficulty_id}/${Course_id}/${Module_id}`;

        // Redirect the browser to the constructed URL
        window.location.href = url;
    }


    document.addEventListener("DOMContentLoaded", () => {
        handleModuleData();

        handleBreadcumbTopicData();
        handleBreadcumbLevelData();
        handleBreadcumbCourseData();
        handleBreadcumbModuleData();
        handleBreadcumbLessonData();
        
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


    function handleBreadcumbModuleData() {
        /* console.log(Module_id); */

        fetch(`/api/page-education-module/${Module_id}`)
            .then(response => response.json())
            .then(data => {
                /* console.log(data); */
                // Update breadcrumb with name_topic
                const breadcrumbItem = document.querySelector('.breadcrumb-item.previous-module a');
                breadcrumbItem.textContent = data.name_module;
                breadcrumbItem.href = `/education_modules/${Topic_id}/${Difficulty_id}/${Course_id}`;
            })
        .catch(error => console.error('Error fetching members:', error));
    }

    function handleBreadcumbLessonData() {
        /* console.log(lesson_id); */

        fetch(`/api/page-education-lesson/${lesson_id}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // Update breadcrumb with name_topic
                const breadcrumbItem = document.querySelector('.breadcrumb-item.previous-lesson a');
                breadcrumbItem.textContent = data.name_lesson;
                // breadcrumbItem.href = `/education_lesson/${Topic_id}/${Difficulty_id}/${Course_id}/${Module_id}`;

                // Update breadcrumb with name_lesson
                const lessonTitleElement = document.querySelector('.lesson-title');
                lessonTitleElement.textContent = `Lesson: ${data.name_lesson}`;

                // Update input with time_lesson
                const educationLessonTimeInput = document.getElementById('EducationLessonTime');
                educationLessonTimeInput.value = data.time_lesson;


                const educationLessonNameInput = document.getElementById('EducationLessonName');
                educationLessonNameInput.value = data.name_lesson;

                // Insert content_lesson into editor container
                const editorContainer = document.getElementById('editor');
                editorContainer.innerHTML = data.content_lesson;

                 // Update created_date input
                const publishDateInput = document.getElementById('PublishDate');
                publishDateInput.value = data.created_date;

                // Update updated_date input
                const updateDateInput = document.getElementById('UpdateDate');
                updateDateInput.value = data.updated_date;

            })
        .catch(error => console.error('Error fetching members:', error));
    }


    /* Fetch Level Data on the Select Form Input */
     /* Fetch Course Data on the Table */

    function handleModuleData() {
        const educationModuleSelect = document.getElementById("EducationModule");
        /* const editEducationCourseSelect = document.getElementById("EditEducationCourseModule"); */

        fetch(`/api/view-education-module/${Course_id}`)
            .then(response => response.json())
            .then(data => {
                /* console.log(data); */

                data.forEach(module => {
                    const option = document.createElement('option');
                    option.value = module.id;
                    option.textContent = module.name_module;
                    educationModuleSelect.appendChild(option);

                    // const editoption = document.createElement('option');
                    // editoption.value = course.id;
                    // editoption.textContent = course.name_course;
                    // editEducationCourseSelect.appendChild(editoption);

                    // Select the option based on Difficulty_id
                    if (module.id == Module_id) {
                        option.selected = true;
                    }

                });
            })
        .catch(error => console.error('Error fetching members:', error));
    }


    /* ---------------------------------------------------------- CRUD METHOD ---------------------------------------------- */

    function UpdateEducationLesson() {
        // Construct the URL with the provided ID
        var url = `/education_update_lesson/${Topic_id}/${Difficulty_id}/${Course_id}/${Module_id}/${lesson_id}`;

        // Redirect the browser to the constructed URL
        window.location.href = url;
    }


    // /* Create */
    // function AddEducationLesson() {

    //     // Get the Values
    //     const educationCourseModuleId = document.getElementById("EducationModule").value;
    //     const educationLessonTime = document.getElementById("EducationLessonTime").value;
    //     const educationLessonName = document.getElementById("EducationLessonName").value;

    //    // Get CKEditor instance
    //    const editorData = editor.getData();

    //     // console.log("Education Module ID: " + educationCourseModuleId);
    //     // console.log("Education Lesson Time: " + educationLessonTime);
    //     // console.log("Education Lesson Name: "+ educationLessonName);
    //     // console.log("Education Lesson Content: "+ editorData);

    //     // Now you can use these values as needed, such as sending them in a fetch request

    //     // Example of how to send a POST request using fetch:

    //     fetch('/api/add-education-lesson', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
    //         },
    //         body: JSON.stringify({
    //             id_course_module: educationCourseModuleId,
    //             time_lesson: educationLessonTime,
    //             name_lesson: educationLessonName,
    //             content_lesson: editorData
    //         })
    //     })
    //     .then(response => {
    //         if (!response.ok) {
    //             throw new Error('Network response was not ok');
    //         }
    //         return response.json();
    //     })
    //     .then(data => {
    //         console.log(data);

    //         if(data == 0) {

    //             BackToLessonPage()

    //         } else if(data == 1){
    //             alert("Education Course Lesson Name is Already Exist! Please Try different Name.");
    //         }
    //     })
    //     .catch(error => {
    //         console.error('There was a problem with the fetch operation:', error);
    //         alert('Failed to add education course');
    //     });
    // }


    // // /* Retrive - Info in to Edit Modal */
    // function EditEducationCourseModule(id, name, course_id) {
    //     document.getElementById("EditEducationModuleCourseId").value = id;
    //     document.getElementById("EditEducationModuleCourseName").value = name;

    //     // Set selected option for Course dropdown
    //     const CourseSelect = document.getElementById("EditEducationCourseModule");
    //     Array.from(CourseSelect.options).forEach(option => {
    //         if (option.value == course_id) {
    //             option.selected = true;
    //         }
    //     });
    // }


    // // /* Update */
    // function UpdateEducationCourseModule() {
        
    //     const editEducationModuleCourseId = document.getElementById("EditEducationModuleCourseId").value;
    //     const editEducationCourseModule = document.getElementById("EditEducationCourseModule").value;
    //     const editEducationModuleCourseName = document.getElementById("EditEducationModuleCourseName").value;

    //     console.log(editEducationModuleCourseId);
    //     console.log(editEducationCourseModule);
    //     console.log(editEducationModuleCourseName);

    //     // Send PUT request to update the Education Level
    //     fetch(`/api/update-education-module/${editEducationModuleCourseId}`, {
    //         method: 'PUT',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' // Add CSRF token if CSRF protection is enabled
    //         },
    //         body: JSON.stringify({
    //             name_module: editEducationModuleCourseName,
    //             education_Course_id: editEducationCourseModule,
    //         })
    //     })
    //     .then(response => {
    //         if (!response.ok) {
    //             throw new Error('Network response was not ok');
    //         }
    //         return response.json();
    //     })
    //     .then(data => {
    //         // Handle success response
    //         if(data == 0) {
    //             // document.getElementById("EditEducationCourseName").value = ""; // Clear input field
    //             // document.getElementById("EditEducationCourseId").value = ""; // Clear input field


    //             // Close modal using jQuery
    //             $('#EditEducationModule').modal('hide');

    //             handleTableData();

    //         } else if(data == 1){
    //             alert("Education Course Module Name is Already Exist! Please Try different Name.");
    //         }
    //     })
    //     .catch(error => {
    //         // Handle error
    //         console.error('There was a problem with the fetch operation:', error);
    //         alert('Failed to update education level');
    //     });
    // }

    // // /* Delete */
    // function DeleteEducationCourseModule(id) {

    //     // Send DELETE request to delete the Education Level
    //     fetch(`/api/delete-education-module/${id}`, {
    //         method: 'DELETE',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' // Add CSRF token if CSRF protection is enabled
    //         }
    //     })
    //     .then(response => {
    //         if (!response.ok) {
    //             throw new Error('Network response was not ok');
    //         }
    //         return response.json();
    //     })
    //     .then(data => {
    //         // Handle success response
    //         /* alert(data); // Display success message */

    //         // Optionally, you can perform any other action here, such as refreshing the table
    //         handleTableData();
    //     })
    //     .catch(error => {
    //         // Handle error
    //         console.error('There was a problem with the fetch operation:', error);
    //         alert('Failed to delete education level');
    //     });
    // }

</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('header.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin-IT\Desktop\tru-international\example-app\resources\views/education/educationViewlesson.blade.php ENDPATH**/ ?>