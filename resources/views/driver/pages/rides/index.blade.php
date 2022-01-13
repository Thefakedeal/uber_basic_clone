@extends('driver.app')

@section('content')

    @foreach ($rides as $ride)
    <a class="text-white " href="{{ route('driver.rides.show', $ride->id) }}" >
        <div class="card @if($ride->is_completed) text-muted text-decoration-line-through @endif">
            <div class="card-body">
                <div class="d-flex w-100 justify-content-between ">
                    <div>
                        
                        <b> {{ $ride->user->name }} - {{ $ride->created_at->format('d/m/Y h:i a') }}</b> - {{ $ride->status }}
                    </div>
                </div>
            </div>
        </div>
    </a>
    @endforeach

@endsection