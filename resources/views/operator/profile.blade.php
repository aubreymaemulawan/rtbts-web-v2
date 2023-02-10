@extends('layouts.app')
@section('title','Manage Profile')

@section('operator_content') 
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> My Profile</h4>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);">
                            <i class="bx bx-user me-1"></i> Personnel Details
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./operator-password">
                            <i class="bx bx-key me-1"></i> Change Password
                        </a>
                    </li>
                </ul>
                <div id="main" class="card mb-4">
                    <form id="updating" enctype="multipart/form-data">
                    @csrf
                        <h5 class="card-header">Personnel Details</h5>
                        <!-- Account -->
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <input type="hidden" class="form-control" id="edit-new_img" name="edit-new_img">
                                <input type="hidden" class="form-control" id="id" name="id" value="{{Auth::user()->personnel_id}}">
                                <input type="hidden" class="form-control" id="password" name="password" value="{{Auth::user()->password}}">
                                <!-- Upload Profile Picture -->
                                <img id="edit-uploadedAvatar" src="{{ asset('assets/img/avatars/default.jpg') }}" alt="user-avatar" class="d-block rounded" height="100" width="100"/>
                                <div class="button-wrapper">
                                    <label for="profile_picture" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="profile_picture" name="profile_picture" class="edit-account-file-input" hidden accept="image/png, image/jpeg"/>
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary edit-account-image-reset mb-4">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>
                                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 2048K</p>
                                    <!-- Error Message -->
                                    <div class="error-pad"> 
                                        <span class="errorMsg_profile_picture"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <div class="row">
                                <!-- Input Username / Email -->
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Username</label>
                                    <input class="form-control" type="text" id="email" name="email"/>
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_email"></span>
                                    </div>
                                </div>
                                <!-- Input Personnel No. -->
                                <div class="mb-3 col-md-6">
                                    <label for="personnel_no" class="form-label">Personnel No.</label>
                                    <input disabled class="form-control" type="text" id="personnel_no" name="personnel_no"/>
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_personnel_no"></span>
                                    </div>
                                </div>
                                <!-- Input Name -->
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input class="form-control" type="text" id="name" name="name"/>
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_name"></span>
                                    </div>
                                </div>
                                <!-- Input Company -->
                                <div class="mb-3 col-md-6">
                                    <label for="company_id" class="form-label">Company</label>
                                    <input disabled class="form-control" type="text" id="company_id" name="company_id"/>
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_company_id"></span>
                                    </div>
                                </div>
                                <!-- Input Age -->
                                <div class="mb-3 col-md-6">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="number" class="form-control" id="age" name="age"/>
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_age"></span>
                                    </div> 
                                </div>
                                <!-- Input Usertype -->
                                <div class="mb-3 col-md-6">
                                    <label for="user_type" class="form-label">User Type</label>
                                    <input disabled class="form-control" type="text" id="user_type" name="user_type"/>
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_user_type"></span>
                                    </div>
                                </div>
                                <!-- Contact No -->
                                <div class="mb-3 col-md-6">
                                    <label for="contact_no" class="form-label">Contact Number</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">PH (+63)</span>
                                        <input type="number" class="form-control" id="contact_no" name="contact_no" />
                                    </div>
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_contact_no"></span>
                                    </div> 
                                </div>
                                <!-- Input Address -->
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Address</label>
                                    <input class="form-control" type="text" id="address" name="address"/>
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_address"></span>
                                    </div> 
                                </div>
                            </div>
                            <!-- Submit Form -->
                            <div class="mt-2">
                                <button id="save" type="submit" class="btn btn-primary me-2">Save changes</button>
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
        $('#menu-operator-profile').addClass('active')
        
        // Personnel Details
        Controller.Post('/api/personnel/items', { 'id': "{{Auth::user()->personnel_id}}" }).done(function(result) {
            Controller.Post('/api/company/items', { 'id': result.company_id }).done(function(result1) {
                // Profile Picture
                if(result.profile_path==null){
                    document.getElementById('edit-uploadedAvatar').src='{{ asset('assets/img/avatars/default.jpg') }}';
                }else{
                    var str = result.profile_path;
                    var str1 = str.replace('public/','../storage/');
                    document.getElementById('edit-uploadedAvatar').src = str1;
                }
                // Clear Error Messages
                $("#main .errorMsg_profile_picture").html('');
                $("#main .errorMsg_personnel_no").html('');
                $("#main .errorMsg_company_id").html('');
                $("#main .errorMsg_user_type").html('');
                $("#main .errorMsg_email").html('');
                $("#main .errorMsg_name").html('');
                $("#main .errorMsg_age").html('');
                $("#main .errorMsg_address").html('');
                $("#main .errorMsg_contact_no").html('');
                // Show ID values in Input Fields
                $('#id').val(result.id),
                $('#personnel_no').val(result.personnel_no),
                $('#company_id').val(result1.company_name),
                $('#user_type').val("Driver"),
                $('#email').val("{{Auth::user()->email}}"),
                $('#name').val(result.name),
                $('#age').val(result.age),
                $('#address').val(result.address),
                $('#contact_no').val(result.contact_no)
            })
        })
        
        $(document).ready(function (e) {
            // Data Table
            $('#dataTable').DataTable();
            // Update/Edit Data
            $(document).on('submit','#updating', function(e) {
                e.preventDefault();
                let editformData = new FormData($('#updating')[0]);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/api/personnel/update_profile') }}",
                    data: editformData,
                    cache: false,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    // If success, return message
                    success: (data) => {
                        var dialog = bootbox.dialog({
                            centerVertical: true,
                            closeButton: false,
                            title: 'Updating Information',
                            message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
                        }); 
                        dialog.init(function(){
                            setTimeout(function(){
                                dialog.find('.bootbox-body').html('Information Successfully updated!');
                                window.location.reload();
                            }, 1500);
                        });
                    },
                    // If fail, show errors
                    error: function(data) {
                        const error2 = data.responseJSON.errors;
                        let error_profile_picture = "";
                        let error_email = "";
                        let error_name = "";
                        let error_age = "";
                        let error_contact_no = "";
                        let error_address = "";
                        for (const listKey in error2){
                            if(listKey == "profile_picture"){
                                error_profile_picture = ""+error2[listKey]+"";
                            }else if(listKey == "email"){
                                error_email = ""+error2[listKey]+"";
                            }else if(listKey == "name"){
                                error_name = ""+error2[listKey]+"";
                            }else if(listKey == "age"){
                                error_age = ""+error2[listKey]+"";
                            }else if(listKey == "contact_no"){
                                error_contact_no = ""+error2[listKey]+"";   
                            }else if(listKey == "address"){
                                error_address = ""+error2[listKey]+"";   
                            }
                        }
                        let msg_profile_picture = "<text>"+error_profile_picture+"</text>";
                        let msg_email = "<text>"+error_email+"</text>";
                        let msg_name = "<text>"+error_name+"</text>";
                        let msg_age = "<text>"+error_age+"</text>";
                        let msg_contact_no = "<text>"+error_contact_no+"</text>";
                        let msg_address = "<text>"+error_address+"</text>";
                        $("#main .errorMsg_profile_picture").html(msg_profile_picture).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_email").html(msg_email).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_name").html(msg_name).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_age").html(msg_age).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_contact_no").html(msg_contact_no).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_address").html(msg_address).addClass('text-danger').fadeIn(1000);
                        $("#main button").attr('disabled',false);
                    }
                });
            });
        });

        
    </script>
@endsection
            