@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">User Lists</h2>

    <form method="GET" action="{{ route('users.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name, student ID, or email">
            <button type="submit" class="btn btn-success">Search</button>
        </div>
    </form>

    @if($users->count())
        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Profile Photo</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                    <th>Status</th>      
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile" width="60" height="60" class="rounded-circle">
                            @else
                                <img src="{{ asset('default-profile.png') }}" alt="Default" width="60" height="60" class="rounded-circle">
                            @endif
                        </td>
                        <td>{{ $user->student_id ?? 'N/A' }}</td>
                        <td>{{ ($user->firstname ?? '') . ' ' . ($user->lastname ?? '') }}</td>
                        <td>{{ $user->email ?? 'N/A' }}</td>
                        <td>{{ $user->address ?? 'N/A' }}</td>
                        <td>{{ $user->contact_number ?? 'N/A' }}</td>    
                        <td>{{ $user->psu_status ?? 'N/A' }}</td>   
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No users found.</p>
    @endif
</div>
@endsection
