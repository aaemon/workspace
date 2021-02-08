<?php 
    include "db.inc.php"; 

    if(isset($_POST['edit_heading'])) {
        $edit_name = $_POST['h_name'];
 
        $query = "UPDATE heading_table SET h_name='$edit_name' WHERE h_id=1";
        $run = mysqli_query($conn, $query);

        if(!$run) {
            die("Failed");
        } else {
            header("Location:index.php?updated-heading");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>
    <div class="container">
        <div class="item">
            <h1>Change Heading</h1>
            <form action="" method="POST">
                <?php   
                    $sql = "SELECT * from heading_table WHERE h_id=1";
                    $result = mysqli_query($conn, $sql);
                    $data = mysqli_fetch_array($result);
                ?>
                <div class="form-group">
                <input class="form-control" type="text" name="h_name" value="<?php echo $data['h_name'] ?>" placeholder="Item Name">
                </div>

                <div class="form-group">
                <input class="btn btn-primary" type="submit" name="edit_heading" value="submit">
                </div>
            </form>
        </div>
    </div>
</body>

</html>