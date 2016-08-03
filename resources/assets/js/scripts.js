function setPaying(company){
    //e.preventDefault();
    console.log(company);
    var form = $(this);

    $.ajax({
        type: 'POST',
        url: company + '/setPaying',
        data: '_token = <?php echo csrf_token() ?>',
        success: function(data){
            console.log(data);
        }
    });


    //$.post('/' + companyId + '/setPaying', companyId).then(function(data){
    //    console.log(data);
    //});
    //console.log(companyId);
}

(function(){
    var submitAjaxRequest = function(e) {
        console.log("triggad");
        var form = $(this);
        var method = form.find('input[name="_method"]').val() || 'POST';
        var submitButton = form.find('button[data-submit]');
        submitButton.html(
            '<div class="spinner">'+
            '<div class="bounce1"></div>'+
            '<div class="bounce2"></div>'+
            '<div class="bounce3"></div>'+
            '</div>'
        );

        $.ajax({
            type: method,
            url: form.prop('action'),
            data: form.serialize(),
            success: function (data) {
                demonstrateSuccessOnButton(submitButton);
                console.log(data);
                $.publish('form.submitted', form);
            },
            error: function(e){
                var errorMsg = form.find('.error');
                errorMsg.find('span').html(e.statusText);
                form.find('.error').fadeIn(500);
            }

        });

        e.preventDefault();
    };

    var demonstrateSuccessOnButton = function(button){
        button.addClass('btn-success');
        button.html('<i class="fa fa-check"></i>');
        setTimeout(function(){
            button.removeClass('btn-success');
            button.html('Spara');
        }, 1500)

    };

    $.subscribe('form.submitted', function(e){
        $('.flash-message').fadeIn(500).delay(1500).fadeOut(500);
    });

    $('form[data-remote]').on('submit', submitAjaxRequest)


})();