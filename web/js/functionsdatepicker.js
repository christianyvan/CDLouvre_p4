$(document).ready(function(){

    moment.locale('fr');
    var  currentDate = moment().format('L'); // renvoie la date courante sous la forme jj/mm/yyyy
  //  alert( currentDate);
  //  var currentDate = moment.unix(now).format('DD/MM/Y');

    var today = new Date();
    var today_2 = moment(today).format('DD/MM');
    var now = new Date();
    var currentDay = today.getDay();
    now.setDate(today.getDate()+1);
    var tomorrow = moment(now).format('DD/MM/Y');

   // alert(tomorrow);
    //var dateSplit = tomorrow.split("/");
    //alert(dateSplit);

   // var dateJourMois = dateSplit[0] + "/" + dateSplit[1]; // 26/06

    function changeDate(currentDay,today_2) {
        // si le jour courant est un mardi ou un dimanche, on positionne le champ du datepicker au jour suivant
        while((currentDay === 2) ||(currentDay === 0) || today_2 === '01/05' || today_2 === '01/11' || today_2 === '25/12' ){

            var value = $("#cd_louvrebundle_purchaseorder_visitDate").val(tomorrow);
            alert('value est '+ value);

            if (currentDay === 2){

               return 3;

            }


            if (currentDay === 0){
                return 1
            }

            if (today_2 === '01/05'){
                return '02/05';


            }

            if (today_2 === '01/11'){
                return '02/11';

            }

            if (today_2 === '25/12'){
               return '26/12';

            }
        }



    }

    changeDate(currentDay,today_2);
/*
    function dump(currentDate) {
        var out = '';
        for (var i in currentDate) {
            out += i + ": " + currentDate[i] + "\n";
        }

        return out;
    }
        alert(dump(currentDate));
   */

  //  if(currentDate === '01/05/2018' || currentDate === '01/11/2018' || '25/12/2018' || currentDate === '01/05/2018' || currentDate === '01/11/2018' || '25/12/2018'){
   //     $("#cd_louvrebundle_purchaseorder_visitDate").val(tomorrow);
  //  }






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
        alert(dateTab);

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


});


