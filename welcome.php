<!-- INSERT INTO `food` (`sno`, `title`, `description`, `tstamp`) VALUES ('1', 'Pizza', 'Tomato Sauce & Mozzerella with Oregano', current_timestamp()); -->

<?php
$insert = false;
$update =  false;
$delete = false;
require_once "config.php";

if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `food` WHERE `sno` = $sno";
    $delete = mysqli_query($conn, $sql);
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset( $_POST['snoEdit'])){
        //update the record
        $sno = $_POST['snoEdit'];
        $image = $_POST['imageEdit'];
        $title = $_POST['titleEdit'];
        $description = $_POST['descriptionEdit'];
    
       $sql =  "UPDATE `food` SET `image` = '$image' , `title` = '$title' , `description` = '$description' WHERE `food`.`sno` = $sno";
       $result = mysqli_query($conn, $sql);

       if($result){
        $update = true;
       }
       else{
        echo "We could not update the record successfully";
       }
    }
    else{

    $image = $_POST['image'];
    $title = $_POST['title'];
    $description = $_POST['description'];

   $sql =  "INSERT INTO `food` (`image`, `title`, `description`) VALUES ('$image', '$title', '$description');";
   $result = mysqli_query($conn, $sql);

   if($result){
    $insert = true;
   }
   else{
    echo "The record was not inserted successfully because of this error ".mysqli_error($conn);
   }
}
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>


</head>
  <body>

  <!-- Edit Modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit Modal
</button> -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit this item</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

    <form action="/intern/welcome.php" method="post">
      <div class="modal-body">

     
        <input type="hidden" class="hidden" name="snoEdit" id="snoEdit">
    <div class="mb-3">
    <label for="title" class="form-label">Food Title</label>
    <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
    
    </div>
    <div class="mb-3">
    <label for="imageEdit" class="form-label">Food Image link</label>
    <input type="text" class="form-control" id="imageEdit" name="imageEdit" aria-describedby="emailHelp">
    
    </div>
      <label for="exampleInputEmail1" class="form-label">Food Description</label>
    <div class="form-floating">
    <textarea class="form-control" name="descriptionEdit" id="descriptionEdit" style="height: 100px"></textarea>
  </div>

</div>
      <div class="modal-footer d-block mr-auto">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
 </form>
 
    </div>
  </div>
</div>


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Orderista</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
        <li class="nav-item position-absolute end-0">
          <a class="nav-link" href="logout.php">Logout</a>
</li>
      </ul>
    </div>
  </div>
</nav>

<?php
 if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your item has been inserted successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
 }
?>
<?php
 if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your item has been deleted successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
 }
?>
<?php
 if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your menu has been updated successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
 }
?>

<div class="container my-4">
  <div class="row">
    <div class="col my-4">
    <form action="/intern/welcome.php" method="post">
  <div class="mb-3">
    <label for="title" class="form-label">Food Title</label>
    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
    
  </div>
  <div class="mb-3">
    <label for="title" class="form-label">Food Image Link</label>
    <input type="text" class="form-control" id="image" name="image" aria-describedby="emailHelp">
    
  </div>
  <label for="exampleInputEmail1" class="form-label">Food Description</label>
  <div class="form-floating">
  <textarea class="form-control" name="description" id="description" style="height: 100px"></textarea>
</div>
  
  <button type="submit" class="btn btn-primary my-4">Add item</button>
</form>
</div>
<div class="col"><img src="banner.png"></div>
</div>
</div>

<div class="container my-4">
    <?php
    
    ?>

<table id="myTable" class="table">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>

  <?php
  $sql = "SELECT * FROM `food`";
  $result = mysqli_query($conn, $sql);
  $sno = 0;
  while($row = mysqli_fetch_assoc($result)){
    $sno = $sno+1;
    echo "<tr>
    <th scope='row'>".$sno. "</th>
    <td><img src=".$row['image']." width=90px' height='90px'></td>
    <td>".$row['title']. "</td>
    <td>".$row['description']. "</td>
    <td><button class='edit btn btn-sm btn-primary' id=".$row['sno']." href='/edit'>Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno']." href='/edit'>Delete</button></td>
  </tr>";
  echo "<br>";
  }

  ?>
    
  </tbody>
</table>
</div>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
    
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element)=>{
            element.addEventListener("click", (e)=>{
                console.log("edit ");
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, description);
                titleEdit.value = title;
                descriptionEdit.value = description;
                snoEdit.value = e.target.id;
                console.log(e.target.id);
                $('#editModal').modal('toggle');

            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element)=>{
            element.addEventListener("click", (e)=>{
                console.log("edit ");
                sno = e.target.id.substr(1,);
                
                if(confirm("Are you sure you want to delete this item!")){
                    console.log("yes");
                    window.location = `/intern/welcome.php?delete=${sno}`;
                }
                else{
                    console.log("no");
                }

            })
        })
    </script>

</body>
</html>