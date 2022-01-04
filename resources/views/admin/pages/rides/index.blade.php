@extends('admin.app')

@section('content')
    <div class="container-fluid">
        <h4>Ride Records</h4>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <td>
                                #
                            </td>
                            <td>
                                User
                            </td>
                            <td>
                                Driver
                            </td>
                            <td>
                                Date
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rides as $ride)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $ride->user->id) }}">
                                    {{ $ride->user->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $ride->driver->id) }}">
                                    {{ $ride->driver->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $ride->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection