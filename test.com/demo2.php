<?php
$time = date('Y-m-d H:i:s', time());
$time7 = date('Y-m-d H:i:s', strtotime("+1 week"));

echo json_encode($_POST);
