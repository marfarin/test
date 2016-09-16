/**
 * Created by panik on 08.09.16.
 */
$(document).ready(function () {
    $('.close_alert_button').click(function () {
        var id = $(this).attr('id');
        $.ajax('/event-class/set-alert-showed/', {
            success: function() {return true;},
            method: 'GET',
            data: {
                id: id
            }
        });
    });
});