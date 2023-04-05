@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Show user</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 justify-content-center">
                            <center>
                                <img class="border" src="{{ asset($user->avatar) }}" style="width: 200px">
                            </center>
                        </div>
                        <div class="col-md-9">
                            <div class="row mb-4">   
                                <div class="col-md-3">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" readonly value="{{ $user->username }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" readonly value="{{ $user->email }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="prefixname">Prefix</label>
                                    <input type="text" name="prefixname" class="form-control" readonly value="{{ $user->prefixname }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label for="firstname">First name</label>
                                    <input type="text" name="firstname" class="form-control" readonly value="{{ $user->firstname }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="middlename">Middle name</label>
                                    <input type="text" name="middlename" class="form-control" readonly value="{{ $user->middlename }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="lastname">Last name</label>
                                    <input type="text" name="lastname" class="form-control" readonly value="{{ $user->lastname }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="suffixname">Suffix</label>
                                    <input type="text" name="suffixname" class="form-control" readonly value="{{ $user->suffixname }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
