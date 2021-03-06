<?php
    include('db.inc.php');

    if(isset($_GET['delete'])) {
        $delete = $_GET['delete'];
        $sql = "DELETE from device_list WHERE id=$delete";
        $res = mysqli_query($conn, $sql);
        if (!$res) {
            die('Failed to delete item');
        } else {
            header("Location:device.php?deleted");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Device Page</title>
</head>
<body>
    <nav class="container navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CARNIVAL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link" href="add_device.php">Add Device</a>
                </li>
            </ul>
            
            </div>
        </div>
    </nav>

    <div class="container text-center">
        <h2>Device List</h2>
        <table class="table table-sm table-hover table-bordered text-center" style="width: 100%;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Device IP</th>
                    <th scope="col">Device Name</th>
                    <th scope="col">State</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $qry = "SELECT * FROM device_list";
            $result = mysqli_query($conn, $qry);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $device_ip = $row['device_ip'];
                $device_name = $row['device_name'];
                $state = $row['state']; ?>
                <tr>
                    <th scope="row"><?php echo $id ?></th>
                    <td><?php echo $device_ip ?></td>
                    <td><?php echo $device_name ?></td>
                    <td><?php if($state == '1') echo "Active"; else echo "Disabled" ?></td>
                    <td>
                    <a href="edit_device.php?edit=<?php echo $id; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="device.php?delete=<?php echo $id; ?>" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr> <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>