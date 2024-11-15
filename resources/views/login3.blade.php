<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Referral System</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('resources/img/favicon1.png') }}" rel="icon" type="image/x-icon">
    <link href="{{ asset('resources/medilab/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

</head>

<input type="hidden" value="{{ asset('/') }}" id="broadcasting_url">
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- jQuery 2.1.4 -->
{{--<script src="{{ asset('resources/assets/js/jquery.min.js') }}"></script>--}}
{{--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}

{{--<!-- Template Main JS File -->
<script src="{{ asset('resources/assets/js/jquery.form.min.js') }}"></script>
<script src="{{ asset('resources/plugin/Lobibox/Lobibox.js') }}?v=2"></script>--}}

<script src="{{ asset('public/js/app_login.js?version=').date('YmdHis') }}" defer></script>

<div id="app_login">
    <input type="hidden" value="{{ asset('/') }}" id="login_root_url">
    <login-app></login-app>
</div>

<script>
    console.log("login 3");
</script>

</html>