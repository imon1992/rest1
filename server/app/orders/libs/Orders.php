<?php

class Orders
{
    protected $orderSql;

    public function __construct()
    {
        $this->orderSql = new OrderInfoSql();
    }

    public function postOrders($params)
    {
        $result = $this->orderSql->addOrder($params['carId'],$params['userId'],$params['fName'],$params['lName'],$params['paymentMethod']);
//        if($result != false)
//        {
//            $result = true;
//        }
        return $result;
    }

    public function getOrders($userId)
    {
        $result = $this->orderSql->getOrderInfo($userId);
//        var_dump($result);
        return $result;
    }
}
