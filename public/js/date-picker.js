$(function() {
    function isHolidayOrWeekend(date) {
        var day = date.getDay();
        var dateString = $.datepicker.formatDate('yy-mm-dd', date);
        return (day === 0 || day === 6 || holidays.includes(dateString));
    }

    $('input[type="date"]').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShowDay: function(date) {
            return [!isHolidayOrWeekend(date), ''];
        }
    });
});
