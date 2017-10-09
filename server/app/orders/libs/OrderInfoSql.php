<?php
//include('../config.php');

class OrderInfoSql
{

    private $dbConnect;

    public function __construct()
    {
        $baseAndHostDbName = MY_SQL_DB . ':host=' . MY_SQL_HOST . '; dbname=' . MY_SQL_DB_NAME;
        try {
            $this->dbConnect = new PDO($baseAndHostDbName, MY_SQL_USER, MY_SQL_PASSWORD);
            $this->dbConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->dbConect = 'connect error';
        }
    }

    public function getOrderInfo($userId)
    {
        $result = [];
        if($this->dbConnect !== 'connect error')
        {
            $stmt =$this->dbConnect->prepare('select c.model,c.mark,c.year,c.engine,c.color,c.maxSpeed,c.price
                                                from orders as o
                                                INNER JOIN cars as c on c.id = o.id_car
                                                where id_user = :userId');
            $stmt->bindParam(':userId',$userId);
            $stmt->execute();
            while($assocRow = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $result[]=$assocRow;
            }
        }else
        {
            return 'error';
        }

        return $result;
    }


    public function addOrder($carId,$userId,$fName,$lName,$paymentMethod)
    {
        if($this->dbConnect !== 'connect error')
        {
            $stmt =$this->dbConnect->prepare('INSERT INTO orders(id_car,id_user,firstName,surname,paymentMethod)
                                              VALUES(:carId,:userId,:firstName,:surname,:paymentMethod)');
            $stmt->bindParam(':carId',$carId);
            $stmt->bindParam(':userId',$userId);
            $stmt->bindParam(':firstName',$fName);
            $stmt->bindParam(':surname',$lName);
            $stmt->bindParam(':paymentMethod',$paymentMethod);
            $result = $stmt->execute();
        }else
        {
            return 'error';
        }

        return $result;
    }

}
