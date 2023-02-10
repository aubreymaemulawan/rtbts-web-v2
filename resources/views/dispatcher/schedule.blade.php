@extends('layouts.app')
@section('title','My Schedule')

@section('dispatcher_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light">Bus Schedule /</span> My Schedule
        </h4>
        <div class="alert alert-primary" style="padding:20px">
            <i class="bx bx-info-circle me-1"></i>
            Real-time Table. View your assigned schedule here.
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
                                <th>Route</th>
                                <th>Bus</th>
                                <th>Trips</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="realtime_table_dispatcher_schedule" class="table-border-bottom-0">
                            
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
        $('#main-dispatcher-schedule').addClass('active open')
        
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
    </script>
    <script>
        function loadXMLDoc() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    $(function () {
                        $('[data-bs-toggle="tooltip"]').tooltip();
                    });
                    document.getElementById("realtime_table_dispatcher_schedule").innerHTML =
                    this.responseText;
                }
            };
            xhttp.open("GET", "./tbl-dispatcher-schedule", true);
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