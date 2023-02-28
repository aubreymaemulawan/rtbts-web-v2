
@foreach($personnel_schedule as $ps)
    @if($ps->schedule->company_id == Auth::user()->company_id)
    <?php $count = 0; ?>
        <tr class="tbl">
            <td></td>
            <!-- Personnel -->
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
                    <li data-bs-toggle="tooltip" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Conductor : {{$c_name}} @if($c_status == 1)(Active) @elseif($c_status == 2)(Not Active) @endif">
                        <img src="{{ asset('assets/img/avatars/default.jpg') }}" alt="Avatar" class="rounded-circle" />
                    </li>
                    
                @else
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Conductor : {{$c_name}} @if($c_status == 1)(Active) @elseif($c_status == 2)(Not Active) @endif">
                        <img src="{{ asset('../storage/'.$str1) }}" alt="Avatar" class="rounded-circle" />
                    </li>
                @endif
                @if($d==null)
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Dispatcher : {{$d_name}} @if($d_status == 1)(Active) @elseif($d_status == 2)(Not Active) @endif">
                        <img src="{{ asset('assets/img/avatars/default.jpg') }}" alt="Avatar" class="rounded-circle" />
                    </li>
                @else
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Dispatcher : {{$d_name}} @if($d_status == 1)(Active) @elseif($d_status == 2)(Not Active) @endif">
                        <img src="{{ asset('../storage/'.$str2) }}" alt="Avatar" class="rounded-circle" />
                    </li>
                @endif
                @if($o==null)
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Driver : {{$o_name}} @if($o_status == 1)(Active) @elseif($o_status == 2)(Not Active) @endif">
                        <img src="{{ asset('assets/img/avatars/default.jpg') }}" alt="Avatar" class="rounded-circle" />
                    </li>
                @else
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Driver : {{$o_name}} @if($o_status == 1)(Active) @elseif($o_status == 2)(Not Active) @endif">
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
            <!-- Route Column -->
            @if($ps->schedule->status == 2 && $ps->status == 4)
            <td style="color:red">N/A</td>
            @else
            <td>{{$ps->schedule->route->from_to_location}}</td>
            @endif
            <!-- Bus column -->
            @if($ps->bus->status == 2 && $ps->status == 4)
            <td style="color:red">N/A</td>
            @else
                @if($ps->bus->bus_type == 1)
                <td>{{$ps->bus->bus_no}} - Aircon</td>
                @elseif($ps->bus->bus_type == 2)
                <td>{{$ps->bus->bus_no}} - Non Aircon</td>                                    
                @endif
            @endif
            <!-- Max Trip Column -->
            <td>{{$ps->max_trips}}</td>
            <!-- Status column -->
            @foreach($trip as $tp)
                @if($tp->personnel_schedule_id == $ps->id)
                    <?php $count++; ?>
                @endif
            @endforeach
            @if($ps->status == 1)
            <td><span class="badge bg-label-success me-1">Active</span></td>
            @elseif($ps->status == 2)
            <td><span class="badge bg-label-danger me-1">Cancelled</span></td>
            @elseif($ps->status == 3)
            <td><span class="badge bg-label-secondary me-1">Done</span></td>
            @elseif($ps->status == 4)
            <td><span class="badge bg-label-warning me-1">Need Update</span></td>
            @endif
            <!-- Trip -->
            @if($count != 0)
            <td><span class="badge bg-label-warning me-1">Ongoing</span></td>
            @else
            <td><span class="badge bg-label-danger me-1">NONE</span></td>
            @endif
            <!-- Actions Column -->
            <td>
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <!-- View -->
                        <button onclick="View({{ $ps->id }})" class="dropdown-item" href="javascript:void(0);">
                            <i class="bx bx-info-square me-1"></i>
                            View
                        </button>
                        @if($count != 0)
                        @else
                            <?php
                                $date1 = new DateTime($ps->created_at);
                                $result1 = $date1->format('F j, Y');

                                $date2 = new DateTime();
                                $result2 = $date2->format('F j, Y');
                            ?>
                            @if($ps->status == 3 && $result1 != $result2)
                              
                            @else
                            <!-- Edit -->
                            <button onclick="Edit({{ $ps->id }})" class="dropdown-item" href="javascript:void(0);">
                                <i class="bx bx-edit-alt me-1"></i>
                                Edit
                            </button>
                            @endif
                            
                            <!-- Delete -->
                            <!-- <button onclick="Delete({{ $ps->id }})" class="dropdown-item" href="javascript:void(0);">
                                <i class="bx bx-trash me-1"></i>
                                Delete
                            </button> -->
                        @endif
                    </div>
                </div>
            </td>
        </tr>
    @endif
@endforeach
