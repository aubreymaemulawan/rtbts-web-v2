@extends('layouts.app')
@section('title','Announcements')

@section('modal')
    <!-- Status Modal --> 
        <div class="modal fade" id="view-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <!-- Status Form -->
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
                                    <h5 class="mb-1" id="subject"></h5>
                                    <small id="to"></small>
                                </div>
                            </div>
                        </div>
                        <hr class="hr-style">
                        <li class="d-flex mb-1 pb-1">
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <p class="mb-4" id="message"></p>
                                <small class="col-12">From : {{$comp_name}}</small>
                                <small class=" col-12" id="date"></small>
                            </div>
                        </li> 
                    </div>
                </form>
            </div>
        </div>
    <!-- End of Status Modal -->
@endsection

@section('dispatcher_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light">Bus Reminders /</span> Announcements
        </h4>
        <div class="alert alert-primary" style="padding:20px">
            <i class="bx bx-info-circle me-1"></i>
            View announcements from your management here.
        </div>
        <!-- Schedule Table -->
        <div class="card">
            <div class="card-body pad">
                <div class="tbl table-responsive">
                    <table id=dataTable class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th>To</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($announce as $an)
                                <tr>
                                    <td>
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-primary">
                                                <i class="bx bx-envelope"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                            $user_type = '';
                                            if($an->user_type == 1){
                                                $user_type = 'All';
                                            }else if($an->user_type == 2){
                                                $user_type = 'Conductors';
                                            }else if($an->user_type == 3){
                                                $user_type = 'Dispatchers';
                                            }else if($an->user_type == 4){
                                                $user_type = 'Operators';
                                            }else if($an->user_type == 5){
                                                $user_type = 'Passengers';
                                            }else if($an->user_type == 6){
                                                $user_type = 'All Personnel';
                                            }
                                        ?>
                                        <strong>{{$user_type}}</strong>
                                    </td>
                                    <td class="abbreviation">{{$an->subject}}</td>
                                    <td class="abbreviation">{{$an->message}}</td>
                                        <?php
                                            $date = new DateTime($an->created_at);
                                            $result = $date->format('F j, Y, g:i a');
                                        ?>
                                    <td>{{$result}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <!-- Status Logs -->
                                                <button onclick="View({{$an}})" class="dropdown-item" href="javascript:void(0);">
                                                    <i class="bx bx-info-square me-1"></i>
                                                    View
                                                </button>
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
        $('#main-dispatcher-announcement').addClass('active open')
        $('[id^="menu-"]').removeClass('active')

        // Data Table
        $('#dataTable').DataTable();

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
                user_type = 'Operators';
            }else if(data.user_type == 5){
                user_type = 'Passengers';
            }else if(data.user_type == 6){
                user_type = 'All Personnel';
            }
            $('#subject').html(data.subject);
            $('#to').html('To : '+user_type);
            $('#message').html(data.message);
            $('#date').html(date);
            $('#view-modal').modal('show')
        }
    </script>
@endsection