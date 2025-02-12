<?php
session_start();
include 'db.php';

// Handle Create operation
if (isset($_POST['add_barang'])) {
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $stmt = $conn->prepare("INSERT INTO barang (Nama_Barang, Harga, Stok) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $nama_barang, $harga, $stok);
    $stmt->execute();
}

// Handle Update operation
if (isset($_POST['update_barang'])) {
    $barang_id = $_POST['barang_id'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $stmt = $conn->prepare("UPDATE barang SET Nama_Barang=?, Harga=?, Stok=? WHERE Barang_ID=?");
    $stmt->bind_param("siii", $nama_barang, $harga, $stok, $barang_id);
    $stmt->execute();
}

// Handle Delete operation
if (isset($_GET['delete'])) {
    $barang_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM barang WHERE Barang_ID=?");
    $stmt->bind_param("i", $barang_id);
    $stmt->execute();
}

// Fetch all barang records
$result = $conn->query("SELECT * FROM barang");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Dashboard - Manage Barang</h2>

    <!-- Add Barang Form -->
    <form method="post" action="">
        <div class="form-group">
            <label for="nama_barang">Nama Barang:</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
        </div>
        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="number" class="form-control" id="harga" name="harga" required>
        </div>
        <div class="form-group">
            <label for="stok">Stok:</label>
            <input type="number" class="form-control" id="stok" name="stok" required>
        </div>
        <button type="submit" name="add_barang" class="btn btn-primary">Add Barang</button>
    </form>
    <?php if(isset($_SESSION['loggedin'])){ ?>
      <a href="logout.php" onclick="logout()" class="btn btn-secondary ml-auto">Logout</a>
     <?php } ?>

    <!-- Display Barang Table -->
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Barang ID</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['Barang_ID']; ?></td>
                    <td><?php echo $row['Nama_Barang']; ?></td>
                    <td><?php echo number_format($row['Harga']); ?></td>
                    <td><?php echo $row['Stok']; ?></td>
                    <td>
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?php echo $row['Barang_ID']; ?>">Edit</button>

                        <!-- Delete Button -->
                        <a href="?delete=<?php echo $row['Barang_ID']; ?>" class="btn btn-danger">Delete</a>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?php echo $row['Barang_ID']; ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Barang</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" action="">
                                        <div class="modal-body">
                                            <input type="hidden" name="barang_id" value="<?php echo $row['Barang_ID']; ?>">
                                            <div class="form-group">
                                                <label for="edit_nama_barang">Nama Barang:</label>
                                                <input type="text" class="form-control" id="edit_nama_barang" name="nama_barang" value="<?php echo $row['Nama_Barang']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_harga">Harga:</label>
                                                <input type="number" class="form-control" id="edit_harga" name="harga" value="<?php echo $row['Harga']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_stok">Stok:</label>
                                                <input type="number" class="form-control" id="edit_stok" name="stok" value="<?php echo $row['Stok']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="update_barang" class="btn btn-primary">Update</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
