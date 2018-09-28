$(document).ready(function() {

    var excludeDates = [];

 //   $('#cd_louvrebundle_purchaseorder_visitDate').datepicker(function () {
        $.ajax({
            type: 'get',
            format: 'json',
            url: 'http://localhost/CDLouvre_p4/web/app_dev.php/disponibilityDay',
            success: function (data) {
                excludeDates.push("01/05/2018");
                excludeDates.push("01/11/2018");
                excludeDates.push("25/12/2018");
                $.each(data, function (key, value) {
                   excludeDates.push(value);
                   console.log(excludeDates);
                });
                initDate(excludeDates);
            }
        })

    /************** On initialise le datepicker en désactivant les dates non disponibles **************/

    function initDate(excludeDates) {
        $('#cd_louvrebundle_purchaseorder_visitDate').datepicker({
            language: "fr",
            autoclose: true,
            daysOfWeekDisabled: "0,2",
            datesDisabled: excludeDates,
            orientation: "auto",
            startDate: "0d",
        })

    }
});




