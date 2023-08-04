<?php

class masterBrandName
{
    public $db;
    public $id;
    public $db_table = "master_brand";
    public $brandname;
    public $result;
   

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addNewBrandName()
    {
        $sql = "SELECT * FROM $this->db_table WHERE brandname='$this->brandname'";
        $this->result = $this->db->query($sql);
        
        if(mysqli_num_rows($this->result) > 0)
        {
            return 'Existed';
        }
        else
        {
            $sql_check_in = "INSERT INTO $this->db_table (brandname) VALUES ('$this->brandname')";
            $this->result = $this->db->query($sql_check_in);
            return $this->db;
        }
        
    }

    public function readNewBrandName()
    {
        $sql = "SELECT * FROM $this->db_table";
        $this->result = $this->db->query($sql);
        
        
        return $this->result;
    }

    public function updateBrandName()
    {
        $sql = "SELECT * FROM $this->db_table WHERE id='$this->id'";
        $this->result = $this->db->query($sql);
        
        if(mysqli_num_rows($this->result) > 0)
        {
            $sql = "UPDATE $this->db_table SET brandname='$this->brandname' WHERE id='$this->id'";
        
            $this->result = $this->db->query($sql);
            return $this->db;
        }
        
    }

    public function deleteBrandName()
    {
        $sql = "DELETE FROM $this->db_table WHERE id='$this->id'";
        
            $this->result = $this->db->query($sql);
            return $this->db;
    }
}


?>