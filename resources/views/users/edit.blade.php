@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Update user</div>

                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

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
                                <input type="file" name="photo" class="form-control" value="{{ $user->photo }}" accept="image/*">
                                <span class="text-primary small">Select to replace current image. Click <a href="{{ asset($user->photo) }}">here</a> to view.</span>
                            </div>
                            <div class="col-md-3">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="prefixname">Prefix</label>
                                <select class="form-select" name="prefixname">
                                    <option value="Mr." {{ $user->prefixname === 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                    <option value="Ms." {{ $user->prefixname === 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                    <option value="Mrs." {{ $user->prefixname === 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="firstname">First name</label>
                                <input type="text" name="firstname" class="form-control" value="{{ $user->firstname }}" required maxlength="255">
                            </div>
                            <div class="col-md-3">
                                <label for="middlename">Middle name</label>
                                <input type="text" name="middlename" class="form-control" value="{{ $user->middlename }}" maxlength="255">
                            </div>
                            <div class="col-md-3">
                                <label for="lastname">Last name</label>
                                <input type="text" name="lastname" class="form-control" value="{{ $user->lastname }}" required maxlength="255">
                            </div>
                            <div class="col-md-3">
                                <label for="suffixname">Suffix</label>
                                <input type="text" name="suffixname" class="form-control" value="{{ $user->suffixname }}" maxlength="255">
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
