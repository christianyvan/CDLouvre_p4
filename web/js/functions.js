$(document).ready(function () {

   $('.datepicker').change(function () {

        var visitDate = $('.datepicker').val();

   // on récupère la date courante sous la forme jj/mm/aaaa
        let now = new Date();
        var year   = now.getFullYear();
        var month  =('0'+(now.getMonth()+1)).slice(-2);
        var day    = ('0'+now.getDate()   ).slice(-2);
        var currentDate = day+"/"+month+"/"+year;

        let currentHour = ('0'+now.getHours()  ).slice(-2);

/*********** on affiche le nombre de places disponibles pour la date de visite choisi **************************/
       $.ajax({
            type: 'get',
            format: 'json',
            url: 'http://localhost/CDLouvre_p4/web/app_dev.php/numberPlaces/?visitDate='+visitDate,
            success: function (data) {
                afficher(data);

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
                alert(XMLHttpRequest);
                alert(errorThrown);
            }
        });

/*** On supprime le choix journée de la date courante si la réservation est pour le jour même et si il est 14h et + **/

        if (visitDate === currentDate)
        {
            if (currentHour >= 14)
            {    // si la réservation est pour le jour même et que l'heure en cour est >= 14h,
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

                    $('#cd_louvrebundle_purchaseorder_visitType').append('<option value="1">Journée</option>');
                }
            }
        }

        if(visitDate !== currentDate)
        {
            if( $("#cd_louvrebundle_purchaseorder_visitType > option").length< 2)
            {
               $('#cd_louvrebundle_purchaseorder_visitType').append('<option value="1">Journée</option>');
            }
        }

       $("#cd_louvrebundle_purchaseorder_numberTicketsDesired").show();
       $("#cd_louvrebundle_purchaseorder_customerEmail").show();
   });

    function afficher(avalaiblePlaces)
    {
        $("#nbPlaces").empty();
        $("#maxPlaces").empty();

        if(avalaiblePlaces >=0)
        {
            $('#cd_louvrebundle_purchaseorder_numberTicketsDesired option').each(function(){
                ($(this).removeAttr('disabled'));

            $("#nbPlaces").text(avalaiblePlaces);
            $("#maxPlaces").text(avalaiblePlaces);
            })
        }
        else
        {
           // $('#cd_louvrebundle_purchaseorder_numberTicketsDesired').val(0);
            $('#myModal').modal('show');
           resetNumberTicketDesired();
        }
    }

    $(".btn-danger").click(function () {
        document.location.href="http://localhost/CDLouvre_p4/web/app_dev.php/"
    });


/*********************************Création d'un sous formulaire par défaut ****************************************/
        // On récupère la balise <div> qui contient l'attribut « data-prototype »

    var $container = $('div#cd_louvrebundle_purchaseorder_ticketDescription');

/*************** Fonction qui permet d'ajouter un sous formulaire TicketDescriptionType **************************/

    function addDescription($container) {

        // Dans le contenu de l'attribut « data-prototype », on remplace le texte "__name__label__" par le label du champ
        // le texte "__name__" par le numéro du champ
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

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec le numéro suivant
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

