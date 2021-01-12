{{-- layout --}}
@extends('layouts.fullLayoutMaster')

{{-- page title --}}
@section('title','User Login')

{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/login.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div id="login-page" class="row">
  <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
    <form class="login-form" method="POST" action="{{ route('login') }}">
      @csrf
      <div class="row">
        <div class="input-field col s12">
          <h5 class="ml-4">{{ __('Sign in') }}</h5>
        </div>
      </div>

      <div class="row margin">
        <div class="input-field col s12">
          <i class="material-icons prefix pt-2">person_outline</i>
          <input id="username" type="text" class=" @error('username') is-invalid @enderror" name="username"
            value="{{ old('username') }}" required autocomplete="username" autofocus>
          <label for="username" class="center-align">{{ __('Username') }}</label>
          @error('username')
          <small class="red-text ml-10" role="alert">
            {{ $message }}
          </small>
          @enderror
        </div>
      </div>
      <div class="row margin">
        <div class="input-field col s12">
          <i class="material-icons prefix pt-2">lock_outline</i>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" required autocomplete="current-password">
          <label for="password">{{ __('password') }}</label>
          @error('password')
          <small class="red-text ml-10" role="alert">
            {{ $message }}
          </small>
          @enderror
        </div>
      </div>
      <div class="row">
        <div class="col s12 m12 l12 ml-2 mt-1">
          <p>
            <label>
              <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <span>Remember Me</span>
            </label>
          </p>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <button type="submit" class="btn waves-effect waves-light border-round gradient-45deg-green-teal col s12">
            Login
          </button>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s4">
            <a type="button" href="{{ route('social.redirect' ,'facebook') }}" class="btn waves-effect waves-light border-round gradient-45deg-indigo-light-blue col s12">
                Facebook
            </a>
        </div>
        <div class="input-field col s4">
            <a type="submit" class="btn waves-effect waves-light border-round gradient-45deg-blue-grey-blue-grey col s12">
                Github
            </a>
        </div>
        <div class="input-field col s4">
            <a type="submit" class="btn waves-effect waves-light border-round gradient-45deg-red-pink col s12">
                Google+
            </a>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6 m6 l6">
          <p class="margin medium-small"><a href="{{ route('register') }}">Register Now!</a></p>
        </div>
        <div class="input-field col s6 m6 l6">
          <p class="margin right-align medium-small">
            <a href="{{ route('password.request') }}">Forgot password?</a>
          </p>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
