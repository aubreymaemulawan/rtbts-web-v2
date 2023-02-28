@foreach($trip as $tr)
    <?php 
    $origin = ''; 
    $destination = '';
    $str1 = $tr->personnel_schedule->schedule->route->from_to_location;
    ?>
    @if($tr->inverse == 1)
        <?php 
        $orig_dest1 = explode(" - ", $str1);
        $destination = $orig_dest1[0];
        $origin = $orig_dest1[1];
        ?>
    @elseif($tr->inverse == 0)
        <?php 
        $orig_dest1 = explode(" - ", $str1);
        $origin = $orig_dest1[0];
        $destination = $orig_dest1[1];
        ?>
    @endif

    <tr>
        <td><strong>{{$tr->personnel_schedule->schedule->company->company_name}}</strong></td>
        @if($tr->personnel_schedule->bus->bus_type == 1)
        <td>{{$tr->personnel_schedule->bus->bus_no}} - AC</td>
        @elseif($tr->personnel_schedule->bus->bus_type == 2)
        <td>{{$tr->personnel_schedule->bus->bus_no}} - Non-AC</td>
        @endif
        <td>{{$tr->trip_no}}</td>
        <td>{{$origin}}</td>
        <td>{{$destination}}</td>
        <td>
            <?php
                $st = DB::table('status')->where('trip_id',$tr->id)->latest('created_at')->first();
                if($st){
                    $date = new DateTime($st->created_at);
                    $result1 = $date->format('g:i a');
                }
            ?>
            @if(!$st)
                <span class="badge bg-label-dark me-1">Standby</span>
            @else
                @if($st->bus_status == 1)
                <span class="badge bg-label-warning me-1">On Alley - {{$result1}}</span>
                @elseif($st->bus_status == 2)
                <span class="badge bg-label-secondary me-1">Break - {{$result1}}</span>
                @elseif($st->bus_status == 3)
                <span class="badge bg-label-info me-1">Departed - {{$result1}}</span>
                @elseif($st->bus_status == 4)
                <span class="badge bg-label-danger me-1">Cancelled - {{$result1}}</span>
                @elseif($st->bus_status == 5)
                <span class="badge bg-label-success me-1">Arrived - {{$result1}}</span>
                @endif
            @endif
        </td>               
        @if(!$st && $tr->arrived == 0)
            <td><a rel="nofollow" href="/track-bus/{{$tr->id}}">Track location &rarr;</a></td>
        @elseif(!$st && $tr->arrived == 1)
            <td></td>
        @else
            @if($st->bus_status == 5 || $st->bus_status == 4)
            <td></td>
            @else
            <td><a rel="nofollow" href="/track-bus/{{$tr->id}}">Track location &rarr;</a></td>
            @endif
        @endif
    </tr>
@endforeach