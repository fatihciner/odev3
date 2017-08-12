@foreach ($result['data']->data as $report)
    <?php $transactionId = !empty($report->transaction->merchant->transactionId)?$report->transaction->merchant->transactionId:''; ?>
    <tr alt="{{$transactionId}}">
        <td class="transactionInfo">
            <a href="javascript:;" class="clickable" title="transaction">
                {{ $transactionId  }}</span><br>
                <button type="button" class="btn btn-info btn-sm">GET TRANSACTION DETAIL</button>
            </a>
        </td>
        <td class="merchantInfo clickable" title="merchant">
            <a href="javascript:;" class="clickable" title="merchant">
                {{ $report->merchant->name or ""  }} <br>
                <button type="button" class="btn btn-info btn-sm">GET MERCHANT DETAIL</button>
            </a>
        </td>
        <td class="customerInfo">
            <a href="javascript:;" class="clickable" title="client">
                {{ $report->customerInfo->billingFirstName or "" }} {{ $report->customerInfo->billingLastName or "" }}<br>
                <button type="button" class="btn btn-info btn-sm">GET CLIENT DETAIL</button>
            </a>
        </td>
        <td>
            {{ $report->updated_at or "" }} <br>
            {{ $report->created_at or "" }} <br>
        </td>
        <td>
            {{ $report->fx->merchant->originalAmount or "" }} {{ $report->fx->merchant->originalCurrency or "" }} <br>
            {{ $report->fx->merchant->convertedAmount or "" }} {{ $report->fx->merchant->convertedCurrency or "" }} <br>
        </td>
    </tr>
@endforeach