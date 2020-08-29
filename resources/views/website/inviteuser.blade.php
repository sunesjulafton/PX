@extends('layouts.app')

@section('title', 'Invite user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Invite user to {{ $website->id }}</div>

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
                            <button type="submit" class="btn btn-primary">Invite user</button>
                        </div>
                        
                        <input name="invited_by" type="hidden" value="{{ Auth::user()->id }}">
                        <input name="website_id" type="hidden" value="{{ $website->id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
