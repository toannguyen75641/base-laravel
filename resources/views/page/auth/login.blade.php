@extends('layout.authBase')

@section('title', 'Login')

@section('content')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <h3 class="text-center">クーポン管理画面</h3>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="input-group mt-5 mb-3">
                                    <label class="col-md-3 col-form-label">{{__('title.common.login_id')}}</label>
                                    <input class="form-control"
                                           type="text"
                                           name="user_id"
                                    >
                                </div>
                                <div class="input-group mb-4">
                                    <label class="col-md-3 col-form-label">{{__('title.kddi.user.field.password')}}</label>
                                    <input class="form-control"
                                           type="password"
                                           name="password"
                                    >
                                </div>
                                <p class="text-right">パスワード再設定は<a class="reset-password" href="#" data-toggle="modal" data-target="#exampleModal">こちら</a></p>
                                @if(isset($errors))
                                    <div class="error-login">
                                        @foreach($errors as $err)
                                            <p class="text-center text-danger">{{ $err }}</p>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="row justify-content-center">
                                    <button class="btn _btn" type="submit">
                                        {{__('title.common.button.login')}}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">パスワード再設定</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">パスワードの再設定はメールの本文にログインIDをご入力の上​</p>
                    <p class="text-center">以下のメールアドレスからお問い合わせください。</p>
                    <p class="text-center"><a href="https://mail.google.com/" class="text-danger" target="_blank">xxxxx@kddi.com​</a></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
