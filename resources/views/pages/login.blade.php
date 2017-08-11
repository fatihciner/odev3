@extends('layouts.default')

@section('content')
    {{ Form::open(array('id' => 'loginForm')) }}
        Email: {{ Form::text(FieldType::EMAIL, 'demo@bumin.com.tr',  array('id' => 'fieldEmail')) }}  <br/>
        Password: {{ Form::password(FieldType::PASSWORD,array('id' => 'fieldPassword')) }}  <br/>
    {{ Form::submit() }}
    {{ Form::close() }}

    <br> email: demo@bumin.com.tr | sifrE: cjaiU8CV

<div id="log"></div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@stop

@section('script_footer')
    Odev.LoginHandler();
@stop


@section('title')
    LOGIN PAGE
@stop