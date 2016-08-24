//var Vue = require('vue');
//
//
//var vm = new Vue({
//    el: '#app',
//    data: {
//        message: 'Hello Vue.js!'
//    }
//});
//
//console.log(vm);
//

function toggleDatePicker(){
    var target = $(this).data('date-toggle');
    $('#' + target + '-date-picker').toggle(200);
}

function handleLogoUpload(form){
    var target = form.data('target');
    var formData = new FormData(form[0]);
    var method = form.find('input[name="_method"]').val() || 'POST';
    var submitButton = form.find('button[data-submit]');


    $.ajax({
        url: form.prop('action'),
        type: method,
        data: formData,
        success: function (data) {
            $('#logo-img').attr('src', data.path);
            form.find('.error').fadeOut(200);
            demonstrateSuccessOnButton(submitButton);
            changePanelStyle(data[target], $("#" + form.data('target') + "-panel"));
            $.publish('form.submitted', form);
        },
        error: function(e){
            demonstrateSuccessOnButton(submitButton, false);
            var errors = e.responseJSON.logo;
            form.find(".error span").html('');
            errors.forEach(function(error){
                form.find(".error span").html(error);
            });
            form.find('.error').fadeIn(200);
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
}

var submitAjaxRequest = function(e) {
    var form = $(this);
    var target = form.data('target');

    var method = form.find('input[name="_method"]').val() || 'POST';
    var submitButton = form.find('button[data-submit]');
    submitButton.prop('disabled', true);
    submitButton.html(
        '<div class="spinner">'+
        '<div class="bounce1"></div>'+
        '<div class="bounce2"></div>'+
        '<div class="bounce3"></div>'+
        '</div>'
    );

    if(target === "logo"){
        handleLogoUpload(form);
    } else{
        $.ajax({
            type: method,
            url: form.prop('action'),
            data: form.serialize(),
            success: function (data) {
                demonstrateSuccessOnButton(submitButton);
                if(target === "changeOwner"){
                    var $ownerButton = $('button[data-job-id=' + data.jobId + ']');
                    $ownerButton.attr('data-current-owner', data.newOwnerId);
                    $ownerButton.html(data.newOwnerName);
                    setTimeout(function(){
                        form.find('[data-dismiss=modal]').click();
                    }, 500);
                } else{
                    // ändra texten och klass på rutan så den ändrar stil
                    changePanelStyle(data[target], $("#" + form.data('target') + "-panel"));
                }
                $.publish('form.submitted', form);

            },
            error: function(e){
                demonstrateSuccessOnButton(submitButton, false);
                var errorMsg = form.find('.error');
                errorMsg.find('span').html(e.statusText);
                form.find('.error').fadeIn(200);
            }

        });
    }

    e.preventDefault();
};

function onLoadChangePanelStyle(){
    var onCompanyPage = $('#companyPage').length;
    if(onCompanyPage){
        var panels = ['paying', 'featured', 'logo'];
        var isActive = false;
        for (var i in panels) {
            var $panel = $("#" + panels[i] + "-panel");
            if(panels[i] != 'logo'){
                isActive = $panel.find('input[name="' + panels[i] + '"]')[0].checked;
            } else{
                isActive = $panel.find('#logo-img').attr('src') ? true : false;
            }
            if(isActive){
                $panel.addClass('panel-success');
                $panel.find(".not-active").hide();
            } else{
                $panel.addClass('panel-danger');
                $panel.find(".is-active").hide();
            }
        }
    }
}

function changePanelStyle(isActive, $panel){
    if(isActive){
        $panel.addClass('panel-success');
        $panel.removeClass('panel-danger');
        $panel.find(".is-active").fadeIn(200);
        $panel.find(".not-active").hide();
    } else{
        $panel.removeClass('panel-success');
        $panel.addClass('panel-danger');
        $panel.find(".is-active").hide();
        $panel.find(".not-active").fadeIn(200);
    }
}

var demonstrateSuccessOnButton = function(button, success){
    success = typeof success !== 'undefined' ? success : 'true';

    if(success){
        button.addClass('btn-success');
        button.html('<i class="fa fa-check"></i>');
    } else{
        button.addClass('btn-danger');
        button.html('<i class="fa fa-times"></i>');
    }

    setTimeout(function(){
        button.removeClass('btn-success btn-danger');
        button.html('Spara');
        button.prop('disabled', false);
    }, 1500)

};

var setCurrentOwnerInSelect = function(){
    var currentOwner = $(this).data('current-owner');
    var jobId = $(this).data('job-id');
    var $modal = $('#jobOwnerModal');
    $modal.find('#jobId').val(jobId);
    var company = $modal.find('select option.companyOption[value=' + currentOwner + ']');
    company.attr('selected', 'selected');
};

$.subscribe('form.submitted', function(e){
    $('.flash-message').fadeIn(500).delay(1500).fadeOut(500);
});


// event listeners
$('form[data-remote]').on('submit', submitAjaxRequest);
$('form input[data-date-toggle]').on('click', toggleDatePicker);
$('[data-toggle=modal]').on('click', setCurrentOwnerInSelect);
$('[data-confirm]').on('click', function(e){
    if (!confirm('Är du säker på att du vill ta bort jobbannonsen? Detta går inte att ångra.')) e.preventDefault();
});

$(document).on('ready', function(){
    onLoadChangePanelStyle();

    $('.summernote').summernote({
        lang: 'sv-SE', // default: 'en-US'
        height: 300,                 // set editor height
        minHeight: null,             // set minimum height of editor
        disableDragAndDrop: true,
        placeholder: 'Här beskriver du jobbets uppgifter, vad som förväntas av den jobbsökande, och kanske en kort företagsbeskrivning.',
        fontNames: ['Arial', 'Arial Black', 'Courier New', 'Helvetica', 'Impact', 'Roboto', 'Tahoma', 'Times New Roman', 'Verdana'],
        fontNamesIgnoreCheck: ['Roboto'],
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['misc', ['undo', 'redo']]
        ]
    });

    console.log($('.summernote').length);
    //$('.modal').on('show.bs.modal', function () {
    //    var scrollTop = $(window).scrollTop();
    //    $(this).css({'top' : scrollTop + 50 +  'px'});
    //})
});