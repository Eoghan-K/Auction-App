<?php
    $GLOBALS['isLoggedIn'] = false;
    session_start();
    if ( isset( $_SESSION[ 'id' ] ) ) {
        $GLOBALS[ 'isLoggedIn' ] = true;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type='text/css' href="../style/style.css" />
    <title>Document</title>
</head>

<body ondragstart="return false;" ondrop="return false;">

<?php
    
    include "includes/nav.php";

?>