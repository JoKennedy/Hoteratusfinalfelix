{{-- layout --}}
@extends('layouts.fullLayoutMaster')

{{-- page title --}}
@section('title','User Lock Screen')

{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/lock.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div id="lock-screen" class="row">
  <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 forgot-card bg-opacity-8">
    <form class="login-form" action="{{ route('login') }}" method="POST">
        @csrf
      <div class="row">
        <div class="input-field col s12 center-align mt-10">
          <img class="z-depth-4 circle responsive-img" width="100" src="{{$lock['avatar']}}" alt="">
            <h5>{{$lock['full_name']}}</h5>
        </div>
      </div>
      <div>

    @if($errors->all())
        @foreach ($errors->all() as $error)
            <div class="text-center">
                <small class="red-text ml-10" role="alert">
                    {{ $error }}
                </small></div>
        @endforeach
    @endif

      </div>
    <input name="username" type="hidden" value="{{$lock['username']}}">
      <div class="row margin">
        <div class="input-field col s12">
          <i class="material-icons prefix pt-2">lock_outline</i>
          <input required autocomplete="current-password" class="form-control @error('password') is-invalid @enderror" name="password" id="password"
           type="password">
          <label for="password">Password</label>
            @error('password')
                <small class="red-text ml-10" role="alert">
                    {{ $message }}
                </small>
            @enderror
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <button type="submit"
            class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">Login
        </button>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6 m6 l6">
          <p class="margin medium-small"><a href="{{asset('user-register')}}">Register Now!</a></p>
        </div>
        <div class="input-field col s6 m6 l6">
          <p class="margin right-align medium-small"><a href="{{asset('user-forgot-password')}}">Forgot password ?</a>
          </p>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
