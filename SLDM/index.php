<?php
include("db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

    <style>
        .card-img-top {
            width: 130px;
            height: 120px;
        }
        .btn,.btn-close{
            background-color: red;
        }
        .btn:hover{
            background-color: red;
        }
        .btn-close:hover{
            background-color: red;
        }
    </style>
    
</head>

<body class="bg-danger-subtle">

<nav class="navbar bg-body-tertiary border border-dark">
  <div class="container">
    <span class="navbar-brand mb-0 h1"></span>
  </div>
</nav>

    <div class="container">
        <div class="row">
            <?php
            $sql = "SELECT * FROM products";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {;
            ?>
                <div class="col-12 col-md-6 col-lg-3 mt-5">
                    <div class="card border-dark rounded-5">
                        <img src="images/<?= $row['img'] ?>" alt="" class="card-img-top container mt-3">
                        <div class="card-body d-flex justify-content-between">
                            <span class="fs-5">$<?= $row["price"] ?></span>
                            <span class="fs-5"><?= $row["name"] ?></span>
                        </div>
                        <div class="container">
                            <button class="btn w-100 mb-3 rounded-5" data-bs-toggle="modal" data-bs-target="#product-id-<?= $row["product_id"] ?>">Buy</button>
                        </div>
                    </div>
                    <div class="modal" id="product-id-<?= $row["product_id"] ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger-subtle border"><button class="btn-close" data-bs-dismiss="modal"></button></div>
                                <div class="modal-body bg-danger-subtle">
                                    <div class="card border-dark rounded-5">
                                        <img src="images/<?= $row['img'] ?>" alt="" class="card-img-top container mt-3">
                                        <div class="modal-body">
                                            <div class="modal-name d-flex justify-content-between mb-3">
                                                <span class="fs-5">$<?= $row["price"] ?></span>
                                                <span class="fs-5"><?= $row["name"] ?></span>
                                            </div>

                                            <form action="insert.php" method="get">
                                                <input type="hidden" name="product_id" value="<?=$row['product_id']?>">
                                                <div class="input-group container">
                                                    <span class="input-group-text">Price</span>
                                                    <input type="text" class="form-control" name="price" value="<?=$row['price']?>" readonly>
                                                </div>
                                                <div class="input-group container mt-3">
                                                    <span class="input-group-text">Quantity</span>
                                                    <input type="number" class="form-control" name="qty">
                                                </div>
                                                <div class="input-group container mt-3">
                                                    <span class="input-group-text">Username</span>
                                                    <input type="text" class="form-control" name="user">
                                                </div>
                                                <div class="input-group container mt-3">
                                                    <span class="input-group-text">Contact</span>
                                                    <input type="text" class="form-control" name="contact">
                                                </div>
                                                <div class="container">
                                                    <button class="btn w-100 mt-3 rounded-5" data-bs-dismiss="modal" onclick="alert('Order Placed!')">Buy</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>

</body>

</html>