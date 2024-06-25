//_______________________Calendar___________________________________//

document.addEventListener("DOMContentLoaded", function () {
    
    let calendarEl = document.getElementById("calendar");
    let calendar = new FullCalendar.Calendar(calendarEl, {
         locale: 'vi',
        initialView: "dayGridMonth",
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        }
    });
    calendar.render();
});
//_______________________End Calendar___________________________________//