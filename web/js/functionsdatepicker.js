$(document).ready(function(){

    /**************** on récupère le nombre de places disponibles pour un jour donnée **********************************/

    var excludeDates = [];
    var $visitDate = $("#cd_louvrebundle_purchaseorder_visitDate").val();

    if($visitDate){

        $.ajax({
            type: 'get',
            format: 'json',
            url: "disponibilityDay",
            success: function (data) {

                // on récupère les dates excluses et on les ajoutes au tableau excludeDates
                $.each(data,function(key,value){
                    excludeDates.push(moment.unix(value).format('DD-MM-Y'));
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

        if ($visitDate == dateCurrent)
        {
            if (currentHour >= 14)
            {
                 $('#cd_louvrebundle_purchaseorder_visitType').val(0);
                 $('#cd_louvrebundle_purchaseorder_visitType option').each(function ()
                 {
                        if ($(this).attr("value") == 1)
                        {
                            $(this).remove();
                        }
                 })
            }
        }



        /**************** on récupère le nombre de places disponibles pour un jour donnée **********************************/
        var dateSplit = $visitDate.split("/");
        var dateTab = dateSplit[2] + "-" + dateSplit[1] + "-" + dateSplit[0];

        $.ajax({
            type: 'get',
            format: 'json',
            url: 'numberPlaces/'+ dateTab,
            success: function (avalaiblePlaces) {
                afficher(avalaiblePlaces);

            }
        });
    }

    /**
     * fonction qui affiche le nombre de place disponible pour un jour donné
     * @param avalaiblePlaces
     */
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
            $('#myAlert').modal('show');
        }
    }

    /**
     * Fonction qui initialise le datepicker au jour courant plus un si le jour courant est un jour de fermeture
     * @param d
     * @param j
     * @returns {Date}
     */
    addDays = function(d){
        if(d.getDay()== 0){
            return new Date(d.getTime() + (1000 * 60 * 60 * 24 * 1));
        }
        if(d.getDay() == 2){

            return new Date(d.getTime() + (1000 * 60 * 60 * 24 * 1));
        }
    }
});


