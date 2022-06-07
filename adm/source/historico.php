<?php

if (!empty($_POST)) {

    require __DIR__ . "/banco.php";

    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

    // selecionar textos pelo dia da semana atual 
    // SELECT * FROM texto_logs WHERE registro LIKE '%7412%' AND YEARWEEK(registrado_em, 1) = YEARWEEK(CURDATE(), 1)

    // selecionar os registros do mes atual
    // SELECT * FROM texto_logs WHERE YEAR(registrado_em) = YEAR(CURRENT_DATE()) AND MONTH(registrado_em) = MONTH(CURRENT_DATE());

    // selecionar os registros da semana passada
    // SELECT * FROM texto_logs WHERE registrado_em >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND registrado_em < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY

    // selecionar os registros do mes passado
    // SELECT * FROM texto_logs WHERE YEAR(registrado_em) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(registrado_em) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH);


    $historic = $_POST["historic"];
    // $codigo = $_POST["codigo"];
    $order = $_POST["registerOrder"];


    if ($order == "thisWeek") {

        $register = $mysqli->query("SELECT * FROM {$historic}_logs WHERE YEARWEEK(registrado_em, 1) = YEARWEEK(CURDATE(), 1)");
    }

    if ($order == "thisMonth") {
        $register = $mysqli->query("SELECT * FROM {$historic}_logs WHERE YEAR(registrado_em) = YEAR(CURRENT_DATE()) AND MONTH(registrado_em) = MONTH(CURRENT_DATE());");
    }

    if ($order == "lastWeek") {
        $register = $mysqli->query("SELECT * FROM {$historic}_logs WHERE registrado_em >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND registrado_em < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY");
    }

    if ($order == "lastMonth") {
        $register = $mysqli->query("SELECT * FROM {$historic}_logs WHERE YEAR(registrado_em) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(registrado_em) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)");
    }

    if ($order == "thisYear") {
        $year = date("Y");
        $register = $mysqli->query("SELECT * FROM {$historic}_logs WHERE YEAR(registrado_em) = {$year}");
    }

    if ($order == "allTime") {
        $register = $mysqli->query("SELECT * FROM {$historic}_logs WHERE registro LIKE '%{$codigo}%'");
    }

    if ($register->num_rows) {

        $log = [];

        foreach ($register->fetch_all(MYSQLI_ASSOC) as $i) {
            $i["registrado_em"] = date("d/m/Y H:i:s", strtotime($i["registrado_em"]));
            $i["sort"] = date("Ymd", strtotime($i["registrado_em"]));

            if (!empty($i["dificuldade"])) {
                if ($i["dificuldade"] == "easy") {
                    $i["dificuldade"] = "Fácil";
                }
                if ($i["dificuldade"] == "hard") {
                    $i["dificuldade"] = "Difícil";
                }
                if ($i["dificuldade"] == "medium") {
                    $i["dificuldade"] = "Médio";
                }
            }

            $log[] = $i;
        }


        echo json_encode($log);
        // echo json_encode($register->fetch_all(MYSQLI_ASSOC));
        return;
    }

    echo json_encode([
        "message" => "Não foi possível encontrar esse registro, tente mudar a ordem.",
        "type" => "error"
    ]);
    return;
}
