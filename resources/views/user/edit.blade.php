@extends('layouts.app')

@section('title', 'Edit user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit user</div>

                <div class="card-body">
                <form action="/users/{{ $user->id }}" method="post">
                        @method('PATCH')
                        @csrf
                        
                        <div class="form-group">
                            <label for="user_name">Change user Name</label>
                            <input name="user_name" type="text" class="form-control" id="user_name" aria-describedby="user_nameHelp" autocomplete="off" value="{{ old('user_name') ?? $user->user_name }}">
                            

                            @error('user_name')
                                <small class="text-danger">{{ $message }} </small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="user_url">Change user URL</label>
                            <input name="user_url" type="text" class="form-control" id="user_url" aria-describedby="user_urlHelp"  autocomplete="off" value="{{ old('user_url') ?? $user->user_url }}">
                            

                            @error('user_url')
                                <small class="text-danger">{{ $message }} </small>
                            @enderror

                        </div>
                    
                        <button type="submit" class="btn btn-primary">Save user</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
