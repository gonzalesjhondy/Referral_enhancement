@extends('layouts.app')
<!-- VUE Scripts -->
<script src="{{ asset('public/js/app.js?version=').date('YmdHis') }}" defer></script>
@section('content')
    <div class="row">
        <div class="box box-success">
            <div class="box-body" id="app">

            </div>
        </div>
    </div>
@endsection