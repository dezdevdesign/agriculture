@extends('layouts.app')
@section('title', 'Login Page')
@section('content')
<!-- Login -->
<div class="login__block active" id="l-login">
    <div class="login__block__header">
        <i class="zmdi zmdi-account-circle"></i>
        Hi there! Please Sign in
    </div>
    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="login__block__body">
            <div class="form-group form-group--float form-group--centered {{ $errors->has('username') ? ' has-danger' : '' }}">
                <input type="text" class="form-control" name="username" id="username" required>
                <label>Username</label>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-group form-group--centered">
                @if($errors->has('username'))
                    <span class="help-block">
                        <span style="color: red">{{ $errors->first('username') }}</span>
                    </span>
                @endif
            </div>
            <div class="form-group form-group--float form-group--centered {{ $errors->has('password') ? ' has-danger' : '' }}">
                <input type="password" class="form-control" name="password" id="password" required>
                <label>Password</label>
                <i class="form-group__bar"></i>
            </div>
             <div class="form-group form-group--centered">
                @if($errors->has('password'))
                    <span class="help-block">
                        <span style="color: red">{{ $errors->first('password') }}</span>
                    </span>
                @endif
            </div>
            <div class="form-group form-group--centered">
                <button type="submit" class="btn btn--icon login__block__btn">
                    <i class="zmdi zmdi-long-arrow-right"></i>
                </button>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script>
document.body.style.background = "#f3f3f3 url(images/login-bg.jpg) no-repeat right top";
document.body.style.backgroundSize = "cover";
</script>
@endpush
@endsection