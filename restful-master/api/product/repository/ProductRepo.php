<?php
require_once "core/utility.php";
class ProductRepo
{
    private $utili;
    public function __construct(Utility $seUtil)
    {
        $this->utili = $seUtil;
    }

    public function addproducts()
    {

        $sdata = $this->utili->Input['data'];
        $name = $this->utili->validateParameter('name', $sdata['name'], STRING, false);
        $qty = $this->utili->validateParameter('qty', $sdata['qty'], STRING, false);
        // $date = $this->utili->validateParameter('date', $sdata['date'], STRING, false);
        $prod = new ProductBean();

        $prod->setName($name);
        $prod->setqty($qty);
        $prod->setDate(date('Y-m-d'));

        if(!$prod->insert()) {
            $message = 'Failed to insert.';
        } else {
            $message = "Inserted successfully.";
        }

        $this->utili->returnResponse(SUCCESS_RESPONSE, $message);
    }

    public function getproduct()
    {
        $prod = new ProductBean();
        $prod->setId(1);
        $product = $prod->getProduct();
        if (!is_array($product)) {
            $this->utili->returnResponse(SUCCESS_RESPONSE, ['message' => 'Customer details not found.']);
        }

       
        $response['name']    = $product['name'];
        $response['qty']   = $product['qty'];

        // $response['createdBy'] 		= $customer['created_user'];
        // $response['lastUpdatedBy'] 	= $customer['updated_user'];
        $this->utili->returnResponse(SUCCESS_RESPONSE, $response);
    }

    public function updateproducts()
    {
        $prod = new ProductBean();
        $sdata = $this->utili->Input['data'];
        $name = $this->utili->validateParameter('name', $sdata['name'], STRING, false);
        $qty = $this->utili->validateParameter('qty', $sdata['qty'], STRING, false);

        $prod->setId(1);
        $prod->setName($name);
        $prod->setQty($qty);
        // $cust->setUpdatedBy($this->userId);
        // 	$cust->setUpdatedOn(date('Y-m-d'));

        	if(!$prod->update()) {
        		$message = 'Failed to update.';
        	} else {
        		$message = "Updated successfully.";
        	}

        	$this->util->returnResponse(SUCCESS_RESPONSE, $message);
        }
    

    public function deletproducts()
    {
        // $prod = new ProductBean();
        //     $cust->setId($customerId);

        //     if(!$cust->delete()) {
        //         $message = 'Failed to delete.';
        //     } else {
        //         $message = "deleted successfully.";
        //     }

        //     $this->returnResponse(SUCCESS_RESPONSE, $message);
        // }
    }
}
