<?php
// refreshs and redirects to a different page
header('refresh: 5; url= /streetartmap/index.php');

// checks if $_GET is declared and not equal to null
if(isset($_GET)){
    var_dump($_GET);
    // connects to database and deletes from table with id
    include 'application/bdd.php';
    $query = $pdo->prepare(
        "DELETE 
        FROM 
            images 
        WHERE
            id=?"
    );

    if ($query->execute([$_GET['id']]) === TRUE) {
        echo "Record deleted successfully";
        // if delation from database is succesfull
        // deletes file from path throught url
        unlink ( "img/upload/".$_GET['path']);
    } else {
        // displays error message 
        echo "Error deleting record: " . $conn->error;
    }
    $conn->close();
}


?>