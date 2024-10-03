<?php

session_start(); // Precisa do start para retirar a atual sessão. (session_start() vem primeiro)

session_destroy();
header("Location: index.php");
exit;