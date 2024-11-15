@extends('layouts.app')

@section('content')
    <?php $user = Session::get('auth'); ?>
    <!-- VUE Scripts -->
    <script src="{{ asset('public/js/app_reco.js?version=').date('YmdHis') }}" defer></script>
    <input type="hidden" id="doh_logo" value="{{ asset('resources/img/doh.png') }}">
    <input type="hidden" id="receiver_pic" value="{{ asset('resources/img/receiver.png') }}">
    <input type="hidden" id="sender_pic" value="{{ asset('resources/img/sender.png') }}">
    <input type="hidden" id="facility_name" value="{{ \App\Facility::find($user->facility_id)->name }}">
    <input type="hidden" id="archived_reco_page" value="true">
    <div id="app_reco">
        <reco-app :user="{{ $user }}"></reco-app>
    </div>
@endsection

@section('js')
    <script>
        tinymce.init({
            selector: "#mytextarea",
            plugins: "emoticons autoresize",
            toolbar: "emoticons",
            toolbar_location: "bottom",
            menubar: false,
            statusbar: false
        });
    </script>
@endsection