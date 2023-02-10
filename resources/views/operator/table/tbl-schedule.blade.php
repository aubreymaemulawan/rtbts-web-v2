@foreach($personnel_schedule as $ps)
    @if($ps->operator_id==Auth::user()->personnel_id && $ps->status != 4)
    <tr>
        <td></td>
        <!-- Personnel Column -->
        <?php 
            $c = DB::table('personnel')->where('id',$ps->conductor_id)->value('profile_path'); 
            $c_name = DB::table('personnel')->where('id',$ps->conductor_id)->value('name');
            $c_status = DB::table('personnel')->where('id',$ps->conductor_id)->value('status');
            $d = DB::table('personnel')->where('id',$ps->dispatcher_id)->value('profile_path');
            $d_name = DB::table('personnel')->where('id',$ps->dispatcher_id)->value('name');
            $d_status = DB::table('personnel')->where('id',$ps->dispatcher_id)->value('status');
            $o = DB::table('personnel')->where('id',$ps->operator_id)->value('profile_path');
            $o_name = DB::table('personnel')->where('id',$ps->operator_id)->value('name');
            $o_status = DB::table('personnel')->where('id',$ps->operator_id)->value('status');
            $str1 = $c;
            $str1 = ltrim($str1, 'public/');
            $str2 = $d;
            $str2 = ltrim($str2, 'public/');
            $str3 = $o;
            $str3 = ltrim($str3, 'public/');
        ?>
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
                $date = new DateTime($ps->date);
                $result = $date->format('F j, Y');
            ?>
            <strong>{{$result}}</strong>
        </td>
        <!-- Route No. Column -->
        <td>{{$ps->schedule->route->from_to_location}}</td>
        <!-- Bus Column -->
        @if($ps->bus->bus_type == 1 && $ps->bus->status == 1)
        <td>{{$ps->bus->bus_no}} - Aircon</td>
        @elseif($ps->bus->bus_type == 2 && $ps->bus->status == 1)
        <td>{{$ps->bus->bus_no}} - Non Aircon</td>
        @endif
        <!-- Maximum Trips column -->
        <?php $cn = 0; ?>
        @foreach($trip as $tr)
            @if($tr->personnel_schedule_id == $ps->id && $tr->arrived == 1) 
                <?php $cn++; ?>
            @endif
        @endforeach
        <td>{{$cn}} / {{$ps->max_trips}}</td>
        
        @if($ps->status == 1)
        <td><span class="badge bg-label-success me-1">Active</span></td>
        @elseif($ps->status == 2)
        <td><span class="badge bg-label-danger me-1">Cancelled</span></td>
        @elseif($ps->status == 3)
        <td><span class="badge bg-label-secondary me-1">Done</span></td>
        @endif
    </tr>
    @endif
@endforeach