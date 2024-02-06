<?php
$insert = false;
$update=false;
$delete=false;

//Connecting to the DB
$servername='localhost';
$username='root';
$password='';
$database='notes';

//Creat a connection obj
$conn = mysqli_connect($servername,$username,$password,$database);

//Die if connection was not successful(Error Handling)
if(!$conn){
    die("Sorry we failed to connect ".mysqli_connect_error());
}
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete=true;
  $sql = "DELETE FROM `mynotestable` WHERE `sno`=$sno";
  $result = mysqli_query($conn, $sql);
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['snoEdit'])){
    $sno=$_POST["snoEdit"];
    $title=$_POST["titleEdit"];
    $description=$_POST["descriptionEdit"];
    $sql="UPDATE `mynotestable` SET `title` = '$title' , `description` = '$description' WHERE `mynotestable`.`sno` = $sno"; 
    $result = mysqli_query($conn, $sql);
    if($result){
      $update=true;
    }
    else{
      echo "We couldn't updated the record successfully";
    }
  }
  else{  
    $title=$_POST["title"];
    $description=$_POST["description"];
    $sql="INSERT INTO `mynotestable` (`title`, `description`) VALUES ('$title', '$description')"; 
    $result = mysqli_query($conn, $sql);
    //Check for the Data Insertion success
    if($result){
        $insert = true;
    }
    else{
        echo "The record was not inserted successfully because of this error-->" .mysqli_error($conn);
    }
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iNotes - Note taking made easy</title>

    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
      if(window.history.replaceState){
        window.history.replaceState(null, null, window.location.href);
      }
    </script>
    <style>
      body{
            background: #edeaff;
            margin: 0;
            padding: 0;
            }
    </style>   
  </head>
  <body>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit this Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/02_CRUD_Application/index.php" method="POST">
      <div class="modal-body">
        <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="title" class="form-label"><b>Note Title - </b></label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text"></div>
            </div>
           
            <div class="mb-3">
              <label for="desc" class="form-label"><b>Note Description - </b></label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
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
          <a class="navbar-brand" href="#"><img src="/02_CRUD_Application/php_icon.svg" alt="php" height="40px"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">About</a>
              </li>              
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Blog</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">ContactUs</a>
              </li>
           </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>  
        </div>
    </nav>
    <?php
      if($insert==true){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong>The record has been inserted successfully
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
    ?>
     <?php
      if($delete){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong>The record has been deleted successfully
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
    ?>
     <?php
      if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong>The record has been updated successfully
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
    ?>
    
    <div class="container my-5">
        <h2 align="center"><b>Add a Note to iNotes App</b></h2>
        <form action="/02_CRUD_Application/index.php" method="post">
            <div class="mb-3">
              <label for="title" class="form-label"><b>Note Title - </b></label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text"></div>
            </div>
           
            <div class="mb-3">
              <label for="desc" class="form-label"><b>Note Description - </b></label>
              <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
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
        $sql="SELECT * FROM `mynotestable`";
        $result = mysqli_query($conn,$sql);
        $sno=0;
        while($row = mysqli_fetch_assoc($result)){
          $sno=$sno+1;
          echo "<tr>
          <th scope='row'>". $sno . "</th>
          <td>". $row['title'] . "</td>
          <td>". $row['description'] . "</td>
          <td> <button class='edit btn btn-sm btn-primary' data-bs-toggle='modal' id=". $row['sno'] . ">Edit</button> <button class='delete btn btn-sm btn-primary' data-bs-toggle='modal' id=d". $row['sno'] . ">Delete</button>
          </tr>";       
       }
       ?>
    </tbody>
    </table>
  </div>
  <hr>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
  <script>
      let table = new DataTable('#myTable');
  </script> 
  <script>
          edits=document.getElementsByClassName('edit');
          Array.from(edits).forEach((element)=>{
          element.addEventListener("click",(e)=>{
          console.log("edit ",);
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title,description);
          titleEdit.value=title;
          descriptionEdit.value=description;
          snoEdit.value=e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle');
       })
      })

      deletes=document.getElementsByClassName('delete');
          Array.from(deletes).forEach((element)=>{
          element.addEventListener("click",(e)=>{
          console.log("edit ",);
          sno=e.target.id.substr(1,);
          if(confirm("Do you want to Delete this Note ?")){
            console.log("yes");
            window.location=`/02_CRUD_Application/index.php?delete=${sno}`;
          }
          else{
            console.log("no");
          }
       })
      })
  </script>
</html>