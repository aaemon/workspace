<?php 
    include "db.inc.php";
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_name = $_POST['client_name'];
    $client_address = $_POST['client_address'];
    $client_mobile = $_POST['client_mobile'];
    $client_email = $_POST['client_email'];
    $client_package = $_POST['client_package'];

    $sql = "INSERT INTO project_table (client_name, client_address, client_mobile, client_email, client_package) values ('$client_name', '$client_address', '$client_mobile', '$client_email', '$client_package')";
    $exc = mysqli_query($conn, $sql);

    if (!$exc) {
        die('Failed to insert data into database');
    } else {
        header("Location:index.php?client-added");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Page</title>
    <link type="text/css" rel="stylesheet" href="main.css">
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container form-cont">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Client Name:</label>
                <input type="text" name="client_name" class="form-control" id="name" placeholder="Client Name" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" name="client_address" class="form-control" id="address" placeholder="Address" required>
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile:</label>
                <input type="number" name="client_mobile" class="form-control" id="mobile" placeholder="Mobile" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="client_email" class="form-control" id="email" placeholder="Email"required>
            </div>
            <div class="mb-3">
                <label for="package" class="form-label">Package:</label>
                <select class="form-select" name="client_package" id="package" required>
                    <option selected>Choose...</option>
                    <option value="100tk">100 TK</option>
                    <option value="200tk">200 TK</option>
                    <option value="300tk">300 TK</option>
                </select>
            </div>
            <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>
</html>