@extends('header.header')

@section('content')

<link rel="stylesheet" href="{{ asset ('assets/css/education/education.css') }}">
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/inline/ckeditor.js"></script> -->
<meta name="csrf-token" content="{{ csrf_token() }}">

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
                <li class="breadcrumb-item active fw-bold" aria-current="page">Add a Lesson</li>
            </ol>
        </nav>

        <!-- <h1 class="text-center my-3 fw-bold">MEMBERS MANAGEMENT</h1> -->

        <div class="d-flex mb-3">

            <div class="ms-auto">
                <button id="toggleBlockedButton" class="btn btn-block text-white fw-bold" onclick=BackToLessonPage()>Back to Course Lesson</button>
            </div>
        </div>
        
       
        <div class="addLessonContent" >
            <h1 class="title text-center mb-5 fw-bold">Create Course Lesson</h1>

            <div class="row">
                <div class="mb-3 col-6">
                    <label for="EducationModule" class="form-label">Course Module:</label>
                    <select class="form-select" aria-label="Default select example" id="EducationModule" disabled>
                    </select>
                </div>
                
                <div class="mb-3 col-6">
                    <label for="EducationLessonTime" class="form-label">Reading Time (Minutes):</label>
                    <input type="Number" class="form-control" id="EducationLessonTime" aria-describedby="emailHelp">
                </div>
                
            </div>

            <div class="mb-3">
                <label for="EducationLessonName" class="form-label">Lesson:</label>
                <input type="text" class="form-control" id="EducationLessonName" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Kindly  input the education Lesson name here.</div>
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
            <button id="toggleBlockedButton" class="btn btn-block text-white fw-bold" onclick="BackToLessonPage()">Cancel</button>
            <button id="toggleBlockedButton" class="btn btn-add-level text-white fw-bold" onclick="AddEducationLesson()">Create Content</button>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/super-build/ckeditor.js"></script>

<script>

    let editor;
    // This sample still does not showcase all CKEditor&nbsp;5 features (!)
    // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
    CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
        // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
        
        toolbar: {
            items: [
                'exportPDF','exportWord', '|',
                'findAndReplace', 'selectAll', '|',
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'outdent', 'indent', '|',
                'undo', 'redo',
                '-',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                'alignment', '|',
                'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                'textPartLanguage', '|',
                'sourceEditing'
            ],
            shouldNotGroupWhenFull: true
        },
        // Changing the language of the interface requires loading the language file using the <script> tag.
        // language: 'es',
        list: {
            properties: {
                styles: true,
                startIndex: true,
                reversed: true
            }
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            ]
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
        placeholder: 'Lesson Content Here!',
        // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif',
                'Articulat CF, sans-serif' // Add Articulat CF here
            ],
            supportAllValues: true
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
        fontSize: {
            options: [ 10, 12, 14, 'default', 18, 20, 22 ],
            supportAllValues: true
        },
        // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
        // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
        htmlSupport: {
            allow: [
                {
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }
            ]
        },
        // Be careful with enabling previews
        // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
        htmlEmbed: {
            showPreviews: true
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
        link: {
            decorators: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Downloadable',
                    attributes: {
                        download: 'file'
                    }
                }
            }
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
        mention: {
            feeds: [
                {
                    marker: '@',
                    feed: [
                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                        '@sugar', '@sweet', '@topping', '@wafer'
                    ],
                    minimumCharacters: 1
                }
            ]
        },
        // The "superbuild" contains more premium features that require additional configuration, disable them below.
        // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
        removePlugins: [
            // These two are commercial, but you can try them out without registering to a trial.
            // 'ExportPdf',
            // 'ExportWord',
            'AIAssistant',
            'CKBox',
            'CKFinder',
            'EasyImage',
            // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
            // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
            // Storing images as Base64 is usually a very bad idea.
            // Replace it on production website with other solutions:
            // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
            // 'Base64UploadAdapter',
            'RealTimeCollaborativeComments',
            'RealTimeCollaborativeTrackChanges',
            'RealTimeCollaborativeRevisionHistory',
            'PresenceList',
            'Comments',
            'TrackChanges',
            'TrackChangesData',
            'RevisionHistory',
            'Pagination',
            'WProofreader',
            // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
            // from a local file system (file://) - load this site via HTTP server if you enable MathType.
            'MathType',
            // The following features are part of the Productivity Pack and require additional license.
            'SlashCommand',
            'Template',
            'DocumentOutline',
            'FormatPainter',
            'TableOfContents',
            'PasteFromOfficeEnhanced',
            'CaseChange'
        ]
    }).then( newEditor => {
        editor = newEditor;
    } )
    .catch( error => {
        console.error( error );
    } );

    /* ---------------------------------------------------------- Page METHOD ---------------------------------------------- */

    // Get the current URL
    var currentUrl = window.location.href;

    // Split the URL by '/' to get individual parts
    var urlParts = currentUrl.split('/');

    // The second-to-last part of the URL will be the ID before the last one
    var Topic_id = urlParts[urlParts.length - 4];

    // The second-to-last part of the URL will be the ID before the last one
    var Difficulty_id = urlParts[urlParts.length - 3];

    // The last part of the URL will be the last ID
    var Course_id = urlParts[urlParts.length - 2];

    // The last part of the URL will be the last ID
    var Module_id = urlParts[urlParts.length - 1];

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

                    if (module.id == Module_id) {
                        option.selected = true;
                    }

                });
            })
        .catch(error => console.error('Error fetching members:', error));
    }


    /* ---------------------------------------------------------- CRUD METHOD ---------------------------------------------- */

    // /* Create */
    function AddEducationLesson() {

        // Get the Values
        const educationCourseModuleId = document.getElementById("EducationModule").value;
        const educationLessonTime = document.getElementById("EducationLessonTime").value;
        const educationLessonName = document.getElementById("EducationLessonName").value;

       // Get CKEditor instance
       const editorData = editor.getData();

        // console.log("Education Module ID: " + educationCourseModuleId);
        // console.log("Education Lesson Time: " + educationLessonTime);
        // console.log("Education Lesson Name: "+ educationLessonName);
        // console.log("Education Lesson Content: "+ editorData);

        // Now you can use these values as needed, such as sending them in a fetch request

        // Example of how to send a POST request using fetch:

        fetch('/api/add-education-lesson', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id_course_module: educationCourseModuleId,
                time_lesson: educationLessonTime,
                name_lesson: educationLessonName,
                content_lesson: editorData
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);

            if(data == 0) {

                BackToLessonPage()

            } else if(data == 1){
                alert("Education Course Lesson Name is Already Exist! Please Try different Name.");
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('Failed to add education course');
        });
    }

</script>


@endsection
