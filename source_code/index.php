<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Team.php');
include('classes/Car.php');
include('classes/Driver.php');
include('classes/Template.php');

// buat instance driver
$listdriver = new Driver($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listdriver->open();
// tampilkan data driver
$listdriver->getDriverJoin();

// cari driver
if (isset($_POST['btn-cari'])) {
    // methode mencari data driver
    $listdriver->searchDriver($_POST['cari']);
} else if (isset($_POST['btn-filter'])) {
    $listdriver->sortDriver($_POST['filter']);
} else {
    // method menampilkan data driver
    $listdriver->getDriverJoin();
}

$data = null;

// ambil data driver
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listdriver->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 pengurus-thumbnail">
        <a href="detail.php?id=' . $row['id_driver'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['driver_img'] . '" class="card-img-top" alt="' . $row['driver_img'] . '">
            </div>
            <div class="card-body">
                <p class="card-text pengurus-nama my-0">' . $row['name'] . '</p>
                <p class="card-text divisi-nama">' . $row['team_name'] . '</p>
                <p class="card-text jabatan-nama my-0">Number: ' . $row['number'] . '</p>
                <p class="card-text jabatan-nama my-0">Car: ' . $row['car_name'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}

// tutup koneksi
$listdriver->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_PENGURUS', $data);
$home->write();
