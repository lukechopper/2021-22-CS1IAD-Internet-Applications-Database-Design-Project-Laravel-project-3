@extends('partials.header')

@section('css')
<link rel="stylesheet" href="{{asset('public/css/form.css')}}">
@endsection

@section('title')
<title>Reset Password</title>
@endsection


@section('body')

<body>
    @if(session('success'))
    <div class="centre-container centre-container__info_box">
        <div class="info_box">
            <div>Success. Your password has been reset!</div>
            <div>Click here to <a href="{{route('login')}}">Login.</a></div>
        </div>
    </div>
    @elseif(session('error'))
    <div class="centre-container centre-container__info_box">
        <div class="info_box">
            <div><span class="error_msg">Error.</span> The password could not be updated!</div>
            <div>Click <a class="error_msg" href="{{route('requestToChangePassword')}}">here</a> to send a new email.</div>
        </div>
    </div>
    @else
    <div class="centre-container centre-container--reset_password">
        <form action="{{route('resetPassword')}}" method="post" class="form">
            @csrf
            <input type="hidden" name="token" value="{{$token}}">
            <h1>Reset Password</h1>
            <label for="form_email">Email:</label>
            @error('email')
            <div class="error_msg">{{$message}}</div>
            @enderror
            <input type="text" name="email" id="form_email" class="form__input" value="{{old('email')}}" />
            <div class="form__label_container">
                <label for="form_password">Password:</label>
                <div class="form__sub_label form__sub_label--show_hide"><i class="fa-solid fa-eye"></i>Show</div>
            </div>
            @error('password')
            <div class="error_msg">{{$message}}</div>
            @enderror
            <input type="password" name="password" id="form_password" class="form__input" />
            <div class="form__label_container">
                <label for="form_confirm_password">Confirm Password:</label>
                <div class="form__sub_label form__sub_label--show_hide"><i class="fa-solid fa-eye"></i>Show</div>
            </div>
            <input type="password" name="password_confirmation" id="form_confirm_password" class="form__input"  />
            <input type="submit" class="form__submit" value="Reset Password" />
        </form>
    </div>
    <!-- FORM SCRIPT -->
    <script src="{{asset('public/js/form.js')}}"></script>
    @endif
</body>

</html>
@endsection
