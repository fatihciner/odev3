@extends('layouts.default')
@section('content')
    {{ Form::open() }}


    Email: {{ Form::text(FieldType::EMAIL, 'demo@bumin.com.tr') }}  <br/>
    Password: {{ Form::password(FieldType::PASSWORD) }}  <br/>
    {{ Form::submit() }}
    {{ Form::close() }}

    <br> email: demo@bumin.com.tr | sifrE: cjaiU8CV


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

@section('title')
    LOGIN PAGE
@stop