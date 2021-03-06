@extends('layouts.app')

@section('title', 'Invite user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Invite user to {{ $website->name }}</div>

                <div class="card-body">
                    <form method="POST" action="/websites/{{ $website->id }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                            <div class="col-md-6">
                                <select class="custom-select form-control @error('role') is-invalid @enderror" id="role-select" name="role">
                                    <option  value="" disabled selected hidden>Select role</option>
                                    @forelse($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @empty
                                        <option>No roles found</option>
                                    @endforelse
                                </select>

                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Invite user</button>
                        <input name="invited_by" type="hidden" value="{{ Auth::user()->id }}">
                        <input name="website_id" type="hidden" value="{{ $website->id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
