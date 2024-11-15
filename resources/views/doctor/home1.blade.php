<?php
    $error = \Illuminate\Support\Facades\Input::get('error');
    $user = Session::get('auth');
    $multi_faci = Session::get('multiple_login');
?>
@extends('layouts.app')

@section('content')
    @if($multi_faci)
        @include('admin.loginAs')
    @else
        <script src="{{ asset('public/js/app_doctor.js?version=').date('YmdHis') }}" defer></script>

        @include('script.chart')

        <div id="app_doctor">
            <input type="hidden" value="{{ asset('resources/img/loading.gif') }}" id="loadingGif">
            <doctor-app :date_start="{{ json_encode($date_start) }}" 
                        :date_end="{{ json_encode($date_end) }}" 
                        :user="{{ $user }}" 
                        :error="{{ json_encode($error) }}"
                        :incoming_reffered="{{ json_encode($totalIncoming) }}"
                        :total_referred="{{ json_encode($totalReferred) }}"
                        :year="{{ $year }}">
            </doctor-app>
        </div>
    @endif

@endsection

@section('js')

@endsection

