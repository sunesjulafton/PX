@extends('layouts.app')

@section('title', 'Create Website')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create new website</div>

                <div class="card-body">
                    <form action="/websites" method="post">
                    
                        @csrf
                        
                        <div class="form-group">
                            <label for="website_name">Enter Website Name</label>
                            <input name="website_name" type="text" class="form-control" id="website_name" aria-describedby="website_nameHelp" placeholder="Name">
                            

                            @error('website_name')
                                <small class="text-danger">{{ $message }} </small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="website_url">Enter Website URL</label>
                            <input name="website_url" type="text" class="form-control" id="website_url" aria-describedby="website_urlHelp" placeholder="URL">
                            

                            @error('website_url')
                                <small class="text-danger">{{ $message }} </small>
                            @enderror

                        </div>
                        
                    <input name="created_by" type="hidden" value="{{ Auth::user()->id }}">

                        <button type="submit" class="btn btn-primary">Create Website</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
