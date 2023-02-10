@extends('layouts.app')
@section('title','My Trips')

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

@section('dispatcher_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light">Trip Records /</span> My Trips
        </h4>
        <div class="alert alert-primary" style="padding:20px">
            <i class="bx bx-info-circle me-1"></i>
            Real-time Table. View your assigned trips here.
        </div>
        <!-- Schedule Table -->
        <div class="card">
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
                        <tbody id="realtime_table_dispatcher_trip" class="table-border-bottom-0">
                            
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
        $('#main-dispatcher-trip').addClass('active open')
        
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
    </script>
    <script>
        function loadXMLDoc() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    $(function () {
                        $('[data-bs-toggle="tooltip"]').tooltip();
                    });
                    document.getElementById("realtime_table_dispatcher_trip").innerHTML =
                    this.responseText;
                }
            };
            xhttp.open("GET", "./tbl-dispatcher-trip", true);
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
