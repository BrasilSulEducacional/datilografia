<?php

require __DIR__ . "/banco.php";


if (!empty($_POST)) {
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select

    $cod = $_POST["cod"];
    $nome = $_POST["nome"];
    $texto = $_POST["texto"];
    $query = $mysqli->query("SELECT nome FROM alunos_textos WHERE cod='{$cod}'");
    $row = $query->fetch_assoc();
    $existe = mysqli_num_rows($query);
    if ($existe > 0) {
        $response = [
            "situacao" => "existe"
        ];
        echo json_encode($response);
        return;
    }

    $query = $mysqli->query("INSERT INTO alunos_textos(cod, nome, texto) VALUES ('{$cod}','{$nome}','{$texto}')");

    if ($query) {
        $response = [
            "situacao" => "sucesso"
        ];
    } else {
        $response = [
            "situacao" => "erro"
        ];
    }
    echo json_encode($response);
    return;
}
