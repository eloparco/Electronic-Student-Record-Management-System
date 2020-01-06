$(document).ready(function(){
    // datepiacker initialization
    let date = new Date();
    let sDate = new Date();
    if(date.getMonth() < 8){
        date.setFullYear(date.getFullYear()-1);
    }
    sDate.setFullYear(date.getFullYear());
    sDate.setMonth(8);
    sDate.setDate(1);
    let eDate = new Date();
    eDate.setFullYear(date.getFullYear()+1);
    eDate.setMonth(5);
    eDate.setDate(30);
    $(".date-selection").datepicker({
        format: 'dd/mm/yyyy',
        startDate: sDate,
        endDate: eDate,
        daysOfWeekDisabled: "0,6",
        autoclose: true
    });

    function get_date_from_format(dateString){
        var pattern = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/;
        var arrayDate = dateString.match(pattern);
        return new Date(arrayDate[3], arrayDate[2]-1, arrayDate[1]);
    }

    /**
     * function to select the filters and pass them to the filtering function [updateWithDataFilters]
     */
    function updateVisualization(){
        let selectedSubject = $("#subjectSelection").children("option:selected").val();
        selectedSubject = selectedSubject === "" ? null : selectedSubject;
        let startDate = $("#startDateSelection").val();
        let endDate = $("#endDateSelection").val();
        let sDate = null;
        let eDate = null;
        let pattern = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/;
        if(startDate !== ""){
            if(pattern.test(startDate)){
                sDate = get_date_from_format(startDate);
            } else {
                return;
            }
        }
        if(endDate !== ""){
            if(pattern.test(endDate)){
                eDate = get_date_from_format(endDate);
            } else {
                return;
            }
        }
        updateWithDataFilter(selectedSubject, sDate, eDate);
    }

    function updateWithDataFilter(subject, sDate, eDate){
        var rows = $("table#marks_table > tbody > tr");
        rows.each(function(){
            let actualDate = get_date_from_format($(this).data('date'));
            let actualSubject = $(this).data('subject');
            if(((sDate === null && eDate === null) || (sDate === null && actualDate <= eDate) || (actualDate >= sDate && eDate === null) || (actualDate >= sDate && actualDate <= eDate)) && (subject === null || actualSubject === subject)){
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $("#subjectSelection").change(updateVisualization);
    $(".date-selection").change(updateVisualization);
})