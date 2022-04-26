@extends('users.dashboard')
@section('content')
<div class="container-fluid overflow-hidden" style="padding: 0%; background-color: #fff6f6 ">
    {{-- Banner --}}
    <div class="row g-0">
        <div class="col-6 d-flex align-items-center justify-content-center" style="background-color: #f77f00">
            <div class="col-9 text-white text-start fw-bold" style="font-size: 65px">
                The fast, affordable way to ride.
            </div>
        </div>
        <div class="col-6">
            <img src="https://images.pexels.com/photos/1399282/pexels-photo-1399282.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="" style="height: 89vh; width:100%;  object-fit: cover; object-position: center">
        </div>
    </div>

    {{-- Earn Extra money --}}
    <div class="row" style="height: 32vh; background-color: #d62828">
        <div class="col-7 text-end fw-bold fs-3 text-white d-flex align-items-center justify-content-end">
            <p class="fw-bold fs-3 mb-0">Earn extra money driving<br><span class="fs-5">Set your own schedule, be your own boss</span></p>
        </div>
        <div class="col-5 d-flex align-items-center">
            <a href="/driver/register" class="btn rounded-pill px-5 fw-bold" style="background-color: #fcbf49">Sign in</a>
        </div>
    </div>

    {{-- Our Services section --}}
    <div class="row mt-5 mx-auto py-5">
        <div class="col-md-4 text-center">
            <img src="{{ asset('assets/car2.svg') }}" alt="" style="height: 100px">
            <h4>Get a ride</h4>
            <p class="mb-0 text-muted">Bolt offers you a ride in minutes.</p>
        </div>
        <div class="col-md-4 text-center">
            <img src="{{ asset('assets/money.svg') }}" alt="" style="height: 100px">
            <h4>The best prices</h4>
            <p class="mb-0 text-muted">We aim to offer the best ride prices in every city. See for yourself!</p>
        </div>
        <div class="col-md-4 text-center">
            <img src="{{ asset('assets/easy2.svg') }}" alt="" style="height: 100px">
            <h4>Easy to use</h4>
            <p class="mb-0 text-muted">Get wherever you need to go as quickly as possible.</p>
        </div>
    </div>

    {{-- Get a ride in minutes --}}
    <div class="mt-4" style="background-color: #fcbf49">
        <div class="row container mx-auto py-4">
            <div class="col-8 text-white d-flex align-items-center">
                <p class=" text-dark"><span class="fw-bold fs-2">Get a ride in minutes!</span><br>Pick your destination, request a ride, meet your driver, enjoy the journey.</p>
            </div>
            <div class="col-4">
                <img src="{{ asset('assets/map3.svg') }}" alt="" style="width: 100%; height: 28vh;">
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
                    <p class="text-muted">Safe and convenient</p>
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
                    <p class="text-muted">Bolt drivers earn more thanks to lower commission rates.</p>
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
                    <p class="text-muted">Get fast support, whenever you need.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Ready to Ride --}}
    <div class="mt-4" style="position: relative; height: 45vh; width: 100%; background-image: url('https://cdn.pixabay.com/photo/2016/11/22/23/44/porsche-1851246_960_720.jpg'); background-repeat: no-repeat; background-size: cover;">
        <div class="" style="position: absolute; height: 45vh; width: 100%; background-color: black; opacity: 0.6;">
        </div>
        <div class="text-white d-flex align-items-center justify-content-center" style="position: absolute; height: 45vh; width: 100%;">
            <p><span class="fw-bold fs-1">Ready to ride?</span><br>Or <a href="/driver/register" class="text-warning">sign in</a> to start driving
            </p>            
        </div>
    </div>
</div>
@endsection
