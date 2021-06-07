<?php
    include('db.inc.php');

    if(isset($_POST['add'])) { 
        $receiver = $_POST['receiver']; 
        $mobile = $_POST['mobile'];

        $sql = "INSERT INTO contact_list (receiver, mobile) values ('$receiver', '$mobile')";
        $exc = mysqli_query($conn, $sql);

        if (!$exc) {
            die('Failed to insert data into database');
        } else {
            header("Location:contact.php?added");
        }
    }

    if(isset($_GET['delete'])) {
        $delete = $_GET['delete'];
        $sql = "DELETE from contact_list WHERE id=$delete";
        $res = mysqli_query($conn, $sql);
        if (!$res) {
            die('Failed to delete item');
        } else {
            header("Location:contact.php?deleted");
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
    <title>Contact Page</title>
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
                <!-- <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Add</a>
                </li> -->
            </ul>
            
            </div>
        </div>
    </nav>

    <div class="container" style="padding: 30px;">
        <form method="POST" action="" class="form-inline">
        <div class="row g-3">
            <div class="col-md-5">
                <!-- <label for="receiver" class="form-label">Receiver</label> -->
                <input placeholder="Receiver" type="text" class="form-control" id="receiver" name="receiver" maxlength="30">
            </div>
            <div class="col-md-5">
                <!-- <label for="mobile" class="form-label">Mobile</label> -->
                <input placeholder="Mobile" type="text" class="form-control" id="mobile" name="mobile" maxlength="11" minlength="11">
            </div>
            <div class="col-md-2">
                <button type="submit" name="add" value="submit" class="btn btn-primary" style="width: 100%;">Add</button>
            </div>
        </div>
        </form>
    </div>

    <div class="container text-center">
        <h2>Contact List</h2>
        <table class="table table-sm table-hover table-bordered text-center" style="width: 100%;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Receiver</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $qry = "SELECT * FROM contact_list";
            $result = mysqli_query($conn, $qry);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $receiver = $row['receiver'];
                $mobile = $row['mobile']; ?>
                <tr>
                    <th scope="row"><?php echo $id ?></th>
                    <td><?php echo $receiver ?></td>
                    <td><?php echo $mobile ?></td>
                    <td>
                    <a href="contact.php?delete=<?php echo $id; ?>" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr> <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>