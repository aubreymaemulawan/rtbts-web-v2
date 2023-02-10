@foreach($persched_today as $per)
    @if($per->status == 1)
    <tr>
        <?php $count = 0;?>
        <td><strong>{{$per->schedule->company->company_name}}</strong></td>
        <td>{{$per->schedule->route->from_to_location}}</td>
        @if($per->bus->bus_type == 1)
        <td>{{$per->bus->bus_no}} - AC</td>
        @elseif($per->bus->bus_type == 2)
        <td>{{$per->bus->bus_no}} - Non-AC</td>
        @endif
        <?php
            $date1 = new DateTime($per->schedule->first_trip);
            $first_trip = $date1->format('g:i a');
            $date2 = new DateTime($per->schedule->last_trip);
            $last_trip = $date2->format('g:i a');
        ?>
        <td>{{$first_trip}}</td>
        <td>{{$last_trip}}</td>
        <td>{{$per->schedule->interval_mins}} mins</td>
        @foreach($trip as $tp)
            @if($tp->personnel_schedule_id == $per->id)
                <?php $count++; ?>
            @endif
        @endforeach
        @if($count != 0)
        <td><span class="badge bg-label-warning me-1">Ongoing</span></td>
        @else
        <td><span class="badge bg-label-danger me-1">None</span></td>
        @endif
        <td><button class="btn" onclick="OpenTrips2({{$per->id}})">View Trips &rarr;</button></td>
    </tr>
    @endif
@endforeach