<?php

require __DIR__ . "/banco.php";

if (!empty($_POST)) {
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRIPPED); // impedir alteração de valor no select

    if (!empty($_POST["type"])) {
        $query = $mysqli->query("SELECT alunos.*, classificacao_alunos.id_badge, classificacao_badges.image, classificacao_badges.nome AS 'nome_badge' 
                                FROM alunos 
                                INNER JOIN classificacao_alunos ON alunos.id = classificacao_alunos.id_aluno
                                INNER JOIN classificacao_badges ON classificacao_alunos.id_badge = classificacao_badges.id
                                 WHERE alunos.id = {$_POST["idAluno"]}");
        if ($query->num_rows) {
            $row = $query->fetch_assoc();

            echo json_encode($row);
            return;
        }

        $query = $mysqli->query("SELECT * FROM alunos WHERE id = {$_POST["idAluno"]}");
        $row = $query->fetch_assoc();

        echo json_encode($row);
        return;
    }

    $month = (!empty($_POST["month"]) ? $_POST["month"] : date("m"));
    $year = date("Y");

    $response = [];

    $query = $mysqli->query("SELECT * FROM ranking WHERE dificuldade = '{$_POST["difficult"]}' AND MONTH(realizado_em) = '{$month}' AND YEAR(realizado_em) = '{$year}' ORDER BY ppm DESC");
    $row = $query->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT ranking.*, classificacao_alunos.id_badge, classificacao_badges.image, classificacao_badges.nome 
            FROM `ranking` 
            INNER JOIN classificacao_alunos ON ranking.id_aluno = classificacao_alunos.id_aluno 
            INNER JOIN classificacao_badges ON classificacao_badges.id = classificacao_alunos.id_badge 
            WHERE ranking.dificuldade = '{$_POST["difficult"]}' 
            AND MONTH(ranking.realizado_em) = '{$month}' 
            AND YEAR(ranking.realizado_em) = '{$year}'";

    $alunoBadge = $mysqli->query($sql);
    $alunoBadge = $alunoBadge->fetch_all(MYSQLI_ASSOC);

    foreach ($row as $aluno) {
        $idBadge = null;
        $imageBadge = null;
        $nomeBadge = null;

        foreach ($alunoBadge as $badge) {
            if ($badge["id_aluno"] == $aluno["id_aluno"]) {
                $idBadge = $badge["id_badge"];
                $imageBadge = $badge["image"];
                $nomeBadge = $badge["nome"];
            }
        }

        $response[] = [
            "id" => $aluno["id"],
            "id_aluno" => $aluno["id_aluno"],
            "ppm" => $aluno["ppm"],
            "precisao" => $aluno["precisao"],
            "dificuldade" => $aluno["dificuldade"],
            "id_badge" => $idBadge,
            "image_badge" => $imageBadge,
            "nome_badge" => $nomeBadge,
            "realizado_em" => $aluno["realizado_em"],
        ];
    }

    // var_dump($response);

    echo json_encode($response);
    return;
}
