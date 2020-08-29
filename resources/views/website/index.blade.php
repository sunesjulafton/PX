@extends('layouts.app')

@section('title', 'Websites')

<link href="{{ asset('css/websites.css') }}" rel="stylesheet" />

@section('content')
    <div class="card mt-4">
        <div class="card-header">Websites</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="websites-table" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th class="th-sm">Id
                        </th>
                        <th class="th-sm">Name
                        </th>
                        <th class="th-sm">Url
                        </th>
                        <th class="th-sm">Created by
                        </th>
                        <th class="th-sm">Created at
                        </th>
                        <th class="th-sm">Updated at
                        </th>
                        
                        <!--<th class="th-sm">Share
                        </th>
                        <th class="th-sm">Delete
                        </th>-->
                        <th class="th-sm hide">
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($websites as $website)
                        <tr class="website-row">
                            <td>{{ $website->id }}</td>
                            <td>{{ $website->name }}</td>
                            <td>{{ $website->url }}</td>
                            <td>
                            @if ($website->username == Auth::user()->email)
                                You
                            @else
                                <div style="display:flex; flex-direction:column;"><span>{{ $website->created_by }}</span><span style="font-size:10px;">( {{ $website->username }} )</span></div>
                            @endif 
                            </td>
                            <td>{{ $website->created_at }}</td>
                            <td>{{ $website->updated_at }}</td>
                                                     
                            <td class="hide">
                                @if (Auth::user()->type == 'admin' || Auth::user()->type == 'user')
                                <div class="action-menu-content">
                                    <div class="action-menu-content-row"><a href="/websites/{{ $website->id }}/edit"><i class="far fa-edit"></i> Edit</a></div>
                                    <div class="action-menu-content-row"><a href="/websites/share/{{ $website->id }}/edit"><i class="far fa-share-square"></i> Share</a></div>
                                    <div class="action-menu-content-row"><a href="/websites/{{ $website->id }}/manageusers"><i class="far fa-share-square"></i> Manage users</a></div>
                                    <div class="action-menu-content-row">
                                        <form action="/websites/{{ $website->id }}" method="post" class="website-delete-form">
                                            @method('DELETE')
                                            @csrf
                                            <button><i class="far fa-trash-alt"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <script>
                    //$('#websites-table').tablesort();


                    $('.website-row').click(function(e) {
                        $(this).find('.action-menu-content').css({'top' : e.clientY +'px', 'left' : e.clientX + 'px'});
                        if($(this).hasClass('show')) {
                            $('.website-row').removeClass('show');
                        }
                        else {
                            $('.website-row').removeClass('show');
                            $(this).addClass('show');
                        }
                    });

                    document.addEventListener("click", function(event) {
                        // If user clicks inside the element, do nothing
                        if (event.target.closest(".website-row")) return;

                        // If user clicks outside the element, hide it!
                        $('.website-row').removeClass('show');
                    });

                </script>
            
                <div>
                    @if (Auth::user()->type == 'admin' || Auth::user()->type == 'user')
                        <a class="btn btn-sm btn-dark" href="/websites/create">Add new website</a>
                    @endif
                </div>
                
            </div>
        </div>
        
    </div>
    
    

@endsection