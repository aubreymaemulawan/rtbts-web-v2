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
                        <a class="nav-link" href="./change-email">
                            <i class="bx bx-envelope me-1"></i> Change Email
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);">
                            <i class="bx bx-key me-1"></i> Change Password
                        </a>
                    </li>
                </ul>
                <div id="main" class="card mb-4">
                    <form id="updating" enctype="multipart/form-data">
                    @csrf
                        <h5 class="card-header">Change Admin Password</h5>
                        <hr class="my-0"/>
                        <br>
                        <div class="card-body">
                            <input type="hidden" class="form-control" id="id" name="id" value="{{Auth::user()->company_id}}">
                            <div class="row justify-content-center">
                                <!-- Input Current Password -->
                                <div class="justify-content-center row mb-4">
                                    <div class="col-md-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="password" id="current_password" name="current_password" autofocus/>
                                        <!-- Error Message -->
                                        <div class="error-pad">
                                            <span class="errorMsg_current_password"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Input New Password -->
                                <div class="justify-content-center row mb-4">
                                    <div class="col-md-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="password" id="new_password" name="new_password"/>
                                        <!-- Error Message -->
                                        <div class="error-pad">
                                            <span class="errorMsg_new_password"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Input Re-type Password -->
                                <div class="justify-content-center row mb-3">
                                    <div class="col-md-3">
                                        <label for="retype_password" class="form-label">Re-type New Password</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="password" id="retype_password" name="retype_password"/>
                                        <!-- Error Message -->
                                        <div class="error-pad">
                                            <span class="errorMsg_retype_password"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <!-- Submit Form -->
                            <div class="mt-2">
                                <button id="save" type="submit" class="btn btn-primary me-2">Update Password</button>
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
        
        $(document).ready(function (e) {
            // Update/Edit Data
            $(document).on('submit','#updating', function(e) {
                $("#main .errorMsg_current_password").html('');
                $("#main .errorMsg_new_password").html('');
                $("#main .errorMsg_retype_password").html('');
                e.preventDefault();
                let editformData = new FormData($('#updating')[0]);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/api/company/update_password') }}",
                    data: editformData,
                    cache: false,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    // If success, return message
                    success: (data) => {
                        if(data == 1){
                            let msg_current_password = "<text>The password is incorrect.</text>";
                            $("#main .errorMsg_current_password").html(msg_current_password).addClass('text-danger').fadeIn(1000);
                            $("#main button").attr('disabled',false);
                        }else if(data == 2){
                            let msg_new_password = "<text>Please choose a new password.</text>";
                            $("#main .errorMsg_new_password").html(msg_new_password).addClass('text-danger').fadeIn(1000);
                            $("#main button").attr('disabled',false);
                        }else{
                            var dialog = bootbox.dialog({
                                centerVertical: true,
                                closeButton: false,
                                title: 'Updating Password',
                                message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
                            }); 
                            dialog.init(function(){
                                setTimeout(function(){
                                    dialog.find('.bootbox-body').html('Password Successfully updated!');
                                    window.location.reload();
                                }, 1500);
                            });
                        }
                        
                    },
                    // If fail, show errors
                    error: function(data) {
                        const error2 = data.responseJSON.errors;
                        let error_current_password = "";
                        let error_new_password = "";
                        let error_retype_password = "";
                        for (const listKey in error2){
                            if(listKey == "current_password"){
                                error_current_password = ""+error2[listKey]+"";
                            }else if(listKey == "new_password"){
                                error_new_password = ""+error2[listKey]+"";
                            }else if(listKey == "retype_password"){
                                error_retype_password = ""+error2[listKey]+"";
                            }
                        }
                        let msg_current_password = "<text>"+error_current_password+"</text>";
                        let msg_new_password = "<text>"+error_new_password+"</text>";
                        let msg_retype_password = "<text>"+error_retype_password+"</text>";
                        $("#main .errorMsg_current_password").html(msg_current_password).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_new_password").html(msg_new_password).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_retype_password").html(msg_retype_password).addClass('text-danger').fadeIn(1000);
                        $("#main button").attr('disabled',false);
                    }
                });
            });
        });

        
    </script>
@endsection
            