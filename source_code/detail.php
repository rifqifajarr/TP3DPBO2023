<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Team.php');
include('classes/Car.php');
include('classes/Driver.php');
include('classes/Template.php');

$pengurus = new Driver($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$pengurus->open();

$data = nulL;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $pengurus->getDriverById($id);
        $row = $pengurus->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['name'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['driver_img'] . '" class="img-thumbnail" alt="' . $row['driver_img'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>' . $row['name'] . '</td>
                                </tr>
                                <tr>
                                    <td>Number</td>
                                    <td>:</td>
                                    <td>' . $row['number'] . '</td>
                                </tr>
                                <tr>
                                    <td>Team</td>
                                    <td>:</td>
                                    <td>' . $row['team_name'] . '</td>
                                </tr>
                                <tr>
                                    <td>Car</td>
                                    <td>:</td>
                                    <td>' . $row['car_name'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="form.php?edit=' . $row['id_driver'] . '"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
                <a href="detail.php?del=' . $row['id_driver'] . '"><button type="button" class="btn btn-danger">Hapus Data</button></a>
            </div>';
    }
}

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    if ($id > 0) {
        if ($pengurus->deleteDriver($id)) {
            echo
            "
            <script>
                alert('Data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>
            ";
        } else {
            echo
            "
            <script>
                alert('Data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>
            ";
        }
    }
}

$pengurus->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_PENGURUS', $data);
$detail->write();
