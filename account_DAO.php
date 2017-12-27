<?php
class account_DAO
{
    private $_connection;

    function __construct($connection)
    {
        $this->_connection = $connection;
    }

    public function new_user($username,$hashed_password,$role_level)
    {
        $query = "INSERT INTO ACCOUNT (user_id, user_password, user_role) VALUES (?,?,?)";
        $prepared_query = mysqli_prepare($this->_connection, $query);
        $prepared_query->bind_param('sss',$username,$hashed_password,$role_level);
        $prepared_query->execute();
        return $username;
    }

    public function login($username,$hashed_password)
    {
        $query = "SELECT user_role FROM ACCOUNT WHERE USER_ID = ? AND USER_PASSWORD = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('ss',$username,$hashed_password);
        $prepared_query->execute();
        if(!empty($prepared_query->fetch()))
        {
            $_SESSION["access"] = "granted";
            $_SESSION["level"] = $user_role;
            return true;
        }
        else 
        {
            return false;
        }
    }
}