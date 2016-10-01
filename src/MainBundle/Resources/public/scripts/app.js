function getCathedrasList(instituteSelect, cathedraSelect) {
    $('body').on('change', instituteSelect, function () {
        if ($(this).val()) {
            $.ajax({
                method: "get",
                url: "/app_dev.php/cathedras/get/" + $(this).val()
            })
                .done(function (msg) {
                    if (msg.status == 1) {
                        $(cathedraSelect).empty().append(msg.output).prop('disabled', false);
                    } else {
                        $(cathedraSelect).empty().append('<option value="">-</option>').prop('disabled', 'disabled');
                    }

                });
        } else {
            $(cathedraSelect).empty(cathedraSelect).append('<option value="">-</option>').prop('disabled', 'disabled');
        }
    });
}
