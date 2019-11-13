$(document).ready(function(){
    // datepiacker initialization
    let date = new Date();
    let sDate = new Date();
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

    /**
     * TODO: merge subjects and data filters
     */
    // listener on subjects
    $("#subjectSelection").change(function(){
        var selectedSubject = $(this).children("option:selected").val();
        console.log("Showing subject: " + selectedSubject + "\n");
        var rows = $("table#marks_table tr");
        rows.each(function(){
            if($(this).data('subject') === selectedSubject){
                $(this).show();
            } else {
                $(this).hide();
            }
        })
    });

    // date filters
    function updateWithDataFilter(){
        let sDate = $("#startDateSelection").val();
        let eDate = $("#endDateSelection").val();
        console.log("Start period: " + sDate + "\nEnd period: " + eDate + "\n");
        var rows = $("table#marks_table tr");
        rows.each(function(){
            let actualDate = $(this).data('date');
            if((sDate === "" && eDate === "") || (sDate === "" && actualDate <= eDate) || (actualDate >= sDate && eDate === "") || (actualDate >= sDate && actualDate <= eDate)){
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $(".date-selection").change(updateWithDataFilter);
})