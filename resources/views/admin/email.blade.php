@extends('layouts.app')
@section('title','Manage Profile')

@section('admin_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> My Profile</h4>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link" href="./profile">
                            <i class="bx bx-user me-1"></i> Company Details
                        </a>
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link active" href="javascript:void(0);">
                            <i class="bx bx-envelope me-1"></i> Change Email
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./change-password">
                            <i class="bx bx-key me-1"></i> Change Password
                        </a>
                    </li>
                </ul>
                <div id="main" class="card mb-4">
                    <form id="updating" enctype="multipart/form-data">
                    @csrf
                        <h5 class="card-header">Change Admin Email</h5>
                        <hr class="my-0"/>
                        <br>
                        <div class="card-body">
                            <input type="hidden" class="form-control" id="id" name="id" value="{{Auth::user()->company_id}}">
                            <input type="hidden" class="form-control" id="email" name="email" value="{{Auth::user()->email}}">
                            <input type="hidden" class="form-control" id="password" name="password" value="{{Auth::user()->password}}">
                            <div class="row justify-content-center">
                                <!-- Input New Email -->
                                <div class="justify-content-center row mb-4">
                                    <div class="col-md-3">
                                        <label for="current_email" class="form-label">Current Email Address</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input disabled class="form-control" type="text" id="current_email" name="current_email"/>
                                    </div>
                                </div>
                                <!-- Input New Email -->
                                <div class="justify-content-center row mb-4">
                                    <div class="col-md-3">
                                        <label for="new_email" class="form-label">New Email Address</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" id="new_email" name="new_email" autofocus/>
                                        <!-- Error Message -->
                                        <div class="error-pad">
                                            <span class="errorMsg_new_email"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Input Admin Password -->
                                <div class="justify-content-center row mb-3">
                                    <div class="col-md-3">
                                        <label for="admin_password" class="form-label">Admin Password</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="password" id="admin_password" name="admin_password"/>
                                        <!-- Error Message -->
                                        <div class="error-pad">
                                            <span class="errorMsg_admin_password"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <!-- Submit Form -->
                            <div class="mt-2">
                                <button id="save" type="submit" class="btn btn-primary me-2">Send Email Verification</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Sidebar
        $('[id^="menu-"]').removeClass('active')
        $('#menu-profile').addClass('active')
        $("#current_email").val('{{Auth::user()->email}}');

        $(document).ready(function (e) {
            // Data Table
            $('#dataTable').DataTable();
            // Update/Edit Data
            $(document).on('submit','#updating', function(e) {
                $("#main .errorMsg_admin_password").html('');
                $("#main .errorMsg_new_email").html('');
                e.preventDefault();
                let editformData = new FormData($('#updating')[0]);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/api/company/update_email') }}",
                    data: editformData,
                    cache: false,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    // If success, return message
                    success: (data) => {
                        if(data == 1){
                            let msg_new_email = "<text>Please choose a new email.</text>";
                            $("#main .errorMsg_new_email").html(msg_new_email).addClass('text-danger').fadeIn(1000);
                            $("#main button").attr('disabled',false);
                        }else if(data == 2){
                            let msg_admin_password = "<text>The password is incorrect.</text>";
                            $("#main .errorMsg_admin_password").html(msg_admin_password).addClass('text-danger').fadeIn(1000);
                            $("#main button").attr('disabled',false);
                        }else{
                            var dialog = bootbox.dialog({
                            centerVertical: true,
                            closeButton: false,
                            title: 'Updating Information',
                            message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
                            }); 
                            dialog.init(function(){
                                setTimeout(function(){
                                    dialog.find('.bootbox-body').html('Email Successfully updated!');
                                    window.location.reload();
                                }, 1500);
                            });
                        }
                    },
                    // If fail, show errors
                    error: function(data) {
                        const error2 = data.responseJSON.errors;
                        let error_new_email = "";
                        let error_admin_password = "";
                        for (const listKey in error2){
                            if(listKey == "new_email"){
                                error_new_email = ""+error2[listKey]+"";
                            }else if(listKey == "admin_password"){
                                error_admin_password = ""+error2[listKey]+"";
                            }
                        }
                        let msg_new_email = "<text>"+error_new_email+"</text>";
                        let msg_admin_password = "<text>"+error_admin_password+"</text>";
                        $("#main .errorMsg_new_email").html(msg_new_email).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_admin_password").html(msg_admin_password).addClass('text-danger').fadeIn(1000);
                        $("#main button").attr('disabled',false);
                    }
                });
            });
        });

        
    </script>
@endsection
            