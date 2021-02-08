<?php 
    include "db.inc.php"; 
    if(isset($_GET['edit_item'])) {
        $edit_id = $_GET['edit_item'];
    }
    if(isset($_POST['edit_item'])) {
        $edit_name = $_POST['item_name'];     
        $edit_quantity = $_POST['item_quantity'];     
        $edit_price = $_POST['item_price']; 

        $query = "UPDATE campaign_table SET item_name='$edit_name', item_quantity='$edit_quantity', item_price='$edit_price' WHERE item_id=$edit_id";
        $run = mysqli_query($conn, $query);

        if(!$run) {
            die("Failed");
        } else {
            header("Location:index.php?updated-item");
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
            <h1>Name of the Campaign</h1>
            <h3>Add a New list</h3>
            <form action="" method="POST">
                <?php   
                    $sql = "SELECT * FROM campaign_table WHERE item_id = $edit_id";
                    $result = mysqli_query($conn, $sql);
                    $data = mysqli_fetch_array($result);
                ?>
                <div class="form-group">
                <input class="form-control" type="text" name="item_name" value="<?php echo $data['item_name']; ?>" placeholder="Item Name">
                </div>
                <div class="form-group">
                <input class="form-control" type="text" name="item_quantity" value="<?php echo $data['item_quantity']; ?>" placeholder="Item Quantity">
                </div>
                <div class="form-group">
                <input class="form-control" type="text" name="item_price" value="<?php echo $data['item_price']; ?>" placeholder="Item Price">
                </div>
                <div class="form-group">
                <input class="btn btn-primary" type="submit" name="edit_item" value="submit">
                </div>
            </form>
        </div>
    </div>
</body>

</html>