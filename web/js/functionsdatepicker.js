$(document).ready(function(){

    var excludeDates = [];
   // excludeDates.push("01/05/2018");
    //excludeDates.push("08/05/2018");
    //excludeDates.push("01/11/2018");
   // excludeDates.push("25/12/2018");
  //  var date = new Date();
  //  var day = date.getDay();


    $.ajax({
        type: 'get',
        format: 'json',
        url: "disponibilityDay",
        success: function (data) {
            // on récupère les dates excluses et on les ajoutes au tableau excludeDates
            $.each(data,function(key,value){
                excludeDates.push(moment.unix(value).format('DD-MM-Y'));
               console.log(excludeDates);
            });


        }
    });

    $('#cd_louvrebundle_purchaseorder_visitDate').datepicker({
        language: "fr",
        autoclose: true,
        daysOfWeekDisabled: "0,2",
        datesDisabled: excludeDates,
        startDate: "0d",
    }).on('changeDate', function (ev) {
        $(this).datepicker('hide');
    });


   // var  currentDate = moment().format('L'); // renvoie la date courante sous la forme jj/mm/yyyy

   // let today = new Date();
   // var today_2 = moment(today).format('DD/MM');
   // alert(today_2+"tody2");
   // let now = new Date();
   // var currentDay = today.getDay();
   // alert(currentDay+"currentday");
   // now.setDate(today.getDate()+1);



   /**************** on récupère le nombre de places disponibles pour un jour donnée **********************************/

 if(!$(".datepicker").val()){

     $(".datepicker").datepicker({
         beforeShowDay: function (date,excludeDates)
         {
             if (date.getDay() == 0 || date.getDay() == 2)
             {                           // La semaine commence à 0 = Dimanche
                 return [false, ''];
             }
             else
             {
                 return [true, ''];
             }
         }
     });



    }
    $('.datepicker').on(blur,function(){
        var $visitDate = $("#cd_louvrebundle_purchaseorder_visitDate").val();
        //alert($visitDate);
        if($visitDate){
            $.ajax({
                type: 'get',
                format: 'json',
                url: "disponibilityDay",
                success: function (data) {
                    var excludeDates = [];
                    // on récupère les dates excluses et on les ajoutes au tableau excludeDates
                    $.each(data,function(key,value){

                       excludeDates.push(moment.unix(value).format('DD/MM/Y'));
                       //console.log(excludeDates);



                    });
                    // alert(excludeDates+"dans jspicker");

                    $(".datpicker").datepicker({
                        language: 'fr',
                        autoclose: true,
                        minDate: 0,



                    }).on('changeDate', function (ev) {
                        $(this).datepicker('disable');
                    })


                }
            });

            moment.locale('fr');

            var dateCurrent = moment().format('L');
            var currentDate2 = new Date();
            var currentHour = currentDate2.getHours();

            if ($visitDate === dateCurrent)
            {
                if (currentHour >= 14) // supprime le choix demi-journée si on a dépassé 14h pour le jour en cour
                {

                    $('.datepicker').val(0);
                    alert( $('.datepicker').val());
                    $('.datepicker option').each(function ()
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
            // alert(dateTab);

            $.ajax({
                type: 'get',
                format: 'json',
                url: 'numberPlaces/'+ dateTab,
                success: function (avalaiblePlaces) {

                    // changeDate(currentDay,today_2)
                    afficher(avalaiblePlaces);

                }
            });
        }




    })


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



