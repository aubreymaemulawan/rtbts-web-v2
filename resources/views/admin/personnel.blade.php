@extends('layouts.app')
@section('title','Manage Personnel')

@section('modal')
    <!-- Viewing Modal -->
        <div class="modal fade" id="view-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <!-- Viewing Form -->
                <form class="modal-content" id="viewing">
                    <div class="modal-header">
                        <h5 class="modal-title" id="view-modalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img id="view-uploadedAvatar" src="{{ asset('assets/img/avatars/default.jpg') }}" alt="user-avatar" class="d-block rounded" height="100" width="100"/>
                            <div class="button-wrapper">
                                <select disabled style="-webkit-appearance: none; background-color: #41729F;" class="btn btn-primary me-2 mb-4" id="view-user_type" name="view-user_type" tabindex="0">
                                    <option value="2">Conductor</option>
                                    <option value="3">Dispatcher</option>
                                    <option value="4">Driver</option>
                                </select>
                                <select disabled style="-webkit-appearance: none;" class="mb-4" id="view-status" name="view-status">
                                    <option value="1">Active</option>
                                    <option value="2">Not Active</option>
                                </select>
                                <p id="update" class="text-muted mb-0"></p>
                            </div>
                        </div>
                        <hr class="hr-style">
                        <div class="mb-3 row">
                            <label for="view-personnel_no" class="col-md-4 col-form-label">Personnel ID Number</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-personnel_no" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-name" class="col-md-4 col-form-label">Full Name</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-name" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-contact_no" class="col-md-4 col-form-label">Contact Number</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-contact_no" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-birthdate" class="col-md-4 col-form-label">Birthdate</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-birthdate" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-address" class="col-md-4 col-form-label">Address</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-address" />
                            </div>
                        </div>
                        <div class="mb-0 row">
                            <label for="view-account" class="col-md-4 col-form-label">Account Status</label>
                            <div class="col-md-8">
                                <select disabled class="form-control" id="view-account" name="view-account">
                                    <option value="1">Enabled</option>
                                    <option value="2">Disabled</option>
                                    <option value="3">No Account</option>
                                </select>
                            </div>
                        </div>
                        <div id="v-u" class="mt-3 mb-3 row" style="display:none">
                            <label for="view-username" class="col-md-4 col-form-label">Username</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-username" name="view-username"/>
                            </div>
                        </div>
                        <div id="v-p" class="mb-0 row" style="display:none">
                            <label for="view-password" class="col-md-4 col-form-label">Password</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-password" name="view-password"/>
                            </div>
                        </div>
                    </div>
                    <!-- Go to Edit / Delete Form -->
                    <div id="view-modal-footer" class="modal-footer">
                        
                    </div>
                </form>
            </div>
        </div>
    <!-- End of Viewing Modal -->

    <!-- Adding Modal -->
        <div class="modal fade" id="add-modal" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <!-- Adding Form -->
                <form class="modal-content" enctype="multipart/form-data" id="adding">
                @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="add-modalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Input Hidden ID -->
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input type="hidden" class="form-control" id="name" name="name">
                        <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{Auth::user()->company_id}}">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <!-- Upload Profile Picture -->
                            <img id="uploadedAvatar" src="{{ asset('assets/img/avatars/default.jpg') }}" alt="user-avatar" class="d-block rounded" height="100" width="100"/>
                            <div class="button-wrapper">
                                <label for="profile_picture" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="profile_picture" name="profile_picture" class="account-file-input" hidden accept="image/png, image/jpeg"/>
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
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
                        <br>
                        <!-- Create Account -->
                        <div class="form-check mt-3 col mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="add-account" name="add-account"/>
                            <label class="form-check-label" for="defaultCheck1">Create Account</label>
                        </div>
                        <div id="add-credentials" class="row g-2" style="display:none">
                            <!-- Generate Username -->
                            <div class="col mb-0">
                                <label for="add-username" class="form-label">Username</label>
                                <div class="input-group input-group-merge">
                                    <input readonly="readonly" type="text" id="add-username" name="add-username" class="form-control"/>
                                </div>
                            </div>
                            <!-- Generate Password -->
                            <div class="col mb-0">
                                <label for="add-password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input readonly="readonly" type="number" id="add-password" name="add-password" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <hr class="hr-style">
                        <div class="row">
                            <!-- Input ID Number -->
                            <div class="col mb-3">
                                <label for="personnel_no" class="form-label">ID Number</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-id-card"></i>
                                    </span>
                                    <input style="padding-left:10px;" readonly="readonly" type="number" id="personnel_no" name="personnel_no" class="form-control" placeholder="00-0000-0000"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_personnel_no"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <!-- Input First Name -->
                            <div class="col">
                                <label for="first_name" class="form-label">First Name</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-user"></i>
                                    </span>
                                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="John"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_first_name"></span>
                                </div>
                            </div>
                            <!-- Input Last Name -->
                            <div class="col">
                                <label for="last_name" class="form-label">Last Name</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-user"></i>
                                    </span>
                                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Doe"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_last_name"></span>
                                </div>
                            </div>
                            <!-- Error Message -->
                            <div class="error-pad1">
                                <span class="errorMsg_name"></span>
                            </div>
                        </div>
                        <div class="row g-2">
                            <!-- Input Birthdate -->
                            <div class="col mb-3">
                                <label for="age" class="form-label">Birthdate</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-calendar"></i>
                                    </span>
                                    <input type="date" id="birthdate" name="birthdate" class="form-control" />
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_birthdate"></span>
                                </div>
                            </div>
                            <!-- Input Contact Number -->
                            <div class="col mb-3">
                                <label for="contact_no" class="form-label">Contact No.</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-phone-call"></i>
                                    </span>
                                    <input type="number" id="contact_no" name="contact_no" class="form-control" placeholder="09 000 000 000"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_contact_no"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Input Address -->
                            <div class="col mb-3">
                                <label for="address" class="form-label">Address</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-map"></i>
                                    </span>
                                    <input type="text" id="address" name="address" class="form-control" placeholder="Street,  Barangay,  City,  State/Province,  ZIP/Postal Code"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_address"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Select User Type -->
                            <div class="col mb-3">
                                <label for="user_type" class="form-label">User Type</label>
                                <div class="input-group input-group-merge">
                                    <select class="form-select" id="user_type" name="user_type">
                                        <option value="" disabled selected hidden>Please Choose...</option>
                                        <option value="2">Conductor</option>
                                        <option value="3">Dispatcher</option>
                                        <option value="4">Driver</option>
                                    </select>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_user_type"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Form -->
                    <div class="modal-footer">
                        <button id="add-close" type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="add-submit" type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    <!-- End of Adding Modal -->

    <!-- Editing Modal -->
        <div class="modal fade" id="edit-modal" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <!-- Editing Form -->
                <form class="modal-content" enctype="multipart/form-data" id="editing">
                @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit-modalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Edit Hidden ID -->
                        <input type="hidden" class="form-control" id="edit-id" name="edit-id">
                        <input type="hidden" class="form-control" id="edit-name" name="edit-name">
                        <input type="hidden" class="form-control" id="edit-new_img" name="edit-new_img">
                        <input type="hidden" class="form-control" id="edit-company_id" name="edit-company_id" value="{{Auth::user()->company_id}}">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <!-- Upload Profile Picture -->
                            <img id="edit-uploadedAvatar" src="{{ asset('assets/img/avatars/default.jpg') }}" alt="user-avatar" class="d-block rounded" height="100" width="100"/>
                            <div class="button-wrapper">
                                <label for="edit-profile_picture" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="edit-profile_picture" name="edit-profile_picture" class="edit-account-file-input" hidden accept="image/png, image/jpeg"/>
                                </label>
                                <button id="reset" type="button" class="btn btn-outline-secondary edit-account-image-reset mb-4">
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
                        <br>
                        <!-- Create Account -->
                        <div id="e-cb" style="display:none" class="form-check mt-3 col mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="edit-account" name="edit-account"/>
                            <label class="form-check-label" for="defaultCheck1">Create Account</label>
                        </div>
                        <div id="edit-credentials" class="row g-2" style="display:none">
                            <!-- Show Username -->
                            <div class="col mb-0">
                                <label for="edit-username" class="form-label">Username</label>
                                <div class="input-group input-group-merge">
                                    <input readonly="readonly" type="text" id="edit-username" name="edit-username" class="form-control"/>
                                </div>
                            </div>
                            <!-- Show Password -->
                            <div class="col mb-0">
                                <label for="edit-password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input readonly="readonly" type="number" id="edit-password" name="edit-password" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <hr class="hr-style">
                        <div class="row">
                            <!-- Edit ID Number -->
                            <div class="col mb-3">
                                <label for="edit-personnel_no" class="form-label">ID Number</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-id-card"></i>
                                    </span>
                                    <input style="padding-left:10px;" readonly="readonly" type="number" id="edit-personnel_no" name="edit-personnel_no" class="form-control" placeholder="00-0000-0000"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_personnel_no"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <!-- Input First Name -->
                            <div class="col">
                                <label for="edit-first_name" class="form-label">First Name</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-user"></i>
                                    </span>
                                    <input type="text" id="edit-first_name" name="edit-first_name" class="form-control" />
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_first_name"></span>
                                </div>
                            </div>
                            <!-- Input Last Name -->
                            <div class="col">
                                <label for="edit-last_name" class="form-label">Last Name</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-user"></i>
                                    </span>
                                    <input type="text" id="edit-last_name" name="edit-last_name" class="form-control" />
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_last_name"></span>
                                </div>
                            </div>
                            <!-- Error Message -->
                            <div class="error-pad1">
                                <span class="errorMsg_name"></span>
                            </div>
                        </div>
                        <div class="row g-2">
                            <!-- Edit Birthdate -->
                            <div class="col mb-3">
                                <label for="edit-birthdate" class="form-label">Birthdate</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-calendar"></i>
                                    </span>
                                    <input type="date" id="edit-birthdate" name="edit-birthdate" class="form-control"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_age"></span>
                                </div>
                            </div>
                            <!-- Edit Contact Number -->
                            <div class="col mb-3">
                                <label for="edit-contact_no" class="form-label">Contact No.</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-phone-call"></i>
                                    </span>
                                    <input type="number" id="edit-contact_no" name="edit-contact_no" class="form-control" placeholder="09 000 000 000"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_contact_no"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Edit Address -->
                            <div class="col mb-3">
                                <label for="edit-address" class="form-label">Address</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-map"></i>
                                    </span>
                                    <input type="text" id="edit-address" name="edit-address" class="form-control" placeholder="Street,  Barangay,  City,  State/Province,  ZIP/Postal Code"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_address"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <!-- Edit User Type -->
                            <div class="col mb-0">
                                <label for="edit-user_type" class="form-label">User Type</label>
                                <div class="input-group input-group-merge">
                                    <select class="form-select" id="edit-user_type" name="edit-user_type">
                                        <option value="" disabled selected hidden>Please Choose...</option>
                                        <option value="2">Conductor</option>
                                        <option value="3">Dispatcher</option>
                                        <option value="4">Driver</option>
                                    </select>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_user_type"></span>
                                </div>
                            </div>
                            <!-- Edit Status -->
                            <div class="col mb-3">
                                <label for="edit-status" class="form-label">Status</label>
                                <div class="input-group input-group-merge">
                                    <select class="form-select" id="edit-status" name="edit-status">
                                        <option value="1">Active</option>
                                        <option value="2">Not Active</option>
                                    </select>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_status"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Form -->
                    <div class="modal-footer">
                        <button id="edit-close" type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="edit-submit" type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    <!-- End of Editing Modal -->
@endsection

@section('admin_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light">Bus Personnel /</span> Manage Personnel
        </h4>
        <div class="alert alert-primary" style="padding:20px">
            <i class="bx bx-info-circle me-1"></i>
            Manage your personnel information here. You can Add, Update, and View data.
        </div>
        <!-- Personnel Table -->
        <div class="card">
            <div class="card-header color">
                <button onclick="Add()" type="button" class="btn rounded-pill btn-primary">Add New</button>
            </div>
            <div class="card-body pad">
                <div class="tbl table-responsive text-nowrap">
                    <table id=dataTable class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Name</th>
                                <th>Personnel No.</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Account</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($personnel as $pn)
                                @if($pn->company_id==Auth::user()->company_id)
                                <tr>
                                    <td></td>
                                    <!-- Profile Column -->
                                    <td>
                                        @if($pn->profile_path==null)
                                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="{{$pn->name}}">
                                                <img src="{{ asset('assets/img/avatars/default.jpg') }}" alt="Avatar" class="rounded-circle" />
                                            </li>
                                        </ul>
                                        @else
                                        <?php
                                            $str = $pn->profile_path;
                                            $str = ltrim($str, 'public/');
                                        ?>
                                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="{{$pn->name}}">
                                                <img src="{{ asset('../storage/'.$str) }}" alt="Avatar" class="rounded-circle" />
                                            </li>
                                        </ul>
                                        @endif
                                    </td>
                                    <!-- Name Column -->
                                    <td><strong>{{$pn->name}}</strong></td>
                                    <!-- Personnel No. Column -->
                                    <td>{{$pn->personnel_no}}</td>
                                    <!-- User Type Column -->
                                    @if ($pn->user_type == 2)
                                    <td>Conductor</td>
                                    @elseif ($pn->user_type == 3)
                                    <td>Dispatcher</td>
                                    @elseif ($pn->user_type == 4)
                                    <td>Driver</td>
                                    @endif
                                    <!-- Status column -->
                                    @if ($pn->status == 1)
                                    <td><span class="badge bg-label-success me-1">Active</span></td>
                                    @elseif ($pn->status == 2)
                                    <td><span class="badge bg-label-danger me-1">Not Active</span></td>
                                    @endif
                                    <!-- Account Status Column -->
                                    @if(DB::table('users')->where('personnel_id',$pn->id)->exists())
                                    <td><span class="badge bg-label-success me-1">Enabled</span></td>
                                    @elseif( DB::table('account')->where('personnel_id',$pn->id)->exists() && !(DB::table('users')->where('personnel_id',$pn->id)->exists()) )
                                    <td><span class="badge bg-label-danger me-1">Disabled</span></td>
                                    @elseif( !(DB::table('account')->where('personnel_id',$pn->id)->exists()) && !(DB::table('users')->where('personnel_id',$pn->id)->exists()) )
                                    <td><span class="badge bg-label-warning me-1">No Account</span></td>
                                    @endif
                                    <!-- Actions Column -->
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <!-- View -->
                                                @if($pn->profile_path==null)
                                                <button onclick="View({{ $pn->id }},document.getElementById('view-uploadedAvatar').src='{{ asset('assets/img/avatars/default.jpg') }}')" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-info-square me-1"></i>
                                                    View
                                                </button>
                                                @else
                                                <button onclick="View({{ $pn->id }},document.getElementById('view-uploadedAvatar').src='{{ asset('../storage/'.$str) }}')" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-info-square me-1"></i>
                                                    View
                                                </button>
                                                @endif
                                                <!-- Edit -->
                                                @if($pn->profile_path==null)
                                                <button onclick="Edit({{ $pn->id }},document.getElementById('edit-uploadedAvatar').src='{{ asset('assets/img/avatars/default.jpg') }}')" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-edit-alt me-1"></i>
                                                    Edit
                                                </button>
                                                @else
                                                <button onclick="Edit({{ $pn->id }},document.getElementById('edit-uploadedAvatar').src='{{ asset('../storage/'.$str) }}')" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-edit-alt me-1"></i>
                                                    Edit
                                                </button>
                                                @endif
                                                <!-- Delete -->
                                                <!-- <button onclick="Delete({{ $pn->id }})" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-trash me-1"></i>
                                                    Delete
                                                </button> -->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts') 
    <script>
        // Sidebar
        $('[id^="main"]').removeClass('active open')
        $('#main-admin-personnel').addClass('active open')
        $('[id^="menu-"]').removeClass('active')
        $('#menu-personnel').addClass('active') 
        
        $(document).ready(function (e) {
            // Data Table
            $('#dataTable').DataTable();
            // Add Data to Database
            $(document).on('submit','#adding', function(e) {
                var first = $.trim($("#first_name").val());
                var last = $.trim($("#last_name").val());
                var name = $.trim();
                $("#name").val(last+', '+first);
                e.preventDefault();
                let addformData = new FormData($('#adding')[0]);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/api/personnel/create') }}",
                    data: addformData,
                    cache: false,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    // If success, return message
                    success: (data) => {
                        var dialog = bootbox.dialog({
                            centerVertical: true,
                            closeButton: false,
                            title: 'Saving Information',
                            message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
                        });
                        $('#add-modal').modal('hide');
                        dialog.init(function(){
                            setTimeout(function(){
                                dialog.find('.bootbox-body').html('Information Successfully saved!');
                                window.location.reload();
                            }, 1500);
                        });
                    },
                    // If fail, show errors
                    error: function(data) {
                        const error1 = data.responseJSON.errors;
                        let error_personnel_no = "";
                        let error_name = "";
                        let error_first_name = "";
                        let error_last_name = "";
                        let error_birthdate = "";
                        let error_contact_no = "";
                        let error_address = "";
                        let error_user_type = "";
                        let error_profile_picture = "";
                        for (const listKey in error1){
                            if(listKey == "personnel_no"){
                                error_personnel_no = ""+error1[listKey]+"";
                            }else if(listKey == "name"){
                                error_name = ""+error1[listKey]+"";
                            }else if(listKey == "birthdate"){
                                error_birthdate = ""+error1[listKey]+"";
                            }else if(listKey == "contact_no"){
                                error_contact_no = ""+error1[listKey]+"";
                            }else if(listKey == "address"){
                                error_address = ""+error1[listKey]+"";
                            }else if(listKey == "user_type"){
                                error_user_type = ""+error1[listKey]+"";
                            }else if(listKey == "profile_picture"){
                                error_profile_picture = ""+error1[listKey]+"";   
                            }else if(listKey == "first_name"){
                                error_first_name = ""+error1[listKey]+"";
                            }else if(listKey == "last_name"){
                                error_last_name = ""+error1[listKey]+"";
                            }
                        }
                        let msg_personnel_no = "<text>"+error_personnel_no+"</text>";
                        let msg_name = "<text>"+error_name+"</text>";
                        let msg_birthdate = "<text>"+error_birthdate+"</text>";
                        let msg_contact_no = "<text>"+error_contact_no+"</text>";
                        let msg_address = "<text>"+error_address+"</text>";
                        let msg_user_type = "<text>"+error_user_type+"</text>";
                        let msg_profile_picture = "<text>"+error_profile_picture+"</text>";
                        let msg_first_name = "<text>"+error_first_name+"</text>";
                        let msg_last_name = "<text>"+error_last_name+"</text>";
                        $("#add-modal .errorMsg_personnel_no").html(msg_personnel_no).addClass('text-danger').fadeIn(1000);
                        $("#add-modal .errorMsg_name").html(msg_name).addClass('text-danger').fadeIn(1000);
                        $("#add-modal .errorMsg_birthdate").html(msg_birthdate).addClass('text-danger').fadeIn(1000);
                        $("#add-modal .errorMsg_contact_no").html(msg_contact_no).addClass('text-danger').fadeIn(1000);
                        $("#add-modal .errorMsg_address").html(msg_address).addClass('text-danger').fadeIn(1000);
                        $("#add-modal .errorMsg_user_type").html(msg_user_type).addClass('text-danger').fadeIn(1000);
                        $("#add-modal .errorMsg_profile_picture").html(msg_profile_picture).addClass('text-danger').fadeIn(1000);
                        $("#add-modal .errorMsg_first_name").html(msg_first_name).addClass('text-danger').fadeIn(1000);
                        $("#add-modal .errorMsg_last_name").html(msg_last_name).addClass('text-danger').fadeIn(1000);
                        $("#add-modal button").attr('disabled',false);
                    }
                });
            });
            // Update/Edit Data
            $(document).on('submit','#editing', function(e) {
                var first = $.trim($("#edit-first_name").val());
                var last = $.trim($("#edit-last_name").val());
                var name = $.trim();
                $("#edit-name").val(last+', '+first);
                e.preventDefault();
                let editformData = new FormData($('#editing')[0]);
                $.ajax({
                    type:'POST',
                    url: "{{ url('/api/personnel/update') }}",
                    data: editformData,
                    cache: false,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    // If success, return message
                    success: (data) => {
                        if(data == 1){
                            let msg_status = "<text>There is an active personnel-schedule assigned to this personnel.</text>";
                            $("#edit-modal .errorMsg_status").html(msg_status).addClass('text-danger').fadeIn(1000);
                            $("#edit-modal button").attr('disabled',false);
                        }else{
                            var dialog = bootbox.dialog({
                                centerVertical: true,
                                closeButton: false,
                                title: 'Updating Information',
                                message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
                            }); 
                            $('#edit-modal').modal('hide');
                            dialog.init(function(){
                                setTimeout(function(){
                                    dialog.find('.bootbox-body').html('Information Successfully updated!');
                                    window.location.reload();
                                }, 1500);
                                
                            });
                        }
                    },
                    // If fail, show errors
                    error: function(data) {
                        const error2 = data.responseJSON.errors;
                        let error_personnel_no = "";
                        let error_name = "";
                        let error_first_name = "";
                        let error_last_name = "";
                        let error_birthdate = "";
                        let error_contact_no = "";
                        let error_address = "";
                        let error_user_type = "";
                        let error_profile_picture = "";
                        let error_status = "";
                        for (const listKey in error2){
                            if(listKey == "edit-personnel_no"){
                                error_personnel_no = ""+error2[listKey]+"";
                            }else if(listKey == "edit-name"){
                                error_name = ""+error2[listKey]+"";
                            }else if(listKey == "edit-birthdate"){
                                error_birthdate = ""+error2[listKey]+"";
                            }else if(listKey == "edit-contact_no"){
                                error_contact_no = ""+error2[listKey]+"";
                            }else if(listKey == "edit-address"){
                                error_address = ""+error2[listKey]+"";
                            }else if(listKey == "edit-user_type"){
                                error_user_type = ""+error2[listKey]+"";
                            }else if(listKey == "edit-profile_picture"){
                                error_profile_picture = ""+error2[listKey]+"";   
                            }else if(listKey == "edit-status"){
                                error_status = ""+error2[listKey]+"";   
                            }else if(listKey == "edit-first_name"){
                                error_first_name = ""+error2[listKey]+"";   
                            }else if(listKey == "edit-last_name"){
                                error_last_name = ""+error2[listKey]+"";   
                            }
                        }
                        let msg_personnel_no = "<text>"+error_personnel_no+"</text>";
                        let msg_name = "<text>"+error_name+"</text>";
                        let msg_first_name = "<text>"+error_first_name+"</text>";
                        let msg_last_name = "<text>"+error_last_name+"</text>";
                        let msg_birthdate = "<text>"+error_birthdate+"</text>";
                        let msg_contact_no = "<text>"+error_contact_no+"</text>";
                        let msg_address = "<text>"+error_address+"</text>";
                        let msg_user_type = "<text>"+error_user_type+"</text>";
                        let msg_profile_picture = "<text>"+error_profile_picture+"</text>";
                        let msg_status = "<text>"+error_status+"</text>";
                        $("#edit-modal .errorMsg_personnel_no").html(msg_personnel_no).addClass('text-danger').fadeIn(1000);
                        $("#edit-modal .errorMsg_name").html(msg_name).addClass('text-danger').fadeIn(1000);
                        $("#edit-modal .errorMsg_birthdate").html(msg_birthdate).addClass('text-danger').fadeIn(1000);
                        $("#edit-modal .errorMsg_contact_no").html(msg_contact_no).addClass('text-danger').fadeIn(1000);
                        $("#edit-modal .errorMsg_address").html(msg_address).addClass('text-danger').fadeIn(1000);
                        $("#edit-modal .errorMsg_user_type").html(msg_user_type).addClass('text-danger').fadeIn(1000);
                        $("#edit-modal .errorMsg_profile_picture").html(msg_profile_picture).addClass('text-danger').fadeIn(1000);
                        $("#edit-modal .errorMsg_status").html(msg_status).addClass('text-danger').fadeIn(1000);
                        $("#edit-modal .errorMsg_first_name").html(msg_first_name).addClass('text-danger').fadeIn(1000);
                        $("#edit-modal .errorMsg_last_name").html(msg_last_name).addClass('text-danger').fadeIn(1000);
                        $("#edit-modal button").attr('disabled',false);
                    }
                });
            });
        })

        // Onclick View Function
        function View(id){
            $('#view-status').removeClass("btn btn-danger")
            $('#view-status').removeClass("btn btn-success")
            $('#view-modal-footer').html('')
            document.getElementById("view-modalTitle").innerHTML="View Personnel Information";
            // Show Account Values
            Controller.Post('/api/account/find', { 'personnel_id': id }).done(function([acc_email,acc_pass,user_email,user_pass]) {
                if(acc_email !=null && user_email != null){
                    $('#v-u').show(),
                    $('#v-p').show(),
                    $('#view-account').val(1),
                    $('#view-username').val(acc_email),
                    $('#view-password').val(acc_pass)
                }else if(acc_email !=null && user_email == null){
                    $('#v-u').show(),
                    $('#v-p').show(),
                    $('#view-account').val(2),
                    $('#view-username').val(acc_email),
                    $('#view-password').val(acc_pass)
                }else if(acc_email == null && user_email == null){
                    $('#view-account').val(3),
                    $('#v-u').hide(),
                    $('#v-p').hide()
                }
            });
            // Change Color of Status
            Controller.Post('/api/personnel/items', { 'id': id }).done(function(result) {
                var date1 = moment(result.updated_at).format('MMMM Do YYYY, h:mm a');
                var birthday = moment(result.birthdate).format('MMMM Do YYYY');
                document.getElementById("update").innerHTML="Last Updated : "+date1;
                if(result.status == 1){
                    $('#view-status').addClass("btn btn-success")
                }else if(result.status == 2){
                    $('#view-status').addClass("btn btn-danger")
                }
                if(result.profile_path==null){
                    var edit1 = "document.getElementById('edit-uploadedAvatar').src='{{ asset('assets/img/avatars/default.jpg') }}'"
                    $('#view-modal-footer').append('<button onclick="Edit('+result.id+','+edit1+')" type="button" class="btn btn-outline-primary">Edit</button>');  
                }else{
                    var str = result.profile_path;
                    var str1 = str.replace('public/','')
                    var str2 = "document.getElementById('edit-uploadedAvatar').src='{{ asset('../storage/rep') }}'"
                    var edit2 = str2.replace('rep',''+str1+'')
                    $('#view-modal-footer').append('<button onclick="Edit('+result.id+','+edit2+')" type="button" class="btn btn-outline-primary">Edit</button>');  
                }
                // $('#view-modal-footer').append('<button onclick="Delete('+result.id+')" type="button" class="btn btn-outline-danger">Delete</button>');
                $('#view-id').val(result.id),
                $('#view-personnel_no').val(result.personnel_no),
                $('#view-name').val(result.name),
                $('#view-birthdate').val(birthday),
                $('#view-contact_no').val(result.contact_no),
                $('#view-address').val(result.address),
                $('#view-user_type').val(result.user_type),
                $('#view-status').val(result.status),
                $('#view-modal').modal('show')
            });
        }

        // Onclick Add Function
        function Add(){
            var unique_id = Math.floor(100000000 + Math.random() * 900000000);
            document.getElementById("add-modalTitle").innerHTML= "Create Personnel Information";
            document.getElementById("uploadedAvatar").src = "{{ asset('assets/img/avatars/default.jpg') }}";
            // Clear Input Fields
            $('#id').val('-1'),
            // $('#personnel_no').val(''),
            $('#name').val(''),
            $('#age').val(''),
            $('#contact_no').val(''),
            $('#address').val(''),
            $('#profile_picture').val(''),
            $('#user_type').val(''),
            $('#personnel_no').val(unique_id),
            $('#first_name').val(''),
            $('#last_name').val(''),
            // Clear Checkbox 
            $('#add-username').val(unique_id),
            $('#add-password').val(unique_id),
            $("#add-account").prop("checked", false);
            $("#add-credentials").hide();
            // Clear Error Messages
            $("#add-modal .errorMsg_personnel_no").html('');
            $("#add-modal .errorMsg_name").html('');
            $("#add-modal .errorMsg_age").html('');
            $("#add-modal .errorMsg_contact_no").html('');
            $("#add-modal .errorMsg_address").html('');
            $("#add-modal .errorMsg_user_type").html('');
            $("#add-modal .errorMsg_profile_picture").html('');
            // Show Modal
            $('#add-modal').modal('show');
            // Create Account Checkbox is clicked
            $("input[name=add-account]").change(function(){
                if($("#add-account").is(':checked')){
                    $('#add-account').val(1);
                    $("#add-credentials").show();
                }else{
                    $('#add-account').val(0);
                    $("#add-credentials").hide();
                }
            });
            
            // // Personnel_no == Username (add)
            // $('#personnel_no').keyup(function (){
            //     $('#add-username').val($(this).val());
            // });
            // // Personnel_no == Password (add)
            // $('#personnel_no').keyup(function (){
            //     $('#add-password').val($(this).val());
            // });
        }

        // Onclick Edit Function
        function Edit(id) {
            $('#view-modal').modal('hide');
            $('#e-cb').hide(),
            $('#edit-credentials').hide(),
            $('#edit-username').val(''),
            $('#edit-password').val(''),
            document.getElementById("edit-modalTitle").innerHTML="Edit Personnel Information";
            // Show Values in Modal
            Controller.Post('/api/personnel/items', { 'id': id }).done(function(result) {
                // Show ID values in Input Fields
                $('#edit-id').val(result.id),
                $('#edit-personnel_no').val(result.personnel_no),
                $('#edit-name').val(result.name),
                $('#edit-first_name').val(result.first_name),
                $('#edit-last_name').val(result.last_name),
                $('#edit-birthdate').val(result.birthdate),
                $('#edit-contact_no').val(result.contact_no),
                $('#edit-address').val(result.address),
                $('#edit-user_type').val(result.user_type),
                $('#edit-status').val(result.status),
                // Clear Error Messages
                $("#edit-modal .errorMsg_personnel_no").html('');
                $("#edit-modal .errorMsg_name").html('');
                $("#edit-modal .errorMsg_age").html('');
                $("#edit-modal .errorMsg_contact_no").html('');
                $("#edit-modal .errorMsg_address").html('');
                $("#edit-modal .errorMsg_user_type").html('');
                $("#edit-modal .errorMsg_profile_picture").html('');
                // Show Modal
                $('#edit-modal').modal('show')
                // Show Account Values
                Controller.Post('/api/account/find', { 'personnel_id': id }).done(function([acc_email,acc_pass,user_email,user_pass]) {
                    // If status is active and account is available == ENABLED
                    if(acc_email != null && user_email != null){ 
                        $('#e-cb').hide(),
                        $('#edit-credentials').show(),
                        $('#edit-username').val(acc_email),
                        $('#edit-password').val(acc_pass)
                    }// If status is not active but account is available == DISABLED
                    else if(acc_email != null && user_email == null && result.status == 2){
                        $('#e-cb').hide(),
                        $('#edit-credentials').show(),
                        $('#edit-username').val(acc_email),
                        $('#edit-password').val(acc_pass)
                    }// If status is not active and no account available == NO ACCOUNT
                    else if(acc_email == null && user_email == null){
                        $('#e-cb').show(),
                        $("#edit-account").prop("checked", false);
                        $('#edit-credentials').hide(),
                        // Edit Account Checkbox is clicked
                        $("input[name=edit-account]").change(function(){
                            if($("#edit-account").is(':checked')){
                                $('#edit-account').val(1);
                                $("#edit-credentials").show();
                                $('#edit-username').val($('#edit-personnel_no').val());
                                $('#edit-password').val($('#edit-personnel_no').val());
                                // Personnel_no == Username (edit)
                                $('#edit-personnel_no').keyup(function (){
                                    $('#edit-username').val($(this).val());
                                });
                                // Personnel_no == Password (edit)
                                $('#edit-personnel_no').keyup(function (){
                                    $('#edit-password').val($(this).val());
                                });
                            }else{
                                $('#edit-account').val(0);
                                $("#edit-credentials").hide();
                            }
                        });
                    }
                });
            });
        }

        // Onclick Delete Function
        // function Delete(id) {
        //     $('#view-modal').modal('hide');
        //     bootbox.confirm({
        //         title: "Deleting Information",
        //         closeButton: false,
        //         message: "Are you sure you want to delete this item? This cannot be undone.",
        //         buttons: {
        //             cancel: {
        //                 label: 'Cancel',
        //                 className : "btn btn-outline-secondary",
        //             },
        //             confirm: {
        //                 label: 'Confirm',
        //                 className : "btn btn-primary",
        //             }
        //         },
        //         centerVertical: true,
        //         callback: function(result){
        //             if(result) {
        //                 Controller.Post('/api/personnel/delete', { 'id': id }).done(function(result) {
        //                     if(result == 1){
        //                         bootbox.confirm({
        //                             title: "Oops! There is a personnel-schedule with this personnel.",
        //                             closeButton: false,
        //                             message: "Go to personnel-schedules list?",
        //                             buttons: {
        //                                 cancel: {
        //                                     label: 'No',
        //                                     className : "btn btn-outline-secondary",
        //                                 },
        //                                 confirm: {
        //                                     label: 'Yes',
        //                                     className : "btn btn-primary",
        //                                 }
        //                             },
        //                             centerVertical: true,
        //                             callback: function(result){
        //                                 if(result) {
        //                                     location.href = './personnel-schedule';
        //                                 }
        //                             }
        //                             })
        //                     }else{
        //                         var dialog = bootbox.dialog({
        //                             centerVertical: true,
        //                             closeButton: false,
        //                             title: 'Deleting Information',
        //                             message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
        //                         });
        //                         dialog.init(function(){
        //                             setTimeout(function(){
        //                                 dialog.find('.bootbox-body').html('Information Successfully deleted!');
        //                                 window.location.reload();
        //                             }, 1500);
                                    
        //                         });
        //                     }
        //                 });
        //             }
        //         }
        //     })
        // }

    </script>
@endsection
    