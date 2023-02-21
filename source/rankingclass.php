<?php

require __DIR__ . "/banco.php";

if (!empty($_POST)) {
    $badge = $_POST["badge"];
    $type = $_POST["type"];

    if ($type == "path") {
        $pathBadge = $mysqli->query("SELECT image FROM classificacao_badges WHERE id = {$badge}");
        $pathBadge = $pathBadge->fetch_assoc();

        echo json_encode($pathBadge);
        return;
    }

    return;
}

if (!empty($_GET)) {
    $badge = $_GET["badge"];

    if ($badge) {
        $clause = "classificacao_alunos.id_badge = {$badge}";

        if ($badge != 17 && $badge != 18) {
            $clause = "classificacao_alunos.id_badge BETWEEN {$badge} AND " . ($badge >= 10 && $badge < 14 ? intval($badge) + 3 : intval($badge) + 2);
        }
    }

    $ranking = $mysqli->query("SELECT RANK() OVER(PARTITION BY id_badge ORDER BY pts desc) AS 'colocacao', classificacao_alunos.id_badge, classificacao_alunos.pts, classificacao_alunos.id_aluno, alunos.nome, classificacao_badges.nome AS 'nome_badge' FROM classificacao_alunos INNER JOIN classificacao_badges ON classificacao_alunos.id_badge = classificacao_badges.id INNER JOIN alunos ON classificacao_alunos.id_aluno = alunos.id ");

    $ranking = $ranking->fetch_all(MYSQLI_ASSOC);

    echo json_encode($ranking);
    return;
}
