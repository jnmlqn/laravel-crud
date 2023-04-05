@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create user</div>

                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger pb-0">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="photo">User photo</label>
                                <input type="file" name="photo" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" required minlength="8">
                            </div>
                            <div class="col-md-3">
                                <label for="prefixname">Prefix</label>
                                <select class="form-select" name="prefixname">
                                    <option value="Mr.">Mr.</option>
                                    <option value="Ms.">Ms.</option>
                                    <option value="Mrs.">Mrs.</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="firstname">First name</label>
                                <input type="text" name="firstname" class="form-control" required maxlength="255">
                            </div>
                            <div class="col-md-3">
                                <label for="middlename">Middle name</label>
                                <input type="text" name="middlename" class="form-control" maxlength="255">
                            </div>
                            <div class="col-md-3">
                                <label for="lastname">Last name</label>
                                <input type="text" name="lastname" class="form-control" required maxlength="255">
                            </div>
                            <div class="col-md-3">
                                <label for="suffixname">Suffix</label>
                                <input type="text" name="suffixname" class="form-control" maxlength="255">
                            </div>
                        </div>

                        <div class="mb-4">
                            <button class="btn btn-success" style="float: right;">
                                <i class="fa-solid fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
