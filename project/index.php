<?php
    //Set connection variables        
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "trip";

    //create database connection
    $con = mysqli_connect($server ,$username, $password, $db);

    //Check for connection success
    if(!$con){
        die("connection to this database failed due to" . mysqli_connect_error());
    }
    //echo "Success connecting to the db";
$insert = false;
if(isset($_POST['name'])){    
    //collect post variables
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $desc = $_POST['desc'];
    $sql_check = "SELECT * FROM `trip` WHERE Phone='$phone';";
    $res = $con->query($sql_check);
    $sql = "";
    if(mysqli_num_rows($res) == 0){
        $sql = "INSERT INTO `trip`.`trip` ( `Name`, `Age`, `Gender`, `Email`, `Phone`, `Other`, `Date`) VALUES ( '$name', '$age', '$gender', '$email', '$phone', '$desc', current_timestamp());";
    }
    else{
        $sql = "UPDATE `trip` SET Name='$name', Age = '$age', Email = '$email', Other='$desc' WHERE Phone='$phone';";
    }

    //Execute the query
    if($con-> query($sql) == true)
    {
        //echo "Successfully inserted";
        $insert = true;
        header("location:index.php");
    }
    else{
        echo "ERROR: $sql <br> $con->error";
    }
    unset($_POST['name']);
}
if(isset($_POST['delete-submit'])){
    $phone = $_POST['phone'];
    $sql = "DELETE FROM `trip` WHERE Phone='$phone';";
    $con-> query($sql);
    header("location:index.php");
}

//close the database connection
$con->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Travel Form</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <img class="ns" src="ns.jpg" alt="NSTU">
    <div class="container">
        <div class="header">
            <h1>Welcome to NSTU to Saint-Martin Travel Form</h1>
            <p>Enter your details to conform your participation on the trip</p>
        </div>

          <?php
          if($insert == true){
            echo "<p class='sbmt'>Thanks for submitting.We will contact with you in a short period..</p>";
          }
          ?>
          <br><br>
          <form action="index.php" method="post">
            <input type="text" name="name" id="name" placeholder="Enter your name">
            <input type="text" name="age" id="age" placeholder="Enter your Age">
            <input type="text" name="gender" id="gender" placeholder="Enter your gender">
            <input type="email" name="email" id="email" placeholder="Enter your email">
            <input type="phone" name="phone" id="phone" placeholder="Enter your phone">
            <textarea name="desc" id="desc" cols="30" rows="10" placeholder="Enter any other information here"></textarea>
            <button class = "btn">Submit</button>
          </form>
          <br><br>
          <form action="index.php" method="post">
            <input type="phone" name="phone" id="phone" placeholder="Enter your phone">
            <button name="delete-submit" class="btn">Delete</button>
          </form>
    </div>
    <script src="index.js"></script>
</body>
</html>