@extends('header.header')

@section('content')

<link rel="stylesheet" href="{{ asset ('assets/css/dashboard/member.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">



<div class="main mx-auto">
    <div class="w-100 p-3">
        
        <nav aria-label="breadcrumb mt-3 ">
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page">Members Management</li>
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
                <button id="toggleBlockedButton" onclick="toggleBlockedMembers()" class="btn btn-block-view table-btn-view text-white fw-bold">Blocked Members List</button>
            </div>
        </div>
        
        <table id="membersTable" class="table table-striped table-bordered my-3">
            <thead>
                <tr>
                    <th class="text-center" width="10%">No.</th>
                    <th class="text-center">MEMBER'S NAME</th>
                    <th class="text-center">EMAIL</th>
                    <th class="text-center" width="10%">COUNTRY</th>
                    <th class="text-center" width="15%">VERIFIED</th>
                    <th class="text-center" width="15%"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script>

let isBlocked = false; // Track if blocked members are currently displayed

function toggleBlockedMembers() {
    isBlocked = !isBlocked; // Toggle the state
    
    const toggleBlockedButton = document.getElementById('toggleBlockedButton');
    toggleBlockedButton.textContent = isBlocked ? 'Unblocked Members List' : 'Blocked Members List';
    
    if (isBlocked) {
        toggleBlockedButton.classList.remove('btn-block-view');
        toggleBlockedButton.classList.add('btn-unblock-view');
    } else {
        toggleBlockedButton.classList.remove('btn-unblock-view');
        toggleBlockedButton.classList.add('btn-block-view');
    }
    
    handleTableData();
}

document.addEventListener("DOMContentLoaded", () => {
    handleTableData();
})

function handleTableData() {
    const membersTableBody = document.querySelector('#membersTable tbody');

    fetch(`/api/members/${isBlocked ? 'blocked' : 'unblocked'}`)
        .then(response => response.json())
        .then(data => {
            console.table(data);

            if (data.length === 0) {
                // If there are no registered users, display a message
                membersTableBody.innerHTML = `
                    <tr>
                        
                        <td colspan="6" class="align-middle text-center">${isBlocked ? 'No Blocked User.' : 'No Registered User.' }</td>
                    </tr>
                `;
            } else {
                // Clear existing table content
                membersTableBody.innerHTML = '';

                data.forEach((user, index) => {

                    // console.log(user);
                    const row = `
                        <tr>
                            <td class="text-center align-middle fw-bold">${user.id}</td>
                            <td class="text-start align-middle">${user.first_name} ${user.last_name}</td>
                            <td class="text-start align-middle">${user.email}</td>
                            <td class="text-center align-middle">${user.country}</td>
                            <td class="text-center align-middle">${user.email_verified ? 'Verified' : 'Not Verified'}</td>
                            <td class="text-center align-middle">
                                <button class="btn btn-view-user" onclick="user_profile(${user.id})">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#0B7CB8" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier"> 
                                            <path d="M18.5 19.5L20 21M4 21C4 17.134 7.13401 14 11 14M19 17.5C19 18.8807 17.8807 20 16.5 20C15.1193 20 14 18.8807 14 17.5C14 16.1193 15.1193 15 16.5 15C17.8807 15 19 16.1193 19 17.5ZM15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                                        </g>
                                    </svg>
                                </button>
                                <button class="btn btn-edit-user">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier"> 
                                            <path d="M4 21C4 17.134 7.13401 14 11 14C11.3395 14 11.6734 14.0242 12 14.0709M15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7ZM12.5898 21L14.6148 20.595C14.7914 20.5597 14.8797 20.542 14.962 20.5097C15.0351 20.4811 15.1045 20.4439 15.1689 20.399C15.2414 20.3484 15.3051 20.2848 15.4324 20.1574L19.5898 16C20.1421 15.4477 20.1421 14.5523 19.5898 14C19.0376 13.4477 18.1421 13.4477 17.5898 14L13.4324 18.1574C13.3051 18.2848 13.2414 18.3484 13.1908 18.421C13.1459 18.4853 13.1088 18.5548 13.0801 18.6279C13.0478 18.7102 13.0302 18.7985 12.9948 18.975L12.5898 21Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                                        </g>
                                    </svg>
                                </button>
                                ${isBlocked 
                                ? `<button class="btn btn-unblock-user" onclick="user_unblock(${user.id})">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 18L14 18M17 15V21M4 21C4 17.134 7.13401 14 11 14C11.695 14 12.3663 14.1013 13 14.2899M15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>`
                                : `<button class="btn btn-block-user" onclick="user_block(${user.id})">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier"> 
                                            <path d="M15 16L20 21M20 16L15 21M4 21C4 17.134 7.13401 14 11 14M15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                                        </g>
                                    </svg>
                                </button>`}
                            </td>
                        </tr>
                    `;
                    membersTableBody.innerHTML += row;
                });
            }
        })
    .catch(error => console.error('Error fetching members:', error));
}

function user_block(userId) {
    fetch(`/members/user-block/${userId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            // Block action successful, now refresh the table data
            handleTableData();
        } else {
            // Handle error case here
            alert('Failed to block user');
        }
    })
    .catch(error => console.error('Error blocking user:', error));
}


function user_unblock(userId) {
    fetch(`/members/user-unblock/${userId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            // Block action successful, now refresh the table data
            handleTableData();
        } else {
            // Handle error case here
            alert('Failed to block user');
        }
    })
    .catch(error => console.error('Error blocking user:', error));
}

function user_profile(userId) {
    // Redirect to the user profile page with the user's ID
    window.location.href = `/members/user-profile/${userId}`;
}
 
</script>

@endsection
