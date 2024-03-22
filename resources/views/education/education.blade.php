@extends('header.header')

@section('content')

<link rel="stylesheet" href="{{ asset ('assets/css/dashboard/dashboard.css') }}">

<div class="main">
    
    <div class="row m-auto p-3">
        <h1 class="text-center">Education Management</h1>
        <div class="col-sm-6 col-xl-4 p-3">
            <a href="/education_topic" class="card navigation-section p-3">
                <img class="card-img-icon" width="64" height="64" src="https://img.icons8.com/bubbles/50/topic.png"/>
                <div class="card-body">
                    <h5 class="card-title">Topics</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-4 p-3">
            <a href="/education_level" class="card navigation-section p-3">
                <img class="card-img-icon" width="64" height="64" src="https://img.icons8.com/clouds/100/business.png"/>
                <div class="card-body">
                    <h5 class="card-title">Difficulty</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-4 p-3">
            <a href="/education_course" class="card navigation-section p-3">
                <img class="card-img-icon" width="64" height="64" src="https://img.icons8.com/clouds/100/classroom.png"/>
                <div class="card-body">
                    <h5 class="card-title">Course</h5>
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
@endsection