<?php 
    include "db.inc.php"; 
    $query = "SELECT * fROM campaign_table";
    $result = mysqli_query($conn, $query);

    $qur = "SELECT * FROM heading_table";
    $rs = mysqli_query($conn, $qur);
    $dt = mysqli_fetch_array($rs);

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $item_name = $_POST['item_name'];
        $item_quantity = $_POST['item_quantity'];
        $item_price = $_POST['item_price'];
        $sql = "INSERT INTO campaign_table (item_name, item_quantity, item_price) values ('$item_name', '$item_quantity', '$item_price')";
        $exc = mysqli_query($conn, $sql);

        if (!$exc) {
            die('Failed to insert data into database');
        } else {
            header("Location:index.php?item-added");
        }
    }
    if(isset($_GET['delete_item'])) {
        $delete_item = $_GET['delete_item'];
        $sql = "DELETE from campaign_table WHERE item_id=$delete_item";
        $res = mysqli_query($conn, $sql);
        if (!$res) {
            die('Failed to delete item');
        } else {
            header("Location:index.php?item-deleted");
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
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>
    <div class="container">
            <div class="heading"> 
                <h1><?php echo $dt['h_name'] ?><a href="edit_heading.php" class="btn btn-primary"> Edit </a></h1>
            </div>
        <div class="item">
            

            <h3>Add New list</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group">
                <input class="form-control" type="text" name="item_name" placeholder="Item Name">
                </div>
                <div class="form-group">
                <input class="form-control" type="text" name="item_quantity" placeholder="Item Quantity">
                </div>
                <div class="form-group">
                <input class="form-control" type="text" name="item_price" placeholder="Item Price">
                </div>
                <div class="form-group">
                <input class="btn btn-primary" type="submit" value="submit">
                </div>
            </form>
        </div>

    

        <div class="table-responsive">
            <table class="table table-bodered table-striped">
                <thead>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </thead>
                <tbody>
                    <?php 
                    while ($row = mysqli_fetch_assoc($result)) {
                        $item_id = $row['item_id'];
                        $item_name= $row['item_name'];
                        $item_quantity= $row['item_quantity'];
                        $item_price = $row['item_price'];
                    ?>
                    <tr>
                        <th><?php echo $item_id; ?></th>
                        <th><?php echo $item_name; ?></th>
                        <th><?php echo $item_quantity; ?></th>
                        <th><?php echo $item_price; ?></th>
                        <th><a href="edit.php?edit_item=<?php echo $item_id; ?>" class="btn btn-primary">Edit</th>
                        <th><a href="index.php?delete_item=<?php echo $item_id; ?>" class="btn btn-danger">Delete</th>                    
                    </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>