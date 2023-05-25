<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Team.php');
include('classes/Template.php');

$divisi = new Team($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$divisi->open();
$divisi->getTeam();

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($divisi->addTeam($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'team.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'team.php';
            </script>";
        }
    }

    $btn = 'Add';
    $title = 'Add';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Team';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Team Name</th>
<th scope="row">Team Principal</th>
<th scope="row">Action</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'Team';

while ($div = $divisi->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['team_name'] . '</td>
    <td>' . $div['team_principal'] . '</td>
    <td style="font-size: 22px;">
        <a href="team.php?id=' . $div['id_team'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="team.php?hapus=' . $div['id_team'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($divisi->updateTeam($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'team.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'team.php';
            </script>";
            }
        }

        $divisi->getTeamById($id);
        $row = $divisi->getResult();

        $dataUpdate = $row['team_name'];
        $principalUpdate = $row['team_principal'];
        $btn = 'Update';
        $title = 'Ubah';

        $view->replace('DATA_PRINCIPAL_VAL_UPDATE', $principalUpdate);
        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($divisi->deleteTeam($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'divisi.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'divisi.php';
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
