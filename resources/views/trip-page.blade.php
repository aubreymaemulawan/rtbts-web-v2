@extends('layouts.index')
@section('title','Ongoing Trips')

@section('passenger_content')

    <!-- Main Content -->
    <main id="main" data-aos="fade-up">

        <!-- Header -->
        <section class="breadcrumbs track">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="text-dark">On-going <span>Trips</span> </h2>
                    <ol>
                        <li class="text-blue"><a href="/#home">Home</a></li>
                        <li class="text-dark">Trips</li>
                    </ol>
                </div>
                <h3>View the current trips available on the bus terminal.</h3>
            </div>
        </section>

        <!-- Trips -->
        <section id="trip" class="updates section-no-bg">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-12 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="box featured">
                            <?php
                                $date = new DateTime();
                                $result = $date->format('F j, Y');
                            ?>
                            <h3>On-going Trips - Today ({{$result}})
                                <span id="date"></span>
                            </h3>
                            <div class="table-responsive">
                                <table class="table table-hover dataTable" width="100%" cellspacing="1">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Company</th>
                                            <th>Bus Info</th>
                                            <th>Trip No.</th>
                                            <th>Origin</th>
                                            <th>Destination</th>
                                            <th>Status</th>
                                            <th>Location</th>
                                        </tr>
                                    </thead>
                                    <tbody id="realtime_trip_page">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        function loadXMLDoc_TripPage() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    $(function () {
                        $('[data-bs-toggle="tooltip"]').tooltip();
                    });
                    document.getElementById("realtime_trip_page").innerHTML =
                    this.responseText;
                }
            };
            xhttp.open("GET", "/tbl-trip-page/"+@json($persched_id), true);
            xhttp.send();
        }
        setInterval(function(){
            $('[data-bs-toggle="tooltip"]').tooltip('hide');
            loadXMLDoc_TripPage();
        },10000);
        window.onload = loadXMLDoc_TripPage;
    </script>
@endsection