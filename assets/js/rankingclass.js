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
                url: './source/rankingclass.php',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                }
            });

            return theResponse;
        },
        getPathRanking: function (badge) {
            var theResponse = null;
            $.ajax({
                url: './source/rankingclass.php',
                method: 'POST',
                data: { badge: badge, type: "path" },
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                }
            });

            return theResponse;
        }
    })
    // $orderRanking.change(function () {
    //     table($(this).val());
    // });

    function table(badge = 1) {
        $rankingTable.DataTable({
            destroy: true,
            bInfo: false,
            bLengthChange: false,
            showWeekNumber: true,
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
                type: 'post',
            },
            columns: [
                { data: 'colocacao' },
                { data: 'image' },
                { data: 'nome_badge' },
                { data: 'pts' },
                { data: 'nome' },
                { data: 'id_badge' }

            ],
            columnDefs: [{ visible: false, targets: 1 }, { visible: false, targets: 5 }],
            order: [[5, 'desc']],
            displayLength: 5,
            drawCallback: function (responce) {
                var api = this.api();
                var rows = api.rows({ page: 'current' }).nodes();
                var last = null;

                api
                    .column(1, { page: 'current' })
                    .data()
                    .each(function (group, i) {
                        if (last !== group) {
                            $(rows)
                                .eq(i)
                                .before('<tr class="group"><td colspan="5"> <img src="https://datilografia.brasilsuleducacional.com.br/assets/images/ranking/' + group + '"></td></tr>');

                            last = group;
                        }
                    });

            },

        });
    }
    table($orderRanking.val());
})