@extends('layouts.app')

@section('title', 'লগইন | দোকান খাতা (Dokan Khata)')

@section('css')
    <style type="text/css">
        .invalid-feedback {
            color: red;
        }
    </style>
@endsection

@section('content')
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="tabs divcenter nobottommargin clearfix" id="tab-login-register" style="max-width: 500px;">

                <div class="tab-content clearfix" id="tab-login">
                    <div class="panel panel-default nobottommargin">
                        <div class="panel-body" style="padding: 40px;">
                            <form id="login-form" name="login-form" class="nobottommargin" action="{{ route('login') }}" method="POST">
                                @csrf
                                <h3>আপনার অ্যাকাউন্টে লগইন করুন</h3>

                                <div class="col_full">
                                    <label for="mobile">মোবাইল নম্বর</label>
                                    <input type="text" id="mobile" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" required autocomplete="off" autofocus />
                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col_full">
                                    <label for="password">পাসওয়ার্ড</label>
                                    <input type="password" id="password" name="password" value="" class="form-control @error('password') is-invalid @enderror" required autocomplete="off"/>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col_full nobottommargin">
                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('মনে রেখো') }}
                                    </label>
                                </div>
                                </div>

                                <div class="col_full nobottommargin">
                                    <button type="submit" class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">লগইন</button>
                                    <a href="#!" class="fright">পাসওয়ার্ড ভুলে গেছেন?</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</section><!-- #content end -->
@endsection
