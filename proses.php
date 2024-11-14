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


    // Step 2: Kurangin dengan FIFO
    $remaining_quantity = $jumlah;

    // ambil data inv terlama
    $fetchInventory = "SELECT id_inventory, jumlah, kode_pembelian FROM inventory WHERE id_produk = ? ORDER BY tanggal_masuk ASC";
    $stmt = $conn->prepare($fetchInventory);
    $stmt->bind_param("i", $id_produk);
    // Execute the query and check for errors
    if (!$stmt->execute()) {
        echo "Error executing query: " . $stmt->error;
        return;
    }
    // Retrieve the result set and check if any rows were returned
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "No inventory available for this product!";
        return;
    }

    // Process semua batch
    while ($row = $result->fetch_assoc()) {
        if ($remaining_quantity <= 0)
            break;
        $id_inventory = $row['id_inventory'];
        $batch_quantity = $row['jumlah'];
        $quantity_taken = min($remaining_quantity, $batch_quantity);
        $new_quantity = $batch_quantity - $quantity_taken;
        // Update  inventory record
        $updateInventory = "UPDATE inventory SET jumlah = ? WHERE id_inventory = ?";
        $updateStmt = $conn->prepare($updateInventory);
        $updateStmt->bind_param("ii", $new_quantity, $id_inventory);
        $updateStmt->execute();
        $updateStmt->close();

        // Insert ke tabel penjualan
        $sale_date = $tanggal_penjualan;
        $insertSale = "INSERT INTO penjualan (id_produk, jumlah, harga_jual, tanggal_penjualan, kategori_obat, kode_penjualan, id_pengguna, kode_pembelian) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($insertSale);
        $stmt->bind_param("iiisssis", $id_produk, $quantity_taken, $harga_jual, $sale_date, $kategori_obat, $kode_penjualan, $id_pengguna, $row['kode_pembelian']);
        $stmt->execute();
        $stmt->close();

        $remaining_quantity -= $quantity_taken;

        if ($new_quantity == 0) {
            $deleteInventory = "DELETE FROM inventory WHERE id_inventory = ?";
            $deleteStmt = $conn->prepare($deleteInventory);
            $deleteStmt->bind_param("i", $id_inventory);
            $deleteStmt->execute();
            $deleteStmt->close();
        }

    }
}

function deleteSale($kode_penjualan, $conn)
{
    // Step 1: Fetch batch details for the sale
    $fetchDetails = "SELECT id_penjualan, jumlah, id_produk FROM penjualan WHERE kode_penjualan = ?";
    $stmt = $conn->prepare($fetchDetails);
    $stmt->bind_param("s", $kode_penjualan);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if sale exists
    if ($result->num_rows === 0) {
        echo "Penjualan tidak ada";
        return;
    }

    // Step 2: Restore inventory based on `sale_details` entries
    while ($row = $result->fetch_assoc()) {
        $id_penjualan = $row['id_penjualan'];
        $jumlah = $row['jumlah'];
        $id_produk = $row['id_produk'];

        // Update the inventory by adding back the quantity taken
        $restoreInventory = "UPDATE inventory SET jumlah = jumlah + ? WHERE id_produk = ? ORDER BY tanggal_masuk ASC LIMIT 1";
        $updateStmt = $conn->prepare($restoreInventory);
        $updateStmt->bind_param("ii", $jumlah, $id_produk);
        $updateStmt->execute();
        $updateStmt->close();
    }

    // Close the result set and statement
    $stmt->close();
    // Step 4: Delete the sale record from the `sales` table
    $deleteSale = "DELETE FROM penjualan WHERE kode_penjualan = ?";
    $stmt = $conn->prepare($deleteSale);
    $stmt->bind_param("s", $kode_penjualan);
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
        $satuan = $_POST['satuan'];
        // generate product code based on $satuan
        $kode_produk = strtoupper(substr($satuan, 0, 3));
        // find last product code
        $query = mysqli_query($conn, "SELECT MAX(kode_produk) AS kode_produk FROM produk WHERE kode_produk LIKE '$kode_produk%'");
        $data = mysqli_fetch_array($query);
        $max = $data['kode_produk'] ? substr($data['kode_produk'], 4, 3) : "000";
        $no = $max + 1;
        $char = $kode_produk . "-";
        $kode_produk = $char . sprintf("%03s", $no);
        $nama_produk = $_POST['nama_produk'];
        $deskripsi = $_POST['deskripsi'];
        $harga_beli = $_POST['harga_beli'];
        $harga_beli = preg_replace('/[^0-9]/', '', $_POST['harga_beli']);
        $harga_jual = $_POST['harga_jual'];
        $harga_jual = preg_replace('/[^0-9]/', '', $_POST['harga_jual']);
        $golongan_obat = $_POST['golongan_obat'];
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $path = 'assets/images/product/' . $foto;
        move_uploaded_file($tmp, $path);

        $sql = "INSERT INTO produk (nama_produk, kode_produk, deskripsi, harga_beli, harga_jual, satuan, foto, golongan_obat) 
        VALUES ('$nama_produk','$kode_produk', '$deskripsi', '$harga_beli', '$harga_jual', '$satuan', '$path', '$golongan_obat')";
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
        $harga_beli = preg_replace('/[^0-9]/', '', $_POST['harga_beli']);
        $harga_jual = $_POST['harga_jual'];
        $harga_jual = preg_replace('/[^0-9]/', '', $_POST['harga_jual']);
        $satuan = $_POST['satuan'];
        $satuan_lama = $_POST['satuan_lama'];
        $golongan_obat = $_POST['golongan_obat'];
        $kode_produk = $_POST['kode_produk'];
        // jika satuan berubah
        if ($satuan != $satuan_lama) {
            $generator_kode_produk = strtoupper(substr($satuan, 0, 3));
            $query = mysqli_query($conn, "SELECT MAX(kode_produk) AS kode_produk FROM produk WHERE kode_produk LIKE '$generator_kode_produk%'");
            $data = mysqli_fetch_array($query);
            $max = $data['kode_produk'] ? substr($data['kode_produk'], 4, 3) : "000";
            $no = $max + 1;
            $char = $generator_kode_produk . "-";
            $kode_produk = $char . sprintf("%03s", $no);
        }

        $sql = "UPDATE produk SET kode_produk = '$kode_produk', nama_produk = '$nama_produk', deskripsi = '$deskripsi', harga_beli = '$harga_beli', harga_jual
= '$harga_jual', satuan = '$satuan', golongan_obat = '$golongan_obat' WHERE id_produk = '$id'";
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
        $harga_beli = preg_replace('/[^0-9]/', '', $_POST['harga_beli']);
        $harga_beli = substr($harga_beli, 0, -2);
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
        $harga_jual = preg_replace('/[^0-9]/', '', $_POST['harga_jual']);
        $harga_jual = substr($harga_jual, 0, -2);
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
        deleteSale($kode_penjualan, $conn);
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
    case 'tambah-return-pembelian':
        $kode_pembelian = $_POST['kode_pembelian'];
        $jumlah = $_POST['jumlah'];
        $harga_beli = $_POST['harga_beli'];
        $harga_beli = preg_replace('/[^0-9]/', '', $_POST['harga_beli']);
        $id_supplier = $_POST['id_supplier'];
        $tanggal_return = $_POST['tanggal_return'];
        $id_produk = $_POST['id_produk'];
        $sql = "INSERT INTO `apotik`.`return_pembelian` 
        (`kode_pembelian`, `jumlah`, `harga_beli`, `id_supplier`, `tanggal_return`, `id_produk`) 
        VALUES ('$kode_pembelian', '$jumlah', '$harga_beli', '$id_supplier', '$tanggal_return', '$id_produk')";
        $result = $conn->query($sql);
        // check to inventory
        $sql = "SELECT * FROM `inventory` WHERE `id_produk` = '$id_produk' AND `kode_pembelian` = '$kode_pembelian'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['jumlah'] >= $jumlah) {
                $jumlahInventory = $row['jumlah'] - $jumlah;
                $sql = "UPDATE `inventory` SET `jumlah` = '$jumlahInventory' WHERE `id_produk` = '$id_produk' AND `kode_pembelian` = '$kode_pembelian'";
                $conn->query($sql);
                // insert to transaksi
                $totalReturn = $jumlah * $harga_beli;
                $kodetransaksi = 'RT' . rand(1000, 9999);
                $sql = "INSERT INTO `apotik`.`transaksi` (`id_akun_debit`, `id_akun_kredit`, kode_transaksi, `total`, `deskripsi`, `tanggal_transaksi`) 
                VALUES ('1', '2', '$kodetransaksi', '$totalReturn', 'Return Pembelian - $kode_pembelian', '$tanggal_return')";
                $conn->query($sql);
            }
        }
        if ($result) {
            header('location:index.php?page=return-pembelian');
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data transaksi gagal dihapus']);
        }
        break;
    case 'hapus-return-pembelian':
        $id_return_pembelian = $_POST['id_return_pembelian'];
        $kode_pembelian = $_POST['kode_pembelian'];
        $jumlah = $_POST['jumlah'];
        $sql = "DELETE FROM `apotik`.`return_pembelian` WHERE `id_return_pembelian` = '$id_return_pembelian'";
        $result = $conn->query($sql);
        // delete from transaksi
        $sql = "DELETE FROM `apotik`.`transaksi` WHERE `deskripsi` = 'Return Pembelian - $kode_pembelian'";
        $result = $conn->query($sql);
        // check to inventory
        $sql = "SELECT * FROM `inventory` WHERE kode_pembelian = '$kode_pembelian'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $jumlahInventory = $row['jumlah'] + $jumlah;
            $sql = "UPDATE `inventory` SET `jumlah` = '$jumlahInventory' WHERE `kode_pembelian` = '$kode_pembelian'";
            $conn->query($sql);
        }
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data transaksi berhasil dihapus']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data transaksi gagal dihapus']);
        }
        break;
    case 'tambah-return-penjualan':
        $kode_penjualan = $_POST['kode_penjualan'];
        $jumlah = $_POST['jumlah'];
        $harga_jual = $_POST['harga_jual'];
        $harga_jual = preg_replace('/[^0-9]/', '', $_POST['harga_jual']);
        $tanggal_return = $_POST['tanggal_return'];
        $id_produk = $_POST['id_produk'];
        $sql = "INSERT INTO `apotik`.`return_penjualan` 
        (`kode_penjualan`, `jumlah`, `harga_jual`, `tanggal_return`, `id_produk`) 
        VALUES ('$kode_penjualan', '$jumlah', '$harga_jual','$tanggal_return', '$id_produk')";
        $result = $conn->query($sql);
        // check to penjualan
        $sql = "SELECT * FROM `penjualan` WHERE `id_produk` = '$id_produk' AND `kode_penjualan` = '$kode_penjualan'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['jumlah'] >= $jumlah) {
                $jumlahInventory = $row['jumlah'] - $jumlah;
                $sql = "UPDATE `penjualan` SET `jumlah` = '$jumlahInventory' WHERE `id_produk` = '$id_produk' AND `kode_penjualan` = '$kode_penjualan'";
                $conn->query($sql);
                // insert to transaksi
                $totalReturn = $jumlah * $harga_jual;
                $kodetransaksi = 'RT' . rand(1000, 9999);
                $sql = "INSERT INTO `apotik`.`transaksi` (`id_akun_debit`, `id_akun_kredit`, kode_transaksi, `total`, `deskripsi`, `tanggal_transaksi`) 
                VALUES ('2', '1', '$kodetransaksi', '$totalReturn', 'Return Penjualan - $kode_penjualan', '$tanggal_return')";
                $conn->query($sql);
            }
        }
        if ($result) {
            header('location:index.php?page=return-penjualan');
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data transaksi gagal dihapus']);
        }
        break;
    case 'hapus-return-penjualan':
        $id_return_penjualan = $_POST['id_return_penjualan'];
        $kode_penjualan = $_POST['kode_penjualan'];
        $jumlah = $_POST['jumlah'];
        $sql = "DELETE FROM `apotik`.`return_penjualan` WHERE `id_return_penjualan` = '$id_return_penjualan'";
        $result = $conn->query($sql);
        // delete from transaksi
        $sql = "DELETE FROM `apotik`.`transaksi` WHERE `deskripsi` = 'Return Pembelian - $kode_penjualan'";
        $result = $conn->query($sql);
        // check to inventory
        $sql = "SELECT * FROM `penjualan` WHERE kode_penjualan = '$kode_penjualan'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $jumlahInventory = $row['jumlah'] + $jumlah;
            $sql = "UPDATE `penjualan` SET `jumlah` = '$jumlahInventory' WHERE `kode_penjualan` = '$kode_penjualan'";
            $conn->query($sql);
        }
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Data transaksi berhasil dihapus']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Data transaksi gagal dihapus']);
        }
        break;


}