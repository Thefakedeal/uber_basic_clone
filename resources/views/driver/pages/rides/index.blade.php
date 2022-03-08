@extends('driver.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-md-0 mb-3" style="height: 80vh; overflow-y:auto;">
                <div class="alert alert-primary sticky-top" role="alert">
                    Accepted Drivers
                </div>
                @forelse ($accepted_rides as $ride)
                    <a class="text-white " href="{{ route('driver.rides.show', $ride->id) }}" >
                        <div class="card @if($ride->is_completed) text-muted text-decoration-line-through @endif">
                            <div class="card-body">
                                <div class="d-flex w-100 justify-content-between ">
                                    <div>

                                        <b> {{ $ride->user->name }} <br> {{ $ride->created_at->format('d/m/Y h:i a') }}</b> - {{ $ride->status }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <h1 class="text-center text-muted">
                        Sorry No Rides Yet
                    </h1>
                @endforelse
            </div>
            <div class="col-md-4 mb-md-0 mb-3" style="height: 80vh; overflow-y:auto;">
                <div class="alert alert-secondary sticky-top" role="alert">
                    Pending Drivers
                </div>
                @forelse ($pending_rides as $ride)
                    <a class="text-white " href="{{ route('driver.rides.show', $ride->id) }}" >
                        <div class="card @if($ride->is_completed) text-muted text-decoration-line-through @endif">
                            <div class="card-body">
                                <div class="d-flex w-100 justify-content-between ">
                                    <div>

                                        <b> {{ $ride->user->name }} <br> {{ $ride->created_at->format('d/m/Y h:i a') }}</b> - {{ $ride->status }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <h1 class="text-center text-muted">
                        Sorry No Rides Yet
                    </h1>
                @endforelse
            </div>
            <div class="col-md-4 mb-md-0 mb-3" style="height: 80vh; overflow-y:auto;">
                <div class="alert alert-danger sticky-top" role="alert">
                    Cancelled Drivers
                </div>
                @forelse ($cancelled_rides as $ride)
                    <a class="text-white " href="{{ route('driver.rides.show', $ride->id) }}" >
                        <div class="card @if($ride->is_completed) text-muted text-decoration-line-through @endif">
                            <div class="card-body">
                                <div class="d-flex w-100 justify-content-between ">
                                    <div>

                                        <b> {{ $ride->user->name }} <br> {{ $ride->created_at->format('d/m/Y h:i a') }}</b> - {{ $ride->status }}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <h1 class="text-center text-muted">
                        Sorry No Rides Yet
                    </h1>
                @endforelse
            </div>
        </div>
    </div>


@endsection
