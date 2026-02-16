@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Profile</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" value="{{ $user->firstname }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" value="{{ $user->lastname }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" name="profile_photo" class="form-control">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="img-thumbnail mt-2" width="150">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Student ID (Only applicable for PSU students)</label>
                            <input type="text" name="student_id" class="form-control" value="{{ $user->student_id }}">
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                        <a href="{{ url('/home') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
