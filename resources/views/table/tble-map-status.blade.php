@if(!$status)
    <h1>
        <div class="alert alert-dark text-center" role="alert" >
            Standby
        </div>
    </h1>
    @else
        <?php
            $date = new DateTime($status->created_at);
            $result1 = $date->format('g:i a');
        ?>
        @if($status->bus_status == 1)
        <h1>
            <div class="alert alert-warning text-center" role="alert" >
                On Alley - {{$result1}}
            </div>
        </h1>
        @elseif($status->bus_status == 2)
        <h1>
            <div class="alert alert-secondary text-center" role="alert" >
                Break - {{$result1}}
            </div>
        </h1>
        @elseif($status->bus_status == 3)
        <h1>
            <div class="alert alert-info text-center" role="alert" >
                Departed - {{$result1}}
            </div>
        </h1>
        @elseif($status->bus_status == 4)
        <h1>
            <div class="alert alert-danger text-center" role="alert" >
                Cancelled - {{$result1}}
            </div>
        </h1>
        @elseif($status->bus_status == 5)
        <h1>
            <div class="alert alert-success text-center" role="alert" >
                Arrived - {{$result1}}
            </div>
        </h1>
        @elseif($status->bus_status == 6)
        <h1>
            <div class="alert alert-warning text-center" role="alert" >
                Bus Maintenance - {{$result1}}
            </div>
        </h1>
        @endif
@endif