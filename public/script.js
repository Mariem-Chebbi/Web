var $date = $("#test_date")
var $token = $("#test_token")

$date.change(function()
{
    var $form = $(this).closest('form')
    var data = {}
    data[$token.attr('name')] = $token.val()
    data[$date.attr('name')] = $date.val()

    $.get($form.attr('action'), data).then(function (response)
    {
        $("#test_time_minute").replaceWith(
            $(response).find("#test_time_minute")
        )
    }
    )
}
)

