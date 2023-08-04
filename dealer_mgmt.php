<?php

class Dealermgmt
{
    public $db;
    public $id;
    public $db_table = "user";
    public $userFullName;
    public $mobileNo;
    public $aadharNo;
    public $emailId;
    public $address;
    public $userType;
    public $dealerAgency;
    public $result;
    public $todaysDate;

    public function __construct($db)
    {
        $this->db = $db;
        $this->todaysDate = date("Y-m-d H:i:s");
    }

    public function addNewrtoDealer()
    {
        
        $sql = "SELECT id,userFullName,address,mobileNo,aadharNo,emailId,dealerAgency FROM $this->db_table WHERE mobileNo='$this->mobileNo' AND userType='Dealer'";
        $this->result = $this->db->query($sql);
        
        if(mysqli_num_rows($this->result) > 0)
        {
            while($row=mysqli_fetch_assoc($this->result))
            {
                $id = $row['id'];
            }
            return $id;
        }
        else
        {
            $this->address = addslashes($this->address);
            $sql_check_in = "INSERT INTO $this->db_table (userType, userFullName,status,
             mobileNo, address,emailId,aadharNo,PANNumber,dealerAgency) VALUES ('Dealer','$this->userFullName','Active','$this->mobileNo','$this->address','$this->emailId',
             '$this->aadharNo','$this->PANNumber','$this->dealerAgency')";

            $this->result = $this->db->query($sql_check_in);
            $last_id = $this->db->insert_id;
            return $last_id;
        }
        return $this->result;
    }
    public function readNewrtoDealer()
    {
        $sql = "SELECT * FROM $this->db_table WHERE userType='Dealer' AND status='Active'";
        $this->result = $this->db->query($sql);
        
        
        return $this->result;
    }
       public function readNewrtoDealeById()
    {
        $sql = "SELECT * FROM $this->db_table  WHERE userType='Dealer' AND id='$this->id'";
        $this->result = $this->db->query($sql);
        
        
        return $this->result;
    }
    public function updatertoDealer()
    {
        $sql = "SELECT * FROM $this->db_table WHERE id='$this->id'";
        $this->result = $this->db->query($sql);
        
        if(mysqli_num_rows($this->result) > 0)
        {
            $sql = "UPDATE $this->db_table SET userFullName='$this->userFullName',mobileNo='$this->mobileNo',address='$this->address',emailId='$this->emailId',aadharNo='$this->aadharNo',
            PANNumber='$this->PANNumber', dealerAgency='$this->dealerAgency' WHERE id='$this->id'";
        
            $this->result = $this->db->query($sql);
            return $this->db;
        }
        
    }
    public function deletertoDealer()
    {
            $sql = "UPDATE $this->db_table SET status='Deactive' WHERE id='$this->id'";
        
            $this->result = $this->db->query($sql);
            return $this->db;
    }

}
?>