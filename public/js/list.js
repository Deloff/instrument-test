$(function(){
    function setReturnDate(modal)
    {
        var regionId = $(modal).find('select[name="region"]').val();
        var sentDate = $(modal).find('input[name="sent_date_time"]').val();
        if (sentDate !== '') {
            $.getJSON('/addTrip/calculateDate', {region: regionId, sent_date: sentDate}, function (data) {
                if (data.status === 'success') {
                    $(modal).find('#return_date').html(data.date);
                }
            });
        }
    }

    function getCouriers(regionId, sentDate, modal) {
        if (sentDate !== '') {
            $.getJSON('/addTrip/freeCouriers', {sent_date:sentDate, region: regionId}, function (data) {
                if (data.status === 'success') {
                    var select = $(modal).find('select[name="courier"]');
                    select.html('');

                    for (var i = 0; i < data.couriers.length; i++) {
                        var courier = data.couriers[i];
                        select.append(
                            $('<option>').attr(
                                'value',
                                courier.id
                            ).html(courier.last_name + ' ' + courier.first_name + ' ' + courier.middle_name)
                        )
                    }
                }
            })
        }
    }

    $('#myModal').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var href = $(button).attr('href');
        var self = this;
        $(this).find('h5.modal-title').text('Добавление поездки');

        $.get(href, function(data, result) {
            var now = new Date();
            $(self).find('div.modal-body').html(data);
            $('input[name="sent_date_time"]').datetimepicker({
                locale: 'ru',
                format:'d.m.Y H:i',
                lang:'ru',
                minDate: now.getFullYear()+ '/'+now.getDate() + '/'+now.getMonth(),
                onSelectDate:function(ct,$i){
                    var regionId = $(self).find('select[name="region"]').val();
                    var sentDate = $(self).find('input[name="sent_date_time"]').val();
                    setReturnDate($(self));
                    getCouriers(regionId, sentDate, self);
                }
            });
            $(self).on('change','select[name="region"]', function () {
                var modal = $('#myModal');
                var regionId = $(modal).find('select[name="region"]').val();
                var sentDate = $(modal).find('input[name="sent_date_time"]').val();
                setReturnDate($(modal));
                getCouriers(regionId, sentDate, modal);
            });
            $(self).on('click', 'button[name="save"]', function () {
                var form = $('form[name="addTrip"]');
                $.ajax({
                    method:'POST',
                    data: $(form).serialize(),
                    url: $(form).attr('action'),
                    dataType:'json'
                }).done(function(data) {
                    console.log(data);
                    if (data.status === 'success') {
                        $('#myModal').modal('hide');
                        window.location.href = window.location.href;
                    }
                });
            })
        });

    });
    var now = new Date();
    $('input[name="sent_from"]').datetimepicker({
        locale: 'ru',
        format:'d.m.Y H:i',
        lang:'ru',
        minDate: now.getFullYear()+ '/'+now.getDate() + '/'+now.getMonth(),
    });
    $('input[name="sent_to"]').datetimepicker({
        locale: 'ru',
        format:'d.m.Y H:i',
        lang:'ru',
        minDate: now.getFullYear()+ '/'+now.getDate() + '/'+now.getMonth(),
    });
});