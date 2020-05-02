@extends('layouts.app')

@section('title', 'Edit Website')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit website</div>

                <div class="card-body">
                <form action="/websites/{{ $website->id }}" method="post">
                        @method('PATCH')
                        @csrf
                        
                        <div class="form-group">
                            <label for="website_name">Change Website Name</label>
                            <input name="website_name" type="text" class="form-control" id="website_name" aria-describedby="website_nameHelp" autocomplete="off" value="{{ old('website_name') ?? $website->website_name }}">
                            

                            @error('website_name')
                                <small class="text-danger">{{ $message }} </small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="website_url">Change Website URL</label>
                            <input name="website_url" type="text" class="form-control" id="website_url" aria-describedby="website_urlHelp"  autocomplete="off" value="{{ old('website_url') ?? $website->website_url }}">
                            

                            @error('website_url')
                                <small class="text-danger">{{ $message }} </small>
                            @enderror

                        </div>
                    
                        <button type="submit" class="btn btn-primary">Save Website</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
