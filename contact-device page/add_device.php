<?php
    include('db.inc.php');

    if(isset($_POST['submit'])) { 
        $device_ip = $_POST['device_ip']; 
        $device_name = $_POST['device_name'];
        $state = $_POST['state'];

        $sql = "INSERT INTO device_list (device_ip, device_name, state) values ('$device_ip', '$device_name', $state)";
        $exc = mysqli_query($conn, $sql);

        if (!$exc) {
            die('Failed to insert data into database');
        } else {
            header("Location:device.php?added");
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
                <a class="nav-link" aria-current="page" href="device.php">Device List</a>
                </li>
            </ul>
            
            </div>
        </div>
    </nav>

    <div class="container" style="max-width: 600px;">
        <h2 class="text-center">Add Device</h2>
        <form action="" method="POST">
        <div class="mb-3">
            <label for="device_ip">Device IP</label>
            <input type="text" name="device_ip" class="form-control" placeholder="192.168.0.1" id="device_ip" required>
        </div>
        <div class="mb-3">
            <label for="device_name">Device Name</label>
            <input type="text" name="device_name" class="form-control" placeholder="Device Name" id="device_name" required>
        </div>
        <div class="mb-3">
            <label for="state">State</label>
            <select class="form-select" name="state" required>
                <option selected hidden>Select</option>
                <option value="1">Active</option>
                <option value="0">Disable</option>
                </select>
        </div>

        <button type="submit" name="submit" class="btn btn-primary float-end">Submit</button>
        </form>
    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>