<?php
//include('../config.php');

class CarInfoSql
{

    private $dbConnect;

    public function __construct()
    {
        //     var_dump($this->dbConnect);
//        var_dump(MY_SQL_DB,MY_SQL_HOST,MY_SQL_DB_NAME,MY_SQL_USER,MY_SQL_PASSWORD);
        $baseAndHostDbName = MY_SQL_DB . ':host=' . MY_SQL_HOST . '; dbname=' . MY_SQL_DB_NAME;
        try {
            $this->dbConnect = new PDO($baseAndHostDbName, MY_SQL_USER, MY_SQL_PASSWORD);
            $this->dbConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->dbConect = 'connect error';
        }
        //var_dump($this->dbConnect);
    }

    private function generateSortSql($paramArr)
    {
        $select = 'SELECT mark,model,id ';
        $where = 'WHERE ';
        $arrLength = count($paramArr);
        $i = 1;
        foreach ($paramArr as $paramName => $paramValue) {
            if ($arrLength != $i) {
                if($paramName == 'engine')
                {
                    $where .= ' CAST('.$paramName . ' AS CHAR)' . '=:' .$paramName .' AND ';
                    $i++;
                    continue;
                }
                if($paramName == 'maxSpeed' || $paramName == 'price')
                {
                    $where .= $paramName . ' BETWEEN :' . $paramName .'1 AND :' . $paramName . '2 AND ';
                }else
                {
                    $where .= $paramName . '=:' . $paramName . ' AND ';
                }
            } else {
                if($paramName == 'engine')
                {
                    $where .= ' CAST('.$paramName . ' AS CHAR)' . '=:' .$paramName;
                    $i++;
                    continue;
                }
                if($paramName == 'maxSpeed' || $paramName == 'price')
                {
                    $where .= $paramName . ' BETWEEN :' . $paramName .'1 AND :' . $paramName . '2';
                }else
                {
                    $where .= $paramName . '=:' . $paramName;
                }
            }
            $i++;
        }

        $sql = $select . ' FROM cars ' . $where;

        return $sql;
    }

    public function getCarMarkAndModel()
    {
        $result = [];
//        var_dump($this->dbConnect);
        if($this->dbConnect !== 'connect error')
        {
            $stmt =$this->dbConnect->prepare('SELECT id, mark, model
                FROM cars');
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

    public function getModelYearAmountColorSpeedPrice($id)
    {
        $result = [];
        if($this->dbConnect !== 'connect error')
        {
            $stmt =$this->dbConnect->prepare('SELECT model, year, engine, color, maxSpeed, price
                FROM cars
                WHERE id = :id');
            $stmt->bindParam(':id',$id);
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

    public function getCarsInfoByParams($paramsArr)
    {

        $sql = $this->generateSortSql($paramsArr);

        $result = [];

        if ($this->dbConnect !== 'connect error') {
            $stmt = $this->dbConnect->prepare($sql);
            foreach ($paramsArr as $paramName => &$paramValue) {
                if(is_array($paramValue))
                {
                    $stmt->bindParam($paramName . '1',$paramValue[0]);
                    $stmt->bindParam($paramName . '2',$paramValue[1]);
                }else
                {
                    $stmt->bindParam($paramName, $paramValue);
                }
            }
            $stmt->execute();

            while ($assocRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $assocRow;
            }

        }else
        {
            return 'error';
        }

        return $result;
    }

    public function addOrder($orderParams)
    {
        if($this->dbConnect !== 'connect error')
        {
            $stmt =$this->dbConnect->prepare('INSERT INTO orders(id_car,firstName,surname,paymentMethod)
                                              VALUES(:carId,:firstName,:surname,:paymentMethod)');
            $stmt->bindParam(':carId',$orderParams['carId']);
            $stmt->bindParam(':firstName',$orderParams['firstName']);
            $stmt->bindParam(':surname',$orderParams['surname']);
            $stmt->bindParam(':paymentMethod',$orderParams['paymentMethod']);
            $result = $stmt->execute();
        }else
        {
            return 'error';
        }

        return $result;
    }

}
