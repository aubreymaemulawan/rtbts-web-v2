@extends('layouts.app')
@section('title','Assign Schedules')

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
                        <!-- Conductor Info -->
                        <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                            <img id="view-conductor_avatar" src="{{ asset('assets/img/avatars/default.jpg') }}" alt="user-avatar" class="d-block rounded" height="100" width="100"/>
                            <div class="button-wrapper">
                                <button disabled class="btn btn-primary me-2 mb-2" tabindex="0">Conductor</button>
                                <select disabled style="-webkit-appearance: none;" class=" me-2 mb-2" id="view-conductor_status" name="view-conductor_status">
                                    <option value="1">Active</option>
                                    <option value="2">Not Active</option>
                                </select>
                                <select disabled style="-webkit-appearance: none;" class="mb-2" id="view-conductor_account" name="view-conductor_account">
                                    <option value="1">Account</option>
                                    <option value="2">No Account</option>
                                </select>
                                <p id="view-conductor_name" name="view-conductor_name" class="text-muted mb-0"></p>
                            </div>
                        </div>
                        <!-- Dispatcher Info -->
                        <!-- <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                            <img id="view-dispatcher_avatar" src="{{ asset('assets/img/avatars/default.jpg') }}" alt="user-avatar" class="d-block rounded" height="100" width="100"/>
                            <div class="button-wrapper">
                                <button disabled class="btn btn-primary me-2 mb-2" tabindex="0">Dispatcher</button>
                                <select disabled style="-webkit-appearance: none;" class=" me-2 mb-2" id="view-dispatcher_status" name="view-dispatcher_status">
                                    <option value="1">Active</option>
                                    <option value="2">Not Active</option>
                                </select>
                                <select disabled style="-webkit-appearance: none;" class="mb-2" id="view-dispatcher_account" name="view-dispatcher_account">
                                    <option value="1">Account</option>
                                    <option value="2">No Account</option>
                                </select>
                                <p id="view-dispatcher_name" name="view-dispatcher_name" class="text-muted mb-0"></p>
                            </div>
                        </div> -->
                        <!-- Operator Info -->
                        <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                            <img id="view-operator_avatar" src="{{ asset('assets/img/avatars/default.jpg') }}" alt="user-avatar" class="d-block rounded" height="100" width="100"/>
                            <div class="button-wrapper">
                                <button disabled class="btn btn-primary me-2 mb-2" tabindex="0">Driver</button>
                                <select disabled style="-webkit-appearance: none;" class=" me-2 mb-2" id="view-operator_status" name="view-operator_status">
                                    <option value="1">Active</option>
                                    <option value="2">Not Active</option>
                                </select>
                                <select disabled style="-webkit-appearance: none;" class="mb-2" id="view-operator_account" name="view-operator_account">
                                    <option value="1">Account</option>
                                    <option value="2">No Account</option>
                                </select>
                                <p id="view-operator_name" name="view-operator_name" class="text-muted mb-0"></p>
                            </div>
                        </div>
                        <p id="update" class="text-muted mb-0"></p>
                        <hr class="hr-style">
                        <div class="mb-3 row">
                            <label for="view-schedule_id" class="col-md-4 col-form-label">Schedule Route</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-schedule_id" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-bus_id" class="col-md-4 col-form-label">Bus Number</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-bus_id" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-max_trips" class="col-md-4 col-form-label">Maximum Trips</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-max_trips" />
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="view-status" class="col-md-4 col-form-label">Status</label>
                            <div class="col-md-8">
                                <input disabled class="form-control" type="text" id="view-status" />
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
                        <input type="hidden" class="form-control" id="dispatcher_id" name="dispatcher_id" value="{{Auth::user()->personnel_id}}">
                        <input type="hidden" class="form-control" id="id" name="id">
                        <div class="row g-2">
                            <!-- Input Date -->
                            <div class="col mb-3">
                                <label for="date" class="form-label">Date</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-calendar"></i>
                                    </span>
                                    <input type="date" id="date" name="date" class="form-control" min="<?= date('Y-m-d'); ?>"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_date"></span>
                                </div>
                            </div>
                            <!-- Input Schedule -->
                            <div class="col mb-3">
                                <label for="schedule_id" class="form-label">Route</label>
                                <div class="input-group input-group-merge">
                                    <select class="form-select" id="schedule_id" name="schedule_id">
                                        <option value="" disabled selected hidden>Please Choose...</option>
                                        @foreach($schedule as $s)
                                            @if($s->company_id == Auth::user()->personnel->company_id)
                                                @if($s->status == 1)
                                                    <option value="{{ $s->id }}">{{ $s->route->from_to_location }}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>                                
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_schedule_id"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <!-- Input Max Trips. -->
                            <div class="col mb-3">
                                <label for="max_trips" class="form-label">Max Trips</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-trip"></i>
                                    </span>
                                    <input type="number" id="max_trips" name="max_trips" class="form-control" placeholder="00"/>
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_max_trips"></span>
                                </div>
                            </div>
                            <!-- Input Bus No. -->
                            <div class="col mb-3">
                                <label for="bus_id" class="form-label">Bus No.</label>
                                <div class="input-group input-group-merge">
                                    <select class="form-select" id="bus_id" name="bus_id">
                                        <option value="" disabled selected hidden>Please Choose...</option>
                                        @foreach($bus as $b)
                                            @if($b->company_id == Auth::user()->company_id)
                                                @if($b->status == 1)
                                                    @if($b->bus_type == 1)
                                                        <option value="{{ $b->id }}">{{ $b->bus_no }} - Aircon</option>
                                                    @elseif($b->bus_type == 2)
                                                        <option value="{{ $b->id }}">{{ $b->bus_no }} - Non Aircon</option>
                                                    @endif
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>                                
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_bus_id"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Input Conductor -->
                            <?php $cnt2 = 0; ?>
                            <div class="col mb-3">
                                <label for="conductor_id" class="form-label">Conductor</label>
                                <div class="input-group input-group-merge">
                                    <select class="form-select" id="conductor_id" name="conductor_id">
                                        <option value="" disabled selected hidden>Please Choose...</option>
                                        @foreach($personnel as $p2)
                                            @if($p2->company_id == Auth::user()->company_id)
                                                @if($p2->status == 1)
                                                    @if($p2->user_type == 2)
                                                        
                                                            <option value="{{ $p2->id }}">{{ $p2->name }}</option>
                                                    @endif
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>                                
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_conductor_id"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Input Operator -->
                            <div class="col mb-3">
                                <label for="operator_id" class="form-label">Driver</label>
                                <div class="input-group input-group-merge">
                                    <select class="form-select" id="operator_id" name="operator_id">
                                        <option value="" disabled selected hidden>Please Choose...</option>
                                        @foreach($personnel as $p4)
                                            @if($p4->company_id == Auth::user()->company_id)
                                                @if($p4->status == 1)
                                                    @if($p4->user_type == 4)
                                                        <option value="{{ $p4->id }}">{{ $p4->name }}</option>
                                                    @endif
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>                                
                                </div>
                                <!-- Error Message -->
                                <div class="error-pad">
                                    <span class="errorMsg_operator_id"></span>
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
    
@section('dispatcher_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light">Records /</span> Assigned Schedules
        </h4>
        <div class="alert alert-primary" style="padding:20px">
            <i class="bx bx-info-circle me-1"></i>
            Real-time Table. Assign your personnel schedules information here. You can Add, Update, and View data.
        </div>
        <?php $cnt_bus = 0; $cnt_schedule = 0; $cnt_conductor = 0; $cnt_dispatcher = 0; $cnt_operator = 0;  ?>
        <!-- Schedule Table -->
        <div class="card">
            <input type="hidden" class="form-control" id="company_id" name="company_id" value="{{Auth::user()->personnel->company_id}}">
            <div class="card-header color"> 
                <!-- If Bus table is empty -->
                @foreach($bus as $bs)
                    @if($bs->company_id == Auth::user()->personnel->company_id)
                        @if($bs->status == 1)
                            <?php $cnt_bus += 1;?>
                        @endif
                    @endif
                @endforeach
                <!-- If Schedule table is empty -->
                @foreach($schedule as $sched)
                    @if($sched->company_id == Auth::user()->personnel->company_id)
                        @if($sched->status == 1)
                            <?php $cnt_schedule += 1;?>
                        @endif
                    @endif
                @endforeach
                <!-- If Personnel table is empty -->
                @foreach($personnel as $pn)
                    @if($pn->company_id == Auth::user()->personnel->company_id)
                        @if($pn->status == 1)
                            @if($pn->user_type == 2)
                                <?php $cnt_conductor += 1;?>
                            @elseif($pn->user_type == 3)
                                <?php $cnt_dispatcher += 1;?>
                            @elseif($pn->user_type == 4)
                                <?php $cnt_operator += 1;?> 
                            @endif
                        @endif
                    @endif
                @endforeach
                <!-- Display Button -->
                @if($cnt_bus != 0 && $cnt_schedule != 0 && $cnt_conductor != 0 && $cnt_dispatcher != 0 && $cnt_operator != 0)
                    <button onclick="Add()" type="button" class="btn rounded-pill btn-primary">Add New</button>
                @else
                    <button onclick="Error( {{$cnt_bus}}, {{$cnt_schedule}}, {{$cnt_conductor}}, {{$cnt_dispatcher}}, {{$cnt_operator}} )" type="button" class="btn rounded-pill btn-primary">Add New</button>
                @endif
            </div>
            <div class="card-body pad">
                <div class="tbl table-responsive">
                    <table id=dataTable class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th>Personnel</th>
                                <th>Date</th>
                                <th>Schedule Route</th>
                                <th>Bus</th>
                                <th>Max</th>
                                <th>Status</th>
                                <th>Trip</th>
                                <th>Actions</th>
                            </tr>
                        </thead> 
                        <tbody id="realtime_table_assign_schedule" class="table-border-bottom-0">
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
        $('#main-dispatcher-assign-schedule').addClass('active open')
        $('[id^="menu-"]').removeClass('active')
        $('#menu-personnel-schedule').addClass('active')
        var dropdown1 = $('select[name="bus_id"]');
        var dropdown2 = $('select[name="conductor_id"]');
        var dropdown4 = $('select[name="operator_id"]');

        $(document).ready(function (e) {
            // Data Table
            $('#dataTable').DataTable({
                searching: false, 
                paging: false, 
                info: false,
                order: [[0, 'desc']],
                "bPaginate": false,
            });

            // Dynamic Dropdown
            $('#date').on('change', function () {
                // Clear Error Messages
                $("#main-modal .errorMsg_bus_id").html('');
                $("#main-modal .errorMsg_conductor_id").html('');
                $("#main-modal .errorMsg_operator_id").html('');
                var date = this.value;
                var busType = '';
                
                var companyId = $('#company_id').val();

                // Bus Dropdown
                $('#bus_id').html('');
                Controller.Post('/api/personnel_schedule/check_bus', { 'date': date, 'company_id': companyId }).done(function(result1) {
                    dropdown1.prop('disabled', false);
                    $('#bus_id').html('<option value="" disabled selected hidden>Please choose...</option>');
                    $.each(result1, function (key, value1) {
                        if(value1['bus_type'] == 1){
                            busType = 'Aircon';
                        }else if(value1['bus_type'] == 2){
                            busType = 'Non-Aircon';
                        } 
                        $('#bus_id').append('<option value="'+ value1['id'] +'">'+ value1['bus_no']+' - '+ busType + '</option>'); 
                    });
                });

                // Conductor Dropdown
                $('#conductor_id').html('');
                Controller.Post('/api/personnel_schedule/check_conductor', { 'date': date, 'company_id': companyId }).done(function(result) {
                    dropdown2.prop('disabled', false);
                    $('#conductor_id').html('<option value="" disabled selected hidden>Please choose...</option>');
                    $.each(result, function (key, value2) {
                        $('#conductor_id').append('<option value="'+ value2.id +'">' + value2.name + '</option>');                            
                    });
                });

                // Driver Dropdown
                $('#operator_id').html('');
                Controller.Post('/api/personnel_schedule/check_operator', { 'date': date, 'company_id': companyId }).done(function(result) {
                    dropdown4.prop('disabled', false);
                    $('#operator_id').html('<option value="" disabled selected hidden>Please choose...</option>');
                    $.each(result, function (key, value3) {
                        $('#operator_id').append('<option value="'+ value3.id +'">' + value3.name + '</option>');                            
                    });
                });
            });
        })

        // Onclick Error Function
        function Error( bus, schedule, conductor, dispatcher, operator ){
            // If bus is empty or not active
            if(bus == 0){
                bootbox.alert({
                title: "The bus list is currently empty, or no values are active.",
                closeButton: false,
                message: "Please contact admin.",
                centerVertical: true
                })
            }
            // If schedule is empty or not active
            else if(schedule == 0){
                bootbox.alert({
                title: "The schedule list is currently empty, or no values are active.",
                closeButton: false,
                message: "Please contact admin.",
                centerVertical: true
                })
            }
            // If personnel:conductor is empty or not active
            else if(conductor == 0){
                bootbox.alert({
                title: "The user type conductor is currently empty, or no values are active.",
                closeButton: false,
                message: "Please contact admin.",
                centerVertical: true
                })
            }
            // If personnel:dispatcher is empty or not active
            else if(dispatcher == 0){
                bootbox.alert({
                title: "The user type dispatcher is currently empty, or no values are active.",
                closeButton: false,
                message: "Please contact admin.",
                centerVertical: true,
                })
            }
            // If personnel:operator is empty or not active
            else if(operator == 0){
                bootbox.alert({
                title: "The user type operator is currently empty, or no values are active.",
                closeButton: false,
                message: "Please contact admin.",
                centerVertical: true
                })
            }
        }

        // Onclick View Function
        function View(id){
            // Clear status color
            $('#view-conductor_status').removeClass("btn btn-danger")
            $('#view-conductor_status').removeClass("btn btn-success")
            $('#view-dispatcher_status').removeClass("btn btn-danger")
            $('#view-dispatcher_status').removeClass("btn btn-success")
            $('#view-operator_status').removeClass("btn btn-danger")
            $('#view-operator_status').removeClass("btn btn-success")
            // Clear account status color
            $('#view-conductor_account').removeClass("btn btn-danger")
            $('#view-conductor_account').removeClass("btn btn-success")
            $('#view-dispatcher_account').removeClass("btn btn-danger")
            $('#view-dispatcher_account').removeClass("btn btn-success")
            $('#view-operator_account').removeClass("btn btn-danger")
            $('#view-operator_account').removeClass("btn btn-success")
            // Clear personnel names
            $('#view-conductor_name').html('')
            $('#view-dispatcher_name').html('')
            $('#view-operator_name').html('')
            $('#view-modal-footer').html('')
            document.getElementById("view-modalTitle").innerHTML="View Personnel Schedule Information";
            
            // Personnel Information
            Controller.Post('/api/personnel_schedule/find', { 'id': id }).done(function([
                conductor_name, conductor_status, conductor_acc_email, conductor_acc_pass, con_pic,
                dispatcher_name, dispatcher_status, dispatcher_acc_email, dispatcher_acc_pass, dis_pic,
                operator_name, operator_status, operator_acc_email, operator_acc_pass, ope_pic, trip_cnt]) {

                    // Profile Picture
                    if(con_pic==""){
                        document.getElementById('view-conductor_avatar').src='{{ asset('assets/img/avatars/default.jpg') }}';
                    }else{
                        document.getElementById('view-conductor_avatar').src = con_pic;
                    }
                    if(dis_pic==""){
                        document.getElementById('view-dispatcher_avatar').src='{{ asset('assets/img/avatars/default.jpg') }}';
                    }else{
                        document.getElementById('view-dispatcher_avatar').src = dis_pic;
                    }
                    if(ope_pic==""){
                        document.getElementById('view-operator_avatar').src='{{ asset('assets/img/avatars/default.jpg') }}';
                    }else{
                        document.getElementById('view-operator_avatar').src = ope_pic;
                    }
                    
                    // Change Color of Buttons based on status
                    if(conductor_status == 1 || dispatcher_status == 1 || operator_status == 1 ){
                        $('#view-conductor_status').addClass("btn btn-success")
                        $('#view-dispatcher_status').addClass("btn btn-success")
                        $('#view-operator_status').addClass("btn btn-success")
                    }else if(conductor_status == 2 || dispatcher_status == 2 || operator_status == 2 ){
                        $('#view-conductor_status').addClass("btn btn-danger")
                        $('#view-dispatcher_status').addClass("btn btn-danger")
                        $('#view-operator_status').addClass("btn btn-danger")
                    }
                    
                    // Conductor Name and account status
                    document.getElementById("view-conductor_name").innerHTML="Name : "+conductor_name;
                    // document.getElementById("view-dispatcher_name").innerHTML="Name : "+dispatcher_name;
                    document.getElementById("view-operator_name").innerHTML="Name : "+operator_name;
                    if(conductor_acc_email !=null && conductor_acc_pass != null){
                        $('#view-conductor_account').addClass("btn btn-success"),
                        $('#view-conductor_account').val(1)
                    }else{
                        $('#view-conductor_account').addClass("btn btn-danger")
                        $('#view-conductor_account').val(2)
                    }
                    if(dispatcher_acc_email !=null && dispatcher_acc_pass != null){
                        $('#view-dispatcher_account').addClass("btn btn-success"),
                        $('#view-dispatcher_account').val(1)
                    }else{
                        $('#view-dispatcher_account').addClass("btn btn-danger"),
                        $('#view-dispatcher_account').val(2)
                    }
                    if(operator_acc_email !=null && operator_acc_pass != null){
                        $('#view-operator_account').addClass("btn btn-success"),
                        $('#view-operator_account').val(1)
                    }else{
                        $('#view-operator_account').addClass("btn btn-danger"),
                        $('#view-operator_account').val(2)
                    }
            
            // Convert Timestamp to Date
            Controller.Post('/api/personnel_schedule/items', { 'id': id }).done(function(result) {
                var date1 = moment(result.updated_at).format('MMMM Do YYYY, h:mm a')
                document.getElementById("update").innerHTML="Last Updated : "+date1;
                // Edit & Delete Button
                if(trip_cnt != 0){
                }else{
                    if(result.status == 3){
                    }else{
                        $('#view-modal-footer').append('<button onclick="Edit('+id+')" type="button" class="btn btn-outline-primary">Edit</button>'); 
                    }
                    // $('#view-modal-footer').append('<button onclick="Delete('+id+')" type="button" class="btn btn-outline-danger">Delete</button>');
                }

            });
            // Show Values in Modal
            Controller.Post('/api/personnel_schedule/find1', { 'id': id }).done(function([bus_id, from_to_location, max_trips, status]) {
                $('#view-bus_id').val(bus_id),
                $('#view-status').val(status),
                $('#view-schedule_id').val(from_to_location),
                $('#view-max_trips').val(max_trips),
                $('#view-modal').modal('show')
            });
            });

        }

        // Onclick Add Function
        function Add(){
            dropdown1.prop('disabled', true);
            dropdown2.prop('disabled', true);
            dropdown4.prop('disabled', true);
            $('#main-append').html('');
            document.getElementById("main-modalTitle").innerHTML= "Create Personnel Schedule Information";
            document.getElementById("main-submit").innerHTML= "Create";
            // Clear Input Fields
            $('#id').val('-1'),
            $('#date').val(''),
            $('#schedule_id').val(''),
            $('#conductor_id').val(''),
            // $('#dispatcher_id').val(''),
            $('#operator_id').val(''),
            $('#bus_id').val(''),
            $('#max_trips').val(''),
            // Clear Error Messages
            $("#main-modal .errorMsg_date").html('');
            $("#main-modal .errorMsg_schedule_id").html('');
            $("#main-modal .errorMsg_conductor_id").html('');
            // $("#main-modal .errorMsg_dispatcher_id").html('');
            $("#main-modal .errorMsg_operator_id").html('');
            $("#main-modal .errorMsg_bus_id").html('');
            $("#main-modal .errorMsg_max_trips").html('');
            // Show Modal
            $('#main-modal').modal('show');
        }

        // Onclick Edit Function
        function Edit(id) {
            $('#main-append').html('');
            $('#view-modal').modal('hide');
            document.getElementById("main-modalTitle").innerHTML="Edit Personnel Schedule Information";
            document.getElementById("main-submit").innerHTML= "Save";
            // Show Values in Modal
            Controller.Post('/api/personnel_schedule/items', { 'id': id }).done(function(result) {
                // Clear Error Messages
                $("#main-modal .errorMsg_date").html('');
                $("#main-modal .errorMsg_schedule_id").html('');
                $("#main-modal .errorMsg_conductor_id").html('');
                $("#main-modal .errorMsg_dispatcher_id").html('');
                $("#main-modal .errorMsg_operator_id").html('');
                $("#main-modal .errorMsg_bus_id").html('');
                $("#main-modal .errorMsg_max_trips").html('');
                $("#main-modal .errorMsg_status").html('');
                // Status Input Field
                $('#main-append').show();
                $("#main-append").append('<div id="main-status" class="row">');
                $("#main-append").append('<div class="col mt-3 mb-0">');
                $("#main-append").append('<label for="status" class="form-label">Status</label>');
                $("#main-append").append('<div class="input-group input-group-merge">');
                $("#main-append").append('<select class="form-select" id="status" name="status"> <option value="1">Active</option> <option value="2">Cancel</option> </select>');
                $("#main-append").append('</div>');
                $("#main-append").append('<div class="error-pad">');
                $("#main-append").append('<span class="errorMsg_status"></span>');
                $("#main-append").append('</div>');
                $("#main-append").append('</div>');
                $("#main-append").append('</div>');
                // Show ID values in Input Fields
                $('#id').val(result.id),
                $('#date').val(result.date),
                $('#schedule_id').val(result.schedule_id),
                $('#conductor_id').val(result.conductor_id),
                $('#dispatcher_id').val(result.dispatcher_id),
                $('#operator_id').val(result.operator_id),
                $('#bus_id').val(result.bus_id),
                $('#max_trips').val(result.max_trips),
                $('#status').val(result.status),
                // Show Modal
                $('#main-modal').modal('show');
            });
        }

        // Onclick Save Function
        function Save() {
            // Clear Error messages
            $("#main-modal .errorMsg_date").html('');
            $("#main-modal .errorMsg_schedule_id").html('');
            $("#main-modal .errorMsg_bus_id").html('');
            $("#main-modal .errorMsg_conductor_id").html('');
            $("#main-modal .errorMsg_dispatcher_id").html('');
            $("#main-modal .errorMsg_operator_id").html('');
            $("#main-modal .errorMsg_max_trips").html('');
            $("#main-modal .errorMsg_status").html('');
            // Get Values from input fields
            var data = {
            id: $('#id').val(),
            date: $('#date').val(),
            schedule_id: $('#schedule_id').val(),
            bus_id: $('#bus_id').val(),
            conductor_id: $('#conductor_id').val(),
            dispatcher_id: $('#dispatcher_id').val(),
            operator_id: $('#operator_id').val(),
            max_trips: $('#max_trips').val(),
            status: $('#status').val(),
            }
            // Add Data to Database
            if(data.id == -1) {
                Controller.Post('/api/personnel_schedule/create', data)
                // If success, return message
                .done(function(result) {
                    // If route already registered, display error
                    // if(result == 1 || result == 2 || result == 3 || result == 4){
                    //     if(result == 1){
                    //         let msg_bus_id = "<text>The bus number has a schedule already for selected date.</text>";
                    //         $("#main-modal .errorMsg_bus_id").html(msg_bus_id).addClass('text-danger').fadeIn(1000);
                    //         $("#main-modal button").attr('disabled',false);
                    //     }
                    //     if(result == 2){
                    //         let msg_conductor_id = "<text>The conductor has a schedule already for selected date.</text>";
                    //         $("#main-modal .errorMsg_conductor_id").html(msg_conductor_id).addClass('text-danger').fadeIn(1000);
                    //         $("#main-modal button").attr('disabled',false);
                    //     }
                    //     // if(result == 3){
                    //     //     let msg_dispatcher_id = "<text>The dispatcher has a schedule already for selected date.</text>";
                    //     //     $("#main-modal .errorMsg_dispatcher_id").html(msg_dispatcher_id).addClass('text-danger').fadeIn(1000);
                    //     //     $("#main-modal button").attr('disabled',false);
                    //     // }
                    //     if(result == 4){
                    //         let msg_operator_id = "<text>The operator has a schedule already for selected date.</text>";
                    //         $("#main-modal .errorMsg_operator_id").html(msg_operator_id).addClass('text-danger').fadeIn(1000);
                    //         $("#main-modal button").attr('disabled',false);
                    //     }
                    // }else{
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
                    // }
                })
                // If fail, show errors
                .fail(function (error) {
                    const error1 = error.responseJSON.errors;
                    let error_date = "";
                    let error_schedule_id = "";
                    let error_bus_id = "";
                    let error_conductor_id = "";
                    let error_dispatcher_id = "";
                    let error_operator_id = "";
                    let error_max_trips = "";
                    for (const listKey in error1){
                        if(listKey == "date"){
                            error_date = ""+error1[listKey]+"";
                        }else if(listKey == "schedule_id"){
                            error_schedule_id = ""+error1[listKey]+"";
                        }else if(listKey == "bus_id"){
                            error_bus_id = ""+error1[listKey]+"";
                        }else if(listKey == "conductor_id"){
                            error_conductor_id = ""+error1[listKey]+"";
                        }else if(listKey == "dispatcher_id"){
                            error_dispatcher_id = ""+error1[listKey]+"";
                        }else if(listKey == "operator_id"){
                            error_operator_id = ""+error1[listKey]+"";
                        }else if(listKey == "max_trips"){
                            error_max_trips = ""+error1[listKey]+"";
                        }
                    }
                    let msg_date = "<text>"+error_date+"</text>";
                    let msg_schedule_id = "<text>"+error_schedule_id+"</text>";
                    let msg_bus_id = "<text>"+error_bus_id+"</text>";
                    let msg_conductor_id = "<text>"+error_conductor_id+"</text>";
                    let msg_dispatcher_id = "<text>"+error_dispatcher_id+"</text>";
                    let msg_operator_id = "<text>"+error_operator_id+"</text>";
                    let msg_max_trips = "<text>"+error_max_trips+"</text>";
                    $("#main-modal .errorMsg_date").html(msg_date).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_schedule_id").html(msg_schedule_id).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_bus_id").html(msg_bus_id).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_conductor_id").html(msg_conductor_id).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_dispatcher_id").html(msg_dispatcher_id).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_operator_id").html(msg_operator_id).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_max_trips").html(msg_max_trips).addClass('text-danger').fadeIn(1000);
                    $("#main-modal button").attr('disabled',false);
                })
            }
            // Update Data to Database
            else if(data.id > 0) {
                Controller.Post('/api/personnel_schedule/update', data)
                // If success, return message
                .done(function(result) {
                    // if(result == 1 || result == 2 || result == 3 || result == 4){
                    //     if(result == 1){
                    //         let msg_bus_id = "<text>The bus number has a schedule already for selected date.</text>";
                    //         $("#main-modal .errorMsg_bus_id").html(msg_bus_id).addClass('text-danger').fadeIn(1000);
                    //         $("#main-modal button").attr('disabled',false);
                    //     }
                    //     if(result == 2){
                    //         let msg_conductor_id = "<text>The conductor has a schedule already for selected date.</text>";
                    //         $("#main-modal .errorMsg_conductor_id").html(msg_conductor_id).addClass('text-danger').fadeIn(1000);
                    //         $("#main-modal button").attr('disabled',false);
                    //     }
                    //     if(result == 3){
                    //         let msg_dispatcher_id = "<text>The dispatcher has a schedule already for selected date.</text>";
                    //         $("#main-modal .errorMsg_dispatcher_id").html(msg_dispatcher_id).addClass('text-danger').fadeIn(1000);
                    //         $("#main-modal button").attr('disabled',false);
                    //     }
                    //     if(result == 4){
                    //         let msg_operator_id = "<text>The operator has a schedule already for selected date.</text>";
                    //         $("#main-modal .errorMsg_operator_id").html(msg_operator_id).addClass('text-danger').fadeIn(1000);
                    //         $("#main-modal button").attr('disabled',false);
                    //     }
                    // }else{
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
                    // }
                })
                // If fail, show errors
                .fail(function (error) {
                    const error1 = error.responseJSON.errors;
                    let error_date = "";
                    let error_schedule_id = "";
                    let error_bus_id = "";
                    let error_conductor_id = "";
                    let error_dispatcher_id = "";
                    let error_operator_id = "";
                    let error_max_trips = "";
                    let error_status = "";
                    for (const listKey in error1){
                        if(listKey == "date"){
                            error_date = ""+error1[listKey]+"";
                        }else if(listKey == "schedule_id"){
                            error_schedule_id = ""+error1[listKey]+"";
                        }else if(listKey == "bus_id"){
                            error_bus_id = ""+error1[listKey]+"";
                        }else if(listKey == "conductor_id"){
                            error_conductor_id = ""+error1[listKey]+"";
                        }else if(listKey == "dispatcher_id"){
                            error_dispatcher_id = ""+error1[listKey]+"";
                        }else if(listKey == "operator_id"){
                            error_operator_id = ""+error1[listKey]+"";
                        }else if(listKey == "max_trips"){
                            error_max_trips = ""+error1[listKey]+"";
                        }else if(listKey == "status"){
                            error_status = ""+error1[listKey]+"";
                        }
                    }
                    let msg_date = "<text>"+error_date+"</text>";
                    let msg_schedule_id = "<text>"+error_schedule_id+"</text>";
                    let msg_bus_id = "<text>"+error_bus_id+"</text>";
                    let msg_conductor_id = "<text>"+error_conductor_id+"</text>";
                    let msg_dispatcher_id = "<text>"+error_dispatcher_id+"</text>";
                    let msg_operator_id = "<text>"+error_operator_id+"</text>";
                    let msg_max_trips = "<text>"+error_max_trips+"</text>";
                    let msg_status = "<text>"+error_status+"</text>";
                    $("#main-modal .errorMsg_date").html(msg_date).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_schedule_id").html(msg_schedule_id).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_bus_id").html(msg_bus_id).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_conductor_id").html(msg_conductor_id).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_dispatcher_id").html(msg_dispatcher_id).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_operator_id").html(msg_operator_id).addClass('text-danger').fadeIn(1000);
                    $("#main-modal .errorMsg_max_trips").html(msg_max_trips).addClass('text-danger').fadeIn(1000);
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
        //                 Controller.Post('/api/personnel_schedule/delete', { 'id': id }).done(function(result) {
        //                     var dialog = bootbox.dialog({
        //                         centerVertical: true,
        //                         closeButton: false,
        //                         title: 'Deleting Information',
        //                         message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
        //                     });
        //                     dialog.init(function(){
        //                         setTimeout(function(){
        //                             dialog.find('.bootbox-body').html('Information Successfully deleted!');
        //                             window.location.reload();
        //                         }, 1500);
                                
        //                     });
        //                 });
        //             }
        //         }
        //     })
        // }
    </script>
    <script>
        function loadXMLDoc() { 
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    $(function () {
                        $('[data-bs-toggle="tooltip"]').tooltip();
                    });
                    document.getElementById("realtime_table_assign_schedule").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "./tbl-dispatcher-assign-schedule", true);
            xhttp.send();
        }
        setInterval(function(){
            $('[data-bs-toggle="tooltip"]').tooltip('hide');
            loadXMLDoc();
            // 1sec
        },10000);
        window.onload = loadXMLDoc;
    </script>
@endsection