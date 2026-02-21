<?php
$conn = mysqli_connect("localhost", "root", "", "product_db");

$id = ""; $name = ""; $price = ""; $stocks = ""; $image = "";
$update_mode = false;

// --- GET THE NEXT AUTO-INCREMENT ID FOR PREVIEW ---
$status = mysqli_query($conn, "SHOW TABLE STATUS LIKE 'products'");
$row_status = mysqli_fetch_assoc($status);
$next_id = $row_status['Auto_increment'];

// --- ADD PRODUCT ---
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stocks = $_POST['stocks'];
   
    $image = mysqli_real_escape_string($conn, $_POST['image']); 

    mysqli_query($conn, "INSERT INTO products (name, price, stocks, image) VALUES ('$name', '$price', '$stocks', '$image')");
    header("Location: admin.php");
}

// --- UPDATE PRODUCT ---
if (isset($_POST['update_product'])) {
    $id = $_POST['id']; 
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stocks = $_POST['stocks'];
    $image = mysqli_real_escape_string($conn, $_POST['image']);

    $query = "UPDATE products SET name='$name', price='$price', stocks='$stocks', image='$image' WHERE id=$id";
    
    mysqli_query($conn, $query);
    header("Location: admin.php");
}

// --- DELETE ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: admin.php");
}

// --- EDIT ---
if (isset($_GET['edit'])) {
    $id_to_edit = $_GET['edit'];
    $update_mode = true;
    $rec = mysqli_query($conn, "SELECT * FROM products WHERE id=$id_to_edit");
    $record = mysqli_fetch_array($rec);
    $id = $record['id'];
    $name = $record['name'];
    $price = $record['price'];
    $stocks = $record['stocks'];
    $image = $record['image'];
}

$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel</title>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <style>
        /* Existing styles kept exactly as they were */
        body { 
            font-family: sans-serif; 
            background: #f4f4f4;
            margin: 0; 
        }
        header { 
            background: #589cff; 
            color: white; 
            text-align: center; 
            padding: 10px; 
            margin-top: 59px; 
        }
        .container { 
            display: flex; 
            padding: 20px; 
            gap: 20px; 
    }
        .sidebar { 
            width: 300px; 
        background: #fff; 
        padding: 20px; 
        border-radius: 8px; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
    }
        .sidebar h3 { background: #589cff; 
        color: #fff; 
        margin: -20px -20px 20px -20px; 
        padding: 10px; 
        text-align: center; 
    }
        input { 
            width: 100%; 
        padding: 8px; 
        margin: 10px 0; 
        box-sizing: border-box; 
        border: 1px solid #ccc; 
    }
        input:disabled { 
            background: #e9ecef; 
        color: #495057; 
        font-weight: bold; 
        border: 1px dashed #adb5bd; 
    }
        .main { 
            flex-grow: 1; 
    }
        table { 
            width: 100%; 
        border-collapse: collapse; 
        background: #fff; 
    }
        th, td { 
            border: 1px solid #ddd; 
        padding: 12px; 
        text-align: center; 
    }
        th { 
            background: #589cff; 
        color: white; 
    }
        img { 
            width: 60px; 
        height: auto; 
        border-radius: 4px; 
    }
        .btn-add { 
            background: gray; 
        color: white; border: none; 
        width: 100%; 
        padding: 10px; 
        cursor: pointer; 
        font-weight: bold; 
    }
        .btn-update { 
            background: gray; 
        color: white; 
        border: none; 
        width: 100%;
         padding: 10px; 
        cursor: pointer; font-weight: bold; 
    }
        .action-links a { 
            text-decoration: none; 
        padding: 5px 10px; 
        border-radius: 3px; 
        font-size: 12px; 
        color: white; 
    }
        .edit-link { 
            background: gray; 
    }
        .delete-link { 
            background: gray; 
    }
        .logo { 
            width: 15%; height: 120px; 
    }
    </style>
  </head>
  <body>
    <header data-bs-theme="dark">
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
          <img src="logo.png" alt="" class="logo" >
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
              <li class="nav-item"><a class="nav-link" href="home.html">Home</a></li>
              <li class="nav-item"><a class="nav-link" href="Product.php">Product</a></li>
              <li class="nav-item"><a class="nav-link" href="About.html">About</a></li>
              <li class="nav-item"><a class="nav-link" href="ContactUs.html">Contact Us</a></li>
              <li class="nav-item"><a class="nav-link active" href="admin.php">Admin</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <main>
      <header><h1>ADMIN PANEL</h1></header>

      <div class="container">
        <div class="sidebar">
          <h3><?php echo $update_mode ? "EDIT PRODUCT" : "ADD PRODUCT"; ?></h3>
          <form method="POST">
            <label>ID </label>
            <input type="text" value="<?php echo $update_mode ? $id : $next_id; ?>" disabled>
            
            <?php if($update_mode): ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
            <?php endif; ?>
            
            <label>Product Name</label>
            <input type="text" name="name" value="<?php echo $name; ?>" required>
            
            <label>Price</label>
            <input type="text" name="price" value="<?php echo $price; ?>" required>
            
            <label>Stocks</label>
            <input type="number" name="stocks" value="<?php echo $stocks; ?>" required>
            
            <label>Product Image </label>
            <input type="text" name="image" value="<?php echo $image; ?>" required>

            <?php if ($update_mode): ?>
                <button type="submit" name="update_product" class="btn-update">Update Product</button>
                <p style="text-align:center;"><a href="admin.php" style="font-size: 12px; color: #666;">Cancel Edit</a></p>
            <?php else: ?>
                <button type="submit" name="add_product" class="btn-add">Add Product</button>
            <?php endif; ?>
          </form>
        </div>

        <div class="main">
          <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stocks</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td>P<?php echo number_format($row['price'], 2); ?></td>
                <td><?php echo $row['stocks']; ?></td>
                <td><img src="<?php echo $row['image']; ?>" alt="product"></td>
                <td class="action-links">
                    <a href="admin.php?edit=<?php echo $row['id']; ?>" class="edit-link">Edit</a>
                    <a href="admin.php?delete=<?php echo $row['id']; ?>" class="delete-link" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
          </table>
        </div>
      </div>
    </main>
  </body>
</html>