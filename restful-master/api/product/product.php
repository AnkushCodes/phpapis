<?php

require_once "database/DB.php";
require_once "api/product/repository/ProductRepo.php";
class Product
{

    private $util;
    private $productRepo;
    function __construct(Utility $setUtilObj)
    {
       $this->productRepo = new ProductRepo($setUtilObj);

        $this->util = $setUtilObj;
    }

    function doGet()
    {
        $calls = $this->util->getCallFuntion();
     
        $this->productRepo->$calls();
        exit;
    }
    function doPost()
    {
        $calls = $this->util->getCallFuntion();
        $this->productRepo->$calls();
        exit;
    }
    function doPut()
    {
        $calls = $this->util->getCallFuntion();

        $this->productRepo->$calls();
        exit;
    }
    function doDelete()
    {
        $calls = $this->util->getCallFuntion();

        $this->productRepo->$calls();
        exit;
    }
}
