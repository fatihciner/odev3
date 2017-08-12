var allowSubmit = true;
Odev = {

    LoginHandler: function() {
        $("#loginForm" ).submit(function( event ) {

            event.preventDefault();
            if(!allowSubmit) return;

            var form = $(this),
                formdata = form.serializeArray(),
                url = form.attr('action'),
                logDiv = $('#log');

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: formdata,
                beforeSend: function (data) {
                    allowSubmit = false;
                    logDiv.html(Odev.PrintLoadingGif());
                },
                success: function (data) {
                    if(data.error) logDiv.html(data.error);
                    else window.location.href = '/transaction/list';
                },
                error: function (data) {
                    var errors = '';
                    for(datum in data.responseJSON){
                        errors += data.responseJSON[datum] + '<br>';
                    }
                    logDiv.html(errors);
                },
                complete: function (data) {
                    form.show();
                    console.log(data);
                    setTimeout( function()
                        {
                            allowSubmit = true;
                        },
                        300
                    );
                }
            });
        });
    },
    PrintLoadingGif: function (large) {
        if(large) return '<img src="/img/ajax-loader-large.gif">';
        return '<img src="/img/ajax-loader.gif">';
    },
    TransactionListClickBinder: function() {
        $("#contentArea a" ).click(function( event ) {
            event.preventDefault();
            if(!$(this).is('a')) return;
            if(!allowSubmit) return;
            var elementType = $(this).attr('title'),
                transactionId = $(this).parents('tr').attr('alt'),
                myModal = $('#myModal'),
                myModalBody = $('div.modal-body'),
                myModalTitle = $('h4.modal-title'),
                logDiv = $('#log'),
                url = '',
                myModalTitleText = '';

            if(elementType == 'transaction')  { url = '/transaction/'; myModalTitleText = 'Transaction Details' }
            if(elementType == 'merchant') { url = '/merchant/'; myModalTitleText = 'Merchant Details' }
            if(elementType == 'client') { url = '/client/'; myModalTitleText = 'Client Details' }
            url += transactionId;

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html',
                beforeSend: function (data) {
                    allowSubmit = false;
                    logDiv.html(Odev.PrintLoadingGif());
                },
                success: function (data) {
                    //if(data.error) logDiv.html(data.error);
                    //else  {
                    myModalTitle.html(myModalTitleText);
                    myModalBody.html(data);
                    myModal.modal('show');
                    //} //logDiv.html(data.htmlFormattedContentArea);
                },
                error: function (data) {
                    var errors = '';
                    for(datum in data.responseJSON){
                        errors += data.responseJSON[datum] + '<br>';
                    }
                    console.log(errors);
                    logDiv.html(errors);
                },
                complete: function (data) {
                    setTimeout( function()
                        {
                            allowSubmit = true;
                            logDiv.html('');
                        },
                        300
                    );
                }
            });
        });
    },
    TransactionListSetPage: function(newPage){
        if(!allowSubmit) return;
        $('#fieldCurrentPage').val(newPage);
        $("#reportForm" ).submit();
    },
    TransactionListPagination: function(mode) {
        if(!allowSubmit) return;
        if(!mode) return;
        //var curPage = $('#fieldCurrentPage').val();
        var curPage  = parseInt($('#current_page').html());
        if(mode=='previous' && curPage > 1) curPage--;
        else if(mode=='next') curPage++;
        Odev.TransactionListSetPage(curPage);
    },
    TransactionListRenew: function() {
        $("#reportForm" ).submit(function( event ) {
            event.preventDefault();
            if(!allowSubmit) return;
            var form = $(this),
                formdata = form.serializeArray(),
                url = form.attr('action'),
                logDiv = $('#log'),
                contentArea = $('#contentArea'),
                targetPage=$('#fieldCurrentPage').val();

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: formdata,
                beforeSend: function (data) {
                    allowSubmit = false;
                    contentArea.html(Odev.PrintLoadingGif(1));
                },
                success: function (data) {
                    if(data.error) logDiv.html(data.error);
                    else contentArea.html(data.htmlFormattedContentArea);
                },
                error: function (data) {
                    var errors = '';
                    for(datum in data.responseJSON){
                        errors += data.responseJSON[datum] + '<br>';
                    }
                    console.log(errors);
                    logDiv.html(errors);
                },
                complete: function (data) {
                    $('#fieldCurrentPage').val('1');
                    $('#current_page').html(targetPage);
                    setTimeout( function()
                        {
                            allowSubmit = true;
                        },
                        300
                    );
                }
            });
        });
    }


}