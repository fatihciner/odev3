<div>Ödev  - Hazırlayan : Fatih Emre YILMAZ - [ 09.08.2017 ~ 11.08.2017 ]</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

<script src="/js/vendor/jquery.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script> -->
<script src="/js/vendor/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

<script type="text/javascript">
Odev = {
LoginHandler: function() {
    var allowSubmit = true;
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
                else window.location.href = '/transaction/report';
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
                    1000
                );
            }
        });

    });
},
PrintLoadingGif: function () {
    return '<img src="/img/ajax-loader.gif">';
}


}

@yield('script_footer')


</script>