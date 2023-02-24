<?php

$mysqli = new mysqli("localhost", "serv", "master", "datilografiabse");
if ($mysqli->connect_error) {
    die("Não foi possível se conectar ao banco de dados");
}
