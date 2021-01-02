<?php
require_once "core/utility.php";
require_once "api/product/Bean/ProductBean.php";
class ProductRepo
{
    private $utili;
    public function __construct(Utility $seUtil)
    {
        $this->utili = $seUtil;
    }

    public function addproduct()
    {
        $sdata = $this->utili->Input['data'];
        $name = $this->utili->validateParameter('name', $sdata['name'], STRING, false);
        $qty = $this->utili->validateParameter('qty', $sdata['qty'], INTEGER, false);
        // $date = $this->utili->validateParameter('date', $sdata['date'], STRING, false);
        $prod = new ProductBean();

        $prod->setName($name);
        $prod->setqty($qty);
        $prod->setDate(date('y-m-d'));

        if (!$prod->insert()) {
            $message = 'Failed to insert.';
        } else {
            $message = "Inserted successfully.";
        }

        $this->utili->returnResponse(SUCCESS_RESPONSE, $message);
    }

    public function getproduct()
    {
        $prod = new ProductBean();
        $prod->setId($this->utili->getId());
        $product = $prod->getProduct();
        if (!is_array($product)) {
            $this->utili->returnResponse(SUCCESS_RESPONSE, ['message' => 'Customer details not found.']);
        }

        // $response['name']    = $product['name'];
        // $response['qty']   = $product['qty'];

        $this->utili->returnResponse(SUCCESS_RESPONSE, $product);
    }

    public function getproducts()
    {
        $prod = new ProductBean();
        $products = $prod->getProducts();
        if (!is_array($products)) {
            $this->utili->returnResponse(SUCCESS_RESPONSE, ['message' => 'Customer details not found.']);
        }
        $this->utili->returnResponse(SUCCESS_RESPONSE, $products);
    }



    public function updateproduct()
    {

        $prod = new ProductBean();
        $sdata = $this->utili->Input['data'];

        $name = $this->utili->validateParameter('name', $sdata['name'], STRING, false);
        $qty = $this->utili->validateParameter('qty', $sdata['qty'], INTEGER, false);


        $prod->setId($this->utili->getId());
        $prod->setName($name);
        $prod->setQty($qty);
        $prod->setDate(date('Y-m-d'));

        if (!$prod->update()) {
            $message = 'Failed to update.';
        } else {
            $message = "Updated successfully.";
        }

        $this->utili->returnResponse(SUCCESS_RESPONSE, $message);
    }


    public function deleteproducts()
    {
        $prod = new ProductBean();
        $prod->setId($this->utili->getId());

        if (!$prod->delete()) {
            $message = 'Failed to delete.';
        } else {
            $message = "deleted successfully.";
        }

        $this->utili->returnResponse(SUCCESS_RESPONSE, $message);
    }
}
