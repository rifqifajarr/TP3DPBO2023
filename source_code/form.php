<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Template.php');
include('classes/Driver.php');
include('classes/Team.php');
include('classes/Car.php');

$team = new Team($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$car = new Car($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$driver = new Driver($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$number = new Driver($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$tmp_image = new Driver($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$team->open();
$car->open();
$driver->open();
$number->open();
$tmp_image->open();

$car_options = null;
$team_options = null;

$img_edit = "";
$nama_edit = "";
$number_edit = "";
$car_edit = "";
$team_edit = "";
$btn_edit = "";

$view_form = new Template('templates/skinform.html');
if (!isset($_GET['edit'])) {

    if (isset($_POST['submit'])) {
        if ($driver->addDriver($_POST, $_FILES) > 0) {
            echo "
                <script>
                    alert('Data berhasil ditambahkan!');
                    document.location.href = 'index.php';
                </script>
                ";
        } else {
            echo "
                <script>
                    alert('Data gagal ditambahkan!');
                    document.location.href = 'form.php';
                </script>
                ";
        }
    }


    $btn_edit = "Tambah";
    $car->getCar();

    // Looping for Shows the data 
    while ($row = $car->getResult()) {
        $car_options .= "<option value=" . $row['id_car'] . ">" . $row['car_name'] . "</option>";
    }



    $team->getTeam();

    // Looping for shows the data
    while ($row = $team->getResult()) {
        $team_options .= "<option value=" . $row['id_team'] . ">" . $row['team_name'] . "</option>";
    }
} else if (isset($_GET['edit'])) {
    $_ID = $_GET['edit'];
    $tmp_image->getDriver();
    $tmp_image->getDriverById($_ID);
    $number->getDriverById($_ID);
    $temp_fix = $tmp_image->getResult();
    $temp_img = $temp_fix['driver_img'];
    $btn_edit = "Ubah";

    if (isset($_POST['submit'])) {
        if ($driver->updateDriver($_ID, $_POST, $_FILES, $temp_img) > 0) {
            echo "
                <script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'index.php';
                </script>
                ";
        } else {
            echo "
                <script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'index.php';
                </script>
                ";
        }
    }
    // var_dump($_ID);
    // die();
    $driver->getDriverById($_ID);

    $row = $driver->getResult();
    $img_edit = $row['driver_img'];
    $nama_edit = $row['name'];
    $number_edit = $row['number'];
    $car_edit = $row['id_car'];
    $team_edit = $row['id_team'];

    $car->getCar();

    // Looping for Shows the data 
    while ($row = $car->getResult()) {
        $select = ($row['id_car'] == $car_edit) ? 'selected' : "";
        $car_options .= "<option value=" . $row['id_car'] . " . $select . >" . $row['car_name'] . "</option>";
    }


    // Connect to Tabel Jabatan

    $team->getTeam();

    // Looping for shows the data
    while ($row = $team->getResult()) {
        $select = ($row['id_team'] == $team_edit) ? 'selected' : "";
        $team_options .= "<option value=" . $row['id_team'] . " . $select . >" . $row['team_name'] . $row['team_principal'] . "</option>";
    }
}

$view_form->replace('IMAGE_DATA', $img_edit);
$view_form->replace('NAMA_DATA', $nama_edit);
$view_form->replace('NUMBER_DATA', $number_edit);
$view_form->replace('CAR_DATA', $car_edit);
$view_form->replace('TEAM_DATA', $team_edit);
$view_form->replace('CAR_OPTIONS', $car_options);
$view_form->replace('TEAM_OPTIONS', $team_options);
$view_form->replace('DATA_BUTTON', $btn_edit);
$view_form->write();


$driver->close();
$car->close();
$team->close();