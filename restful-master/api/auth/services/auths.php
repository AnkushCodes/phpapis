<?php
class ServiceAuth
{
    private $Input;
    public function __construct(Utility $utility)
    {
        $this->Input=$utility;
    }

    public function getById()
    {
        $sql = "SELECT 
        c.*, 
        u.name as created_user,
        u1.name as updated_user
    FROM customers c 
        JOIN users u ON (c.created_by = u.id) 
        LEFT JOIN users u1 ON (c.updated_by = u1.id) 
    WHERE 
        c.id = :customerId";

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':customerId', $this->id);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        return $customer;
    }

    public function authInsert()
    {
        $sql = 'INSERT INTO ' . $this->tableName . '(id, name, email, address, mobile, created_by, created_on) VALUES(null, :name, :email, :address, :mobile, :createdBy, :createdOn)';

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':mobile', $this->mobile);
        $stmt->bindParam(':createdBy', $this->createdBy);
        $stmt->bindParam(':createdOn', $this->createdOn);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function authUpdate()
    {
        $sql = "UPDATE $this->tableName SET";
        if (null != $this->getName()) {
            $sql .=    " name = '" . $this->getName() . "',";
        }

        if (null != $this->getAddress()) {
            $sql .=    " address = '" . $this->getAddress() . "',";
        }

        if (null != $this->getMobile()) {
            $sql .=    " mobile = " . $this->getMobile() . ",";
        }

        $sql .=    " updated_by = :updatedBy, 
					  updated_on = :updatedOn
					WHERE 
						id = :userId";

        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':userId', $this->id);
        $stmt->bindParam(':updatedBy', $this->updatedBy);
        $stmt->bindParam(':updatedOn', $this->updatedOn);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function authDelete()
    {
        $stmt = $this->dbConn->prepare('DELETE FROM ' . $this->tableName . ' WHERE id = :userId');
        $stmt->bindParam(':userId', $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
