@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Trashed</div>

                <div class="card-body">
                    <div style="float: right">
                        <a href="{{ route('users.index') }}" class="btn btn-success mb-2" title="Add user">
                            <i class="fa-solid fa-list"></i> View users
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
                                <td>Deleted at</td>
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
                                <td>{{ date('M d, Y H:i A', strtotime($user->deleted_at)) }}</td>
                                <td>
                                    <button class="btn btn-success btn-restore" value="{{ route('users.restore', $user->id) }}" title="Restore">
                                        <i class="fa-sharp fa-solid fa-rotate-left"></i>
                                    </button>
                                    <button class="btn btn-danger btn-delete" value="{{ route('users.delete', $user->id) }}" title="Delete permanently">
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
    const csrf = $('meta[name="csrf-token"]').attr('content');

    $('.btn-delete').click(function () {
        const deleteConfirm = confirm('Are you sure to permanently delete this user?');
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

    $('.btn-restore').click(function () {
        const deleteConfirm = confirm('Are you sure to restore this deleted user?');
        const row = $(this);
        const url = row.val();

        if (deleteConfirm) {
            $.ajax({
                url: url,
                method: 'PATCH',
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
