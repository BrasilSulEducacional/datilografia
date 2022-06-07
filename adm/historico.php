<div class="content" style="flex-direction: column; min-height: auto;">
    <div class="form">
        <div class="form-header">
            <h2>Histórico</h2>
            <div class="form-buttons-alt">
                <button data-historic="texto">Textos</button>
                <button data-historic="exercicio">Exercícios</button>
                <button data-historic="ranking">Ranking</button>
            </div>
        </div>
        <div class="form-body" style="display: none;">
            <!-- <div class="form-group">
                <div class="col">
                    <div class="label">
                        <label for="cod">Código:</label>
                    </div>
                    <input class="input-small" type="text" id="cod" maxlength="4">
                </div>
                <div class="col">
                    <div class="label">
                        <label for="nome">Nome:</label>
                    </div>
                    <input type="text" id="nome" disabled>
                </div>
            </div> -->
        </div>
    </div>
    <div class="historico-data" style="display: none;">
        <div class="historico-registros">
            <label>
                Ordenar por:
                <select name="registerOrder" id="registerOrder">
                    <option value="thisWeek" selected>Essa Semana</option>
                    <option value="thisMonth">Esse Mês</option>
                    <option value="lastWeek">Última semana</option>
                    <option value="lastMonth">Último Mês</option>
                    <option value="thisYear">Esse Ano</option>
                    <option value="allTime">Todos os registros</option>
                </select>
            </label>
            <div class="table-registers">

            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        var $difficultyButtons = $(".form-buttons-alt button");
        var $historicData = $(".historico-data");
        var $formBody = $(".form-body");
        var $codigo = $("#cod");
        var $registerOptions = $("#registerOrder");
        var $tableRegisters = $(".table-registers");
        var loadHTML = `
            <div class="circle-loader">
                <div class="load" style="height: 50px; width: 50px; border-width: 10px; border-color: #2b66c0; border-top-color: transparent;"></div>
            </div>
        `

        function createTableRegister(data = {}) {
            var url = "source/historico.php";

            $tableRegisters.html(loadHTML);

            $.post(url, data, function(response) {

                if (!response.type) {

                    if (data.historic == "ranking") {
                        var tableHTML = `
                        <table id="registerTable" class="display">
                            <thead>
                                <tr>
                                    <th> Registro </th>
                                    <th> PPM </th>
                                    <th> Precisão </th>
                                    <th> Dificuldade </th>
                                    <th> Registrado em </th>
                                </tr>
                            </thead>
                            <tbody>
                        `;

                        response.forEach(function(i) {
                            tableHTML += `
                            <tr>
                                <td> ${i.registro} </td>
                                <td> ${i.ppm} </td>
                                <td> ${i.precisao} </td>
                                <td> ${i.dificuldade} </td>
                                <td data-sort='${i.sort}'> ${i.registrado_em} </td>
                            </tr>
                            `;
                        });

                        tableHTML += `
                            </tbody>
                            </table>
                        `;

                        $tableRegisters.html(tableHTML);

                    }

                    if (data.historic == "texto") {
                        var tableHTML = `
                        <table id="registerTable" class="display">
                            <thead>
                                <tr>
                                    <th> Registro </th>
                                    <th> Texto atual </th>
                                    <th> Texto anterior </th>
                                    <th> Registrado em </th>
                                </tr>
                            </thead>
                            <tbody>
                        `;

                        response.forEach(function(i) {
                            tableHTML += `
                            <tr>
                                <td> ${i.registro} </td>
                                <td> ${i.texto_atual} </td>
                                <td> ${i.texto_anterior} </td>
                                <td data-sort='${i.sort}'> ${i.registrado_em} </td>
                            </tr>
                            `;
                        });

                        tableHTML += `
                            </tbody>
                            </table>
                        `;

                        $tableRegisters.html(tableHTML);

                    }

                    if (data.historic == "exercicio") {
                        var tableHTML = `
                            <table id="registerTable" class="display">
                                <thead>
                                    <tr>
                                        <th> Registro </th>
                                        <th> Exercício atual </th>
                                        <th> Exercício anterior </th>
                                        <th> Registrado em </th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        response.forEach(function(i) {
                            tableHTML += `
                                <tr>
                                    <td> ${i.registro} </td>
                                    <td> ${i.exercicio_atual} </td>
                                    <td> ${i.exercicio_anterior} </td>
                                    <td data-sort='${i.sort}'> ${i.registrado_em} </td>
                                </tr>
                            `;
                        });

                        tableHTML += `
                            </tbody>
                            </table>
                        `;

                        $tableRegisters.html(tableHTML);

                    }

                    $("#registerTable").DataTable({

                        language: {
                            "search": "Procurar:",
                            "info": "Mostrando _START_ a _END_ de um total de _TOTAL_ registros",
                            "lengthMenu": "Mostrando _MENU_ registros por página",
                            "paginate": {
                                "first": "Primeiro",
                                "last": "Último",
                                "next": "Próximo",
                                "previous": "Anterior"
                            },
                        }
                    });

                    $historicData.show();
                } else {
                    var color = response.type == "error" ? "#f22613" : "#03c9a9";

                    $tableRegisters.html(`
                        <span style="display: flex; justify-content: center; font-weight: 700; color: ${color}; text-align: center;" class="msg msg-${response.type}">${response.message}</span>
                    `);
                }
            }, "json");
        }

        $difficultyButtons.click(function(e) {
            var $button = $(this);
            var $buttonActive = $difficultyButtons.filter(".active");

            $buttonActive.removeClass("active");
            $button.addClass("active");

            // $historicData.show();
            $formBody.show();

            var historic = $difficultyButtons.filter(".active").data("historic");
            var data = {
                historic: historic,
                // codigo: $codigo.val(),
                registerOrder: $registerOptions.val()
            };

            createTableRegister(data);

            // if ($codigo.val().length == 4) {

            // }
        });

        // $codigo.bind("input", function(e) {
        //     var codigo = e.currentTarget.value;

        //     if ($(this).val().length > 3) {
        //         var historic = $difficultyButtons.filter(".active").data("historic");
        //         var data = {
        //             historic: historic,
        //             codigo: codigo,
        //             registerOrder: $registerOptions.val()
        //         };

        //         $historicData.show();
        //         createTableRegister(data);
        //     }
        // });

        $registerOptions.change(function() {
            var historic = $difficultyButtons.filter(".active").data("historic");
            var data = {
                historic: historic,
                // codigo: $codigo.val(),
                registerOrder: $registerOptions.val()
            };

            createTableRegister(data);
        });

        $("input").each(function(i, e) {
            if ($(this).val()) {
                $(this).siblings().addClass("up");
            }
        });

        $("input").on("focus blur", function() {
            var $input = $(this);

            if (!$input.val()) {
                $input.siblings().toggleClass("up");
            }
        });


    });
</script>