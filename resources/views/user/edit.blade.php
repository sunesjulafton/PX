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
                            <label for="name">Change name</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="nameHelp" autocomplete="off" value="{{ old('name') ?? $user->name }}">
                            

                            @error('name')
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
