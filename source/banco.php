<?php

$mysqli = new mysqli("localhost", "serv", "master", "datilografia");
if ($mysqli->connect_error) {
    die("Não foi possível se conectar ao banco de dados");
}
