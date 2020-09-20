@extends('layouts.app')

@section('title', 'Manage users')

@section('content')
    <div class="card mt-4">
        <div class="card-header">Manage Users for {{ $website->name }}</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="websites-table" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th class="th-sm">Name
                        </th>
                        <th class="th-sm">Email
                        </th>
                        <th class="th-sm">Access
                        </th>
                        <th class="th-sm">Remove
                        </th>
                        
                        
                        <!--<th class="th-sm">Share
                        </th>
                        <th class="th-sm">Delete
                        </th>
                        <th class="th-sm hide">
                        </th>
                        </tr>-->
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="website-row">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $website->users($user->id)->first()->roles()->first()->name }}</td>
                            <td>
                                <div class="action-menu-content-row">
                                    <form action="/websites/{{ $website->id }}/manageusers" method="post" class="website-delete-form">
                                        
                                        @csrf
                                        <input type="hidden" value="{{$user->id}}" name="user_id">
                                        <button><i class="far fa-trash-alt"></i> Remove</button>
                                    </form>
                                </div>
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
                    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('user'))
                        <a class="btn btn-sm btn-dark" href="/websites/{{$website->id}}/inviteuser">Invite user</a>
                    @endif
                </div>
                
            </div>
        </div>
        
    </div>
    
    

@endsection