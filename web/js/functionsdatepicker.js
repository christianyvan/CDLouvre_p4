$(document).ready(function(){

    /**************** on récupère le nombre de places disponibles pour un jour donnée **********************************/
        // var dateSplit = $visitDate.split("/");
        // var dateTab = dateSplit[2] + "-" + dateSplit[1] + "-" + dateSplit[0];
        // var numberTicketsDesired = $('#cd_louvrebundle_purchaseorder_numberTicketsDesired').val();

    var excludeDates = [];
    var $visitDate = $("#cd_louvrebundle_purchaseorder_visitDate").val();

    if($visitDate){

        $.ajax({
            type: 'get',
            format: 'json',
            url: "http://localhost/CDLouvre_p4/web/app_dev.php/disponibilityDay",
           // url:"{{path('cd_louvre_recovery_disponibilityDay')}}",
            success: function (data) {
                // on récupère les dates excluses et on les ajoutes au tableau excludeDates
                $.each(data,function(key,value){
                    excludeDates.push(moment.unix(value).format('Y-MM-DD'));
                });

                $("#cd_louvrebundle_purchaseorder_visitDate").datepicker({
                    language: 'fr',
                    autoclose: true,
                    daysOfWeekDisabled: "0,2",
                    datesDisabled: excludeDates,
                    startDate: '0d',
                }).on('changeDate', function (ev) {
                    $(this).datepicker('hide');
                })
            }
        });

        moment.locale('fr');

        var dateCurrent = moment().format('L');
        var currentDate = new Date();
        var currentHour = currentDate.getHours();




        if ($visitDate == dateCurrent) {
            if (currentHour >= 14) {
                 $('#cd_louvrebundle_purchaseorder_visitType').val(0);
                 $('#cd_louvrebundle_purchaseorder_visitType option').each(function () {
                        if ($(this).attr("value") == 1)
                            $(this).remove();
                    })
             }
        }



        /**************** on récupère le nombre de places disponibles pour un jour donnée **********************************/
        var dateSplit = $visitDate.split("/");
        var dateTab = dateSplit[2] + "-" + dateSplit[1] + "-" + dateSplit[0];
        var numberTicketsDesired = $('#cd_louvrebundle_purchaseorder_numberTicketsDesired').val();


        $.ajax({
            type: 'get',
            format: 'json',
           // data : 'numberTicketsDesired='+ numberTicketsDesired,
            // url: 'numberPlaces/'+ dateTab,
            // url:"{{path('numberPlaces')}}"/+ dateTab,
            url: "http://localhost/CDLouvre_p4/web/app_dev.php/numberPlaces/" +dateTab,
            // url:"cd_louvre_recovery_numberPlaces"/+ dateTab,
            success: function (avalaiblePlaces) {
                afficher(avalaiblePlaces);

            }
        });
    }

    function afficher(avalaiblePlaces) {
        $("#nbPlaces").empty();
        $("#maxPlaces").empty();

        if(avalaiblePlaces >=0)
        {
            $("#nbPlaces").text(avalaiblePlaces);
            $("#maxPlaces").text(avalaiblePlaces);
        }
        else
        {
            // $("#nbPlaces").text("Capacité d'accueil dépassé");
            $('#myAlert').modal('show');
        }
    }


});


