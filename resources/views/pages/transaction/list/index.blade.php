@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col">
        {{ Form::open(array('id' => 'reportForm')) }}
            From: {{ Form::text(FieldType::FROMDATE, '',  array('id' => 'fieldFromDate')) }}
            To: {{ Form::text(FieldType::TODATE, '1',  array('id' => 'fieldToDate')) }}
            {{-- {{ Form::hidden(FieldType::PAGE, '',  array('id' => 'fieldCurrentPage')) }} --}}
            <input id="fieldCurrentPage" name="page" type="hidden" value="1">
            {{ Form::submit() }}
        {{ Form::close() }}
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <div class="col pull-right">
            <button onClick="Odev.TransactionListPagination('previous')" id="prevPage"  class="btn btn-small btn-alert">PREVIOUS PAGE</button>
                CURRENT PAGE: <span id="current_page" alt="{{ $result['data']->current_page or "1"}}">{{ $result['data']->current_page or "1"}}</span>
            <button onClick="Odev.TransactionListPagination('next')" id="nextPage" class="btn" attr="{{$result['data']->next_page_url}}">NEXT PAGE</button>

        </div>
    </div>

    <div class="row">
        <div class="col">
            <div id="log">{{ $result['error'] }}</div>
        </div>
    </div>

    <div class="row">
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
<hr>
    <div class="row">
        <div class="col">
            <table class="table table-inverse table-striped">
                <thead>
                <th>Transaction Id</th>
                <th>Merchant Referance</th>
                <th>CustomerInfo</th>
                <th>Date updated / <br>Date created</th>
                <th>Currency<br>From->To</th>

                </thead>
                <tbody id="contentArea">
                    @include('pages.transaction.list.tableArea')
                </tbody>
            </table>
        </div>
    </div>

@stop

@section('script_footer')
    Odev.TransactionListRenew();
    Odev.TransactionListClickBinder();
@stop


@section('title')
    TRANSACTION LIST
@stop