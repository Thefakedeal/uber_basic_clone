@extends('admin.app')

@section('content')
    <div class="container-fluid">
        <h4>Users</h4>
        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Add Users
                </a>
            </div>
            <div class="card-body">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>
                                Number
                            </th>
                            <th>
                                Role
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->mobile }}
                                </td>
                                <td>
                                    {{ $user->role }}
                                </td>
                                <td>
                                   
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="post"
                                        onsubmit="return confirm('Are You Sure?')"
                                    >
                                        @csrf
                                        @method('delete')
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn text-primary btn-link ">
                                            Edit
                                        </a>
                                        <button type="submit" class="btn btn-link text-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection