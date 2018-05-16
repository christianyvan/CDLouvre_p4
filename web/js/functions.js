$(document).ready(function () {


    $('#cd_louvrebundle_purchaseorder_visitDate').change(function () {


        var $visitDate = $('#cd_louvrebundle_purchaseorder_visitDate').val();
        moment.locale('fr');

        var dateCurrent = moment().format('L');
        var currentDate = new Date();
        var currentHour = currentDate.getHours();

        if ($visitDate == dateCurrent) {
            if (currentHour >= 14) {
                // $('#cd_louvrebundle_purchaseorder_visitType option:eq(0)').prop('selected', true);
                // $('#cd_louvrebundle_purchaseorder_visitType option:eq(1)').prop('disabled', true);

                $('#cd_louvrebundle_purchaseorder_visitType').val(0);
                $('#cd_louvrebundle_purchaseorder_visitType').attr('disabled', true);
            }
            else {
                $('#cd_louvrebundle_purchaseorder_visitType').val(1);
                $('#cd_louvrebundle_purchaseorder_visitType').attr('disabled', false);
            }
        }
        else {
            // $('#cd_louvrebundle_purchaseorder_visitType option:eq(1)').prop('disabled', false);
            // $('#cd_louvrebundle_purchaseorder_visitType option:eq(0)').prop('disabled', false);
            $('#cd_louvrebundle_purchaseorder_visitType').attr('disabled', false);
        }
        /**************** on récupère le nombre de places disponibles pour un jour donnée **********************************/
        var dateSplit = $visitDate.split("/");
        var dateTab = dateSplit[2] + "-" + dateSplit[1] + "-" + dateSplit[0];
        var numberTicketsDesired = $('#cd_louvrebundle_purchaseorder_numberTicketsDesired').val();

        $.ajax({
            type: 'get',
            format: 'json',
            //data : 'numberTicketsDesired='+ numberTicketsDesired,
            // url: 'numberPlaces/'+ dateTab,
            // url:"{{path('numberPlaces')}}"/+ dateTab,
            url: "http://localhost/Louvre/web/app_dev.php/numberPlaces" / +dateTab,
            // url:"cd_louvre_recovery_numberPlaces"/+ dateTab,
            success: function (data) {
                afficher(data);
                // $("#nbPlaces").text(dataTab);
                // $("#maxPlaces").text(dataTab);
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
        var maxPlacesPerDay = $("#cd_louvrebundle_purchaseorder_numberTicketsDesired").text();
        if (parseInt($placesRequired.val()) > parseInt(maxPlacesPerDay)) {
            $('#myAlert').modal('show');
        } else {
            var indice = $("#cd_louvrebundle_purchaseorder_numberTicketsDesired").val() - 1;
            $container.empty();
            index = 0
            for (var i = 0; i <= indice; i++) {
                addDescription($container);
            }
        }

    });


})

