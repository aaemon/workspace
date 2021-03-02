<?php
    include "db.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link type="text/css" rel="stylesheet" href="main.css">
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row">
        <?php
        $qry = "SELECT * FROM project_table WHERE active=0";
        $result = mysqli_query($conn, $qry);
    
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $client_name = $row['client_name'];
            $client_address = $row['client_address'];
            $client_mobile = $row['client_mobile'];
            $client_email = $row['client_email'];
            $client_package = $row['client_package']; 
            $entry_time = $row['entry_time']; ?>

            
                <div class="col-sm-6">
                    <div class="card">
                            <div class="card-header text-center">
                                ID: <?php echo $id ?>
                            </div>
                        <div class="card-body">
                            <h5 class="card-title">Name: <?php echo $client_name ?></h5>
                            <p class="card-text">Address: <?php echo $client_address ?></p>
                            <p class="card-text">Mobile: <?php echo $client_mobile ?></p>
                            <p class="card-text">Date: <?php echo $entry_time ?></p>
                            <a href="activate.php?id=<?php echo $id; ?>" class="btn btn-success">Action</a>
                        </div>
                    </div>
                </div>
        <?php } ?>
        
        </div>


    </div>
</body>
</html>