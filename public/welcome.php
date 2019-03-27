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
    $username = $_SESSION["username"];
    require "../config.php";

    // this is called a try/catch statement 		
    $sql = "SELECT username FROM userdb WHERE username = '$username'";

    $statement = $connection->prepare($sql);
    $statement->execute();

    // FOURTH: Put it into a $result object that we can access in the page
    $result = $statement->fetchAll();

?>

<?php include "templates/header.php"; ?>
    <div class="page-header pager">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["fullname"]); ?></b>.</h1>
            
        <?php 
            if (count($result)){

        ?>
            <h3>
                You have <?php echo count($result); ?> task to check!
            </h3>

         <?php }
        ?>
        <p>
            <a href="view_task.php" class="btn btn-primary">View task</a>
            <a href="new_task.php" class="btn btn-primary">Create new task</a>
        </p>    
        <p>
            <a href="reset_pwd.php" class="btn btn-warning">Reset Your Password</a>
            <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        </p>
    </div>

<?php include "templates/footer.php"; ?>