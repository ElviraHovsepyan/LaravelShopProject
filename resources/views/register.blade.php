@extends('layout')

@section('content')
    <section class="header_text sub">
        <img class="pageBanner" src="themes/images/pageBanner.png" alt="New products" >
        <h4><span>Login or Register</span></h4>

        @if(isset($error))
            <h3 style="color: darkred">{{ $error }}</h3>
        @endif

    </section>
    <section class="main-content">
        <div class="row">
            <div class="span5">
                <h4 class="title"><span class="text"><strong> Login </strong> Form </span></h4>

                <form action="{{ route('login') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="next" value="/">
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label">Username</label>
                            <div class="controls">
                                <input type="text" name = 'username' placeholder="Enter your username" id="username" class="input-xlarge">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Password</label>
                            <div class="controls">
                                <input type="password" name = 'password' placeholder="Enter your password" id="password" class="input-xlarge">
                            </div>
                        </div>
                        <div class="control-group">
                            <input tabindex="3" class="btn btn-inverse large" type="submit" value="Sign into your account">
                            <hr>
                            <p class="reset">Recover your <a tabindex="4" href="#" title="Recover your username or password">username or password</a></p>
                        </div>
                    </fieldset>
                </form>


            </div>
            <div class="span7">
                <h4 class="title"><span class="text"><strong>Register</strong> Form</span></h4>


                <form action="{{ route('register') }}" method="post" class="form-stacked">
                    {{ csrf_field() }}
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label">Username</label>
                            <div class="controls">
                                <input type="text" name="username" placeholder="Enter your username" class="input-xlarge">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Email address:</label>
                            <div class="controls">
                                <input type="text" name="email" placeholder="Enter your email" class="input-xlarge">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Password:</label>
                            <div class="controls">
                                <input type="password" name="password" placeholder="Enter your password" class="input-xlarge">
                            </div>
                        </div>
                        <div class="control-group">
                        </div>
                        <hr>
                        <div class="actions"><input tabindex="9" class="btn btn-inverse large" type="submit" value="Create your account"></div>
                    </fieldset>
                </form>

                @if(count($errors) > 0)
                    @foreach($errors->all() as $error)
                        <p>{!! $error !!}</p>
                    @endforeach
                @endif


            </div>
        </div>
    </section>


@endsection

@section('rightBar')
@endsection





