@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $website->name }}</div>

                <div class="card-body">
                    <p>{{ $website->website_url }}</p>
                    
                </div>
            </div>

            
        </div>
    </div>
</div>
@endsection
