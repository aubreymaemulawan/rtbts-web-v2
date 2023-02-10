@extends('layouts.index')
@section('title','Welcome')

@section('passenger_content')

    <!-- Home -->
    <section id="home" class="d-flex align-items-center">
        <div class="container" data-aos="zoom-out" data-aos-delay="100">
            <h1>Welcome
                <span>Passengers.</span>
            </h1>
            <h2>Please select your preferred destination to get started!</h2>
            <div class="d-inline-flex" style="gap: 10px">
                <i class="bi bi-geo-alt-fill" style="font-size: 1.8em; color:#274472"></i>
                <select name="persched_id" class="form-control mr-4" style="width:200px;" data-style="btn btn-link" id="persched_id">
                    <option value="" disabled selected hidden>Route</option>
                    @if($persched_today)
                        @foreach($persched_today as $per)
                            <option value="{{$per->id}}">{{$per->schedule->route->from_to_location}} - {{$per->schedule->company->company_name}}</option>
                        @endforeach
                    @endif
                </select>
                <button onclick="OpenTrips()" class="btn-find scrollto">Find</button>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main id="main">

        <!-- Services -->
        <section id="featured-services" class="featured-services section-no-bg">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon"><i class="bx bx-time-five"></i></div>
                            <h4 class="title"><a href="">Efficient</a></h4>
                            <p class="description">
                                Save your time for important things by avoiding lengthy waits at the bus terminal.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon"><i class="bx bx-devices"></i></div>
                            <h4 class="title"><a href="">Convenient</a></h4>
                            <p class="description">
                                Easy access of important information about the buses on your mobile devices.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon"><i class="bx bx-check-shield"></i></div>
                            <h4 class="title"><a href="">Accurate</a></h4>
                            <p class="description">
                                See accurate and real-time information about the bus's arrival and departure details. </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon"><i class="bx bx-group"></i></div>
                            <h4 class="title"><a href="">Synchronized</a></h4>
                            <p class="description">
                                Better communication within the terminal with a synchronized source of information. </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trips -->
        <section id="trip" class="updates section-bg">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Trips</h2>
                    <h3>Bus Terminal <span> Trips</span></h3>
                    <p>Monitor on-going trips to have a hassle-free trip.</p>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="box featured">
                            <?php
                                $date = new DateTime();
                                $result = $date->format('F j, Y');
                            ?>
                            <h3>Schedule for Today ({{$result}})
                                <span id="date"></span>
                            </h3>
                            <div class="table-responsive">
                                <table class="table table-hover dataTable" width="100%" cellspacing="1">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Company</th>
                                            <th>Route (Vice Versa)</th>                                            
                                            <th>Bus Info</th>
                                            <th>First Trip</th>
                                            <th>Last Trip</th>
                                            <th>Interval</th>
                                            <th>Trip</th>
                                            <th>Trip Records</th>
                                        </tr>
                                    </thead>
                                    <tbody id="realtime_landing_trip">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Updates -->
        <section id="updates" class="updates section-no-bg">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Updates</h2>
                    <h3>Schedule | <span> Fare</span></h3>
                    <p>Always stay updated with our Schedules and Fares.</p>
                </div>
                <div class="row">
                    <!-- Tomorrow Schedule -->
                    <div class="col-lg-12 col-md-6 mt-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="box featured">
                            <?php
                                $date = new DateTime();
                                $date->modify('+1 day');
                                $result2 = $date->format('F j, Y');
                            ?>
                            <h3>Schedule for Tomorrow<span> ({{$result2}})</span></h3>
                            <div class="table-responsive">
                                <table class="table table-hover dataTable" width="100%" cellspacing="1">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Company</th>
                                            <th>Bus Route</th>
                                            <th>Bus Info</th>
                                            <th>First Trip</th>
                                            <th>Last Trip</th>
                                            <th>Interval</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($persched)
                                            @foreach ($persched as $sched)
                                                @if($sched->status == 1)
                                                <tr> 
                                                    <td><strong>{{$sched->schedule->company->company_name}}</strong></td>
                                                    <td>{{$sched->schedule->route->from_to_location}}</td>
                                                    @if($sched->bus->bus_type==1)
                                                    <td>{{$sched->bus->bus_no}} - AC</td>
                                                    @elseif($sched->bus->bus_type==2)
                                                    <td>{{$sched->bus->bus_no}} - Non-AC</td>
                                                    @endif
                                                    <?php
                                                        $date1 = new DateTime($sched->schedule->first_trip);
                                                        $first_trip = $date1->format('g:i a');
                                                        $date2 = new DateTime($sched->schedule->last_trip);
                                                        $last_trip = $date2->format('g:i a');
                                                    ?>
                                                    <td>{{$first_trip}}</td>
                                                    <td>{{$last_trip}}</td>
                                                    <td>{{$sched->schedule->interval_mins}} mins</td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Fare -->
                    <div class="col-lg-12 col-md-6 mt-4 " data-aos="fade-up" data-aos-delay="100">
                        <div class="box featured">
                            <h3>Fare</h3>
                            <div class="table-responsive">
                                <table class="table table-hover dataTable" width="100%" cellspacing="1">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Route</th>
                                            <th>Company</th>
                                            <th>Bus Type</th>
                                            <th>Price</th>
                                            <th>Date Updated</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($fare)
                                            @foreach ($fare as $fr)
                                                <tr>
                                                    <td><strong>{{$fr->route->from_to_location}}</strong></td>
                                                    <td>{{$fr->route->company->company_name}}</td>
                                                    @if($fr->bus_type==1)
                                                    <td>AC</td>
                                                    @elseif($fr->bus_type==2)
                                                    <td>Non-AC</td>
                                                    @endif
                                                    <td>₱{{$fr->price}}</td>
                                                    <td>
                                                    <?php
                                                        $date = new DateTime($fr->updated_at);
                                                        $res3 = $date->format('F j, Y');
                                                    ?>
                                                    {{$res3}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if($announce)
        <!-- Announcements -->
        <section id="announce" class="testimonials">
            <div class="container" data-aos="zoom-in">
                <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">
                        @foreach($announce as $an)
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                @if($an->company->logo_path=="")
                                    <img src="{{ asset('assets/img/avatars/default.jpg') }}" class="testimonial-img" alt="">
                                @else
                                    <?php
                                        $str = $an->company->logo_path;
                                        $str = ltrim($str, 'public/');
                                    ?>
                                    <img src="{{ asset('../storage/'.$str) }}" class="testimonial-img" alt="">
                                @endif
                                <h3>{{$an->company->company_name}}</h3>
                                <h4>Bus Company</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    {{$an->message}}
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
        @else
        @endif
        
        <!-- Contact Us -->
        <section id="contact" class="contact section-no-bg">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Contact</h2>
                    <h3>Connect<span> With Us</span></h3>
                    <p>Leave us a message. We're always ready to help you.</p>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-6 ">
                        <iframe class="mb-4 mb-lg-0" src="https://maps.google.com/maps?q=Agora%20Bus%20Terminal,%20Gaabucayan%20Street,%20Cagayan%20de%20Oro,%20Misamis%20Oriental,%20Philippines&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" style="border:0; width: 100%; height: 360px;" allowfullscreen></iframe>
                    </div>
                    <div class="col-lg-6">
                        <div class="info-box mb-4">
                            <i class="bx bx-map"></i>
                            <h3>Our Address</h3>
                            <p>Agora Bus Terminal, Gaabucayan St., Cagayan de Oro, PH</p>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="info-box mb-4">
                                    <i class="bx bx-envelope"></i>
                                    <h3>Email Us</h3>
                                    <p>helpdesk@rtbts.com</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="info-box mb-4">
                                    <i class="bx bx-phone-call"></i>
                                    <h3>Call Us</h3>
                                    <p>+63 916 310 4268</p>
                                </div>
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
        var persched_id = 0;

        
        function OpenTrips(){
            persched_id = $('#persched_id').val();
            Controller.Post('/api/route/check', { 'persched_id': persched_id }).done(function(result) {
                if(result == 1){
                    bootbox.alert({
                        message: "Sorry, there is no trip recorded at this moment with the selected route.",
                        centerVertical: true,
                        closeButton: false,
                        size: 'medium',
                    }); 
                }else{
                    if(persched_id == null){
                        NotComplete();
                    }else{
                        window.open('./trip-page/'+persched_id,"_self");
                    }
                }
            });
            
        }

        
        function OpenTrips2(persched_id){
            Controller.Post('/api/route/check', { 'persched_id': persched_id }).done(function(result) {
                if(result == 1){
                    bootbox.alert({
                        message: "Sorry, there is no trip recorded at this moment with the selected route.",
                        centerVertical: true,
                        closeButton: false,
                        size: 'medium',
                    }); 
                }else{
                    if(persched_id == null){
                        NotComplete();
                    }else{
                        window.open('./trip-page/'+persched_id,"_self");
                    }
                }
            });
            
        }

        // 
        function NotComplete(){
            bootbox.alert({
                message: "Please select a route.",
                centerVertical: true,
                closeButton: false,
                size: 'medium',
            }); 
        }
    </script>

    <script>
        function loadXMLDoc_Trip() {
            var xhttp1 = new XMLHttpRequest();
            xhttp1.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    $(function () {
                        $('[data-bs-toggle="tooltip"]').tooltip();
                    });
                    document.getElementById("realtime_landing_trip").innerHTML =
                    this.responseText;
                }
            };
            xhttp1.open("GET", "/tbl-landing-trip", true);
            xhttp1.send();
        }

        setInterval(function(){
            $('[data-bs-toggle="tooltip"]').tooltip('hide');
            loadXMLDoc_Trip();
        },5000);

        window.onload = function () {
            loadXMLDoc_Trip;
        };
    </script>

@endsection