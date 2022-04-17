@extends('users.dashboard')

@section('content')
<div class="container-fluid overflow-hidden" style="padding: 0%">
    {{-- Banner --}}
    <div class="row g-0">
        <div class="col-6 d-flex align-items-center justify-content-center bg-dark">
            <div class="col-9 text-white text-start fw-bold" style="font-size: 65px">
                The fast, affordable way to ride.
            </div>
        </div>
        <div class="col-6">
            <img src="https://images.unsplash.com/photo-1602604900209-e712d9ca7173?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" alt="" style="height: 89vh; width:100%">
        </div>
    </div>

    {{-- Driver Sign in --}}
    <div class="row bg-dark" style="height: 32vh">
        <div class="col-7 text-end fw-bold fs-3 text-white d-flex align-items-center justify-content-end">
            <p class="fw-bold fs-3 mb-0">Earn extra money driving<br><span class="fs-5">Set your own schedule, be your own boss</span></p>
        </div>
        <div class="col-5 d-flex align-items-center">
            <div class="btn btn-light rounded-pill px-5 fw-bold">Sign in</div>
        </div>
    </div>

    {{-- Our Services section --}}
    <div class="row mt-5 mx-auto py-5">
        <div class="col-md-4 text-center">
            <img src="{{ asset('assets/car2.svg') }}" alt="" style="height: 100px">
            <h4>Get a ride</h4>
            <p class="mb-0">Bolt offers you a ride in minutes.</p>
        </div>
        <div class="col-md-4 text-center">
            <img src="{{ asset('assets/money.svg') }}" alt="" style="height: 100px">
            <h4>The best prices</h4>
            <p class="mb-0">We aim to offer the best ride prices in every city. See for yourself!</p>
        </div>
        <div class="col-md-4 text-center">
            <img src="{{ asset('assets/easy2.svg') }}" alt="" style="height: 100px">
            <h4>Easy to use</h4>
            <p class="mb-0">Get wherever you need to go as quickly as possible.</p>
        </div>
    </div>

    {{-- Get a ride in minutes --}}
    <div class="bg-dark mt-4">
        <div class="row container mx-auto py-4">
            <div class="col-8 text-white d-flex align-items-center">
                <p><span class="fw-bold fs-2">Get a ride in minutes!</span><br>Pick your destination, request a ride, meet your driver, enjoy the journey.</p>
            </div>
            <div class="col-4">
                <img src="{{ asset('assets/map1.svg') }}" alt="" style="width: 100%; height: 28vh;">
            </div>
        </div>
    </div>

    {{-- Why to use section --}}
    <div class="row container mt-4 py-5 mx-auto">
        <div class="col-md-4">
            <div class="row g-0">
                <div class="col-2">
                    <i class="fas fa-car" style="font-size:50px"></i>
                </div>
                <div class="col-10 px-2">
                    <h5>Safe and convenient</h5>
                    <p>Safe and convenient</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row g-0">
                <div class="col-2">
                    <i class="fas fa-hand-holding-heart" style="font-size:50px"></i>
                </div>
                <div class="col-10 px-2">
                    <h5>Happy drivers, happy riders</h5>
                    <p>Bolt drivers earn more thanks to lower commission rates.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row g-0">
                <div class="col-2">
                    <i class="fas fa-headset" style="font-size:50px"></i>
                </div>
                <div class="col-10 px-2">
                    <h5>Always there for you</h5>
                    <p>Get fast support, whenever you need.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Ready to Ride --}}
    <div class="bg-dark text-white d-flex align-items-center justify-content-center mt-4" style="height: 40vh; width: 100%">
        <p><span class="fw-bold fs-1">Ready to ride?</span><br>Or <a href="#" class="text-white">sign in</a> to start driving
        </p>
    </div>

</div>
@endsection
