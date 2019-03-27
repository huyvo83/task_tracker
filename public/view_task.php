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
    $username = $_SESSION['username'];
    require "../config.php";

    // this is called a try/catch statement 		
    $sql = "SELECT id, tasktitle, description, duedate FROM userdb WHERE username = '$username'";

    $statement = $connection->prepare($sql);
    $statement->execute();

    // FOURTH: Put it into a $result object that we can access in the page
    $result = $statement->fetchAll();

?>

<?php include "templates/header.php"; ?>

<div class="wrapper center-block">
    <h2>
        You currently have <?php echo count($result);?> task 
    </h2>


<?php 
        // This is a loop, which will loop through each result in the array
        foreach($result as $row) { 
    ?>

    <p >
        Task: <?php echo $row['tasktitle']; ?><br>     
        Description: <?php echo $row['description']; ?><br>         
        Due Date: <?php echo $row['duedate']; ?><br> 

        <a href='edit_task.php?id=<?php echo $row['id']; ?>'>Edit</a>
            
        <? echo "<a onClick=\"javascript: return confirm('Please confirm deletion');\" href='del_task.php?id=".$row['id']."'>Delete</a>"; ?> 
                
    </p>      
<?php } ?>
    <p>
        <a href="welcome.php" class="btn btn-warning">Main Page</a>
    </p>
</div>

<?php include "templates/footer.php"; ?>