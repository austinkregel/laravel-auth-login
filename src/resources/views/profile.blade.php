@extends(config('kregel.auth-login.base-layout'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>{{ $user->name }}</h2>
                    </div>
                    <div class="panel-body">
                        @foreach($user->getFillable() as $fill)
                        <div class="form-group">
                            <div class="col-md-4 form-control">
                                {{ $fill }}
                            </div>
                            <div class="col-md-6 form-control">
                                {{ $user->$fill }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
