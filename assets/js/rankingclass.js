$(function () {
    $rankingTable = $("#rankingClassTable");
    $orderRanking = $("#orderRanking");

    $.extend($.fn.dataTable.defaults, {
        searching: false,
    });

    $.extend({
        getRankingClass: function (badge) {
            var theResponse = null;
            $.ajax({
                url: 'https://datilografia.brasilsuleducacional.com.br/source/rankingclass.php?badge=' + badge,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    theResponse = response
                }
            });

            return theResponse;
        },
        getPathRanking: function (badge) {
            var theResponse = null;
            $.ajax({
                url: 'https://datilografia.brasilsuleducacional.com.br/source/rankingclass.php',
                method: 'POST',
                data: { badge: badge, type: "path" },
                dataType: 'json',
                success: function (response) {
                    theResponse = response;
                }
            });

            return theResponse;
        }
    })

    $orderRanking.change(function () {
        table($(this).val());
    });

    function table(badge = 1) {
        $rankingTable.DataTable({
            destroy: true,
            bInfo: false,
            bLengthChange: false,

            language: {
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                },
            },
            ajax: {
                url: './source/rankingclass.php?badge=' + badge,
                dataSrc: '',
                type: 'post'
            },
            columns: [
                { data: 'colocacao' },
                { data: 'nome_badge' },
                { data: 'pts' },
                { data: 'nome' },
            ],
            order: [[1, 'desc']],
            rowGroup: {
                dataSrc: 2
            }
        });
    }

    table($orderRanking.val());

    $rankingTable.parent().hide();
})