<?php

// connects to database
try{
  $pdo = new PDO('mysql:host=localhost;dbname=streetartmap','root','root'); 
  $pdo->exec('SET NAMES UTF8');
}catch(PDOException $e){
  echo $e->getMessage();
}

?>