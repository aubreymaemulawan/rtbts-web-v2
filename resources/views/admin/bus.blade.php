@extends('layouts.app')
@section('title','Manage Bus')

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
                            <div class="button-wrapper">
                                <p id="update" class="text-muted mb-0"></p>
                            </div>
                        </div>
                        <hr class="hr-style">
                        <div class="mb-3 row">
                            <label for="view-bus_no" class="col-md-4 col-form-label">Bus Number</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-bus_no" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-bus_type" class="col-md-4 col-form-label">Bus Type</label>
                            <div class="col-md-8">
                                <select disabled class="form-control" id="view-bus_type" name="view-bus_type">
                                    <option value="1">Airconditioned</option>
                                    <option value="2">Non Airconditioned</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-plate_no" class="col-md-4 col-form-label">Plate Number</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-plate_no" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-chassis_no" class="col-md-4 col-form-label">Chassis Number</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-chassis_no" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-engine_no" class="col-md-4 col-form-label">Engine Number</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-engine_no" />
                            </div>
                        </div>
                        <div class="mb-0 row">
                            <label for="view-status" class="col-md-4 col-form-label">Bus Status</label>
                            <div class="col-md-8">
                                <select disabled class="form-control" id="view-status" name="view-status">
                                    <option value="1">Active</option>
                                    <option value="2">Not Active</option>
                                </select>
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
                        <div class="row g-2">
                            <!-- Input Bus No. -->
                            <div class="col mb-3">
                                <label for="bus_no" class="form-label">Bus Number</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-barcode"></i>
                                    </span>
                                    <input type="number" id="bus_no" name="bus_no" class="form-control" placeholder="00000"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_bus_no"></span>
                                </div>
                            </div>
                            <!-- Input Bus Type -->
                            <div class="col mb-3">
                                <label for="bus_type" class="form-label">Bus Type</label>
                                <div class="input-group input-group-merge">
                                    <select class="form-select" id="bus_type" name="bus_type">
                                        <option value="" disabled selected hidden>Please Choose...</option>
                                        <option value="1">Airconditioned</option>
                                        <option value="2">Non Airconditioned</option>
                                    </select>                                
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_bus_type"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Input Plate No. -->
                            <div class="col mb-3">
                                <label for="plate_no" class="form-label">Plate Number</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-barcode"></i>
                                    </span>
                                    <input type="text" id="plate_no" name="plate_no" class="form-control" placeholder="00-0000-0000"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_plate_no"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Input Chassis No. -->
                            <div class="col mb-3">
                                <label for="chassis_no" class="form-label">Chassis Number</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-barcode"></i>
                                    </span>
                                    <input type="text" id="chassis_no" name="chassis_no" class="form-control" placeholder="00-0000-0000"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_chassis_no"></span>
                                </div>
                            </div>
                        </div>   
                        <div class="row">
                            <!-- Input Engine No. -->
                            <div class="col mb-3">
                                <label for="engine_no" class="form-label">Engine Number</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-barcode"></i>
                                    </span>
                                    <input type="text" id="engine_no" name="engine_no" class="form-control" placeholder="00-0000-0000"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_engine_no"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Input Color -->
                            <div class="col mb-0">
                                <label for="color" class="form-label">Color (Map View)</label>
                                <div class="input-group input-group-merge">
                                    <input type="color" id="color" name="color" class="form-control"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_color"></span>
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
            <span class="text-muted fw-light">Bus Vehicle /</span> Manage Bus
        </h4>
        <div class="alert alert-primary" style="padding:20px">
            <i class="bx bx-info-circle me-1"></i>
            Manage your bus information here. You can Add, Update, and View data.
        </div>
        <!-- Bus Table -->
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
                                <th>Bus No.</th>
                                <th>Bus Type</th>
                                <th>Plate No.</th>
                                <th>Color</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($bus as $bs)
                                @if($bs->company_id==Auth::user()->company_id)
                                <tr>
                                    <td></td>
                                    <!-- Bus No. Column -->
                                    <td><strong>{{$bs->bus_no}}</strong></td>
                                    <!-- Bus Type No. Column -->
                                    @if ($bs->bus_type == 1)
                                    <td>Airconditioned</td>
                                    @elseif ($bs->bus_type == 2)
                                    <td>Non Airconditioned</td>
                                    @endif
                                    <!-- Plate No. Column -->
                                    <td>{{$bs->plate_no}}</td>
                                    <!-- Color In Map Column -->
                                    <td><span class="badge me-2" style="background-color:{{$bs->color}};color:{{$bs->color}}">color</span></td>
                                    <!-- Status column -->
                                    @if ($bs->status == 1)
                                    <td><span class="badge bg-label-success me-1">Active</span></td>
                                    @elseif ($bs->status == 2)
                                    <td><span class="badge bg-label-danger me-1">Not Active</span></td>
                                    @endif
                                    <!-- Actions Column -->
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <!-- View -->
                                                <button onclick="View({{ $bs->id }})" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-info-square me-1"></i>
                                                    View
                                                </button>
                                                <!-- Edit -->
                                                <button onclick="Edit({{ $bs->id }})" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-edit-alt me-1"></i>
                                                    Edit
                                                </button>
                                                <!-- Delete -->
                                                <!-- <button onclick="Delete({{ $bs->id }})" class="dropdown-item" href="javascript:void(0);">
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
        $('#main-admin-vehicle').addClass('active open')
        $('[id^="menu-"]').removeClass('active')
        $('#menu-bus').addClass('active')
        
        $(document).ready(function (e) {
            // Data Table
            $('#dataTable').DataTable();
        })

        // Onclick View Function
        function View(id){
            $('#view-modal-footer').html('')
            document.getElementById("view-modalTitle").innerHTML="View Bus Information";
            $('#view-modal-footer').append('<button onclick="Edit('+id+')" type="button" class="btn btn-outline-primary">Edit</button>');  
            // $('#view-modal-footer').append('<button onclick="Delete('+id+')" type="button" class="btn btn-outline-danger">Delete</button>');
            // Convert Timestamp to Date
            Controller.Post('/api/bus/items', { 'id': id }).done(function(result) {
                var date1 = moment(result.updated_at).format('MMMM Do YYYY, h:mm a')
                document.getElementById("update").innerHTML="Last Updated : "+date1;
                $('#view-id').val(result.id),
                $('#view-bus_no').val(result.bus_no),
                $('#view-bus_type').val(result.bus_type),
                $('#view-plate_no').val(result.plate_no),
                $('#view-chassis_no').val(result.chassis_no),
                $('#view-engine_no').val(result.engine_no),
                $('#view-status').val(result.status),
                $('#view-modal').modal('show')
            });
        }

        // Onclick Add Function
        function Add(){
            $('#main-append').html('');
            document.getElementById("main-modalTitle").innerHTML= "Create Bus Information";
            document.getElementById("main-submit").innerHTML= "Create";
            // Clear Input Fields
            $('#id').val('-1'),
            $('#bus_no').val(''),
            $('#bus_type').val(''),
            $('#plate_no').val(''),
            $('#chassis_no').val(''),
            $('#engine_no').val(''),
            $('#color').val('#666EE8'),
            // Clear Error Messages
            $("#main-modal .errorMsg_bus_no").html('');
            $("#main-modal .errorMsg_bus_type").html('');
            $("#main-modal .errorMsg_plate_no").html('');
            $("#main-modal .errorMsg_chassis_no").html('');
            $("#main-modal .errorMsg_engine_no").html('');
            $("#main-modal .errorMsg_color").html('');
            // Show Modal
            $('#main-modal').modal('show');
        }

        // Onclick Edit Function
        function Edit(id) {
            $('#main-append').html('');
            $('#view-modal').modal('hide');
            document.getElementById("main-modalTitle").innerHTML="Edit Bus Information";
            document.getElementById("main-submit").innerHTML= "Save";
            // Show Values in Modal
            Controller.Post('/api/bus/items', { 'id': id }).done(function(result) {
                // Clear Error Messages
                $("#main-modal .errorMsg_bus_no").html('');
                $("#main-modal .errorMsg_bus_type").html('');
                $("#main-modal .errorMsg_plate_no").html('');
                $("#main-modal .errorMsg_chassis_no").html('');
                $("#main-modal .errorMsg_engine_no").html('');
                $("#main-modal .errorMsg_color").html('');
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
                $('#bus_no').val(result.bus_no),
                $('#bus_type').val(result.bus_type),
                $('#plate_no').val(result.plate_no),
                $('#chassis_no').val(result.chassis_no),
                $('#engine_no').val(result.engine_no),
                $('#color').val(result.color),
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
            bus_no: $('#bus_no').val(),
            bus_type: $('#bus_type').val(),
            plate_no: $('#plate_no').val(),
            chassis_no: $('#chassis_no').val(),
            engine_no: $('#engine_no').val(),
            status: $('#status').val(),
            color: $('#color').val(),
            }
            // Add Data to Database
            if(data.id == -1) {
                Controller.Post('/api/bus/create', data)
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
                    let error_bus_no = "";
                    let error_bus_type = "";
                    let error_plate_no = "";
                    let error_chassis_no = "";
                    let error_engine_no = "";
                    let error_color = "";
                    for (const listKey in error1){
                        if(listKey == "bus_no"){
                            error_bus_no = ""+error1[listKey]+"";
                        }else if(listKey == "bus_type"){
                            error_bus_type = ""+error1[listKey]+"";
                        }else if(listKey == "plate_no"){
                            error_plate_no = ""+error1[listKey]+"";
                        }else if(listKey == "chassis_no"){
                            error_chassis_no = ""+error1[listKey]+"";
                        }else if(listKey == "engine_no"){
                            error_engine_no = ""+error1[listKey]+"";
                        }else if(listKey == "color"){
                            error_color = ""+error1[listKey]+"";
                        }
                    }
                    let msg_bus_no = "<text>"+error_bus_no+"</text>";
                    let msg_bus_type = "<text>"+error_bus_type+"</text>";
                    let msg_plate_no = "<text>"+error_plate_no+"</text>";
                    let msg_chassis_no = "<text>"+error_chassis_no+"</text>";
                    let msg_engine_no = "<text>"+error_engine_no+"</text>";
                    let msg_color = "<text>"+error_color+"</text>";
                    $("#main-modal .errorMsg_bus_no").html(msg_bus_no).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_bus_type").html(msg_bus_type).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_plate_no").html(msg_plate_no).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_chassis_no").html(msg_chassis_no).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_engine_no").html(msg_engine_no).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_color").html(msg_color).addClass('text-danger').fadeIn(1000);
                    $("#main-modal button").attr('disabled',false);
                })
            }
            // Update Data to Database
            else if(data.id > 0) {
                Controller.Post('/api/bus/update', data)
                // If success, return message
                .done(function(result) {
                    if(result == 1){
                        let msg_status = "<text>There is an active personnel-schedule assigned to this bus.</text>";
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
                    let error_bus_no = "";
                    let error_bus_type = "";
                    let error_plate_no = "";
                    let error_chassis_no = "";
                    let error_engine_no = "";
                    let error_color = "";
                    let error_status = "";
                    for (const listKey in error1){
                        if(listKey == "bus_no"){
                            error_bus_no = ""+error1[listKey]+"";
                        }else if(listKey == "bus_type"){
                            error_bus_type = ""+error1[listKey]+"";
                        }else if(listKey == "plate_no"){
                            error_plate_no = ""+error1[listKey]+"";
                        }else if(listKey == "chassis_no"){
                            error_chassis_no = ""+error1[listKey]+"";
                        }else if(listKey == "engine_no"){
                            error_engine_no = ""+error1[listKey]+"";
                        }else if(listKey == "color"){
                            error_color = ""+error1[listKey]+"";
                        }else if(listKey == "status"){
                            error_status = ""+error1[listKey]+"";
                        }
                    }
                    let msg_bus_no = "<text>"+error_bus_no+"</text>";
                    let msg_bus_type = "<text>"+error_bus_type+"</text>";
                    let msg_plate_no = "<text>"+error_plate_no+"</text>";
                    let msg_chassis_no = "<text>"+error_chassis_no+"</text>";
                    let msg_engine_no = "<text>"+error_engine_no+"</text>";
                    let msg_color = "<text>"+error_color+"</text>";
                    let msg_status = "<text>"+error_status+"</text>";
                    $("#main-modal .errorMsg_bus_no").html(msg_bus_no).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_bus_type").html(msg_bus_type).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_plate_no").html(msg_plate_no).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_chassis_no").html(msg_chassis_no).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_engine_no").html(msg_engine_no).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_color").html(msg_color).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_status").html(msg_status).addClass('text-danger').fadeIn(1000);
                    $("#main-modal button").attr('disabled',false);
                })    
            }
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
        //                 Controller.Post('/api/bus/delete', { 'id': id }).done(function(result) {
        //                     if(result == 1){
        //                         bootbox.confirm({
        //                             title: "Oops! There is a personnel-schedule with this bus.",
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
        //                         })
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