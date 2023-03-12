@extends('layouts.app')
@section('title','Trip Records')

@section('modal')
    <!-- Status Modal --> 
        <div class="modal fade" id="status-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <!-- Status Form -->
                <form class="modal-content" id="status_logs">
                    <div class="modal-header">
                        <h5 class="modal-title" id="status-modalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="body" class="modal-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <div class="button-wrapper">
                                <p id="update" class="text-muted mb-0"></p>
                            </div>
                        </div>
                        <hr class="hr-style">
                        <div id="status_content">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <!-- End of Status Modal -->
@endsection

@section('admin_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light">Records /</span> Trip Records
        </h4>
        <div class="alert alert-primary" style="padding:20px">
            <i class="bx bx-info-circle me-1"></i>
            Real-time Table. View on-going trips here. Check status and location on map.
        </div>
        <!-- Trip Table -->
        <div class="card">
            <!-- <div class="card-header color">
                <a href="./personnel-schedule" type="button" class="btn rounded-pill btn-primary">Go to Schedules</a>
            </div> -->
            <div class="card-body pad">
                <div class="tbl table-responsive text-nowrap">
                    <table id=dataTable class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th>Personnel</th>
                                <th>Date</th>
                                <th>Trip No.</th>
                                <th>Route</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="realtime_table_trip" class="table-border-bottom-0">
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
        $('#main-admin-trip').addClass('active open')

        $(document).ready(function (e) {
            // Data Table
            $('#dataTable').DataTable({
                searching: false, 
                paging: false, 
                info: false,
                order: [[0, 'desc']],
                "bPaginate": false,
            });
        })

        // Onclick Status Function
        function Status(id, trip_no, date){
            d = Date(date);
            dd = new Date(d);
            $('#status_content').html('');
            $('#status-modal-footer').html('')
            document.getElementById("status-modalTitle").innerHTML="View Status Logs";
            // Show Values in Modal
            document.getElementById("update").innerHTML="Trip No. "+trip_no+" : "+dd.toDateString();
            Controller.Post('/api/status/items', { 'trip_id': id }).done(function(result) {
                if(!result){
                    $('#status_content').append(
                            '<center>'+'<div>No Data Available</div>'+'</center>'
                        );
                    document.getElementById("status_content").innerHTML="No Data Available";
                }else{
                    for (rt of result) {
                        $('#status_content').append(
                            '<div class="mb-3 row">'+
                            '<label class="col-md-2 col-form-label">'+FormatTime(new Date(rt.created_at))+'</label>'+
                            '<div class="col-md-4">'+
                            '<input disabled class="mb-2 form-control" value='+FormatStatus(rt.bus_status)+
                            '> </div>'+
                            '<div class="col-md-6">'+
                            '<input disabled class="form-control" type="text" value='+rt.latitude+'\xa0-\xa0'+rt.longitude+
                            '> </div>'+
                            '</div>'
                        );
                    }


                }
                
                $('#status-modal').modal('show')
            });
            
        }

        function FormatTime(date) {
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12;
            minutes = minutes < 10 ? '0'+minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }

        function FormatStatus(bus_status) {
            var strStatus = '';
            if(bus_status == 1){
                strStatus = 'Passenger\xa0Loading';
            }else if(bus_status == 2){
                strStatus = 'Break';
            }else if(bus_status == 3){
                strStatus = 'Departed';
            }else if(bus_status == 4){
                strStatus = 'Cancelled';
            }else if(bus_status == 5){
                strStatus = 'Arrived';
            }
            return strStatus;
        }

        // var map;
        // function initMap() { 
        //     var location = new google.maps.LatLng(0,0);
        //     map = new google.maps.Map(document.getElementById('map'), {
        //         center: {lat: -34.397, lng: 150.644},
        //         zoom: 8
        //     });
        //     // var mapProperty = {
        //     //     center : location,
        //     //     zoom : 50,
        //     //     // mapTypeId : google.maps.mapTypeId.ROADMAP
        //     // };
        //     // map = new google.maps.Map(document.getElementById('map'), mapProperty);
        //     // marker = new google.maps.Marker({
        //     //     map : map,
        //     //     draggable : true,
        //     //     // animation : google.maps.Animation.DROP,
        //     //     position : location
        //     // });
            

        //     // var uluru = {lat: 28.501859, lng: 77.410320}; 
        //     // var map = new google.maps.Map(document.getElementById('map_content'), { 
        //     // zoom: 4, 
        //     // center: uluru 
        //     // }); 
        //     // var marker = new google.maps.Marker({ 
        //     // position: uluru, 
        //     // map: map 
        //     // }); 
        // } 

        

        // // Onclick Add Function
        // function Add(){
        //     $('#main-append').html('');
        //     document.getElementById("main-modalTitle").innerHTML= "Create Bus Information";
        //     document.getElementById("main-submit").innerHTML= "Create";
        //     // Clear Input Fields
        //     $('#id').val('-1'),
        //     $('#bus_no').val(''),
        //     $('#bus_type').val(''),
        //     $('#plate_no').val(''),
        //     $('#chassis_no').val(''),
        //     $('#engine_no').val(''),
        //     $('#color').val('#666EE8'),
        //     // Clear Error Messages
        //     $("#main-modal .errorMsg_bus_no").html('');
        //     $("#main-modal .errorMsg_bus_type").html('');
        //     $("#main-modal .errorMsg_plate_no").html('');
        //     $("#main-modal .errorMsg_chassis_no").html('');
        //     $("#main-modal .errorMsg_engine_no").html('');
        //     $("#main-modal .errorMsg_color").html('');
        //     // Show Modal
        //     $('#main-modal').modal('show');
        // }

        // // Onclick Edit Function
        // function Edit(id) {
        //     $('#main-append').html('');
        //     $('#view-modal').modal('hide');
        //     document.getElementById("main-modalTitle").innerHTML="Edit Bus Information";
        //     document.getElementById("main-submit").innerHTML= "Save";
        //     // Show Values in Modal
        //     Controller.Post('/api/bus/items', { 'id': id }).done(function(result) {
        //         // Clear Error Messages
        //         $("#main-modal .errorMsg_bus_no").html('');
        //         $("#main-modal .errorMsg_bus_type").html('');
        //         $("#main-modal .errorMsg_plate_no").html('');
        //         $("#main-modal .errorMsg_chassis_no").html('');
        //         $("#main-modal .errorMsg_engine_no").html('');
        //         $("#main-modal .errorMsg_color").html('');
        //         // Status Input Field
        //         $('#main-append').show();
        //         $("#main-append").append('<div id="main-status" class="row">');
        //         $("#main-append").append('<div class="col mt-3 mb-0">');
        //         $("#main-append").append('<label for="status" class="form-label">Status</label>');
        //         $("#main-append").append('<div class="input-group input-group-merge">');
        //         $("#main-append").append('<select class="form-select" id="status" name="status"> <option value="1">Active</option> <option value="2">Not Active</option> </select>');
        //         $("#main-append").append('</div>');
        //         $("#main-append").append('<div class="error-pad">');
        //         $("#main-append").append('<span class="errorMsg_status"></span>');
        //         $("#main-append").append('</div>');
        //         $("#main-append").append('</div>');
        //         $("#main-append").append('</div>');
        //         // Show ID values in Input Fields
        //         $('#id').val(result.id),
        //         $('#bus_no').val(result.bus_no),
        //         $('#bus_type').val(result.bus_type),
        //         $('#plate_no').val(result.plate_no),
        //         $('#chassis_no').val(result.chassis_no),
        //         $('#engine_no').val(result.engine_no),
        //         $('#color').val(result.color),
        //         $('#status').val(result.status),
        //         // Show Modal
        //         $('#main-modal').modal('show');
        //     });
        // }

        // // Onclick Save Function
        // function Save() {
        //     // Get Values from input fields
        //     var data = {
        //     id: $('#id').val(),
        //     company_id: $('#company_id').val(),
        //     bus_no: $('#bus_no').val(),
        //     bus_type: $('#bus_type').val(),
        //     plate_no: $('#plate_no').val(),
        //     chassis_no: $('#chassis_no').val(),
        //     engine_no: $('#engine_no').val(),
        //     status: $('#status').val(),
        //     color: $('#color').val(),
        //     }
        //     // Add Data to Database
        //     if(data.id == -1) {
        //         Controller.Post('/api/bus/create', data)
        //         // If success, return message
        //         .done(function(result) {
        //             var dialog = bootbox.dialog({
        //             centerVertical: true,
        //             closeButton: false,
        //             title: 'Saving Information',
        //             message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
        //             });
        //             $('#main-modal').modal('hide');
        //             dialog.init(function(){
        //                 setTimeout(function(){
        //                     dialog.find('.bootbox-body').html('Information Successfully saved!');
        //                     window.location.reload();
        //                 }, 1500);
        //             });
        //         })
        //         // If fail, show errors
        //         .fail(function (error) {
        //             const error1 = error.responseJSON.errors;
        //             let error_bus_no = "";
        //             let error_bus_type = "";
        //             let error_plate_no = "";
        //             let error_chassis_no = "";
        //             let error_engine_no = "";
        //             let error_color = "";
        //             for (const listKey in error1){
        //                 if(listKey == "bus_no"){
        //                     error_bus_no = ""+error1[listKey]+"";
        //                 }else if(listKey == "bus_type"){
        //                     error_bus_type = ""+error1[listKey]+"";
        //                 }else if(listKey == "plate_no"){
        //                     error_plate_no = ""+error1[listKey]+"";
        //                 }else if(listKey == "chassis_no"){
        //                     error_chassis_no = ""+error1[listKey]+"";
        //                 }else if(listKey == "engine_no"){
        //                     error_engine_no = ""+error1[listKey]+"";
        //                 }else if(listKey == "color"){
        //                     error_color = ""+error1[listKey]+"";
        //                 }
        //             }
        //             let msg_bus_no = "<text>"+error_bus_no+"</text>";
        //             let msg_bus_type = "<text>"+error_bus_type+"</text>";
        //             let msg_plate_no = "<text>"+error_plate_no+"</text>";
        //             let msg_chassis_no = "<text>"+error_chassis_no+"</text>";
        //             let msg_engine_no = "<text>"+error_engine_no+"</text>";
        //             let msg_color = "<text>"+error_color+"</text>";
        //             $("#main-modal .errorMsg_bus_no").html(msg_bus_no).addClass('text-danger').fadeIn(1000);
        //             $("#main-modal .errorMsg_bus_type").html(msg_bus_type).addClass('text-danger').fadeIn(1000);
        //             $("#main-modal .errorMsg_plate_no").html(msg_plate_no).addClass('text-danger').fadeIn(1000);
        //             $("#main-modal .errorMsg_chassis_no").html(msg_chassis_no).addClass('text-danger').fadeIn(1000);
        //             $("#main-modal .errorMsg_engine_no").html(msg_engine_no).addClass('text-danger').fadeIn(1000);
        //             $("#main-modal .errorMsg_color").html(msg_color).addClass('text-danger').fadeIn(1000);
        //             $("#main-modal button").attr('disabled',false);
        //         })
        //     }
        //     // Update Data to Database
        //     else if(data.id > 0) {
        //         Controller.Post('/api/bus/update', data)
        //         // If success, return message
        //         .done(function(result) {
        //             var dialog = bootbox.dialog({
        //             centerVertical: true,
        //             closeButton: false,
        //             title: 'Updating Information',
        //             message: '<p class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </p>'
        //             });
        //             $('#main-modal').modal('hide');
        //             dialog.init(function(){
        //                 setTimeout(function(){
        //                     dialog.find('.bootbox-body').html('Information Successfully updated!');
        //                     window.location.reload();
        //                 }, 1500);
        //             });
        //         })
        //         // If fail, show errors
        //         .fail(function (error) {
        //             const error1 = error.responseJSON.errors;
        //             let error_bus_no = "";
        //             let error_bus_type = "";
        //             let error_plate_no = "";
        //             let error_chassis_no = "";
        //             let error_engine_no = "";
        //             let error_color = "";
        //             let error_status = "";
        //             for (const listKey in error1){
        //                 if(listKey == "bus_no"){
        //                     error_bus_no = ""+error1[listKey]+"";
        //                 }else if(listKey == "bus_type"){
        //                     error_bus_type = ""+error1[listKey]+"";
        //                 }else if(listKey == "plate_no"){
        //                     error_plate_no = ""+error1[listKey]+"";
        //                 }else if(listKey == "chassis_no"){
        //                     error_chassis_no = ""+error1[listKey]+"";
        //                 }else if(listKey == "engine_no"){
        //                     error_engine_no = ""+error1[listKey]+"";
        //                 }else if(listKey == "color"){
        //                     error_color = ""+error1[listKey]+"";
        //                 }else if(listKey == "status"){
        //                     error_status = ""+error1[listKey]+"";
        //                 }
        //             }
        //             let msg_bus_no = "<text>"+error_bus_no+"</text>";
        //             let msg_bus_type = "<text>"+error_bus_type+"</text>";
        //             let msg_plate_no = "<text>"+error_plate_no+"</text>";
        //             let msg_chassis_no = "<text>"+error_chassis_no+"</text>";
        //             let msg_engine_no = "<text>"+error_engine_no+"</text>";
        //             let msg_color = "<text>"+error_color+"</text>";
        //             let msg_status = "<text>"+error_status+"</text>";
        //             $("#main-modal .errorMsg_bus_no").html(msg_bus_no).addClass('text-danger').fadeIn(1000);
        //             $("#main-modal .errorMsg_bus_type").html(msg_bus_type).addClass('text-danger').fadeIn(1000);
        //             $("#main-modal .errorMsg_plate_no").html(msg_plate_no).addClass('text-danger').fadeIn(1000);
        //             $("#main-modal .errorMsg_chassis_no").html(msg_chassis_no).addClass('text-danger').fadeIn(1000);
        //             $("#main-modal .errorMsg_engine_no").html(msg_engine_no).addClass('text-danger').fadeIn(1000);
        //             $("#main-modal .errorMsg_color").html(msg_color).addClass('text-danger').fadeIn(1000);
        //             $("#main-modal .errorMsg_status").html(msg_status).addClass('text-danger').fadeIn(1000);
        //             $("#main-modal button").attr('disabled',false);
        //         })    
        //     }
        // }

        // // Onclick Delete Function
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
        //                             title: "Oops! There is an active personnel-schedule with this bus.",
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
    <script>
        function loadXMLDoc() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                
                if (this.readyState == 4 && this.status == 200) {
                    $(function () {
                        $('[data-bs-toggle="tooltip"]').tooltip();
                    });
                    document.getElementById("realtime_table_trip").innerHTML =
                    this.responseText;
                }
            };
            xhttp.open("GET", "./tbl-trip", true);
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