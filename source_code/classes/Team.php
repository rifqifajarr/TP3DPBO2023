<?php

class Team extends DB
{
    function getTeam()
    {
        $query = "SELECT * FROM teams";
        return $this->execute($query);
    }

    function getTeamById($id)
    {
        $query = "SELECT * FROM teams WHERE id_team=$id";
        return $this->execute($query);
    }

    function addTeam($data)
    {
        $team_name = $data['name'];
        $team_principal = $data['principal'];

        $query = "INSERT INTO teams VALUES ('', '$team_name', '$team_principal')";
        return $this->executeAffected($query);
    }

    function updateTeam($id, $data)
    {
        $team_name = $data['name'];
        $team_principal = $data['principal'];

        $query = "UPDATE teams SET team_name = '$team_name', team_principal = '$team_principal' WHERE id_team = '$id'";
        return $this->executeAffected($query);
    }

    function deleteTeam($id)
    {
        $query = "DELETE FROM teams WHERE id_team = $id";
        return $this->executeAffected($query);
    }
}
