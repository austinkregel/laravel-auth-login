@extends(config('kregel.auth-login.base-layout'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('auth-login::shared.menu')
            </div>
            <div class="col-md-8">
                <div class="panel panel-default" style="padding:1rem;">
                    <h2 style="margin-top:0;">Update Password</h2>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" action="{{ route('auth-login::update-security') }}" method="post">
                            {!! method_field('put') !!}
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="col-md-4 control-label">Current Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="old_password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">New Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div><!--v-component-->

                            <div class="form-group">
                                <label class="col-md-4 control-label">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="confirm_password">
                                </div>
                            </div><!--v-component-->

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <span>
                                            <i class="fa fa-btn fa-save"></i> Update
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
