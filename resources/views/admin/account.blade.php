@extends('layouts.app')
@section('title','Accounts List')

@section('admin_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light">Bus Personnel /</span> Accounts List
        </h4>
        <div class="alert alert-primary" style="padding:20px">
            <i class="bx bx-info-circle me-1"></i>
            View your personnel accounts information here.
        </div>
        <!-- Account Table -->
        <div class="card">
            <div class="card-header color">
                <a type="button" class="btn rounded-pill btn-primary" href="./personnel">Go to Manage</a>
            </div>
            <div class="card-body pad">
                <div class="tbl table-responsive text-nowrap">
                    <table id=dataTable class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th>Personnel No.</th>
                                <th>Role</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Account</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($account as $ac)
                                @if($ac->personnel->company_id==Auth::user()->company_id)
                                <tr>
                                    <td></td>
                                    <!-- Personnel No. Column -->
                                    <td data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="{{$ac->personnel->name}}"><strong>{{$ac->personnel->personnel_no}}</strong></td>
                                    <!-- User Type Column -->
                                    @if ($ac->personnel->user_type == 2)
                                    <td>Conductor</td>
                                    @elseif ($ac->personnel->user_type == 3)
                                    <td>Dispatcher</td>
                                    @elseif ($ac->personnel->user_type == 4)
                                    <td>Driver</td>
                                    @endif
                                    <!-- Username Column -->
                                    <td>{{$ac->email}}</td>
                                    <!-- Password Column -->
                                    <td>{{$ac->password}}</td>
                                    <!-- Account Status Column -->
                                    @if(DB::table('users')->where('personnel_id',$ac->personnel_id)->exists())
                                    <td><span class="badge bg-label-success me-1">Enabled</span></td>
                                    @elseif( DB::table('account')->where('personnel_id',$ac->personnel_id)->exists() && !(DB::table('users')->where('personnel_id',$ac->personnel_id)->exists()) )
                                    <td><span class="badge bg-label-danger me-1">Disabled</span></td>
                                    @endif
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
        $('#menu-account').addClass('active')

        $(document).ready(function (e) {
            // Data Table
            $('#dataTable').DataTable();
        })
    </script>
@endsection