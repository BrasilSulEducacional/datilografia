$(function () {
    var $mainPlayers = $(".main-players");
    var $otherPlayers = $(".other-players");
    var $difficultButtons = $(".difficult-buttons button");
    var $selectMonth = $("#month");

    var circleLoader = `
        <div class="circle-loader">
            <div class="load"></div>
        </div>`;

    $selectMonth.change(function (e) {
        $selectMonth.prop("disabled", true);
        var $mode = $difficultButtons.parent().find(".active");
        loadRanking($mode.data("diff"), $(this).val());
    });

    $difficultButtons.click(function () {
        var active = $difficultButtons.parent().find(".active"); // retorna botão com class active

        active.removeClass("active"); // remove a classe atual que tem o active
        $(this).addClass("active"); // adiciona ao botão que foi clicado

        $difficultButtons.prop("disabled", true);

        loadRanking($(this).data("diff"), $selectMonth.val()); // carrega o ranking pela dificuldade
    });

    function place(ranking) {
        ranking = ranking.slice(0, 3); // remove os alunos que não estão no top 3

        // para os 3 no ranking
        $(".player-name").each(function (i, e) {
            // adiciona o circulo de carregamento
            $(e).children().html(circleLoader);

            if (ranking[i]) {
                // faz um pedido para receber o nome do aluno
                $.post("source/ranking.php", {
                    type: "name",
                    idAluno: ranking[i].id_aluno
                }, function (response) {
                    var $playerRankingImg = $(e).siblings(".player-class").find("img");

                    if (response.image) {
                        $playerRankingImg.prop("src", `https://datilografia.brasilsuleducacional.com.br/assets/images/ranking/${response.image}`);
                        $playerRankingImg.prop("title", response.nome_badge);
                        $playerRankingImg.parent().show();
                    } else {
                        $playerRankingImg.parent().hide();
                    }

                    $(e).children().text(response.nome); // escreve o nome
                    $(e).children().prop("title", response.nome);
                }, "json");


                $(e).parent().find(".player-data").html(`
                    <h5>Precisão: <span>${ranking[i].precisao}%</span></h5>
                    <h5>PPM: <span>${ranking[i].ppm}</span></h5>
                    <h5>Realizado em: <span>${(new Date(ranking[i].realizado_em)).toLocaleDateString()}</span></h5>

                `);
            } else {
                $(e).children().html(`<span class="error-loading">Ainda não há um ${(i) + 1}º colocado</span>`);
                $(e).children().prop("title", "");
                $(e).parent().find(".player-data").empty();
                $(e).siblings(".player-class").hide();
            }
        });

        //$circleLoader.hide();
        $mainPlayers.show(); // mostra o placar
    }

    function generateRanking(ranking) {
        // limpa o ranking antigo
        $otherPlayers.empty();

        ranking = ranking.slice(3, ranking.length); // remove os 3 primeiros

        var repeat = $otherPlayers.data("repeat");
        var templateHTML = `
            <div class="o-player">
                <div class="o-player-place">
                    <span></span>
                </div>
                <div class="o-player-name">
                    <img src="https://datilografia.brasilsuleducacional.com.br/assets/images/ranking" style="width: 20px; display: none;">
                    <i class="fas fa-medal" style="display: none;"></i>
                    <h5></h5>
                </div>
                <div class="o-player-data">
                    <span></span>
                </div>
            </div>
        `;
        (async () => {
            for (var i = 0; i < repeat; i++) {
                var $loadHtml = $(templateHTML);

                $loadHtml.find(".o-player-place span").text(i + 4);

                if (ranking[i]) {
                    // faz um pedido para receber o nome do aluno
                    await $.post("source/ranking.php", {
                        type: "name",
                        idAluno: ranking[i].id_aluno
                    }, function (response) {
                        // console.log(response);
                        if (response.image) {
                            var $img = $loadHtml.find(".o-player-name img");
                            $img.prop("src", $img.attr("src") + `/${response.image}`);
                            $img.prop("title", response.nome_badge);
                            $img.show();
                        } else {
                            var $medal = $loadHtml.find(".o-player-name i");
                            $medal.show();
                        }

                        $loadHtml.find(".o-player-name h5").text(response.nome); // escreve o nome
                    }, "json");

                    $loadHtml.find(".o-player-data span").text(ranking[i].ppm + " PPM");
                } else {
                    $loadHtml.find(".o-player-name h5").text("Ainda não há um " + (i + 4) + "º Colocado");
                }

                $otherPlayers.append($loadHtml);
            }

            $difficultButtons.prop("disabled", false);
            $selectMonth.prop("disabled", false);
        })();

        console.log($otherPlayers.data("repeat"));

        /*$.each($otherPlayers.data("repeat"), function(i) {
            console.log(i);
        });*/
    }

    function loadRanking(difficult = "easy", month = null) {
        $.post("source/ranking.php", {
            difficult: difficult,
            month: month
        }, function (response) {
            response = JSON.parse(response);
            place(response);
            generateRanking(response);
        });

    }

    loadRanking();
    console.log("load ranking");
});