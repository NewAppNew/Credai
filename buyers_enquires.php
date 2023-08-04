<?php

class buyersEnquiry
{
    
    public $db;
    public $id;
    public $id1;
    public $db_userTable = "user";
    public $db_new_enquiryTable = "new_enquiry";
    public $userType;
    public $userFullName;
    public $mobileNo;
    public $address;
    public $status;
    public $budget;
    public $vehicleName;
    public $varient;
    public $fuelType;
    public $vehicleColor;
    public $modelYear;
    public $passingStatus;
    public $bodyType;
    public $numberOfOwner;
    public $enqStatus;
    public $todaysDate;
    public $result;
    public $occupation;
    public $remarks;
    
    public function __construct($db)
    {
        $this->db = $db;
        $this->todaysDate = date("Y-m-d H:i:s");
    }
 public function getBuyersRecordsById()
    {
        $sql = "SELECT NE.id AS enqId,US.userFullName,US.address,US.mobileNo,US.id,
                NE.vehicleName,NE.varient,NE.vehicleColor,NE.passingStatus,NE.fuelType,
                NE.bodyType,NE.modelYear,NE.budget,NE.entryDate,NE.numberOfOwner	
                FROM new_enquiry AS NE
                INNER JOIN user AS US ON NE.idUser = US.id
                WHERE NE.id = $this->id AND US.userType='Buyer' AND US.status='Active'";
        $this->result = $this->db->query($sql);
        
        if(mysqli_num_rows($this->result) > 0)
        {
            return $this->result;
        }
        else
        {
            return false;
        }
    }
     public function getBuyersEditRecordsById()
    {
        $sql = "SELECT NE.id AS enqId,US.userFullName,US.address,US.mobileNo,US.id,
                NE.vehicleName,NE.varient,NE.vehicleColor,NE.passingStatus,NE.fuelType,
                NE.bodyType,NE.modelYear,NE.budget,NE.entryDate
                FROM new_enquiry AS NE
                INNER JOIN user AS US ON NE.idUser = US.id
                WHERE US.id = $this->id AND US.userType='Buyer' AND US.status='Active'";
        $this->result = $this->db->query($sql);
        
        if(mysqli_num_rows($this->result) > 0)
        {
            return $this->result;
        }
        else
        {
            return false;
        }
    }
     public function getnotificationData()
    {
        $sql1 = "SELECT NE.id AS enqId,US.userFullName,US.address,US.mobileNo,
                NE.vehicleName,NE.varient,NE.vehicleColor,NE.passingStatus,NE.fuelType,NE.remarks,
                NE.bodyType,NE.modelYear,NE.budget,NE.buyerDate,NE.entryDate
                FROM reminder AS NE
                INNER JOIN user AS US ON NE.buyerId = US.id
                WHERE NE.id =  $this->id AND US.userType='Buyer' AND US.status='Active'";
                   $this->result = $this->db->query($sql1);
         if(mysqli_num_rows($this->result) > 0)
        {
            return $this->result;
        }
        else
        {
            return false;
        }
    }

       public function getAllBuyersRecords($flag,$startDate=0,$endDate=0)
    {
         if($flag == 1)
        {
       $sql = "SELECT NE.id AS enqId,US.userFullName,NE.vehicleName,
       NE.varient,NE.fuelType,NE.vehicleColor,NE.modelYear,NE.passingStatus,NE.bodyType,NE.numberOfOwner,
       US.id,US.mobileNo,US.address,
        NE.budget,DATE_FORMAT(NE.entryDate,'%d - %b - %Y')AS entryDate ,US.userType
                FROM new_enquiry AS NE
                INNER JOIN user AS US ON NE.idUser = US.id
                WHERE US.userType='Buyer' AND NE.entryDate >= '$startDate 00:00:00' AND NE.entryDate <= '$endDate 23:59:59' order by NE.id desc";
        }
        else
        {
 $sql = "SELECT NE.id AS enqId,US.userFullName,NE.vehicleName,US.mobileNo,US.address,
       NE.varient,NE.fuelType,NE.vehicleColor,NE.modelYear,NE.passingStatus,NE.bodyType,NE.numberOfOwner,
        NE.budget,DATE_FORMAT(NE.entryDate,'%d - %b - %Y')AS entryDate ,US.userType,US.id 
                FROM new_enquiry AS NE
                INNER JOIN user AS US ON NE.idUser = US.id
                WHERE US.userType='Buyer' AND US.status='Active' order by NE.id desc";
        }
             $this->result = $this->db->query($sql);
             return $this->result; 
    }

    public function getAllBuyersNotification($flag,$startDate=0,$endDate=0)
    {
         if($flag == 1)
        {
       $sql = "SELECT NE.id AS enqId,US.userFullName,NE.vehicleName,
        NE.budget,DATE_FORMAT(NE.entryDate,'%d - %b - %Y')AS entryDate ,US.userType
                FROM new_enquiry AS NE
                INNER JOIN user AS US ON NE.idUser = US.id
                WHERE US.userType='Buyer' AND NE.entryDate >= '$startDate 00:00:00' AND NE.entryDate <= '$endDate 23:59:59' order";
        }
        else
        {
 $sql = "SELECT NE.id AS enqId,US.userFullName,NE.vehicleName,
        NE.budget,DATE_FORMAT(NE.entryDate,'%d - %b - %Y')AS entryDate ,US.userType,US.mobileNo
                FROM new_enquiry AS NE
                INNER JOIN user AS US ON NE.idUser = US.id
                WHERE US.userType='Buyer' AND US.status='Active' order by NE.entryDate ASC";
        }
             $this->result = $this->db->query($sql);
             return $this->result; 
    }
    
    public function searchByuerId()
    {
        $sql = "SELECT id as idBuyer,userFullName,mobileNo,address as B_address ,occupation FROM $this->db_userTable  WHERE mobileNo='$this->mobileNo' AND userType='$this->userType'";
        $this->result = $this->db->query($sql);
        
        if(mysqli_num_rows($this->result) > 0)
        {
            return $this->result;
        }
        else
        {
            return false;
        }
    }

    public function searchByuerDetails()
    {
        $sql = "SELECT * FROM $this->db_userTable WHERE mobileNo='$this->mobileNo' AND userType='Buyer'";
        $this->result = $this->db->query($sql);
        
        if(mysqli_num_rows($this->result) > 0)
        {
            return $this->result;
        }
        else
        {
            return false;
        }
    }

    public function addNewByuer()
    {
        $sql = "SELECT id FROM $this->db_userTable WHERE mobileNo='$this->mobileNo' AND userType='Buyer'";
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
            $sql_check_in = "INSERT INTO $this->db_userTable (userType, userFullName, mobileNo, address, entryDate, lastUpdate, status) VALUES ('Buyer','$this->userFullName','$this->mobileNo','$this->address','$this->todaysDate','$this->todaysDate','Active')";
            $this->result = $this->db->query($sql_check_in);
            $last_id = $this->db->insert_id;
            return $last_id;
        }
    }
    
    public function updateFuelType()
    {
         $sql_update = "UPDATE user SET
        userFullName='$this->userFullName',
        mobileNo='$this->mobileNo',
        address='$this->address'
        WHERE id='$this->id'";
        echo $sql_update;die;

         $this->result = $this->db->query($sql_update);
            return $this->db;
  

    }
        public function updateNewByuer()
    {
        

            $sql = "UPDATE user SET userFullName='$this->userFullName',occupation='$this->occupation',mobileNo='$this->mobileNo',address='$this->address' WHERE id='$this->id'";
            $this->result = $this->db->query($sql);
       
     
            $sql1 = "UPDATE new_enquiry SET budget='$this->budget',vehicleName='$this->vehicleName',
            varient='$this->varient',fuelType='$this->fuelType',vehicleColor='$this->vehicleColor',modelYear='$this->modelYear',
            passingStatus='$this->passingStatus',bodyType='$this->bodyType',numberOfOwner='$this->numberOfOwner' WHERE idUser='$this->id'";
            
            $this->result1 = $this->db->query($sql1);
            
            return  $this->result;
            return  $this->result1;
        

    }
       public function updateByuersEnquiryDetails()
    {  
        $sql = "SELECT * FROM new_enquiry WHERE id='$this->id'";
        $this->result = $this->db->query($sql);
        
        if(mysqli_num_rows($this->result) > 0)
        {
            $sql = "UPDATE new_enquiry SET budget='$this->budget',vehicleName='$this->vehicleName',
            varient='$this->varient',fuelType='$this->fuelType',vehicleColor='$this->vehicleColor',modelYear='$this->modelYear',
            passingStatus='$this->passingStatus',bodyType='$this->bodyType',numberOfOwner='$this->numberOfOwner' WHERE id='$this->id'";
        
            $this->result = $this->db->query($sql);
            return $this->db;
        }
    }

    public function addNewByuersEnquiryDetails($buyerId)
    {        
        $this->vehicleName = addslashes($this->vehicleName);
        $sql = "INSERT INTO $this->db_new_enquiryTable (idUser, budget, vehicleName, varient, fuelType, vehicleColor, modelYear,
        passingStatus, bodyType, numberOfOwner, entryDate, lastUpdate, status) 
                            VALUES ($buyerId,'$this->budget','$this->vehicleName','$this->varient','$this->fuelType','$this->vehicleColor','$this->modelYear','$this->passingStatus','$this->bodyType','$this->numberOfOwner','$this->todaysDate','$this->todaysDate','Active')";
        $this->result = $this->db->query($sql);
        
             if($this->result)
            {
                $sql = "INSERT INTO reminder (buyerId, buyerDate,entryDate, vehicleName, budget,varient, fuelType, vehicleColor, modelYear, passingStatus, bodyType, numberOfOwner,
                        remarks, status) 
                        VALUES ($buyerId,DATE_ADD('$this->todaysDate', INTERVAL 3 DAY) ,'$this->todaysDate','$this->vehicleName','$this->budget','$this->varient','$this->fuelType','$this->vehicleColor','$this->modelYear','$this->passingStatus','$this->bodyType','$this->numberOfOwner','$this->remarks',
                        'Active')";
                        

                $this->result = $this->db->query($sql);

                return $last_id;
            }
            else
            {
                return false;
            }
    
    }

    public function readNewVehicleBodyType()
    {
        $sql = "SELECT * FROM $this->db_table";
        $this->result = $this->db->query($sql);
        
        
        return $this->result;
    }
    public function getbuyersReminderCount()
{
   $sql = " select COUNT(id) from reminder where DATE(buyerDate) = CURDATE()";
    $this->result = $this->db->query($sql);
    return $this->result;
}    
   
    public function updateVehicleBodyType()
    {
        $sql = "SELECT * FROM $this->db_table WHERE id='$this->id'";
        $this->result = $this->db->query($sql);
        
        if(mysqli_num_rows($this->result) > 0)
        {
            $sql = "UPDATE $this->db_table SET bodyType='$this->bodyType' WHERE id='$this->id'";
        
            $this->result = $this->db->query($sql);
            return $this->db;
        }
        
    }

    public function deleteEnquiry()
    {
        $sql = "DELETE FROM new_enquiry WHERE id='$this->id'";
        
            $this->result = $this->db->query($sql);
            return $this->db;
    }
    
    public function deleteVehicleBodyType()
    {
        $sql = "DELETE FROM $this->db_table WHERE id='$this->id'";
        
            $this->result = $this->db->query($sql);
            return $this->db;
    }
}


?>