<?php
require_once "config.php";

$username = $password = "";
$username_err = $password_err = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    //check if username is empty

    if(empty(trim($_POST["username"]))){
        echo "<script language='javascript'>alert('Username cannot be blank!');</script>"; 
        $username_err = "Username cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            //set the value of param username
            $param_username = trim($_POST['username']);

            //try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    echo "<script language='javascript'>alert('This username is already taken!');</script>"; 
                    $username_err = "This username is already taken";
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "something went wrong";
            }
        }
        mysqli_stmt_close($stmt);
    }



//check for password
if(empty(trim($_POST['password']))){
    echo "<script language='javascript'>alert('Password cannot be blank!');</script>"; 
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    echo "<script language='javascript'>alert('Password cannot be less than 5 characters!');</script>"; 
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}

//check for confirm password field
if(trim($_POST['password']) != trim($_POST['confirm_password'])){
    echo "<script language='javascript'>alert('Password and confirm password did not match!');</script>"; 
    $password_err = "Passwords should match";
}

// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
    $sql = "INSERT INTO users (username, password) VALUES (?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    if($stmt){
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

        //set there parameters
        $param_username = $username;
        $param_password =  hash('sha256', $password);

        //try to execute the query
        if(mysqli_stmt_execute($stmt)){
            header("location: login.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">
    <link rel="stylesheet" href="style.css">
    <title>Intern</title>


  </head>
  <body>
    <div class="container">
  <main class="form-signin w-100 m-auto">
  <form action = "" method = "POST">
    <img class="mb-4" src="download.jpg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
    <div class="form-floating">
      <input type="text" name="username" class="form-control" id="floatingInput" placeholder="username">
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
      <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input style="margin-bottom: 0;" type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>
    <div class="form-floating">
      <input type="password" name="confirm_password" class="form-control" id="floatingPassword" placeholder="Confirm Password">
      <label for="floatingPassword">Confirm Password</label>
    </div>
    <br>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Register here</button><br><br>
    
    <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2023</p>
  </form>
</main>
</div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>