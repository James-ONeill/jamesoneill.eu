@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            @component('components.panel', ['heading' => 'Log In'])
                <div class="panel-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            These credentials do not match our records.
                        </div>
                    @endif

                    <form action="/login" method="POST" class="form-horizontal">
                        {!! csrf_field() !!}

                        @component('components.form-group', ['name' => 'email'])
                            <label for="email" class="control-label col-sm-3">Email</label>

                            <div class="col-sm-6">
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" autocapitalize="off" value="{{ old('email') }}">
                            </div>
                        @endcomponent

                        @component('components.form-group', ['name' => 'password'])
                            <label for="password" class="control-label col-sm-3">Password</label>

                            <div class="col-sm-6">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                            </div>
                        @endcomponent

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-2">
                                <button type="submit" class="btn btn-primary">
                                    Log in
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endcomponent
        </div>
    </div>
@endsection
