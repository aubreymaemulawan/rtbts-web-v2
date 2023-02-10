@extends('layouts.app')
@section('title','Manage Profile')

@section('admin_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> My Profile</h4>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);">
                            <i class="bx bx-user me-1"></i> Company Details
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./change-email">
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
                        <h5 class="card-header">Company Details</h5>
                        <!-- Account -->
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <input type="hidden" class="form-control" id="edit-new_img" name="edit-new_img">
                                <input type="hidden" class="form-control" id="id" name="id" value="{{Auth::user()->company_id}}">
                                <input type="hidden" class="form-control" id="email" name="email" value="{{Auth::user()->email}}">
                                <input type="hidden" class="form-control" id="password" name="password" value="{{Auth::user()->password}}">
                                <!-- Upload Profile Picture -->
                                <img id="edit-uploadedAvatar" src="{{ asset('assets/img/avatars/default.jpg') }}" alt="user-avatar" class="d-block rounded" height="100" width="100"/>
                                <div class="button-wrapper">
                                    <label for="logo_picture" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="logo_picture" name="logo_picture" class="edit-account-file-input" hidden accept="image/png, image/jpeg"/>
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary edit-account-image-reset mb-4">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>
                                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 2048K</p>
                                    <!-- Error Message -->
                                    <div class="error-pad"> 
                                        <span class="errorMsg_logo_picture"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <div class="row">
                                <!-- Input Company Name -->
                                <div class="mb-3 col-md-6">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input class="form-control" type="text" id="company_name" name="company_name"/>
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_company_name"></span>
                                    </div>
                                </div>
                                <!-- Input User Type -->
                                <div class="mb-3 col-md-6">
                                    <label for="user_type" class="form-label">User Type</label>
                                    <input disabled class="form-control" type="text" id="user_type" name="user_type"/>  
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_user_type"></span>
                                    </div>                               
                                </div>
                                <!-- Input Postal Code -->
                                <div class="mb-3 col-md-6">
                                    <label for="postal_code" class="form-label">Postal Code</label>
                                    <input type="number" class="form-control" id="postal_code" name="postal_code" maxlength="6"/>
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_postal_code"></span>
                                    </div> 
                                </div>
                                <!-- Input Country -->
                                <div class="mb-3 col-md-6">
                                    <label for="country" class="form-label">Country / Region</label>
                                    <input disabled class="form-control" type="text" id="country" name="country"/>
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_country"></span>
                                    </div> 
                                </div>
                                <!-- Input City -->
                                <div class="mb-3 col-md-6">
                                    <label for="city" class="form-label">Province - City</label>
                                    <select class="form-select" id="city" name="city">
                                        <option value="" disabled selected hidden></option>
                                        @foreach($city as $val)
                                            <option value="{{ $val->city_name }} City, {{ $val->province->province_name }}">{{ $val->province->province_name }} - {{ $val->city_name }}</option>
                                        @endforeach
                                    </select>   
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_city"></span>
                                    </div> 
                                </div>
                                <!-- Input Street Address -->
                                <div class="mb-3 col-md-6">
                                    <label for="street" class="form-label">Street Address</label>
                                    <input type="text" class="form-control" id="street" name="street"/>
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_street"></span>
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
                                <!-- Input Description -->
                                <div class="mb-3 col-md-6">
                                    <label for="description" class="form-label">Company Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                    <!-- Error Message -->
                                    <div class="error-pad">
                                        <span class="errorMsg_description"></span>
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
        $('#menu-profile').addClass('active')
        
        // Company Details
        Controller.Post('/api/company/items', { 'id': "{{Auth::user()->company_id}}" }).done(function(result) {
            var street = "";
            var city = "";
            var province = "";
            var country = "";
            var postal_code = "";
            if(result.address==null || result.address==""){
                street = "";
                city = "";
                province = "";
                country = "";
                postal_code = "";
            }else{
                var text = result.address;
                const arr = text.split(", ",);
                street = arr[0];
                city1 = arr[1];
                province = arr[2];
                country = arr[3];
                postal_code = arr[4];
                city = city1.replace(' City','');
            }
            // Profile Picture
            if(result.logo_path==null){
                document.getElementById('edit-uploadedAvatar').src='{{ asset('assets/img/avatars/default.jpg') }}';
            }else{
                var str = result.logo_path;
                var str1 = str.replace('public/','../storage/');
                document.getElementById('edit-uploadedAvatar').src = str1;
            }
            // Clear Error Messages
            $("#main .errorMsg_logo_picture").html('');
            $("#main .errorMsg_company_name").html('');
            $("#main .errorMsg_user_type").html('');
            $("#main .errorMsg_country").html('');
            $("#main .errorMsg_postal_code").html('');
            $("#main .errorMsg_city").html('');
            $("#main .errorMsg_street").html('');
            $("#main .errorMsg_contact_no").html('');
            $("#main .errorMsg_status").html('');
            $("#main .errorMsg_description").html('');
            // Show ID values in Input Fields
            $('#id').val(result.id),
            $('#company_name').val(result.company_name),
            $('#user_type').val("Admin"),
            $('#country').val("Philippines"),
            $('#postal_code').val(postal_code),
            $('#city').val(city+" City, "+province),
            $('#street').val(street),
            $('#contact_no').val(result.contact_no),
            $('#description').val(result.description)
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
                    url: "{{ url('/api/company/update') }}",
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
                        let error_logo_picture = "";
                        let error_company_name = "";
                        let error_user_type = "";
                        let error_country = "";
                        let error_postal_code = "";
                        let error_city = "";
                        let error_street = "";
                        let error_contact_no = "";
                        let error_status = "";
                        let error_description = "";
                        for (const listKey in error2){
                            if(listKey == "logo_picture"){
                                error_logo_picture = ""+error2[listKey]+"";
                            }else if(listKey == "company_name"){
                                error_company_name = ""+error2[listKey]+"";
                            }else if(listKey == "user_type"){
                                error_user_type = ""+error2[listKey]+"";
                            }else if(listKey == "country"){
                                error_country = ""+error2[listKey]+"";
                            }else if(listKey == "postal_code"){
                                error_postal_code = ""+error2[listKey]+"";
                            }else if(listKey == "city"){
                                error_city = ""+error2[listKey]+"";
                            }else if(listKey == "street"){
                                error_street = ""+error2[listKey]+"";   
                            }else if(listKey == "contact_no"){
                                error_contact_no = ""+error2[listKey]+"";   
                            }else if(listKey == "status"){
                                error_status = ""+error2[listKey]+"";   
                            }else if(listKey == "description"){
                                error_description = ""+error2[listKey]+"";   
                            }
                        }
                        let msg_logo_picture = "<text>"+error_logo_picture+"</text>";
                        let msg_company_name = "<text>"+error_company_name+"</text>";
                        let msg_user_type = "<text>"+error_user_type+"</text>";
                        let msg_country = "<text>"+error_country+"</text>";
                        let msg_postal_code = "<text>"+error_postal_code+"</text>";
                        let msg_city = "<text>"+error_city+"</text>";
                        let msg_street = "<text>"+error_street+"</text>";
                        let msg_contact_no = "<text>"+error_contact_no+"</text>";
                        let msg_status = "<text>"+error_status+"</text>";
                        let msg_description = "<text>"+error_description+"</text>";
                        $("#main .errorMsg_logo_picture").html(msg_logo_picture).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_company_name").html(msg_company_name).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_user_type").html(msg_user_type).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_country").html(msg_country).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_postal_code").html(msg_postal_code).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_city").html(msg_city).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_street").html(msg_street).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_contact_no").html(msg_contact_no).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_status").html(msg_status).addClass('text-danger').fadeIn(1000);
                        $("#main .errorMsg_description").html(msg_description).addClass('text-danger').fadeIn(1000);
                        $("#main button").attr('disabled',false);
                    }
                });
            });
        });

        
    </script>
@endsection
            