<?php

class Driver extends DB
{
    function getDriverJoin()
    {
        $query = "SELECT * FROM driver JOIN cars ON driver.id_car=cars.id_car JOIN teams ON driver.id_team=teams.id_team ORDER BY driver.name";

        return $this->execute($query);
    }

    function getDriver()
    {
        $query = "SELECT * FROM driver";
        return $this->execute($query);
    }

    function getDriverById($id)
    {
        $query = "SELECT * FROM driver JOIN cars ON driver.id_car=cars.id_car JOIN teams ON driver.id_team=teams.id_team WHERE id_driver=$id";
        return $this->execute($query);
    }

    function searchDriver($keyword)
    {
        $query = "SELECT * FROM driver JOIN cars ON driver.id_car=cars.id_car JOIN teams ON driver.id_team=teams.id_team WHERE name LIKE '%" . $keyword . "%' ORDER BY driver.name";
        return $this->execute($query);
    }

    function addDriver($data, $file)
    {
        $tmp_file = $file['driver_img']['tmp_name'];
        $driver_img = $file['driver_img']['name'];

        $dir = "assets/images/$driver_img";
        move_uploaded_file($tmp_file, $dir);

        $driver_name = $data['driver_name'];
        $driver_number = $data['driver_number'];
        $id_team = $data['id_team'];
        $id_car = $data['id_car'];

        $query = "INSERT INTO driver VALUES ('', '$driver_name', '$driver_number', '$driver_img', '$id_team', '$id_car')";

        return $this->executeAffected($query);
    }

    function updateDriver($id, $data, $file, $img)
    {
        $tmp_file = $file['driver_img']['tmp_name'];
        $driver_img = $file['driver_img']['name'];

        
        $dir = "assets/images/$driver_img";
        move_uploaded_file($tmp_file, $dir);
        
        $driver_name = $data['driver_name'];
        $driver_number = $data['driver_number'];
        $id_team = $data['id_team'];
        $id_car = $data['id_car'];
        
        if ($driver_img == '') {
            $query = "UPDATE driver SET name = '$driver_name', number = '$driver_number', id_team = '$id_team', id_car = '$id_car' WHERE id_driver = '$id'";
        } else {
            $query = "UPDATE driver SET name = '$driver_name', number = '$driver_number', driver_img = '$driver_img', id_team = '$id_team', id_car = '$id_car' WHERE id_driver = '$id'";

        }
        return $this->executeAffected($query);
    }

    function deleteDriver($id)
    {
        $query = "DELETE FROM driver WHERE id_driver=$id";
        return $this->execute($query);
    }

    function sortDriver($sort) {
        if ($sort == 'ascending') {
            $query = "SELECT * FROM driver JOIN cars ON driver.id_car=cars.id_car JOIN teams ON driver.id_team=teams.id_team ORDER BY driver.number";
        } else {
            $query = "SELECT * FROM driver JOIN cars ON driver.id_car=cars.id_car JOIN teams ON driver.id_team=teams.id_team ORDER BY driver.number DESC";
        }

        return $this->execute($query);
    }
}
