@extends('layouts.app')

@section('css')
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="{{ asset('resources/plugin/fullcalendar/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/plugin/fullcalendar/fullcalendar.print.css') }}" media="print">
    <!-- VUE Scripts -->
    <script src="{{ asset('public/js/app_appointment.js?version=').date('YmdHis') }}" defer></script>
@endsection

@section('content')
    @include('modal.refer')
    <div id="app_appointment">
        <appointment-app :user="{{ $user }}" :appointment_slot="{{ json_encode($appointment_slot) }}"></appointment-app>
        <!-- <appointment-app :user="{{ $user }}" :appointment_sched="{{ json_encode($appointment_slot) }}"></appointment-app> -->
    </div>
@endsection

@section('js')
    <!-- fullCalendar 2.2.5 -->
    <script src="{{ asset('resources/plugin/fullcalendar/fullcalendar.min.js') }}"></script>
@endsection

