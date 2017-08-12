@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col">
        {{ Form::open(array('id' => 'reportForm')) }}
            from: {{ Form::text(FieldType::FROMDATE, array('id' => 'fieldFromDate')) }}
            to: {{ Form::text(FieldType::TODATE, array('id' => 'fieldToDate')) }}
            {{ Form::hidden(FieldType::PAGE, array('id' => 'fieldPage')) }}
            {{ Form::submit() }}
        {{ Form::close() }}
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <div class="col pull-right">
            @if( $result['data']->current_page > 1 )
                <button id="prevPage"  class="btn btn-small btn-alert">PREVIOUS PAGE</button>
            @endif
            CURRENT PAGE: {{ $result['data']->current_page or "1"}}
            @if( $result['data']->current_page > 1 )
                <button id="nextPage" class="btn" attr="{{$result['data']->next_page_url}}">NEXT PAGE</button>
            @endif
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