$(document).ready(function(){
    $('#cd_louvrebundle_purchaseorder_visitDate').datepicker({
        language: 'fr',
        daysOfWeekDisabled: "0,2",
        datesDisabled: ['01/05/2018', '01/11/2018','25/12/2018'],
        startDate: '0d',
    }).on('changeDate', function (ev) {
        $(this).datepicker('hide');
    });
});

