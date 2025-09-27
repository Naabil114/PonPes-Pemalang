@extends('layouts.index')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <h4>Edit User Admin</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('user.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6 col-lg-4">
                   

                    <div class="form-group mb-3">
                        <label>Username</label>
                        <input type="text" name="username" value="{{ $data->username }}" class="form-control @error('username') is-invalid @enderror" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Password</label>
                        <input type="password" name="password" value="" class="form-control" >
                    </div>

                    

                   
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
