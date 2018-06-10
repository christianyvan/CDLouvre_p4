$(document).ready(function(){

    /**************** on récupère le nombre de places disponibles pour un jour donnée **********************************/

    var excludeDates = [];
    var $visitDate = $("#cd_louvrebundle_purchaseorder_visitDate").val();

    if($visitDate){

        $.ajax({
            type: 'get',
            format: 'json',
            url: "disponibilityDay",
          //  url: "http://localhost/CDLouvre_p4/web/app_dev.php/disponibilityDay", bon!!!!!!!!!!!!!!!!

            success: function (data) {

              //  var day = $visitDate.substring(0,$visitDate.indexOf('/'));
              //  var month = $visitDate.substring($visitDate.indexOf('/')+1, $visitDate.indexOf('/')+$visitDate.indexOf('/')+1);
              //  var year = $visitDate.substring($visitDate.indexOf('/')+$visitDate.indexOf('/')+2,$visitDate.length);


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
      //  var numberTicketsDesired = $('#cd_louvrebundle_purchaseorder_numberTicketsDesired').val();


        $.ajax({
            type: 'get',
            format: 'json',
            url: 'numberPlaces/'+ dateTab,
            // url: "http://localhost/CDLouvre_p4/web/app_dev.php/numberPlaces/" +dateTab, bon !!!!!!!!!!!!

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
            // $("#nbPlaces").text("Capacité d'accueil dépassé");
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
           //alert(d.getDay());
            return new Date(d.getTime() + (1000 * 60 * 60 * 24 * 1));
        }
       // return new Date(d.getTime() + (1000 * 60 * 60 * 24 * j));
    }

   // var date=document.getElementById('cd_louvrebundle_purchaseorder_visitDate').value;
    //alert(date);
  //  var day = date.substring(0,date.indexOf('/'));
  //  alert(day);
  //  var month = date.substring(date.indexOf('/')+1, date.indexOf('/')+date.indexOf('/')+1);
  //  alert(month);
   // var year = date.substring(date.indexOf('/')+date.indexOf('/')+2,date.length);
   // alert(year);

   // var laDate=new Date();
   // alert(laDate);

  //  var temp = addDays(currentDate);
   // var day = temp.getDate();
   // alert(day);
   // var month = temp.getMonth()+1;
   // alert(month);
   // var year = temp.getFullYear();
    //alert(year);
  //  var next_date = (day+'/'+month+'/'+year);
   // alert(next_date);
   // $('#cd_louvrebundle_purchaseorder_visitDate').attr("value",next_date);
   // document.getElementById('cd_louvrebundle_purchaseorder_visitDate').innerText = next_date;




});


