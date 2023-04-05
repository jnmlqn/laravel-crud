@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                    <div style="float: right">
                        <a href="{{ route('users.create') }}" class="btn btn-success mb-2" title="Add user">
                            <i class="fa-solid fa-plus"></i> Add user
                        </a>
                        <a href="{{ route('users.trashed') }}" class="btn btn-danger mb-2" title="Add user">
                            <i class="fa-solid fa-trash"></i> View trashed users
                        </a>
                    </div>
                    <table class="table border mb-2">
                        <thead>
                            <tr>
                                <td>Prefix</td>
                                <td>Name</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Type</td>
                                <td>Created at</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->prefixname }}</td>
                                <td>{{ $user->fullname }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->type) }}</td>
                                <td>{{ date('M d, Y H:i A', strtotime($user->created_at)) }}</td>
                                <td>
                                    <a href="/users/{{ $user->id }}" class="btn btn-success" title="Show">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="/users/{{ $user->id }}/edit" class="btn btn-primary" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button class="btn btn-danger btn-delete" value="{{ route('users.destroy', $user->id) }}" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.btn-delete').click(function () {
        const csrf = $('meta[name="csrf-token"]').attr('content');
        const deleteConfirm = confirm('Are you sure to delete this user?');
        const row = $(this);
        const url = row.val();

        if (deleteConfirm) {
            $.ajax({
                url: url,
                method: 'DELETE',
                data: {
                    _token: csrf
                },
                success: function (res) {
                    row.parent().parent().fadeOut('fast', function() {
                        this.remove();
                    });
                }
            });
        }
    });
})
</script>
@endsection
