<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Car.php');
include('classes/Template.php');

$divisi = new Car($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$divisi->open();
$divisi->getCar();

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($divisi->addCar($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'car.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'car.php';
            </script>";
        }
    }

    $btn = 'Add';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel2.html');

$mainTitle = 'Car';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Car Name</th>
<th scope="row">Action</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'Car';

while ($div = $divisi->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['car_name'] . '</td>
    <td style="font-size: 22px;">
        <a href="car.php?id=' . $div['id_car'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="car.php?hapus=' . $div['id_car'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($divisi->updateCar($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'car.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'car.php';
            </script>";
            }
        }

        $divisi->getCarById($id);
        $row = $divisi->getResult();

        $dataUpdate = $row['car_name'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($divisi->deleteCar($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'car.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'car.php';
            </script>";
        }
    }
}

$divisi->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();
