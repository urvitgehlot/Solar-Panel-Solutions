<?php
    require_once '../php/db_connect.php';
    require_once './php/authentication.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  
  <?php require_once "./php/nav_bar.php"; ?>
    <div class="container-fluid mt-5">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Service Id</th>
                <th scope="col">Service Name</th>
                <th scope="col">Service Img</th>
                <th scope="col">Service Title</th>
                <th scope="col">Service Desc</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = "SELECT * FROM services";
                $selectStmt = $conn->prepare($query);
                $selectStmt->execute();
                $result = $selectStmt->get_result();

                while( $row = $result->fetch_assoc() ){
                  echo '<tr>
                    <th scope="row">'.$row["id"].'</th>
                    <td>'.$row["service_name"].'</td>
                    <td>'.$row["service_img"].'</td>
                    <td>'.$row["service_title"].'</td>
                    <td>'.$row["service_desc"].'</td>
                    <td><a class="btn btn-primary" href="./service_detail.php?id='.$row["id"].'">Edit</a></td>
                  </tr>';
                } 
              ?>
            </tbody>
          </table>
    </div>


</body>
</html>