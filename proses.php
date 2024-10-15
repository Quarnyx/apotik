<?php
function tambahTransaksi($id_akun_debit, $id_akun_kredit, $total, $deskripsi, $tanggal_transaksi, $kode_transaksi, $conn)
{
    $sql = "INSERT INTO transaksi (id_akun_debit, id_akun_kredit, total, deskripsi, tanggal_transaksi, kode_transaksi) 
    VALUES ('$id_akun_debit', '$id_akun_kredit', '$total', '$deskripsi', '$tanggal_transaksi', '$kode_transaksi')";
    $result = $conn->query($sql);
    if ($result) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}
function hapusTransaksi($id, $conn)
{
    $sql = "DELETE FROM transaksi WHERE kode_transaksi = '$id'";
    $result = $conn->query($sql);
    if ($result) {
        http_response_code(200);
    } else {
        http_response_code(500);
        echo $conn->error;
    }
}
function handleSale($id_produk, $jumlah, $harga_jual, $tanggal_penjualan, $kategori_obat, $kode_penjualan, $id_pengguna, $conn)
{
    // Step 1: Insert ke tabel penjualan
    $sale_date = $tanggal_penjualan;
    $insertSale = "INSERT INTO penjualan (id_produk, jumlah, harga_jual, tanggal_penjualan, kategori_obat, kode_penjualan, id_pengguna) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($insertSale);
    $stmt->bind_param("iiisssi", $id_produk, $jumlah, $harga_jual, $sale_date, $kategori_obat, $kode_penjualan, $id_pengguna);
    $stmt->execute();
    $stmt->close();

    // Step 2: Kurangin dengan FIFO
    $remaining_quantity = $jumlah;

    // ambil data inv terlama
    $fetchInventory = "SELECT id_inventory, jumlah FROM inventory WHERE id_produk = ? ORDER BY tanggal_masuk ASC";
    $stmt = $conn->prepare($fetchInventory);
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();

    // Process semua batch
    while ($row = $result->fetch_assoc()) {
        $id_inventory = $row['id_inventory'];
        $batch_quantity = $row['jumlah'];

        // If the batch jumlah is enough to cover the remaining sale jumlah
        if ($batch_quantity >= $remaining_quantity) {
            // Deduct the remaining jumlah from this batch
            $new_quantity = $batch_quantity - $remaining_quantity;

            // Update the inventory record
            $updateInventory = "UPDATE inventory SET jumlah = ? WHERE id_inventory = ?";
            $updateStmt = $conn->prepare($updateInventory);
            $updateStmt->bind_param("ii", $new_quantity, $id_inventory);
            $updateStmt->execute();
            $updateStmt->close();

            // If this batch is now empty, delete the record (optional)
            if ($new_quantity == 0) {
                $deleteInventory = "DELETE FROM inventory WHERE id_inventory = ?";
                $deleteStmt = $conn->prepare($deleteInventory);
                $deleteStmt->bind_param("i", $id_inventory);
                $deleteStmt->execute();
                $deleteStmt->close();
            }

            // Sale fully processed
            break;

        } else {
            // Deduct the entire batch jumlah and continue to the next batch
            $remaining_quantity -= $batch_quantity;

            // Delete this batch since it's fully consumed
            $deleteInventory = "DELETE FROM inventory WHERE id_inventory = ?";
            $deleteStmt = $conn->prepare($deleteInventory);
            $deleteStmt->bind_param("i", $id_inventory);
            $deleteStmt->execute();
            $deleteStmt->close();
        }
    }

    $stmt->close();
}
function deleteSale($id_penjualan, $conn)
{
    // Step 1: Fetch the sale details
    $fetchSale = "SELECT id_produk, jumlah FROM penjualan WHERE id_penjualan = ?";
    $stmt = $conn->prepare($fetchSale);
    $stmt->bind_param("i", $id_penjualan);
    $stmt->execute();
    $result = $stmt->get_result();

    // If sale not found, exit
    if ($result->num_rows === 0) {
        echo "Sale not found!";
        return;
    }

    $sale = $result->fetch_assoc();
    $id_produk = $sale['id_produk'];
    $jumlah = $sale['jumlah'];

    $stmt->close();

    // Step 2: Restore inventory in reverse FIFO order (latest deducted batch gets restored first)
    $remaining_quantity = $jumlah;

    // Fetch the inventory batches in reverse order (from most recent to oldest)
    $fetchInventory = "SELECT id_inventory, jumlah FROM inventory WHERE id_produk = ? ORDER BY tanggal_masuk DESC";
    $stmt = $conn->prepare($fetchInventory);
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();

    // Restore the sold jumlah to inventory
    while (($row = $result->fetch_assoc()) !== false && $remaining_quantity > 0) {
        $id_inventory = $row['id_inventory'];
        $batch_quantity = $row['jumlah'];

        // Find how much to restore (either all of the remaining sale jumlah or enough to match batch capacity)
        $restore_quantity = min($remaining_quantity, $batch_quantity);

        // Update the inventory by adding back the restore jumlah
        $updateInventory = "UPDATE inventory SET jumlah = jumlah + ? WHERE id_inventory = ?";
        $updateStmt = $conn->prepare($updateInventory);
        $updateStmt->bind_param("ii", $restore_quantity, $id_inventory);
        $updateStmt->execute();
        $updateStmt->close();

        // Subtract the restored jumlah from the remaining amount
        $remaining_quantity -= $restore_quantity;
    }

    $stmt->close();

    // Step 3: Delete the sale record
    $deleteSale = "DELETE FROM penjualan WHERE id_penjualan = ?";
    $stmt = $conn->prepare($deleteSale);
    $stmt->bind_param("i", $id_penjualan);
    $stmt->execute();
    $stmt->close();
}




require_once 'config.php';
switch ($_GET['aksi'] ?? '') {
    case 'tambah-pengguna':
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $nama = $_POST['nama'];
        $level = $_POST['level'];
        $sql = "INSERT INTO pengguna (username, password, level, nama) VALUES ('$username', '$password', '$level', '$nama')";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'hapus-pengguna':
        $id = $_POST['id'];
        $sql = "DELETE FROM pengguna WHERE id_pengguna = '$id'";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'edit-pengguna':
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $level = $_POST['level'];
        $sql = "UPDATE pengguna SET username = '$username', level = '$level', nama = '$nama' WHERE id_pengguna = '$id'";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'ganti-password':
        $id = $_POST['id'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE pengguna SET password = '$password' WHERE id_pengguna = '$id'";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'tambah-supplier':
        $nama_supplier = $_POST['nama_supplier'];
        $kontak_supplier = $_POST['kontak'];
        $alammat = $_POST['alamat'];
        $sql = "INSERT INTO supplier (nama_supplier, kontak_supplier, alamat) VALUES ('$nama_supplier', '$kontak_supplier', '$alammat')";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'edit-supplier':
        $id = $_POST['id'];
        $nama_supplier = $_POST['nama_supplier'];
        $kontak_supplier = $_POST['kontak'];
        $alammat = $_POST['alamat'];
        $sql = "UPDATE supplier SET alamat = '$alammat', nama_supplier = '$nama_supplier', kontak_supplier = '$kontak_supplier' WHERE id_supplier =
'$id'";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'hapus-supplier':
        $id = $_POST['id'];
        $sql = "DELETE FROM supplier WHERE id_supplier = '$id'";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'tambah-produk':
        $nama_produk = $_POST['nama_produk'];
        $deskripsi = $_POST['deskripsi'];
        $kode_produk = $_POST['kode_produk'];
        $harga_beli = $_POST['harga_beli'];
        $harga_jual = $_POST['harga_jual'];
        $satuan = $_POST['satuan'];
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $path = 'assets/images/product/' . $foto;
        move_uploaded_file($tmp, $path);

        $sql = "INSERT INTO produk (nama_produk, kode_produk, deskripsi, harga_beli, harga_jual, satuan, foto) VALUES ('$nama_produk',
'$kode_produk', '$deskripsi', '$harga_beli', '$harga_jual', '$satuan', '$path')";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'edit-produk':
        $id = $_POST['id'];
        $nama_produk = $_POST['nama_produk'];
        $deskripsi = $_POST['deskripsi'];
        $harga_beli = $_POST['harga_beli'];
        $harga_jual = $_POST['harga_jual'];
        $satuan = $_POST['satuan'];
        $sql = "UPDATE produk SET nama_produk = '$nama_produk', deskripsi = '$deskripsi', harga_beli = '$harga_beli', harga_jual
= '$harga_jual', satuan = '$satuan' WHERE id_produk = '$id'";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'edit-foto-produk':
        $id = $_POST['id'];
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $path = 'assets/images/product/' . $foto;
        move_uploaded_file($tmp, $path);
        $sql = "UPDATE produk SET foto = '$path' WHERE id_produk = '$id'";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
        }
        break;
    case 'hapus-produk':
        $id = $_POST['id'];
        $sql = "DELETE FROM produk WHERE id_produk = '$id'";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'tambah-akun':
        $nama_akun = $_POST['nama_akun'];
        $jenis_akun = $_POST['jenis_akun'];
        $kode_akun = $_POST['kode_akun'];
        $sql = "INSERT INTO akun (nama_akun, jenis_akun,kode_akun) VALUES ('$nama_akun', '$jenis_akun', '$kode_akun')";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'edit-akun':
        $id = $_POST['id'];
        $nama_akun = $_POST['nama_akun'];
        $jenis_akun = $_POST['jenis_akun'];
        $kode_akun = $_POST['kode_akun'];
        $sql = "UPDATE akun SET nama_akun = '$nama_akun',jenis_akun = '$jenis_akun',kode_akun = '$kode_akun' WHERE id_akun =
'$id'";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'hapus-akun':
        $id = $_POST['id'];
        $sql = "DELETE FROM akun WHERE id_akun = '$id'";
        $result = $conn->query($sql);
        if ($result) {
            echo 'ok';
            http_response_code(200);
        } else {
            echo 'error';
            echo $conn->error;
            http_response_code(400);
        }
        break;
    case 'tambah-pembelian':
        $id_akun_debit = $_POST['id_akun_debit'];
        $id_akun_kredit = $_POST['id_akun_kredit'];
        $id_produk = $_POST['id_produk'];
        $id_supplier = $_POST['id_supplier'];
        $kode_pembelian = $_POST['kode_pembelian'];
        $harga_beli = $_POST['harga_beli'];
        $jumlah = $_POST['jumlah'];
        $total = $harga_beli * $jumlah;
        $deskripsi = 'Pembelian' . $kode_pembelian;
        $tanggal_pembelian = $_POST['tanggal_pembelian'];
        $tanggal_kadaluarsa = $_POST['tanggal_kadaluarsa'];
        $id_pengguna = $_POST['id_pengguna'];
        // input ke tabel transaksi
        tambahTransaksi($id_akun_debit, $id_akun_kredit, $total, $deskripsi, $tanggal_pembelian, $kode_pembelian, $conn);
        // inpute ke inventory
        $sql = "INSERT INTO inventory (id_produk, jumlah, harga_beli, tanggal_masuk, tanggal_kadaluarsa, kode_pembelian)
VALUES ('$id_produk', '$jumlah', '$harga_beli', '$tanggal_pembelian', '$tanggal_kadaluarsa', '$kode_pembelian')";
        $result = $conn->query($sql);
        // input ke tabel pembelian
        $sql = "INSERT INTO pembelian (id_supplier, id_produk, jumlah, harga_beli, kode_pembelian, id_pengguna, tanggal_masuk,
tanggal_kadaluarsa)
VALUES ('$id_supplier', '$id_produk', '$jumlah', '$harga_beli', '$kode_pembelian', '$id_pengguna', '$tanggal_pembelian',
'$tanggal_kadaluarsa')";
        $result = $conn->query($sql);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data penjualan berhasil ditambahkan']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data penjualan gagal ditambahkan']);
        }
        break;
    case 'hapus-pembelian':
        $kode_transaksi = $_POST['kode_transaksi'];
        $sql = "DELETE FROM pembelian WHERE kode_pembelian = '$kode_transaksi'";
        $result = $conn->query($sql);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data penjualan berhasil dihapus']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data penjualan gagal dihapus']);
        }
        $sql = "DELETE FROM inventory WHERE kode_pembelian = '$kode_transaksi'";
        $result = $conn->query($sql);
        hapusTransaksi($kode_transaksi, $conn);

        break;
    case 'tambah-penjualan':
        $id_produk = $_POST['id_produk'];
        $jumlah = $_POST['jumlah'];
        $harga_jual = $_POST['harga_jual'];
        $harga_beli = $_POST['harga_beli'];
        $tanggal_penjualan = $_POST['tanggal_penjualan'];
        $kode_penjualan = $_POST['kode_penjualan'];
        $kategori_obat = $_POST['kategori_obat'];
        $id_pengguna = $_POST['id_pengguna'];
        $total = $harga_jual * $jumlah;
        $deskripsi = 'Penjualan' . $kode_penjualan;


        handleSale($id_produk, $jumlah, $harga_jual, $tanggal_penjualan, $kategori_obat, $kode_penjualan, $id_pengguna, $conn);
        // hpp-persediaan
        $id_akun_debit = 5;
        $id_akun_kredit = 2;
        tambahTransaksi($id_akun_debit, $id_akun_kredit, $total, $deskripsi, $tanggal_penjualan, $kode_penjualan, $conn);

        // kas-pendapatan
        $id_akun_debit = 1;
        $id_akun_kredit = 7;
        $total = $_POST['harga_beli'] * $jumlah;
        tambahTransaksi($id_akun_debit, $id_akun_kredit, $total, $deskripsi, $tanggal_penjualan, $kode_penjualan, $conn);
        echo json_encode(['status' => 'success', 'message' => 'Data penjualan berhasil ditambahkan']);




        break;
    case 'hapus-penjualan':
        $id_penjualan = $_POST['id_penjualan'];
        $kode_penjualan = $_POST['kodetransaksi'];
        deleteSale($id_penjualan, $conn);
        hapusTransaksi($kode_penjualan, $conn);
        echo json_encode(['status' => 'success', 'message' => 'Data penjualan berhasil dihapus']);
        break;

    case 'tambah-transaksi':
        $id_akun_debit = $_POST['id_akun_debit'];
        $id_akun_kredit = $_POST['id_akun_kredit'];
        $total = $_POST['total'];
        $deskripsi = $_POST['deskripsi'];
        $tanggal_transaksi = $_POST['tanggal_transaksi'];
        $kode_penjualan = 'JRNL' . rand(1000, 9999);
        tambahTransaksi($id_akun_debit, $id_akun_kredit, $total, $deskripsi, $tanggal_transaksi, $kode_penjualan, $conn);
        echo json_encode(['status' => 'success', 'message' => 'Data transaksi berhasil ditambahkan']);
        break;
    case 'edit-transaksi':
        $id = $_POST['id'];
        $id_akun_debit = $_POST['id_akun_debit'];
        $id_akun_kredit = $_POST['id_akun_kredit'];
        $total = $_POST['total'];
        $deskripsi = $_POST['deskripsi'];
        $tanggal_transaksi = $_POST['tanggal_transaksi'];
        $sql = "UPDATE transaksi SET id_akun_debit = '$id_akun_debit', id_akun_kredit = '$id_akun_kredit', total = '$total', deskripsi = '$deskripsi', tanggal_transaksi = '$tanggal_transaksi' WHERE id_transaksi = '$id'";
        $result = $conn->query($sql);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data transaksi berhasil ditambahkan']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data transaksi gagal ditambahkan']);
        }
        break;
    case 'hapus-transaksi':
        $id = $_POST['id'];
        $sql = "DELETE FROM transaksi WHERE id_transaksi = '$id'";
        $result = $conn->query($sql);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data transaksi berhasil dihapus']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data transaksi gagal dihapus']);
        }
        break;


}