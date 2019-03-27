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
    // include the config file that we created last week
    require "../config.php";
    require "common.php";
    // run when submit button is clicked
    if (isset($_POST['submit'])) {
        try {
   
            //grab elements from form and set as varaible
            $work =[
              "id"           => $_POST['id'],
              "tasktitle"    => $_POST['tasktitle'],
              "description"  => $_POST['description'],
              "duedate"      => $_POST['duedate'],
            ];
            
            // create SQL statement
            $sql = "UPDATE userdb 
                    SET id = :id, 
                        tasktitle = :tasktitle, 
                        description = :description, 
                        duedate = :duedate
                    WHERE id = :id";
            //prepare sql statement
            $statement = $connection->prepare($sql);
            
            //execute sql statement
            $statement->execute($work);
        } catch(PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }
    // GET data from DB
    //simple if/else statement to check if the id is available
    if (isset($_GET['id'])) {
        //yes the id exists 
        
        try {
            // set if as variable
            $id = $_GET['id'];
            
            //select statement to get the right data
            $sql = "SELECT * FROM userdb WHERE id = :id";
            
            // prepare the connection
            $statement = $connection->prepare($sql);
            
            //bind the id to the PDO id
            $statement->bindValue(':id', $id);
            
            // now execute the statement
            $statement->execute();
            
            // attach the sql statement to the new work variable so we can access it in the form
            $work = $statement->fetch(PDO::FETCH_ASSOC);
            
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

<?php if (isset($_POST['submit']) && $statement) : ?>
	<p>Work successfully updated.</p>
<?php endif; ?>



<div class="wrapper center-block">
    <h2>Edit your task</h2>    
    <form method="post">

        <input type="hidden" name="id" id="id" value="<?php echo escape($work['id']); ?>" >            
        <div class="form-group">
            <label for="tasktitle">Task name</label>
            <input type="text" name="tasktitle" value="<?php echo escape($work['tasktitle']); ?>">    
        </div>

        <div class="form-group">
            <label for="description">Task Description</label>
            <input type="text" name="description" value="<?php echo escape($work['description']); ?>">            
        </div>


        <div class="form-group">
            <label for="duedate">Work Due Date</label>
            <input type="text" data-role="calendarpicker" name="duedate" value="<?php echo escape($work['duedate']); ?>">          
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-warning" name="submit" value="Save">
            <a href="view_task.php" class="btn btn-warning">View Task</a>
        </div>    

    </form>    
</div>

<?php include "templates/footer.php"; ?>