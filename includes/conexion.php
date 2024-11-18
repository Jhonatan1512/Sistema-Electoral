<?php 

$host = 'localhost';
$user = 'root';
$db = 'eleccionesdb'; 
$pass = '';

    try { 
        $pdo = new PDO('mysql:host='.$host.';dbname='.$db.';charset-utf8',$user,$pass);
    } catch (Exception $e){
        'error: '.$e->getMessage();
    } 
        
?>

<?php
/*
    $host = 'localhost';
    $user = 'qxskghvm_admin';
    $db = 'qxskghvm_eleccionesdb'; 
    $pass = '4K+eCm@sX67A';
    
        try { 
            $pdo = new PDO('mysql:host='.$host.';dbname='.$db.';charset-utf8',$user,$pass);
        } catch (Exception $e){
            'error: '.$e->getMessage();
        } 
*/