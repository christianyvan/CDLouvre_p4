$(document).ready(function () {
   $('.datepicker').change(function () {

        var visitDate = $('.datepicker').val();

   // on récupère la date courante sous la forme jj/mm/aaaa
        let now = new Date();
        var year   = now.getFullYear();
        var month  =('0'+(now.getMonth()+1)).slice(-2);
        var day    = ('0'+now.getDate()   ).slice(-2);
        var currentDate = +day+"/"+month+"/"+year;

        let currentHour = ('0'+now.getHours()  ).slice(-2);



        $.ajax({
            type: 'get',
            format: 'json',
            url: "disponibilityDay",
            success: function (data) {
                var excludeDates =[];

                // on récupère les dates excluses et on les ajoutes au tableau excludeDates
                $.each(data,function(key,value){

                  excludeDates.push(moment.unix(value).format('DD-MM-Y'));
                  console.log(excludeDates);
                });
               // alert(excludeDates+"exludedate");
                $(".datepicker").datepicker({
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

        var dateSplit = visitDate.split("/");
        var dateTab = dateSplit[2] + "-" + dateSplit[1] + "-" + dateSplit[0];

        $.ajax({
            type: 'get',
            format: 'json',
            url: 'numberPlaces/'+ dateTab,
            success: function (data) {
                afficher(data);

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
                alert(XMLHttpRequest);
                alert(errorThrown);
            }
        });


        if (visitDate === currentDate)
        {
            if (currentHour >= 14) {    // si la réservation est pour le jour même et que l'heure en cour est >= 14h,
                                        // le champs journée est supprimé

                $('#cd_louvrebundle_purchaseorder_visitType option').each(function () {
                    if ($(this).attr("value") === "1")
                        $(this).remove();
                })
            }
            else
            {
                if( $("#cd_louvrebundle_purchaseorder_visitType").length < 2)
                {

                    $('#cd_louvrebundle_purchaseorder_visitType').append('<option value="1">Journée</option>');// à modifier
                }
            }
        }

        if(visitDate !== currentDate){
            if( $("#cd_louvrebundle_purchaseorder_visitType > option").length< 2)

            {
               $('#cd_louvrebundle_purchaseorder_visitType').append('<option value="1">Journée</option>');
            }
        }



       // var dateSplit = visitDate.split("/");
       // var dateTab = dateSplit[2] + "-" + dateSplit[1] + "-" + dateSplit[0];
       // alert("valeur de visit date = "+visitDate);
        $.ajax({
            type: 'get',
            format: 'json',
            url: 'numberPlaces/'+visitDate/*dateTab*/,
            success: function (data) {
                afficher(data);

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
                alert(XMLHttpRequest);
                alert(errorThrown);
            }
        });
    });

    function afficher(avalaiblePlaces) {
        $("#nbPlaces").empty();
        $("#maxPlaces").empty();
        //alert(text(avalaiblePlaces));

        if(avalaiblePlaces >=0)
        {
            $('#cd_louvrebundle_purchaseorder_numberTicketsDesired option').each(function(){
                ($(this).removeAttr('disabled'));

            $("#nbPlaces").text(avalaiblePlaces);
            $("#maxPlaces").text(avalaiblePlaces);
        })}
        else
        {

            $('#myModal').modal('show');
            $('#cd_louvrebundle_purchaseorder_numberTicketsDesired option').val('');

        }



    }


    /*********************************Création d'un sous formulaire par défaut ****************************************/
        // On récupère la balise <div> qui contient l'attribut « data-prototype »
    var $container = $('div#cd_louvrebundle_purchaseorder_ticketDescription');

    if (document.getElementById('cd_louvrebundle_purchaseorder_ticketDescription')) {
        // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
        var index = $container.find(':input').length;

        // On ajoute un premier champ automatiquement.
        if (index == 0) {
            addDescription($container);
        }
    }

    /*************** Fonction qui permet d'ajouter un sous formulaire TicketDescriptionType **************************/

    function addDescription($container) {
        // Dans le contenu de l'attribut « data-prototype », on remplace
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var template = $container.attr('data-prototype')
            .replace(/__name__label__/g, 'Visiteur n°' + (index + 1))
            .replace(/__name__/g, index)
        ;
        // On crée un objet jquery qui contient ce template
        var $prototype = $(template);

        // Augmente l'index de 1 pour l'élément suivant
        $container.data('index', index + 1);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        index++;
    }


    /*********************** Ajout des formulaires en fonction du nombre de billet choisi *****************************/

    var index = $container.find(':input').length;
    var $placesRequired = $("#cd_louvrebundle_purchaseorder_numberTicketsDesired");

    // au changement du choix du nombre de place
    $placesRequired.on('change', function (e) {
        e.preventDefault();
        var maxPlacesPerDay = $("#nbPlaces").text();
        if (parseInt($placesRequired.val()) > (parseInt(maxPlacesPerDay))) {
            $('#myModal').modal('show');
        }
        else
        {
            var indice = $("#cd_louvrebundle_purchaseorder_numberTicketsDesired").val() - 1;
            $container.empty();
            index = 0
            for (var i = 0; i <= indice; i++) {
                addDescription($container);
            }
        }
    });
});

