<?php
class ProductBean
{
    
    private $id;
    private $name;
    private $qty;
    private $date;


    function setId($id)
    {
        $this->id = $id;
    }
    function getId()
    {
        return $this->id;
    }

    function setName($name)
    {
        $this->name = $name;
    }
    function getName()
    {
        return $this->name;
    }

    function setQty($qty)
    {
        $this->qty = $qty;
    }
    function getQty()
    {
        return $this->qty;
    }

    function setDate($date)
    {
        $this->date = $date;
    }
    function getDate()
    {
        return $this->date;
    }

    private $db;
    public function __construct()
    {
        $this->db = DB::getConnection();
    }

    public function getProduct()
    {
        $sql = "select * from product where id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product;
    }

    public function getProducts()
    {
        $stmt = $this->db->prepare("select * from product");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return  $products;
    }

    public function insert()
    {
        $sql = 'insert into product' . '(name,qty,date) values(:name,:qty,:date)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':qty', $this->qty);
        $stmt->bindParam(':date', $this->date);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        $sql = "update product set";
        if (null != $this->getName()) {
            $sql .= "name='" . $this->getName() . "'";
        }
        if (null != $this->getQty()) {
            $sql .= "qty='" . $this->getQty() . "'";
        }
        if (null != $this->getDate()) {
            $sql .= "date='" . $this->getDate() . "'";
        }
        $sql = " where id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $this->getId());
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {
        $stmt = $this->db->prepare('delete from product where =:id');
        $stmt->bindparam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
