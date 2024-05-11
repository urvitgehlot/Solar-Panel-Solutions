<?php
    require_once '../php/db_connect.php';
    require_once './php/authentication.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <?php require_once "./php/nav_bar.php"; ?>
    <div class="container-fluid mt-5">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Order Id</th>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">Mobile Number</th>
                <th scope="col">Address</th>
                <th scope="col">Address 2</th>
                <th scope="col">Order Type</th>
                <th scope="col">Order Type Id</th>
                <th scope="col">Ordered On</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = "SELECT * FROM orders ORDER BY ordered_on DESC";
                $selectStmt = $conn->prepare($query);
                $selectStmt->execute();
                $result = $selectStmt->get_result();

                while( $row = $result->fetch_assoc() ){
                  echo '<tr>
                    <th scope="row">'.$row["id"].'</th>
                    <td>'.$row["user_name"].'</td>
                    <td>'.$row["email"].'</td>
                    <td>'.$row["mobile_number"].'</td>
                    <td>'.$row["location1"].'</td>
                    <td>'.$row["location2"].'</td>
                    <td>'.$row["order_type"].'</td>
                    <td>'.$row["order_type_id"].'</td>
                    <td>'.$row["ordered_on"].'</td>
                  </tr>';
                } 
              ?>
            </tbody>
          </table>
    </div>


</body>
</html>