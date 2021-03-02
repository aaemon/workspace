<?php 
    include "db.inc.php"; 
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $user = "SELECT * FROM project_table WHERE id=$id";
    $result = mysqli_query($conn, $user);
    $data = mysqli_fetch_array($result);
    
    if(isset($_POST['submit'])) {   
        $id = $_POST['id'];     
        $client_name = $_POST['client_name'];     
        $client_address = $_POST['client_address'];     
        $client_mobile = $_POST['client_mobile']; 
        $client_email = $_POST['client_email']; 
        $client_package = $_POST['client_package']; 
        $client_username = $_POST['client_username']; 
        $client_password = $_POST['client_password']; 
        $active = 1; 

        $query = "UPDATE project_table SET client_name='$client_name', client_address='$client_address', client_mobile='$client_mobile', client_email='$client_email', client_package='$client_package', client_username='$client_username', client_password='$client_password', active='$active' WHERE id=$id";

        echo $client_username;

        $run = mysqli_query($conn, $query);

        if(!$run) {
            die("Failed");
        } else {
            header("Location:admin.php?client-activated");
            echo "activated";
        }
    }
    if(isset($_POST['delete'])) {
        $id = $_POST['id']; 
        $qur = "DELETE FROM project_table WHERE id=$id";
        $cmd = mysqli_query($conn, $qur);

        if(!$cmd) {
            die("Failed");
        } else {
            header("Location:admin.php?client-deleted");
            echo "deleted";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activation Page</title>
    <link type="text/css" rel="stylesheet" href="main.css">
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container form-cont">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type='hidden' name='id' value='<?php echo "$id";?>'/> 
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" name="client_username" class="form-control" id="username" placeholder="Username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="client_password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Client Name:</label>
                <input type="text" name="client_name" class="form-control" id="name" value="<?php echo $data['client_name']; ?>" placeholder="Name" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" name="client_address" class="form-control" id="address" value="<?php echo $data['client_address']; ?>" placeholder="Address" required>
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile:</label>
                <input type="number" name="client_mobile" class="form-control" id="mobile" value="<?php echo $data['client_mobile']; ?>" placeholder="Mobile" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="client_email" class="form-control" id="email" value="<?php echo $data['client_email']; ?>" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <label for="package" class="form-label">Package:</label>
                <select class="form-select" name="client_package" id="package" required>
                    <option value="100tk" <?php if($data['client_package']=="100tk") echo 'selected="selected"'; ?>>100 TK</option>
                    <option value="200tk" <?php if($data['client_package']=="200tk") echo 'selected="selected"'; ?>>200 TK</option>
                    <option value="300tk" <?php if($data['client_package']=="300tk") echo 'selected="selected"'; ?>>300 TK</option>
                </select>
            </div>
            <button type="submit" name="submit" value="submit" class="btn btn-primary">Activate</button>
            <button type="submit" name="delete" value="delete" class="btn btn-danger">Delete</button>
        </form>
    </div>

</body>
</html>