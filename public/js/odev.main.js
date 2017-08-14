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
                    console.log(data);
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
        $("#contentArea").delegate('a', 'click', function(event){
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
                dataType: 'json',
                beforeSend: function (data) {
                    allowSubmit = false;
                    logDiv.html(Odev.PrintLoadingGif());
                },
                success: function (data) {
                    if(data.error) {
                        logDiv.html(data.error).addClass('alert alert-danger');
                    } else  {
                        myModalTitle.html(myModalTitleText);
                        myModalBody.html(data.htmlFormattedContentArea);
                        myModal.modal('show');
                    }
                },
                error: function (data) {
                    var errors = '';
                    for(datum in data.responseJSON){
                        errors += data.responseJSON[datum] + '<br>';
                    }
                    if(!Genel.isRedirectedToLoginPage(data)) {
                        logDiv.html(errors).addClass('alert alert-danger');
                    }
                },
                complete: function (data) {
                    Genel.isRedirectedToLoginPage(data,1);
                    setTimeout( function()
                        {
                            allowSubmit = true;
                            logDiv.html('').removeClass('alert alert-danger');;
                        },
                        1000
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
        var curPage  = $('#current_page').html();
        if(curPage != parseInt(curPage)) { curPage=1; $('#current_page').html('1'); return;}
        if(mode=='next') curPage++;
        else if(mode=='previous' && curPage > 1) curPage--;
        else return;
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
                targetPage=$('#fieldCurrentPage').val(),
                currenContentArea;

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: formdata,
                beforeSend: function (data) {
                    allowSubmit = false;
                    currenContentArea = contentArea.html();
                    contentArea.html(Odev.PrintLoadingGif(1));
                },
                success: function (data) {
                    if(data.error) logDiv.html(data.error).addClass('alert alert-danger');
                    else {
                        contentArea.html(data.htmlFormattedContentArea);
                        $('#current_page').html(targetPage);
                        logDiv.html('').removeClass('alert alert-danger');
                    }
                },
                error: function (data) {
                    var errors = '';
                    for(datum in data.responseJSON){
                        errors += data.responseJSON[datum] + '<br>';
                    }
                    if(!Genel.isRedirectedToLoginPage(data)) {
                        contentArea.html(currenContentArea);
                        logDiv.html(errors).addClass('alert alert-danger');
                    }
                },
                complete: function (data) {
                    Genel.isRedirectedToLoginPage(data,1);
                    $('#fieldCurrentPage').val('1');
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


},
Genel = {
    checkJSON: function(m) {
        if (typeof m == 'object') {
            try{
                m = JSON.stringify(m);
            } catch(err) {
                return false;
            }
        }

        if (typeof m == 'string') {
            try{ m = JSON.parse(m); }
            catch (err) { return false; }
        }

        if (typeof m != 'object') { return false;}
        return true;

    },
    isRedirectedToLoginPage: function(data,doRedirect) {
        try{
            if(data.responseText &&  (data.responseText.indexOf('<!--<h2>Login Page</h2>-->') != -1 ) ) {
                if(doRedirect) {
                    var redirectionAccepted = confirm("Click OK to re-login : ) ");
                    if (redirectionAccepted == true)  window.location.href = '/login';
                }
                return true;
            }
        } catch(err) {
            return false;
        }
    }
}












//checkJSON(JSON.parse('{}'));      //true
//checkJSON(JSON.parse('{"a":0}')); //true
//checkJSON('{}');                  //true
//checkJSON('{"a":0}');             //true
//checkJSON('x');                   //false
//checkJSON('');                    //false
//checkJSON();                      //false
