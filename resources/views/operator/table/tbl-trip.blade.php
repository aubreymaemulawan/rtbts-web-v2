@foreach($trip as $tr)
    @if($tr->personnel_schedule->operator_id==Auth::user()->personnel_id)
    <tr>
        <td></td>
        <?php 
            $c = DB::table('personnel')->where('id',$tr->personnel_schedule->conductor_id)->value('profile_path'); 
            $c_name = DB::table('personnel')->where('id',$tr->personnel_schedule->conductor_id)->value('name');
            $c_status = DB::table('personnel')->where('id',$tr->personnel_schedule->conductor_id)->value('status');
            $d = DB::table('personnel')->where('id',$tr->personnel_schedule->dispatcher_id)->value('profile_path');
            $d_name = DB::table('personnel')->where('id',$tr->personnel_schedule->dispatcher_id)->value('name');
            $d_status = DB::table('personnel')->where('id',$tr->personnel_schedule->dispatcher_id)->value('status');
            $o = DB::table('personnel')->where('id',$tr->personnel_schedule->operator_id)->value('profile_path');
            $o_name = DB::table('personnel')->where('id',$tr->personnel_schedule->operator_id)->value('name');
            $o_status = DB::table('personnel')->where('id',$tr->personnel_schedule->operator_id)->value('status');
            $str1 = $c;
            $str1 = ltrim($str1, 'public/');
            $str2 = $d;
            $str2 = ltrim($str2, 'public/');
            $str3 = $o;
            $str3 = ltrim($str3, 'public/');
        ?>
        <!-- Personnel Column -->
        <td>
            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
            @if($c==null)
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Conductor : {{$c_name}}">
                    <img src="{{ asset('assets/img/avatars/default.jpg') }}" alt="Avatar" class="rounded-circle" />
                </li>
            @else
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Conductor : {{$c_name}}">
                    <img src="{{ asset('../storage/'.$str1) }}" alt="Avatar" class="rounded-circle" />
                </li>
            @endif
            @if($d==null)
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Dispatcher : {{$d_name}}">
                    <img src="{{ asset('assets/img/avatars/default.jpg') }}" alt="Avatar" class="rounded-circle" />
                </li>
            @else
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Dispatcher : {{$d_name}}">
                    <img src="{{ asset('../storage/'.$str2) }}" alt="Avatar" class="rounded-circle" />
                </li>
            @endif
            @if($o==null)
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Driver : {{$o_name}}">
                    <img src="{{ asset('assets/img/avatars/default.jpg') }}" alt="Avatar" class="rounded-circle" />
                </li>
            @else
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Driver : {{$o_name}}">
                    <img src="{{ asset('../storage/'.$str3) }}" alt="Avatar" class="rounded-circle" />
                </li>
            @endif
            </ul>
        </td>
        <!-- Date Column -->
        <td>
            <?php
                $date = new DateTime($tr->personnel_schedule->date);
                $result = $date->format('F j, Y');
            ?>
            <strong>{{$result}}</strong>
        </td>
        <!-- Trip No Column -->
        <td>{{$tr->trip_no}}</td>
        <!-- Route Column -->
        @if($tr->inverse == 1)
            <?php 
            $str1 = $tr->personnel_schedule->schedule->route->from_to_location;
            $orig_dest1 = explode(" - ", $str1);
            $a1 = $orig_dest1[0];
            $b1 = $orig_dest1[1];
            $inverse_location = $b1." - ".$a1;
            ?>
        <td>{{$inverse_location}}</td>
        @elseif($tr->inverse == 0)
        <td>{{$tr->personnel_schedule->schedule->route->from_to_location}}</td>
        @endif
        <!-- Duration Column -->
        <td>{{intval($tr->trip_duration)}} mins</td>
        <!-- Status column -->
        @if($tr->arrived == 1)
        <td><span class="badge bg-label-success me-1">Arrived</span></td>
        @elseif($tr->arrived == 2)
        <td><span class="badge bg-label-danger me-1">Cancelled</span></td>
        @elseif($tr->arrived == 0)
        <td><span class="badge bg-label-warning me-1">Ongoing</span></td>
        @endif
        <!-- Actions -->
        <td>
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <!-- Status Logs -->
                    <button onclick="Status({{$tr->id}}, {{$tr->trip_no}}, {{$tr->personnel_schedule->date}})" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-info-square me-1"></i>
                        Status Logs
                    </button>
                    @if($tr->arrived == 0)
                    <a href="/track-bus/{{$tr->id}}" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-map"></i>
                        View in Map
                    </a>
                    @endif
                </div>
            </div>
        </td>
    </tr>
    @endif
@endforeach