@extends('layouts.app')
@section('title','Manage Schedules')

@section('modal')
    <!-- Adding / Editing Modal -->
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
                        <input type="hidden" class="form-control" id="id" name="id">
                        <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{Auth::user()->company_id}}">
                        
                        <div class="row">
                            <!-- Input Route Id -->
                            <div class="col mb-3">
                                <label for="route_id" class="form-label">Route</label>
                                <div class="input-group input-group-merge">
                                    <select class="form-select" id="route_id" name="route_id">
                                        <option value="" disabled selected hidden>Please Choose...</option>
                                        @foreach ($route as $rt)
                                            @if($rt->company_id == Auth::user()->company_id)
                                                <option value="{{ $rt->id }}">{{ $rt->from_to_location }}</option>
                                            @endif
                                        @endforeach
                                    </select> 
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_route_id"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <!-- Input First Trip. -->
                            <div class="col mb-3">
                                <label for="first_trip" class="form-label">First Trip</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-time"></i>
                                    </span>
                                    <input type="time" id="first_trip" name="first_trip" class="form-control" placeholder="00000"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_first_trip"></span>
                                </div>
                            </div>
                            <!-- Input Last Trip -->
                            <div class="col mb-3">
                                <label for="last_trip" class="form-label">Last Trip</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-time"></i>
                                    </span>
                                    <input type="time" id="last_trip" name="last_trip" class="form-control" placeholder="00000"/>                        
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_last_trip"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Input Interval Minutes -->
                            <div class="col mb-0">
                                <label for="interval_mins" class="form-label">Interval Minutes</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                            <i class="bx bx-timer"></i>
                                        </span>
                                        <input type="number" id="interval_mins" name="interval_mins" class="form-control" placeholder="00"/>  
                                    </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_interval_mins"></span>
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
    <!-- End of Adding / Editing Modal -->
@endsection

@section('admin_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light">Bus Schedule /</span> Manage Schedules
        </h4>
        <div class="alert alert-primary" style="padding:20px">
            <i class="bx bx-info-circle me-1"></i>
            Manage your schedule information here. You can Add, Update, and View data.
        </div>
        <?php $crt = 0; ?>
        <!-- Schedule Table -->
        <div class="card">
            <div class="card-header color">
                @foreach($route as $rs)
                    @if($rs->company_id == Auth::user()->company_id)
                      <?php $crt += 1;?>
                    @endif
                @endforeach
                @if($crt != 0)
                    <button onclick="Add()" type="button" class="btn rounded-pill btn-primary">Add New</button>
                @else
                    <button onclick="Error()" type="button" class="btn rounded-pill btn-primary">Add New</button>
                @endif
            </div>
            <div class="card-body pad">
                <div class="tbl table-responsive">
                    <table id=dataTable class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th>Route</th>
                                <th>Trip Details</th>
                                <th>Interval</th>
                                <th>No. of Assigned Personnel</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php $count = 0 ?>
                            @foreach ($schedule as $sd)
                                @if($sd->company_id==Auth::user()->company_id)
                                <tr>
                                    <td></td>
                                    <!-- Route ID Column -->
                                    <td><strong>{{$sd->route->from_to_location}}</strong></td>
                                    <!-- Trip Info Column -->
                                    <td>First Trip: {{$sd->first_trip}} <br> Last Trip: {{$sd->last_trip}}</td>
                                    <!-- Interval Mins Column -->
                                    <td>{{$sd->interval_mins}} mins</td>
                                    <!-- No of Assigned Schedule Column -->
                                    @foreach($personnel_schedule as $ps)
                                        @if($ps->schedule_id == $sd->id)
                                            <?php $count += 3; ?>
                                        @endif
                                    @endforeach
                                    <td style="text-align:center;">{{$count}}</td>
                                    <?php $count = 0 ; ?>
                                    <!-- Status column -->
                                    @if ($sd->status == 1)
                                    <td><span class="badge bg-label-success me-1">Active</span></td>
                                    @elseif ($sd->status == 2)
                                    <td><span class="badge bg-label-danger me-1">Not Active</span></td>
                                    @endif
                                    <!-- Actions Column -->
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <!-- Edit -->
                                                <button onclick="Edit({{ $sd->id }})" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-edit-alt me-1"></i>
                                                    Edit
                                                </button>
                                                <!-- Delete -->
                                                <!-- <button onclick="Delete({{ $sd->id }})" class="dropdown-item" href="javascript:void(0);">
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
        $('#main-admin-schedule').addClass('active open')
        $('[id^="menu-"]').removeClass('active')
        $('#menu-schedule').addClass('active')

        $(document).ready(function (e) {
            // Data Table
            $('#dataTable').DataTable();
        })

        // Onclick Error Function
        function Error(){
            bootbox.confirm({
                title: "The route list is currently empty.",
                closeButton: false,
                message: "Go to manage route list?",
                buttons: {
                    cancel: {
                        label: 'No',
                        className : "btn btn-outline-secondary",
                    },
                    confirm: {
                        label: 'Yes',
                        className : "btn btn-primary",
                    }
                },
                centerVertical: true,
                callback: function(result){
                    if(result) {
                        location.href = './route';
                    }
                }
            })
        }

        // Onclick Add Function
        function Add(){
            $('#main-append').html('');
            document.getElementById("main-modalTitle").innerHTML= "Create Schedule Information";
            document.getElementById("main-submit").innerHTML= "Create";
            // Clear Input Fields
            $('#id').val('-1'),
            $('#route_id').val(''),
            $('#first_trip').val(''),
            $('#last_trip').val(''),
            $('#interval_mins').val(''),
            $('#status').val(''),
            // Clear Error Messages
            $("#main-modal .errorMsg_route_id").html('');
            $("#main-modal .errorMsg_first_trip").html('');
            $("#main-modal .errorMsg_last_trip").html('');
            $("#main-modal .errorMsg_interval_mins").html('');
            $("#main-modal .errorMsg_status").html('');
            // Show Modal
            $('#main-modal').modal('show');
        }

        // Onclick Edit Function
        function Edit(id) {
            $('#main-append').html('');
            document.getElementById("main-modalTitle").innerHTML="Edit Schedule Information";
            document.getElementById("main-submit").innerHTML= "Save";
            // Show Values in Modal
            Controller.Post('/api/schedule/items', { 'id': id }).done(function(result) {
                // Clear Error Messages
                $("#main-modal .errorMsg_route_id").html('');
                $("#main-modal .errorMsg_first_trip").html('');
                $("#main-modal .errorMsg_last_trip").html('');
                $("#main-modal .errorMsg_interval_mins").html('');
                // Status Input Field
                $('#main-append').show();
                $("#main-append").append('<div id="main-status" class="row">');
                $("#main-append").append('<div class="col mt-3 mb-0">');
                $("#main-append").append('<label for="status" class="form-label">Status</label>');
                $("#main-append").append('<div class="input-group input-group-merge">');
                $("#main-append").append('<select class="form-select" id="status" name="status"> <option value="1">Active</option> <option value="2">Not Active</option> </select>');
                $("#main-append").append('</div>');
                $("#main-append").append('<div class="error-pad">');
                $("#main-append").append('<span class="errorMsg_status"></span>');
                $("#main-append").append('</div>');
                $("#main-append").append('</div>');
                $("#main-append").append('</div>');
                // Show ID values in Input Fields
                $('#id').val(result.id),
                $('#route_id').val(result.route_id),
                $('#first_trip').val(result.first_trip),
                $('#last_trip').val(result.last_trip),
                $('#interval_mins').val(result.interval_mins),
                $('#status').val(result.status),
                // Show Modal
                $('#main-modal').modal('show');
            });
        }

        // Onclick Save Function
        function Save() {
            // Get Values from input fields
            var data = {
            id: $('#id').val(),
            company_id: $('#company_id').val(),
            route_id: $('#route_id').val(),
            first_trip: $('#first_trip').val(),
            last_trip: $('#last_trip').val(),
            interval_mins: $('#interval_mins').val(),
            status: $('#status').val(),
            }
            // Add Data to Database
            if(data.id == -1) {
                Controller.Post('/api/schedule/create', data)
                // If success, return message
                .done(function(result) {
                    var dialog = bootbox.dialog({
                    centerVertical: true,
                    closeButton: false,
                    title: 'Saving Information',
                    message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
                    });
                    $('#main-modal').modal('hide');
                    dialog.init(function(){
                        setTimeout(function(){
                            dialog.find('.bootbox-body').html('Information Successfully saved!');
                            window.location.reload();
                        }, 1500);
                    });
                })
                // If fail, show errors
                .fail(function (error) {
                    const error1 = error.responseJSON.errors;
                    let error_route_id = "";
                    let error_first_trip = "";
                    let error_last_trip = "";
                    let error_interval_mins = "";
                    for (const listKey in error1){
                        if(listKey == "route_id"){
                            error_route_id = ""+error1[listKey]+"";
                        }else if(listKey == "first_trip"){
                            error_first_trip = ""+error1[listKey]+"";
                        }else if(listKey == "last_trip"){
                            error_last_trip = ""+error1[listKey]+"";
                        }else if(listKey == "interval_mins"){
                            error_interval_mins = ""+error1[listKey]+"";
                        }
                    }
                    let msg_route_id = "<text>"+error_route_id+"</text>";
                    let msg_first_trip = "<text>"+error_first_trip+"</text>";
                    let msg_last_trip = "<text>"+error_last_trip+"</text>";
                    let msg_interval_mins = "<text>"+error_interval_mins+"</text>";
                    $("#main-modal .errorMsg_route_id").html(msg_route_id).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_first_trip").html(msg_first_trip).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_last_trip").html(msg_last_trip).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_interval_mins").html(msg_interval_mins).addClass('text-danger').fadeIn(1000);
                    $("#main-modal button").attr('disabled',false);
                })
            }
            // Update Data to Database
            else if(data.id > 0) {
                Controller.Post('/api/schedule/update', data)
                // If success, return message
                .done(function(result) {
                    if(result == 1){
                        let msg_status = "<text>There is an active personnel-schedule assigned to this schedule.</text>";
                        $("#main-modal .errorMsg_status").html(msg_status).addClass('text-danger').fadeIn(1000);
                        $("#main-modal button").attr('disabled',false);
                    }else{
                        var dialog = bootbox.dialog({
                        centerVertical: true,
                        closeButton: false,
                        title: 'Updating Information',
                        message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
                        });
                        $('#main-modal').modal('hide');
                        dialog.init(function(){
                            setTimeout(function(){
                                dialog.find('.bootbox-body').html('Information Successfully updated!');
                                window.location.reload();
                            }, 1500);
                        });
                    }
                })
                // If fail, show errors
                .fail(function (error) {
                    const error1 = error.responseJSON.errors;
                    let error_route_id = "";
                    let error_first_trip = "";
                    let error_last_trip = "";
                    let error_interval_mins = "";
                    let error_status = "";
                    for (const listKey in error1){
                        if(listKey == "route_id"){
                            error_route_id = ""+error1[listKey]+"";
                        }else if(listKey == "first_trip"){
                            error_first_trip = ""+error1[listKey]+"";
                        }else if(listKey == "last_trip"){
                            error_last_trip = ""+error1[listKey]+"";
                        }else if(listKey == "interval_mins"){
                            error_interval_mins = ""+error1[listKey]+"";
                        }else if(listKey == "status"){
                            error_status = ""+error1[listKey]+"";
                        }
                    }
                    let msg_route_id = "<text>"+error_route_id+"</text>";
                    let msg_first_trip = "<text>"+error_first_trip+"</text>";
                    let msg_last_trip = "<text>"+error_last_trip+"</text>";
                    let msg_interval_mins = "<text>"+error_interval_mins+"</text>";
                    let msg_status = "<text>"+error_status+"</text>";
                    $("#main-modal .errorMsg_route_id").html(msg_route_id).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_first_trip").html(msg_first_trip).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_last_trip").html(msg_last_trip).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_interval_mins").html(msg_interval_mins).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_status").html(msg_status).addClass('text-danger').fadeIn(1000);
                    $("#main-modal button").attr('disabled',false);
                })    
            }
        }

        // Onclick Delete Function
        // function Delete(id) {
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
        //                 Controller.Post('/api/schedule/delete', { 'id': id }).done(function(result) {
        //                     if(result == 1){
        //                         bootbox.confirm({
        //                             title: "Oops! There is a personnel-schedule with this schedule.",
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
        //                         centerVertical: true,
        //                         closeButton: false,
        //                         title: 'Deleting Information',
        //                         message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
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