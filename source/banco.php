<?php
// $mysqli = new mysqli("localhost", "u454850207_dati", "Banco_2020!", "u454850207_datilografia");
$mysqli = new mysqli("localhost", "serv", "master", "datilografiabse");
if ($mysqli->connect_error) {
    die("Não foi possível se conectar ao banco de dados");
}
