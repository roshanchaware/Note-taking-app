<?php

$insert = false;
$update = false;
$delete = false;

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

//create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

//Die if connection was not successful
if (!$conn) {
  die("unable to connect with database".mysqli_connect_error());
}

if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $delete = true;

  $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
  // echo $result;
}

//date insertion to database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['snoEdit'])) {
    // Update Note
    $sno = $_POST["snoEdit"];
    $title = $_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];

    //sql query to be exicuted
    $sql = "UPDATE `notes` SET `title`='$title',`description`='$description' WHERE `notes`.`sno` = $sno";

    $result = mysqli_query($conn, $sql);

    if ($result) {
      $update = true;
    } 
    else {
      echo "couldn't update note!";
    }
    

  }
  else{

    $title = $_POST["title"];
    $description = $_POST["description"];

    //sql query to be exicuted
    $sql = "INSERT INTO `notes`(`title`, `description`) VALUES ('$title', '$description')";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
      die("The record was not inserted successfully..!".mysql_error($conn));
    }
    else{
      // echo "The record inserted successfully...!";
      $insert = true;
    }
  }
}


?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <title>inotes - project 1 | php crud</title>

  </head>
  <body>
    <!-- edit modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
    Edit Modal
    </button> -->

    <!-- EditModal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <form action="index.php" method="POST">
            <div class="modal-body">
              <input type="hidden" name="snoEdit" id="snoEdit">
              <div class="form-group">
                <label for="title">Note Title</label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
              </div><br>
              <div class="form-group">
                <label for="desc">Note Description</label>
                <textarea class="form-control" placeholder="" id="descriptionEdit" name="descriptionEdit" rows="3" style="height: 100px"></textarea>
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
    		<a class="navbar-brand" href="#"><img src="/crud/logo.svg" height="30px"></a>
    		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      			<span class="navbar-toggler-icon"></span>
    		</button>
    			<div class="collapse navbar-collapse" id="navbarSupportedContent">
      				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
       				 	<li class="nav-item">
          					<a class="nav-link active" aria-current="page" href="index.php">Home</a>
        				</li>
       					<li class="nav-item">
         					 <a class="nav-link" href="#">About</a>
        				</li>
        				<li class="nav-item">
         					 <a class="nav-link" href="#">Contact Us</a>
        				</li>
      				</ul>
      				<form class="d-flex">
        				<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        				<button class="btn btn-outline-success" type="submit">Search</button>
      				</form>
    			</div>
  		</div>
	</nav>

  <?php 
  if ($insert) {
    echo "<div class='alert alert-success alert-dismissible fade show' role'alert'>
    <strong>Success!</strong> Your note has been inserted successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert'aria-label='Close'></button>
    </div>";
  }
  ?>
  <?php 
  if ($delete) {
    echo "<div class='alert alert-success alert-dismissible fade show' role'alert'>
    <strong>Success!</strong> Your note has been deleted successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert'aria-label='Close'></button>
    </div>";
  }
  ?>
  <?php 
  if ($update) {
    echo "<div class='alert alert-success alert-dismissible fade show' role'alert'>
    <strong>Success!</strong> Your note has been updated successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert'aria-label='Close'></button>
    </div>";
  }
  ?>

	<div class="container my-4">
		<h2>Add a Note</h2>
		<form action="index.php" method="POST">
  			<div class="form-group">
    			<label for="title">Note Title</label>
    			<input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
  			</div><br>
  			<div class="form-group">
  				<label for="desc">Note Description</label>
  				<textarea class="form-control" placeholder="" id="description" name="description" rows="3" style="height: 100px"></textarea>
			</div><br>
  			<button type="submit" class="btn btn-primary">Add Note</button>
		</form>
	</div>
	<div class="container my-4">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
      $sql = "SELECT * FROM `notes`";
      $result = mysqli_query($conn, $sql);
      $sno = 0;
      while ($rows = mysqli_fetch_assoc($result)) {
        $sno = $sno + 1;
        echo "<tr>
                <th scope='row'>".$sno."</th>
                <td>".$rows['title']."</td>
                <td>".$rows['description']."</td>
                <td>
                <button class='edit btn btn-sm btn-primary' id=".$rows['sno'].">Edit</button>&nbsp
                <button class='deletes btn btn-sm btn-danger' id=d".$rows['sno'].">Delete</button></td>
              </tr>";
            }
        ?>
      </tbody>
    </table>
	</div>
  <hr>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready( function () {
      $('#myTable').DataTable();
      } );
    </script>

    <script type="text/javascript">
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("edit ", );
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName('td')[0].innerText;
          description = tr.getElementsByTagName('td')[1].innerText;
          console.log(title, description);
          titleEdit.value = title;
          descriptionEdit.value = description;
          snoEdit.value = e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle');
        })
      })

      deletes = document.getElementsByClassName('deletes');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("edit ", );
          sno = e.target.id.substr(1,);
          
          if(confirm("Are you sure, you want to delete this note!")){
            console.log("yes");
            window.location = `/crud/index.php?delete=${sno}`;
          }
          else{
            console.log("no");
          }
        })
      })
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->
  </body>
</html>
