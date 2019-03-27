<?php

session_start(); 

// Include config file
require "../config.php";
require "common.php";
// Define variables and initialize with empty values
$username = $tasktitle = $description = $duedate = "";
$tasktitle_err = $duedate_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_SESSION["username"];
    $tasktitle = trim($_POST["tasktitle"]);
    $description = trim($_POST["description"]);
    $duedate = trim($_POST["duedate"]);
    // Prepare an insert statement
    $sql = "INSERT INTO userdb (username, tasktitle, description, duedate) VALUES (:username, :tasktitle, :description, :duedate )";

    if($stmt = $connection->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
        $stmt->bindParam(":tasktitle", $param_tasktitle, PDO::PARAM_STR);
        $stmt->bindParam(":description", $param_description, PDO::PARAM_STR);
        $stmt->bindParam(":duedate", $param_duedate, PDO::PARAM_STR);

        // Set parameters
        $param_username = $username;
        $param_tasktitle = $tasktitle;
        $param_description = $description;
        $param_duedate = $duedate;        

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Redirect to login page
            echo "Congratulation, you just add a new task successfully";
        } else{
            echo "Something went wrong. Please try again later.";
        }
    }

    // Close statement
    unset($stmt);

    
    // Close connection
    unset($connection);
}
?>
<?php include "templates/header.php"; ?> 

    <div class="wrapper center-block">
        <h2>New Task</h2>
        <p>Please fill this form to create an task.</p>
        <br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($tasktitle_err)) ? 'has-error' : ''; ?>">                
                <label>Title</label>
                <input type="text" name="tasktitle" class="form-control" value="<?php echo $tasktitle; ?>">
                <span class="help-block"><?php echo $tasktitle_err; ?></span>
            </div>         
            
            <div class="form-group">                
                <label>Description</label>
                <input type="text" name="description" class="form-control" value="<?php echo $description; ?>">
            </div>    
            
            <div class="form-group">
                <label>Work Due Date</label>
                <input type="text" data-role="calendarpicker" name="duedate" value="<?php echo $duedate; ?>">
            </div>          

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-primary" value="Reset">
                <a href="welcome.php" class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>    

<?php include "templates/footer.php"; ?>