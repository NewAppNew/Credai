<?php

class autoSuggest
{
    public $db;
    public $result;
    public $todaysDate;
     public $v;

    public function __construct($db)
    {
        $this->db = $db;
        $this->todaysDate = date("Y-m-d H:i:s");
    }
    
    public function getAllvarientType()
    {
        $sql = "SELECT id,varient FROM master_car_varient";
        $this->result = $this->db->query($sql);       
        
        return $this->result;
    }

    public function getvarientType($varient)
    {
        $sql = "SELECT id,varient FROM master_car_varient WHERE varient LIKE '$varient%'";
        $this->result = $this->db->query($sql);       
        
        return $this->result;
    }
    
    public function getAllFuelType()
    {
        $sql = "SELECT id,fuelName FROM master_fuel";
        $this->result = $this->db->query($sql);       
        
        return $this->result;
    }
    public function getFuelType($fuelType)
    {
        $sql = "SELECT id,fuelName FROM master_fuel WHERE fuelName LIKE '$fuelType%'";
        $this->result = $this->db->query($sql);       
        
        return $this->result;
    }

    
    function getBrandName($brandName)
    {
        $sql = "SELECT id,brandName FROM master_brand WHERE brandName LIKE '$brandName%'";
        $this->result = $this->db->query($sql);       
        
        return $this->result;
    }
    public function getAllBrandName()
    {
        $sql = "SELECT id,brandName FROM master_brand";
        $this->result = $this->db->query($sql);       
        
        return $this->result;
    }
    
    public function getAllVehicleType()
    {
        $sql = "SELECT id,bodyType FROM master_body_type";
        $this->result = $this->db->query($sql);       
        
        return $this->result;
    }

    public function getVehicleType($bodyType)
    {
        $sql = "SELECT id,bodyType FROM master_body_type WHERE bodyType LIKE '$bodyType%'";
        $this->result = $this->db->query($sql);       
        
        return $this->result;
    }

    public function getAllUserMobileNumbers($userType)
    {
        $sql = "SELECT mobileNo FROM user WHERE userType='$userType'";
        $this->result = $this->db->query($sql);       
        
        return $this->result;
    }

    public function getUserMobileNumbers($mobileNo,$userType)
    {
        $sql = "SELECT mobileNo FROM user WHERE mobileNo LIKE '$mobileNo%' AND userType='$userType'";
        $this->result = $this->db->query($sql);       
        
        return $this->result;
    }

    

    public function getAllUserVehicleNumbers()
    {
        $sql = "SELECT vehicleNumber FROM car_details";
        $this->result = $this->db->query($sql);       
        
        return $this->result;
    }
    public function getRtoWorkList()
    {
        $sql = "SELECT RW.id,CD.vehicleNumber,CD.vehicleName,US.userFullName,RW.work,
                RW.amountPaid,RW.amountPending,RW.reportStatus,RW.receiptFile,RW.disclaimerFile
                FROM rto_work AS RW
                INNER JOIN user AS US ON US.id=RW.idAgent
                INNER JOIN deal_details AS DD ON DD.id = RW.idDeal
                INNER JOIN car_details AS CD ON CD.id = DD.idVehicle 
                WHERE US.userType='RtoAgent' ORDER BY RW.id DESC";

        $this->result = $this->db->query($sql);
        return $this->result;
    }
    public function getUserVehicleNumbers($vNumber)
    {
        $sql = "SELECT vehicleNumber FROM car_details WHERE vehicleNumber LIKE '$vNumber%'";
        $this->result = $this->db->query($sql);       
        
        return $this->result;
    }

    public function getDealReceiptNumbers($vNumber)
    {
        $sql = "SELECT DD.id 
                FROM deal_details AS DD
                INNER JOIN car_details AS CD ON CD.id=DD.idVehicle
                WHERE CD.vehicleNumber='$vNumber'";
        $this->result = $this->db->query($sql);       
        
        return $this->result;
    }
    public function getDataForQuickReceipt($vNumber)
    {
      $sql = "SELECT DD.id AS dealId,CD.id,CD.vehicleName,CD.vehicleNumber,US.userFullName,US.address 
                FROM deal_details AS DD
                INNER JOIN car_details AS CD ON CD.id=DD.idVehicle
                INNER JOIN user AS US ON US.id = DD.idBuyer
                WHERE DD.dealStatus='Done' AND CD.vehicleNumber='$vNumber'";
        $this->result = $this->db->query($sql);       
        
        return $this->result;
    }
          public function getquickReceiptByNumber()
    {

        
        $sql = "SELECT 
car_details.id,
car_details.vehicleName,
car_details.vehicleNumber,
car_details.varient,
car_details.bodyType,
car_details.modelYear,
car_details.fuelType,
car_details.color,
car_details.passing,
car_details.chassisNo,
car_details.EngineNo,
car_details.kmsDriven,
car_details.average,
car_details.numberOfOwner,
car_details.expectedPrice,

user.id,
user.userFullName,
user.mobileNo,
user.address,


deal_details.id as dealId,
deal_details.dealAmount,

transaction.id,
transaction.dueAmount,
transaction.paidDate


FROM `deal_details` 

JOIN car_details ON car_details.id=deal_details.idVehicle 
JOIN user ON user.id=deal_details.idBuyer 
JOIN transaction ON transaction.idDeal=deal_details.id

WHERE car_details.vehicleNumber='$this->vehicleNumber'  ORDER BY transaction.paidDate DESC LIMIT 1 ";
        $this->result = $this->db->query($sql);       
        return $this->result;
    }
}