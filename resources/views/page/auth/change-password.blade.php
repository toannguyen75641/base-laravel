@extends('layout.app')

@section('title', __('title.common.change_password'))

@section('content')
    <div class="col-lg-12">
        <div class="card">
            @if (isset($message))
                <div class="alert alert-success _notification" role="alert"> {{ $message }}</div>
            @endif
            <div class="card-header">
                <h3 class="_title">{{__('title.common.change_password')}}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('password.change') }}" method="post" class="form-loading">
                    @csrf
                    <div class="row">
                        <div class="offset-md-3 col-md-6">
                            <div class="input-group">
                                <label class="col-md-5 col-form-label">
                                    {{__('title.auth.old_password')}}
                                    <p class="_required" style="display: inline;">*</p>
                                </label>
                                <input class="form-control @error('old_password') is-invalid @enderror"
                                       type="password"
                                       name="old_password"
                                       placeholder="○○○○"
                                >
                                @error('old_password')
                                <div class="invalid-feedback offset-md-5">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="offset-md-3 col-md-6">
                            <div class="input-group">
                                <label class="col-md-5 col-form-label">
                                    {{__('title.auth.new_password')}}
                                    <p class="_required" style="display: inline;">*</p>
                                </label>
                                <input class="form-control @error('new_password') is-invalid @enderror"
                                       type="password"
                                       name="new_password"
                                       placeholder="○○○○"
                                >
                                @error('new_password')
                                <div class="invalid-feedback offset-md-5">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="offset-md-3 col-md-6">
                            <div class="input-group">
                                <label class="col-md-5 col-form-label">
                                    {{__('title.auth.new_password_confirm')}}
                                    <p class="_required" style="display: inline;">*</p>
                                </label>
                                <input class="form-control @error('new_password_confirm') is-invalid @enderror"
                                       type="password"
                                       name="new_password_confirm"
                                       placeholder="○○○○"
                                >
                                @error('new_password_confirm')
                                <div class="invalid-feedback offset-md-5">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @if(isset($errors))
                        <div class="error-login">
                            @foreach($errors as $err)
                                <p class="text-center text-danger">{{ $err }}</p>
                            @endforeach
                        </div>
                    @endif
                    <div class="row justify-content-center _create_update">
                        <button class="btn btn-dark mr-1" type="reset">
                            {{__('title.common.button.cancel')}}
                        </button>
                        <button class="btn _btn ml-1" type="submit">
                            {{__('title.common.button.change')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
