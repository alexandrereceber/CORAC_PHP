<?php

$Tabela = $_GET["Nome"];

//echo hash("sha256", md5($Tabela));
echo md5($Tabela);

