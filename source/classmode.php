<?php
// diretório aonde se encontra as imagens dos rankings

define("BADGE_DIR", "https://datilografia.brasilsuleducacional.com.br/assets/images/ranking");
define("SEM_CLASSIFICACAO", 1);
define("CLASSIFICADO", 2);
define("MAX_POINTS_EARN", 20); // máximo de pontos que pode ganhar em uma partida
define("MAX_POINTS_LOSE", 6); // máximo de pontos que pode perder em uma partida
define("PTS_RANKING", [
    "bronze_1" => 100,
    "bronze_2" => 100,
    "bronze_3" => 100,
    "prata_1" => 100,
    "prata_2" => 100,
    "prata_3" => 100,
    "ouro_1" => 100,
    "ouro_2" => 100,
    "ouro_3" => 100,
    "platina_1" => 100,
    "platina_2" => 100,
    "platina_3" => 200,
    "platina_4" => 200,
    "diamante_1" => 200,
    "diamante_2" => 400,
    "diamante_3" => 400,
    "mestre" => 500,
    "grao_mestre" => 500,
]);
define("PTS_MIN_PPM", [
    "bronze_1" => 10,
    "bronze_2" => 12,
    "bronze_3" => 15,
    "prata_1" => 20,
    "prata_2" => 23,
    "prata_3" => 25,
    "ouro_1" => 30,
    "ouro_2" => 36,
    "ouro_3" => 39,
    "platina_1" => 45,  // original: 45
    "platina_2" => 50,  // original: 50
    "platina_3" => 54,  // original: 66
    "platina_4" => 56,  // original: 77
    "diamante_1" => 60, // original: 79
    "diamante_2" => 70, // original: 80
    "diamante_3" => 80, // original: 85
    "mestre" => 90,
    "grao_mestre" => 100,
]);


require __DIR__ . "/banco.php";

if (!empty($_POST)) {
    if (!empty($_POST["codigo"])) {
        $codigo = $_POST["codigo"];
        $aluno = $mysqli->query("SELECT * FROM alunos WHERE cod = '{$codigo}'");

        if (!empty($_POST["type"]) && $_POST["type"] == "info") {
            if ($aluno->num_rows) {
                $aluno = $aluno->fetch_assoc();
                $idAluno = $aluno["id"];

                $response = [
                    "nome_aluno" => $aluno["nome"],
                    "id_aluno" => $aluno["id"],
                    "cod" => $aluno["cod"],
                ];

                $classificacaoAluno = $mysqli->query("SELECT * FROM classificacao_alunos WHERE id_aluno = {$idAluno}");

                if ($classificacaoAluno->num_rows) {
                    $classificacaoAluno = $classificacaoAluno->fetch_assoc();

                    $response = array_merge($response, [
                        "status" => $classificacaoAluno["status"],
                        "pts" => $classificacaoAluno["pts"],
                        "badge" => $classificacaoAluno["id_badge"],
                        "pts_next_badge" => 5
                    ]);

                    if ($classificacaoAluno["status"] == CLASSIFICADO) {
                        $idBadge = $classificacaoAluno["id_badge"];

                        // seleciona o ranking atual
                        $badge = $mysqli->query("SELECT * FROM classificacao_badges WHERE id = {$idBadge}");
                        $badge = $badge->fetch_assoc();

                        // sql para pegar o próximo ranking
                        $nextBadge = $mysqli->query("SELECT * FROM classificacao_badges WHERE id = (SELECT min(id) FROM classificacao_badges WHERE id > {$idBadge})");
                        $nextBadge = $nextBadge->fetch_assoc();

                        // se for grão-mestre
                        if (explode(".png", $badge["image"])[0] == "grao_mestre") {
                            $response = array_merge($response, [
                                "badge_name" => $badge["nome"],
                                "badge_image" => $badge["image"],
                                "badge_path" => BADGE_DIR . "/{$badge["image"]}",
                                "next_badge_path" => BADGE_DIR . "/{$badge["image"]}",
                                "pts_next_badge" => "---",
                                "badge_grao_mestre" => true,
                            ]);

                            echo json_encode($response);
                            return;
                        }

                        $response = array_merge($response, [
                            "badge_name" => $badge["nome"],
                            "badge_image" => $badge["image"],
                            "badge_path" => BADGE_DIR . "/{$badge["image"]}",
                            "next_badge_path" => BADGE_DIR . "/{$nextBadge["image"]}",
                            "pts_next_badge" => PTS_RANKING[explode(".png", $nextBadge["image"])[0]]
                        ]);
                    }

                    echo json_encode($response);
                    return;
                }

                // inserir alunos que não tem classificação
                $sql = "INSERT INTO classificacao_alunos (id_aluno, status, pts) VALUES ({$idAluno}, 1, 0)";

                if ($classificacaoAluno = $mysqli->query($sql)) {
                    $response = array_merge($response, [
                        "status" => 1,
                        "pts" => 0,
                        "pts_next_badge" => 5
                    ]);

                    echo json_encode($response);
                    return;
                }
            }

            return;
        }

        if (!empty($_POST["type"]) && $_POST["type"] == "registerPts") {
            if ($aluno->num_rows) {
                $aluno = $aluno->fetch_assoc();
                $idAluno = $aluno["id"];

                $ppm = $_POST["ppm"];
                $acc = $_POST["acc"];

                $alunoClassificado = $mysqli->query("SELECT * FROM classificacao_alunos WHERE id_aluno = {$idAluno}");

                if ($alunoClassificado->num_rows) {
                    $alunoClassificado = $alunoClassificado->fetch_assoc();

                    if ($alunoClassificado["status"] == SEM_CLASSIFICACAO) {
                        $newPts = intval($alunoClassificado["pts"]) + 1;

                        if ($partida = $mysqli->query("INSERT INTO classificacao_partidas (id_aluno, pts, ppm, acc) 
                                    VALUES ({$idAluno}, {$newPts}, {$ppm}, {$acc})")) {

                            if ($newPts >= 5) {
                                $todasPartidas = $mysqli->query("SELECT * FROM classificacao_partidas WHERE id_aluno = {$idAluno}");
                                $todasPartidas = $todasPartidas->fetch_all(MYSQLI_ASSOC);

                                $totalPts = 0;

                                foreach ($todasPartidas as $partidaPts) {
                                    $totalPts += $partidaPts["ppm"];
                                }

                                $totalPts = $totalPts * 3;

                                $baseRanking = 0;
                                $baseRankingAnterior = 0;

                                foreach (PTS_RANKING as $ranking => $pts) {
                                    if ($totalPts < $baseRanking) {
                                        break;
                                    }

                                    $baseRankingAnterior = $baseRanking;
                                    $baseRanking += $pts;
                                }

                                // sql badge/ranking atual
                                $badge = $mysqli->query("SELECT * FROM classificacao_badges WHERE nome LIKE '{$ranking}'");
                                $badge = $badge->fetch_assoc();
                                $idBadge = $badge["id"];

                                // sql para pegar o próximo ranking
                                $nextBadge = $mysqli->query("SELECT * FROM classificacao_badges WHERE id = (SELECT min(id) FROM classificacao_badges WHERE id > {$idBadge})");
                                $nextBadge = $nextBadge->fetch_assoc();

                                $newPts = $totalPts - $baseRankingAnterior;

                                // atualizar o status da classificação
                                $mysqli->query("UPDATE classificacao_alunos SET 
                                    `status` = 2, id_badge = {$badge["id"]}, pts = {$newPts} WHERE id_aluno = {$idAluno}");

                                $response = [
                                    "ranking" => $ranking,
                                    "badge_path" => BADGE_DIR . "/{$badge["image"]}",
                                    "badge_name" => $badge["nome"],
                                    "badge_pts" => $pts,
                                    "pts_next_badge" => PTS_RANKING[explode(".png", $nextBadge["image"])[0]],
                                    "next_badge_path" => BADGE_DIR . "/{$nextBadge["image"]}",
                                    "pts" => $totalPts - $baseRankingAnterior,
                                    "total_pts" => $totalPts,
                                    "base_ranking" => $baseRanking,
                                    "base_ranking_anterior" => $baseRankingAnterior,
                                ];

                                echo json_encode($response);
                                return;
                            }

                            $classificacao = $mysqli->query("UPDATE classificacao_alunos SET pts = {$newPts} WHERE id_aluno = {$idAluno}");

                            $response = [
                                "pts" => $newPts,
                                "pts_next_badge" => 5,
                            ];
                            echo json_encode($response);
                            return;
                        }

                        return;
                    }

                    // busca o badge
                    $badge = $mysqli->query("SELECT * FROM classificacao_badges WHERE id = {$alunoClassificado["id_badge"]}");
                    $badge = $badge->fetch_assoc();

                    $idBadge = $badge["id"];

                    // sql para pegar o próximo ranking
                    $nextBadge = $mysqli->query("SELECT * FROM classificacao_badges WHERE id = (SELECT min(id) FROM classificacao_badges WHERE id > {$idBadge})");
                    $nextBadge = $nextBadge->fetch_assoc();

                    // nome do badge sem o .png
                    $badgeImageName = explode(".png", $badge["image"])[0];
                    $nextBadgeImageName = (explode(".png", $nextBadge["image"])[0] ?: $badgeImageName);


                    // se o mínimo de pontos for maior que a ppm realizada, perde ponto
                    if (PTS_MIN_PPM[$badgeImageName] > $ppm) {
                        $ptsLose = floor(($ppm / PTS_MIN_PPM[$badgeImageName]) * MAX_POINTS_LOSE);
                        $ptsAluno = intval($alunoClassificado["pts"]) - $ptsLose;

                        // evita pontos negativos
                        if ($ptsAluno < 0) {
                            $ptsAluno = 0;
                        }

                        $mysqli->query("UPDATE classificacao_alunos SET pts = {$ptsAluno} WHERE id_aluno = {$idAluno}");
                        $response = [
                            "pts" => $ptsAluno,
                            "pts_lose" => $ptsLose,
                            "pts_next_badge" => PTS_RANKING[$nextBadgeImageName]
                        ];

                        echo json_encode($response);
                        return;
                    }

                    // paga o mínimo de ppm para ganhar pontos
                    $ptsEarn = PTS_MIN_PPM[$badgeImageName] / $ppm;

                    if ($ptsEarn > 0) {
                        $ptsEarn = floor($ptsEarn * MAX_POINTS_EARN);
                        $ptsAluno = intval($alunoClassificado["pts"]) + $ptsEarn;

                        $set = "pts = {$ptsAluno}";

                        if ($ptsAluno >= PTS_RANKING[$nextBadgeImageName]) {
                            $ptsAluno = $ptsAluno - PTS_RANKING[$nextBadgeImageName];

                            $set = "pts = {$ptsAluno}, id_badge = {$nextBadge["id"]}";

                            // se for grão mestre
                            if ($nextBadgeImageName == "grao_mestre") {
                                $mysqli->query("UPDATE classificacao_alunos SET {$set} WHERE id_aluno = {$idAluno}");
                                $response =  [
                                    "badge_name" => $nextBadge["nome"],
                                    "badge_image" => $nextBadge["image"],
                                    "badge_path" => BADGE_DIR . "/{$nextBadge["image"]}",
                                    "next_badge_path" => BADGE_DIR . "/{$nextBadge["image"]}",
                                    "pts_next_badge" => "---",
                                    "pts" => $ptsAluno,
                                    "badge_grao_mestre" => true,
                                ];
                                echo json_encode($response);
                                return;
                            }

                            $badge = $nextBadge;

                            // sql para pegar o próximo ranking
                            $nextBadge = $mysqli->query("SELECT * FROM classificacao_badges WHERE id = (SELECT min(id) FROM classificacao_badges WHERE id > {$badge["id"]})");
                            $nextBadge = $nextBadge->fetch_assoc();
                            $badgeImageName = explode(".png", $badge["image"])[0];
                        }

                        $mysqli->query("UPDATE classificacao_alunos SET {$set} WHERE id_aluno = {$idAluno}");

                        $response = [
                            "pts" => $ptsAluno,
                            "pts_earn" => $ptsEarn,
                            "badge" => $badge["id"],
                            "badge_pts" => PTS_RANKING[$badgeImageName],
                            "badge_name" => $badge["nome"],
                            "badge_image" => $badge["image"],
                            "badge_path" => BADGE_DIR . "/{$badge["image"]}",
                            "next_badge_path" => BADGE_DIR . "/{$nextBadge["image"]}",
                            "pts_next_badge" => PTS_RANKING[explode(".png", $nextBadge["image"])[0]]
                        ];
                        echo json_encode($response);

                        return;
                    }

                    return;
                }
            }

            return;
        }

        return;
    }
}
