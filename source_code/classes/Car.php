<?php

class Car extends DB
{
    function getCar()
    {
        $query = "SELECT * FROM cars";
        return $this->execute($query);
    }

    function getCarById($id)
    {
        $query = "SELECT * FROM cars WHERE id_car='$id'";
        return $this->execute($query);
    }

    function addCar($data)
    {
        $nama = $data['name'];
        $query = "INSERT INTO cars VALUES('', '$nama')";
        return $this->executeAffected($query);
    }

    function updateCar($id, $data)
    {
        $car_name = $data['name'];

        $query = "UPDATE cars SET car_name = '$car_name' WHERE id_car = '$id'";
        return $this->executeAffected($query);
    }

    function deleteCar($id)
    {
        $query = "DELETE FROM cars WHERE id_car = '$id'";
        return $this->executeAffected($query);
    }
}
