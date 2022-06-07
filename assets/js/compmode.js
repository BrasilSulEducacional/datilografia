$(function () {
    var startDate;
    var startType = false;
    var correctDigits = [];
    var wrongDigits = [];
    var wpm;
    var accuracy;

    var $display = $(".text-test");
    var $type = $("#user-type");
    var $newTextButton = $(".new-text-button button");
    var $startButton = $(".start-button");
    var $codigo = $("#codigo");
    var $message = $(".message");
    var $statusWpm = $(".status-wpm");
    var $statusAcc = $(".status-precision");
    var $circleLoader = $(".circle-loader");

    var $currentRanking = $(".current-ranking");
    var $nextRanking = $(".next-ranking");
    var $currentPts = $(".current-pts");
    var $badgePts = $(".badge-pts");
    var $progressBar = $(".progressbar div");

    var $modalRanking = $("#modalRanking");


    function getText() {
        $type.prop("disabled", false);
        $display.html("");
        $circleLoader.show();

        $.post("source/texts.php", { difficult: "easy" }, function (response) {
            var words = response.text.split(" ");
            var letters = response.text.split("");

            $.each(letters, function (i, e) {
                $display.append(`<span>${e}</span>`);
            });

            // adiciona a classe .current ao primeiro span
            $display.children().first().addClass("current");

            // limpa os digitos errados e os digitos certos
            correctDigits = [];
            wrongDigits = [];

            // limpa a precisão e as palavras por minuto
            $("#accuracy").text("100%");
            $("#wpm").text("0");

            // toda vez que for carregado um texto, limpa o setInterval()
            if (typeof toCalculate != "undefined") {
                clearInterval(toCalculate);
            }

            $("html, body").animate({ scrollTop: $(document).height() }, 1000);

            $statusWpm.show(500);
            $startButton.hide();
            $startButton.prop("disabled", false); // ativa o botão


            $type.val("");
            $type.focus();
            $circleLoader.hide();
            $display.show();

        }, "json");


    }

    function updateProgressBar(currentPts, totalPts = 100) {
        if (currentPts) {
            var width = (100 * currentPts) / totalPts;

            $progressBar.css("width", width + "%");
        }
    }

    function atualizarClassificacao(codigo, type = "info") {
        $.post("source/classmode.php", {
            codigo: codigo,
            type: type
        }, function (response) {

            if (response.badge_grao_mestre) {
                $currentRanking.hide();
                $nextRanking.hide();

                $progressBar.parent().hide();

                $(".text-footer .ranking-status").after(
                    "<div class='ranking-grao-mestre'> <img src='" + response.badge_path + "' width='100px'> </div>"
                );
            }

            if (response.status) {
                $currentRanking.find("img").prop("src", response.badge_path);
                $nextRanking.find("img").prop("src", response.next_badge_path);

                $currentPts.text(response.pts);
                $badgePts.text(response.pts_next_badge);

                updateProgressBar(response.pts, response.pts_next_badge);
            }

        }, "json");

    }

    function validateCodigo(codigo) {
        $.post("source/texts.php", {
            codigo: codigo
        }, function (response) {
            if (response.type == "error") {
                $codigo.css("color", "rgb(199, 65, 65)");
                $codigo.prop("disabled", false);
            } else {
                $codigo.css("color", "rgb(91, 170, 77)");
                if ($codigo.val().length == 4) {
                    $codigo.blur();
                    $codigo.prop("disabled", true);
                    $message.remove();
                    // $statusAcc.show(500);
                    getText();
                    atualizarClassificacao(codigo);
                    $(".text-footer").show();
                }
            }
        }, "json");
    }

    $startButton.click(function (e) {
        $type.prop("disabled", false); // ativa o campo
        $(this).prop("disabled", true); // ativa o campo

        getText();
        $display.show();
        $newTextButton.show();
    });

    $newTextButton.attr("tabindex", "0");

    $type.keydown(function (e) {
        if (e.key === 'Tab') {
            e.preventDefault();
            $newTextButton.focus();
        }
    });

    $newTextButton.click(function (e) {
        getText();
    });

    // limpa qualquer caractere que não seja um número
    $codigo.keypress(function (e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
    });

    // pega o código
    $codigo.keyup(function (e) {
        if ($(this).val().length == 4) {
            validateCodigo($codigo.val());
            $(this).prop("disabled", true)
            return;
        }
    });

    // getText();

    $type.focus();

    $display.click(function () {
        $type.focus();
    });

    $type.bind("input", function (e) {
        $("body").css("cursor", "none");

        if (!startType) {
            $newTextButton.hide();

            $(window).on("beforeunload", function () {
                return 'Você tem certeza que deseja sair, pode fazer você perder pontos!';
            });

            $(window).on("unload", function () {
                navigator.sendBeacon("source/classmode_leave.php", `codigo=${$codigo.val()}&type=leave`);
            });

            startType = true;
            startDate = new Date();
            var seconds = 1;
            toCalculate = setInterval(function () {
                var now = new Date();
                wpm = ((correctDigits.length / 5) / (seconds / 60)).toFixed(0);
                accuracy = (($display.text().trim().length - wrongDigits.length) / $display.text().trim().length) * 100
                //console.log((new Date()).getSeconds());
                //console.log((new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate())).getSeconds())
                //console.log(now.getSeconds() - startDate.getSeconds())
                $("#wpm").text(wpm);
                $("#accuracy").text(Math.round(accuracy) + "%");
                seconds++;
            }, 1000);
        }

        var typeValue = e.currentTarget.value;
        var digit = typeValue[typeValue.length - 1];
        var $current = $display.find(".current");
        var text = $display.text();

        if ($current.text() == digit) {
            $display.children("span.current").addClass("is-correct");
            $current.removeClass("current");

            $current.removeClass("wrong");
            correctDigits.push(digit);

            // se acabou o teste
            if (!$current.next().is("span")) {
                $type.prop("disabled", true); // desativa o campo

                clearInterval(toCalculate);
                startType = false;
                $(window).off("beforeunload");
                $(window).off("unload");
                $display.hide(800);

                $startButton.show(800);
                $statusWpm.find("#wpm").text("0");
                $statusWpm.hide();

                $.post("source/classmode.php", {
                    type: "registerPts",
                    codigo: $codigo.val(),
                    ppm: wpm,
                    acc: Math.round(accuracy)

                }, function (response) {
                    if (response.ranking) {
                        $modalRanking.find("img").prop("src", response.badge_path);
                        $modalRanking.find(".ranking-name").text(response.badge_name);
                        $modalRanking.addClass("showing");
                    }

                    if (response.pts_lose) {
                        $badgePts.after("<span style='color: #af4154; font-weight: bold;' id='spanPts'>-" + response.pts_lose + "</span>");
                        setTimeout(() => { $('#spanPts').remove() }, 4000);
                    }

                    if (response.pts_earn) {
                        $badgePts.after("<span style='color: #68c3a3; font-weight: bold;' id='spanPts'>+" + response.pts_earn + "</span>");
                        setTimeout(() => { $('#spanPts').remove() }, 4000);
                    }

                    if (response.pts_next_badge) {
                        $badgePts.text(response.pts_next_badge);
                    }

                    if (response.pts) {
                        $currentPts.text(response.pts);
                    }

                    if (response.badge_grao_mestre) {
                        $currentRanking.hide();
                        $nextRanking.hide();

                        $progressBar.parent().hide();

                        $(".text-footer .ranking-status").after(
                            "<div class='ranking-grao-mestre'> <img src='" + response.badge_path + "' width='100px'> </div>"
                        );
                    }

                    $currentRanking.find("img").prop("src", response.badge_path);
                    $nextRanking.find("img").prop("src", response.next_badge_path);

                    updateProgressBar(response.pts, response.pts_next_badge);
                }, "json")

                return;
            }

            $current.next().addClass("current");

            return;
        }

        $current.addClass("wrong");
        wrongDigits.push(digit);

        console.log(typeValue, digit)
    });

    $("body").mousemove(function () {
        if ($(this).css("cursor") != "auto") {
            $(this).css("cursor", "auto")
        }
    })


    if ($codigo.val()) {
        validateCodigo($codigo.val());
    } else {
        $circleLoader.hide();
    }

    $modalRanking.find("a").click(function (e) {
        e.preventDefault();

        $modalRanking.removeClass("showing")
    });

});