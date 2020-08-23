@extends('layouts.app')

@section('title', 'Users')

<link href="{{ asset('css/users.css') }}" rel="stylesheet" />

@section('content')
    <div class="card mt-4">
        <div class="card-header">Users</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th class="th-sm">Id
                        </th>
                        <th class="th-sm">Name
                        </th>
                        <th class="th-sm">Username
                        </th>
                        <th class="th-sm">Type
                        </th>
                        <th class="th-sm">Activated at
                        </th>
                        <th class="th-sm">Dectivated at
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
                    @foreach($users as $user)
                        <tr class="user-row">
                            <td>{{ $user->id }}</td>
                            <?php
                            if($user->id == Auth::user()->id) { ?>
                                <td>{{ $user->name }} (you)</td>
                            <?php } 
                            else { ?>
                                <td>{{ $user->name }}</td>
                            <?php } ?>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->type }}</td>
                            <td>{{ $user->activated_at }}</td>
                            <td>{{ $user->deactivated_at }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                                                     
                            <td class="hide">
                                <div class="action-menu-content">
                                    <div class="action-menu-content-row"><a href="/users/{{ $user->id }}/edit"><i class="far fa-edit"></i> Edit</a></div>
                                    <div class="action-menu-content-row"><a href="/users/share/{{ $user->id }}/edit"><i class="far fa-share-square"></i> Share</a></div>
                                    <div class="action-menu-content-row">
                                        <form action="/users/{{ $user->id }}" method="post" class="user-delete-form">
                                            @method('DELETE')
                                            @csrf
                                            <button><i class="far fa-trash-alt"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <script>
                    //$('#users-table').tablesort();


                    $('.user-row').click(function(e) {
                        console.log(e.target);
                        $(this).find('.action-menu-content').css({'top' : e.clientY +'px', 'left' : e.clientX + 'px'});
                        if($(this).hasClass('show')) {
                            $('.user-row').removeClass('show');
                        }
                        else {
                            $('.user-row').removeClass('show');
                            $(this).addClass('show');
                        }
                    });

                    document.addEventListener("click", function(event) {
                        // If user clicks inside the element, do nothing
                        if (event.target.closest(".user-row")) return;

                        // If user clicks outside the element, hide it!
                        $('.user-row').removeClass('show');
                    });

                </script>
            
                <div>
                    <a class="btn btn-sm btn-dark" href="/users/create">Add new user</a>
                </div>

                
            </div>
        </div>
        
    </div>

@endsection