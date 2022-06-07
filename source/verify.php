<?php

require __DIR__ . "/banco.php";


if (!empty($_POST)) {
    //$_POST[$cod] = filter_var_array($_POST[$cod], FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select

    $table = (filter_var($_POST['cod'], FILTER_VALIDATE_INT) ? "alunos" : "cadastro_tmp");
    $cod = $_POST['cod'];
    $input = $_POST['input'];
    $frases = $_POST['frases'];
    $exercicio = $_POST['exercicio'];
    $acao = $_POST['acao'];



    if ($acao == "exercicio") {
        $frases = 0;
        $exercicio++;
        $query = $mysqli->query("UPDATE {$table} SET frases=$frases, exercicio=$exercicio WHERE cod='{$cod}'");
        return;
    }
    if ($acao == "frases") {
        $frases++;
        $query = $mysqli->query("UPDATE {$table} SET frases=$frases WHERE cod='{$cod}'");
        return;
    }
}
