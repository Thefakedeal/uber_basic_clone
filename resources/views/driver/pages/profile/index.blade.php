@extends('driver.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Update Profile
            </div>
            <div class="card-body">
                <form class="form" method="POST" action="{{ route('driver.profile') }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Display Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ auth()->user()->name }}"
                            required>
                        @error('name')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input type="tel" class="form-control" name="mobile" value="{{ auth()->user()->mobile }}"
                            id="mobile" minlength="10">
                        @error('mobile')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rate">Rate <span class="text-muted fs-6">per KM</span> <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="rate" id="rate"
                            value="{{ auth()->user()->rate }}" min="0">
                        @error('rate')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
