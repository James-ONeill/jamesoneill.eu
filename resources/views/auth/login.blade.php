<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <link rel="stylesheet" type="text/css" href="/css/admin.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Log In</div>

                    <div class="panel-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                These credentials do not match our records.
                            </div>
                        @endif

                        <form action="/login" method="POST" class="form-horizontal">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label for="email" class="control-label col-sm-3">Email</label>

                                <div class="col-sm-6">
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" autocapitalize="off" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="control-label col-sm-3">Password</label>

                                <div class="col-sm-6">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-2">
                                    <button type="submit" class="btn btn-primary">
                                        Log in
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>