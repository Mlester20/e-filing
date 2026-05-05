<?php
session_start();

require_once __DIR__ . '/../../../app/middleware/auth.php';
allowOnly(['registrar']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Home | <?php require_once __DIR__ . '/../../../helpers/title.php'; ?> </title>
</head>
<body>
    
</body>
</html>