<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<?php 
    require "../config.php";
    require "common.php";

    if (isset($_GET['id'])) {
        //yes the id exists 
        
        try {
            // set if as variable
            $id = $_GET['id'];
            
            //select statement to get the right data
            $sql = "DELETE FROM userdb WHERE id = :id";
            
            // Prepare the SQL
            $statement = $connection->prepare($sql);
            
            // bind the id to the PDO
            $statement->bindValue(':id', $id);
            
            // execute the statement
            $statement->execute();
            // Success message
            $success = "Work successfully deleted";
            
            header("location: view_task.php");
            
        } catch(PDOExcpetion $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    } else {
        // no id, show error
        echo "No id - something went wrong";
        //exit;
    };
?>

<?php include "templates/header.php"; ?>


<?php include "templates/footer.php"; ?>