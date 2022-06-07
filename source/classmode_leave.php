<?php

require __DIR__ . "/banco.php";

$postdata = file_get_contents("php://input");

foreach (explode('&', $postdata) as $chunk) {
    $param = explode("=", $chunk);

    if ($param) {
        $_POST[urldecode($param[0])] = urldecode($param[1]);
    }
}

$aluno = $mysqli->query("SELECT * FROM alunos WHERE cod = '{$_POST["codigo"]}'");
$aluno = $aluno->fetch_assoc();

$idAluno = $aluno["id"];

$classificacao = $mysqli->query("SELECT * FROM classificacao_alunos WHERE id_aluno = {$idAluno}");
$classificacao = $classificacao->fetch_assoc();

if ($classificacao["status"] == 2) {
    $pts = intval($classificacao["pts"]);
    $newPts = $pts - 28;

    if ($newPts < 0) {
        $newPts = 0;
    }

    $mysqli->query("UPDATE classificacao_alunos SET pts = {$newPts} WHERE id_aluno = {$idAluno}");
}
