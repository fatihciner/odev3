<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 12.08.2017
 * Time: 00:49
 */ ?>

@extends('layouts.default')

@section('content')
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
    TRANSACTION REPORT
@stop