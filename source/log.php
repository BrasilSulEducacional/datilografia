<?php

require __DIR__ . "/banco.php";

date_default_timezone_set('America/Sao_Paulo');

if (!empty($_POST)) {
    if (!empty($_POST["data"])) { // se tiver dados complementares

        // dados do aluno
        $codigo = (!empty($_POST["data"]["codigo"]) ? $_POST["data"]["codigo"] : $_POST["data"]["ranking"]["codigo"]);

        $table = ($_POST["type"] == "texto" ? "alunos_textos" : "alunos");

        $aluno = $mysqli->query("SELECT * FROM {$table} WHERE cod = '{$codigo}'");
        $aluno = $aluno->fetch_assoc();

        $date = date("Y-m-d H:i:s");

        if ($_POST["type"] == "datilografia") {
            $atividade = $_POST["data"]["atividade"]; // salva qual o registro



            // cria o registro de eventos da datilografia textos e exercícios
            $register = "[{$aluno["cod"]}] ";
            $register .= "{$aluno["nome"]} entrou na Datilografia " . ucfirst($atividade);

            $newRegister = $mysqli->query("INSERT INTO datilografia_logs (registro, atividade, registrado_em) 
                                        VALUES ('{$register}', '{$atividade}', '{$date}')");
            return;
        }

        if ($_POST["type"] == "texto") {

            $textoAtual = intval($_POST["data"]["texto_atual"]) + 1;
            $textoAnterior = intval($textoAtual) - 1;

            $register = "[{$aluno["cod"]}] ";
            $register .= "{$aluno["nome"]} passou um texto";

            $newRegister = $mysqli->query("INSERT INTO texto_logs (registro, texto_atual, texto_anterior, registrado_em) 
                                        VALUES ('{$register}', {$textoAtual}, {$textoAnterior}, '{$date}')");

            return;
        }

        if ($_POST["type"] == "exercicio") {

            $exercicioAtual = intval(($_POST["data"]["exercicio_atual"])) + 1;
            $exercicioAnterior = intval($exercicioAtual) - 1;

            $register = "[{$aluno["cod"]}] ";
            $register .= "{$aluno["nome"]} passou um exercício";

            $newRegister = $mysqli->query("INSERT INTO exercicio_logs (registro, exercicio_atual, exercicio_anterior, registrado_em) 
                                        VALUES ('{$register}', {$exercicioAtual}, {$exercicioAnterior}, '{$date}')");

            return;
        }

        if ($_POST["type"] == "ranking") {

            $message = $_POST["data"]["message"];
            $difficulty = $_POST["data"]["ranking"]["dificuldade"];
            $wpm = $_POST["data"]["ranking"]["ppm"];
            $accuracy = $_POST["data"]["ranking"]["precisao"];

            $register = "[{$aluno["cod"]}] ";
            $register .= "{$aluno["nome"]} {$message}";

            $newRegister = $mysqli->query("INSERT INTO ranking_logs (registro, dificuldade, precisao, ppm, registrado_em)
                                        VALUES ('{$register}', '{$difficulty}', '{$accuracy}', {$wpm}, '{$date}')");

            return;
        }


        return;
    }

    var_dump($_POST);
    return;
}
