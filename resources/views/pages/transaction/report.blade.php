<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 12.08.2017
 * Time: 00:49
 */ ?>

@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col">

        {{ Form::open(array('id' => 'reportForm')) }}
            from: {{ Form::text(FieldType::FROMDATE, array('id' => 'fieldFromDate')) }}
            to: {{ Form::text(FieldType::TODATE, array('id' => 'fieldToDate')) }}
            {{ Form::submit() }}
        {{ Form::close() }}

        <div id="log">{{ $result->error }}</div>
    </div>
    <div class="col">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

<br>

<div class="row">
    <div class="col">
        <table class="table table-inverse table-striped">
            <thead>
                <th>Count</th>
                <th>Total</th>
                <th>Currency</th>
            </thead>
            @foreach ($result->data as $report)
                <tr>
                    <td>{{ number_format( $report->count?:0, 0) }}</td>
                    <td>{{ number_format($report->total ?:0, 0) }}</td>
                    <td>{{ $report->currency or "" }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@stop

@section('script_footer')

@stop


@section('title')
    TRANSACTION REPORT
@stop