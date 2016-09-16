/**
 * Created by panik on 07.09.16.
 */
$(document).ready(function () {

    function getModelFields(eventId, callback){
        $.ajax('/event-class/field-name-class-list/', {
            success: callback,
            method: 'GET',
            data: {
                id: eventId
            }
        });
    }

    $('#copy_header_buttons').on('click', '.copy-to-header', function () {
        console.log($(this).val());
        var val = $('#configuremodelevent-message_header').val();
        val = val + $(this).val();
        $('#configuremodelevent-message_header').val(val);
    });

    $('#copy_text_buttons').on('click', '.copy-to-text', function () {
        console.log($(this).val());
        var val = $('#configuremodelevent-message_text').val();
        val = val + $(this).val();
        $('#configuremodelevent-message_text').val(val);
    });

    $('#configuremodelevent-event_class_id').on("select2:select", function (e) {
        console.log($(this).val());
        getModelFields($(this).val(), function(data){
            console.log(data);
            $.each(data.results, function (index, value) {
                $('#copy_text_buttons').append('<button type="button" class="btn btn-success copy-to-text" value="{model.'+index+'}">MODEL '+value+'</button>');
                $('#copy_header_buttons').append('<button type="button" class="btn btn-success copy-to-header" value="{model.'+index+'}">MODEL '+value+'</button>');

            })
        });
    });
});
