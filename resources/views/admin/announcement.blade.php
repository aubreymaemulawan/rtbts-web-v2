@extends('layouts.app')
@section('title','Announcements')

@section('modal')
    <!-- View Modal --> 
        <div class="modal fade" id="view-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <!-- View Form -->
                <form class="modal-content" id="view_logs">
                    <div class="modal-header">
                        <h5 class="modal-title" id="view-modalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="body" class="modal-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-2">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-envelope"></i>
                                </span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h5 class="mb-1" id="sub"></h5>
                                    <small id="to"></small>
                                </div>
                            </div>
                        </div>
                        <hr class="hr-style">
                        <li class="d-flex mb-1 pb-1">
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <p class="mb-4" id="mess"></p>
                                <small class="col-12">From : {{Auth::user()->name}}</small>
                                <small class=" col-12" id="date"></small>
                            </div>
                        </li> 
                    </div>
                </form>
            </div>
        </div>
    <!-- End of View Modal -->

    <!-- Adding Modal -->
        <div class="modal fade" id="main-modal" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <!-- Adding Form -->
                <form class="modal-content">
                @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="main-modalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <hr class="hr-style-1">
                    <div class="modal-body">
                        <!-- Input Hidden ID -->
                        <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{Auth::user()->company_id}}">
                        <div class="row">
                            <!-- Input Subject -->
                            <div class="col mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-text"></i>
                                    </span>
                                    <input type="text" id="subject" name="subject" class="form-control" placeholder=""/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_subject"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Input Message -->
                            <div class="col mb-3">
                                <label for="message" class="form-label">Message</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-message"></i>
                                    </span>
                                    <textarea type="text" id="message" name="message" class="form-control" rows="3" placeholder=""></textarea>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_message"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Input Chassis No. -->
                            <div class="col mb-3">
                                <label for="user_type" class="form-label">Audience</label>
                                <div class="input-group input-group-merge">
                                    <select class="form-select" id="user_type" name="user_type">
                                        <option value="" disabled selected hidden>Please Choose...</option>
                                        <option value="1">All</option>
                                        <option value="2">Conductors</option>
                                        <option value="3">Dispatchers</option>
                                        <option value="4">Driver</option>
                                        <option value="5">Passengers</option>
                                        <option value="6">All Personnel</option>
                                    </select>    
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_user_type"></span>
                                </div>
                            </div>
                        </div>   
                        <div id="main-append" style="display:none"></div>
                    </div>
                    <!-- Submit Form -->
                    <div class="modal-footer">
                        <button id="main-close" type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="main-submit" type="button" onclick="Save()" class="btn btn-primary"></button>
                    </div>
                </form>
            </div>
        </div>
    <!-- End of Adding Modal -->
@endsection

@section('admin_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light">Bus Reminders /</span> Announcements
        </h4>
        <div class="alert alert-primary" style="padding:20px">
            <i class="bx bx-info-circle me-1"></i>
            Create announcements here for your intended audience.
        </div>
        <!-- Schedule Table -->
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
                                <th>To</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($reminder as $rem)
                                <tr>
                                    <td>
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-primary">
                                                <i class="bx bx-envelope"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <!-- To Column -->
                                    <td>
                                        <?php
                                            $user_type = '';
                                            if($rem->user_type == 1){
                                                $user_type = 'All';
                                            }else if($rem->user_type == 2){
                                                $user_type = 'Conductors';
                                            }else if($rem->user_type == 3){
                                                $user_type = 'Dispatchers';
                                            }else if($rem->user_type == 4){
                                                $user_type = 'Driver';
                                            }else if($rem->user_type == 5){
                                                $user_type = 'Passengers';
                                            }else if($rem->user_type == 6){
                                                $user_type = 'All Personnel';
                                            }
                                        ?>
                                        <strong>{{$user_type}}</strong>
                                    </td>
                                    <!-- Subject Column -->
                                    <td class="abbreviation2">{{$rem->subject}}</td>
                                    <!-- Message Column -->
                                    <td class="abbreviation2">{{$rem->message}}</td>
                                    <!-- Date Column -->
                                        <?php
                                            $date = new DateTime($rem->created_at);
                                            $result = $date->format('F j, Y, g:i a');
                                        ?>
                                    <td>{{$result}}</td>
                                    <!-- Status column -->
                                    <td><span class="badge bg-label-success me-1">Sent</span></td>
                                    <!-- Actions Column -->
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <!-- View -->
                                                <button onclick="View({{ $rem }})" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-info-square me-1"></i>
                                                    View
                                                </button>
                                                <!-- Delete -->
                                                <!-- <button onclick="Delete({{ $rem->id }})" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-trash me-1"></i>
                                                    Delete
                                                </button> -->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
        $('#main-admin-announcement').addClass('active open')

        $(document).ready(function (e) {
            // Data Table
            $('#dataTable').DataTable();
        })

        // Onclick Status Function
        function View(data){
            $('#view_content').html('');
            $('#view-modal-footer').html('')
            document.getElementById("view-modalTitle").innerHTML="View Announcement";
            // Show Values in Modal
            var date = moment(data.created_at).format('MMMM Do YYYY, h:mm a')
            user_type = '';
            if(data.user_type == 1){
                user_type = 'All';
            }else if(data.user_type == 2){
                user_type = 'Conductors';
            }else if(data.user_type == 3){
                user_type = 'Dispatchers';
            }else if(data.user_type == 4){
                user_type = 'Driver';
            }else if(data.user_type == 5){
                user_type = 'Passengers';
            }else if(data.user_type == 6){
                user_type = 'All Personnel';
            }
            $('#sub').html(data.subject);
            $('#to').html('To : '+user_type);
            $('#mess').html(data.message);
            $('#date').html(date);
            $('#view-modal').modal('show')
        }

        // Onclick Add Function
        function Add(){
            $('#main-append').html('');
            document.getElementById("main-modalTitle").innerHTML= "Send Announcement Information";
            document.getElementById("main-submit").innerHTML= "Send";
            // Clear Input Fields
            $('#subject').val(''),
            $('#message').val(''),
            $('#user_type').val(''),
            // Clear Error Messages
            $("#main-modal .errorMsg_subject").html('');
            $("#main-modal .errorMsg_message").html('');
            $("#main-modal .errorMsg_user_type").html('');
            // Show Modal
            $('#main-modal').modal('show');
        }

        // Onclick Save Function
        function Save() {
            // Get Values from input fields
            var data = {
                company_id: $('#company_id').val(),
                subject: $('#subject').val(),
                message: $('#message').val(),
                user_type: $('#user_type').val(),
            }
            // Add Data to Database
            Controller.Post('/api/reminder/create', data)
            // If success, return message
            .done(function(result) {
                var dialog = bootbox.dialog({
                centerVertical: true,
                closeButton: false,
                title: 'Sending Announcement',
                message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
                });
                $('#main-modal').modal('hide');
                dialog.init(function(){
                    setTimeout(function(){
                        dialog.find('.bootbox-body').html('Announcement Successfully sent to audience!');
                        window.location.reload();
                    }, 1500);
                });
            })
            // If fail, show errors
            .fail(function (error) {
                const error1 = error.responseJSON.errors;
                let error_subject = "";
                let error_message = "";
                let error_user_type = "";
                for (const listKey in error1){
                    if(listKey == "subject"){
                        error_subject = ""+error1[listKey]+"";
                    }else if(listKey == "message"){
                        error_message = ""+error1[listKey]+"";
                    }else if(listKey == "user_type"){
                        error_user_type = ""+error1[listKey]+"";
                    }
                }
                let msg_subject = "<text>"+error_subject+"</text>";
                let msg_message = "<text>"+error_message+"</text>";
                let msg_user_type = "<text>"+error_user_type+"</text>";
                $("#main-modal .errorMsg_subject").html(msg_subject).addClass('text-danger').fadeIn(1000);
                $("#main-modal .errorMsg_message").html(msg_message).addClass('text-danger').fadeIn(1000);
                $("#main-modal .errorMsg_user_type").html(msg_user_type).addClass('text-danger').fadeIn(1000);
                $("#main-modal button").attr('disabled',false);
            })
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
        //                 Controller.Post('/api/reminder/delete', { 'id': id }).done(function(result) {
        //                     var dialog = bootbox.dialog({
        //                         centerVertical: true,
        //                         closeButton: false,
        //                         title: 'Deleting Information',
        //                         message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
        //                     });
        //                     dialog.init(function(){
        //                         setTimeout(function(){
        //                             dialog.find('.bootbox-body').html('Announcement Successfully deleted!');
        //                             window.location.reload();
        //                         }, 1500);
                                
        //                     });
        //                 });
        //             }
        //         }
        //     })
        // }
    </script>
@endsection