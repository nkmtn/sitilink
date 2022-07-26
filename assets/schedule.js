
function createScheduleGrid(gridId) {

    const config = {

        width: "100%",
        height: "auto",

        autoload: true,
        filtering: false,
        inserting: false,
        editing: false,
        sorting: true,
        paging: true,

        controller: {
            loadData: function(filter) {
                return $.ajax({
                    type: "GET",
                    url: "/api/schedule/",
                    data: filter
                });
            },
        },
        fields: [
            { title: "ID", name: "id", type: "number"},
            { title: "Имя", name: "name", type: "text", width: 80 , validate: "required"},
            { title: "Очки", name: "points", type: "text", width: 80 },
            { type: "control"}
        ],

        noDataContent: "Данные не найдены",

        deleteConfirm: "Вы уверены, что хотите удалить эти записи?",

        pageSize: 20,
        pagerFormat: "Страницы: {first} {prev} {pages} {next} {last} &nbsp;&nbsp; {pageIndex} из {pageCount}",
        pageNextText: "Вперёд",
        pagePrevText: "Назад",
        pageFirstText: "В начало",
        pageLastText: "В конец",

        invalidMessage: "Неверные данные!",
        loadMessage: "Подождите, пожалуйста..."
    }

    $(gridId).jsGrid(config)
}

$(function() {createScheduleGrid("#schedule-grid")})

$('#membersForm').submit((event) => {
    sendMember(
        $('#membersInput').val()
    );
    $('#membersForm')[0].reset();
    event.preventDefault();
});

function sendMember(text) {
    $.ajax({
        url: '/api/schedule-post',
        type: 'POST',
        data: {
            'membersInput': text
        }
    }).done((data) => {
        $(function(){$("#schedule-grid").jsGrid("loadData")});
    });
}
