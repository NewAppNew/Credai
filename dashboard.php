<?php
date_default_timezone_set("Asia/Kolkata");

class dashBoard
{
    public $db;
    public $result;
    public $todaysDate;
    public $id;
    public $remarks;
    public $buyerDate;
    public function __construct($db)
    {
        $this->db = $db;
        $this->todaysDate = date("Y-m-d H:i:s");
    }
    
       public function notificationData()
    {
        $sql = "SELECT NE.buyerId AS enqId,NE.vehicleName,NE.id,NE.remarks,
   NE.buyerDate  ,US.userType ,US.userFullName,US.mobileNo
                FROM reminder AS NE
                INNER JOIN user AS US ON NE.buyerId = US.id
              WHERE DATE(buyerDate) = CURDATE()";

         $this->result = $this->db->query($sql);
        return $this->result;
    }
      public function updateNotification()
    {
        $sql = "SELECT * FROM reminder WHERE id='$this->id'";
        $this->result = $this->db->query($sql);
        
        if(mysqli_num_rows($this->result) > 0)
        {
            $sql = "UPDATE reminder SET remarks='$this->remarks' ,buyerDate=DATE_ADD('$this->todaysDate', INTERVAL 7 DAY) WHERE id='$this->id'";
        
            $this->result = $this->db->query($sql);
            return $this->db;
        }
        
    }
   
       public function updateScheduleNotification()
    {
        $sql = "SELECT * FROM reminder WHERE id='$this->id'";
        $this->result = $this->db->query($sql);
        
        if(mysqli_num_rows($this->result) > 0)
        {
            $sql = "UPDATE reminder SET remarks='$this->remarks' ,buyerDate='$this->buyerDate' WHERE id='$this->id'";
        
            $this->result = $this->db->query($sql);
            return $this->db;
        }
        
    }
        public function getnotificationData()
    {
        $sql = "SELECT NE.id AS enqId,US.userFullName,US.address,US.mobileNo,
                NE.vehicleName,NE.varient,NE.vehicleColor,NE.passingStatus,NE.fuelType,NE.remarks,
                NE.bodyType,NE.modelYear,NE.budget,NE.entryDate
                FROM  AS NE reminder
                INNER JOIN user AS US ON NE.idBuyer = US.id
                WHERE NE.id = $this->id  AND US.status='Active'";
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
    public function allNotificationData()
    {
       $sql = "SELECT NE.id AS enqId,US.userFullName,US.address,US.mobileNo,
                NE.vehicleName,NE.varient,NE.vehicleColor,NE.passingStatus,NE.fuelType,NE.remarks,
                NE.bodyType,NE.modelYear,NE.budget,NE.buyerDate,NE.entryDate
                FROM reminder AS NE 
                INNER JOIN user AS US ON NE.buyerId = US.id
                WHERE  US.userType='Buyer' AND US.status='Active'";
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
    public function deletenotificationData()
    {
        $sql = "DELETE FROM reminder WHERE id='$this->id'";
        
            $this->result = $this->db->query($sql);
            return $this->db;
    }
    public function readDashboardData()
    {
        $resultArray = array();

        $sql = "SELECT COUNT(*) AS totalSeller FROM user  
          where MONTH(entryDate)=MONTH(now())
                and YEAR(entryDate)=YEAR(now())
                and userType='Seller'";
        $this->result = $this
            ->db
            ->query($sql);

        if ($this->result)
        {

            if (mysqli_num_rows($this->result) > 0)
            {
                while ($row = mysqli_fetch_assoc($this->result))
                {
                    $resultArray['totalSeller'] = $row['totalSeller'];
                }
            }
            else
            {
                $resultArray['totalSeller'] = 0;
            }
        }

        $this->result = $row = NULL;

        $sql = "select count(*) AS totalBuyer from user
                where MONTH(entryDate)=MONTH(now())
                and YEAR(entryDate)=YEAR(now())
                and userType='Buyer'";
        $this->result = $this
            ->db
            ->query($sql);

        if ($this->result)
        {

            if (mysqli_num_rows($this->result) > 0)
            {
                while ($row = mysqli_fetch_assoc($this->result))
                {
                    $resultArray['totalBuyer'] = $row['totalBuyer'];
                }
            }
            else
            {
                $resultArray['totalBuyer'] = 0;
            }
        }

        $this->result = $row = NULL;

        $sql = "SELECT COUNT(*) AS totaldeals FROM deal_details  
         where MONTH(dealDate)=MONTH(now())
                and YEAR(dealDate)=YEAR(now())
                and dealStatus='Completed'";

        $this->result = $this
            ->db
            ->query($sql);

        if ($this->result)
        {

            if (mysqli_num_rows($this->result) > 0)
            {
                while ($row = mysqli_fetch_assoc($this->result))
                {
                    $resultArray['totaldeals'] = $row['totaldeals'];
                }
            }
            else
            {
                $resultArray['totaldeals'] = 0;
            }
        }

        $this->result = $row = NULL;

        $sql = "SELECT COUNT(*) AS totalTwoWheelers FROM car_details 
                  where MONTH(entryDate)=MONTH(now())
                and YEAR(entryDate)=YEAR(now())
                and wheeler='Two' ";

        $this->result = $this
            ->db
            ->query($sql);

        if ($this->result)
        {

            if (mysqli_num_rows($this->result) > 0)
            {
                while ($row = mysqli_fetch_assoc($this->result))
                {
                    $resultArray['totalTwoWheelers'] = $row['totalTwoWheelers'];
                }
            }
            else
            {
                $resultArray['totalTwoWheelers'] = 0;
            }
        }

        $this->result = $row = NULL;

        $sql = "SELECT COUNT(*) AS totalFourWheelers FROM car_details
        
         where MONTH(entryDate)=MONTH(now())
                and YEAR(entryDate)=YEAR(now())
                and wheeler='Four'
     ";

        $this->result = $this
            ->db
            ->query($sql);

        if ($this->result)
        {

            if (mysqli_num_rows($this->result) > 0)
            {
                while ($row = mysqli_fetch_assoc($this->result))
                {
                    $resultArray['totalFourWheelers'] = $row['totalFourWheelers'];
                }
            }
            else
            {
                $resultArray['totalFourWheelers'] = 0;
            }
        }

        $sql = "SELECT COUNT(*) AS totalCancelledDeals FROM deal_details 
        where MONTH(dealDate)=MONTH(now())
                and YEAR(dealDate)=YEAR(now())
                and dealStatus='Cancelled'
      ";

        $this->result = $this
            ->db
            ->query($sql);

        if ($this->result)
        {

            if (mysqli_num_rows($this->result) > 0)
            {
                while ($row = mysqli_fetch_assoc($this->result))
                {
                    $resultArray['totalCancelledDeals'] = $row['totalCancelledDeals'];
                }
            }
            else
            {
                $resultArray['totalCancelledDeals'] = 0;
            }
        }

        $sql = "select COUNT(id) AS todayReminder from reminder where DATE(buyerDate) = CURDATE()";

        $this->result = $this
            ->db
            ->query($sql);

        if ($this->result)
        {

            if (mysqli_num_rows($this->result) > 0)
            {
                while ($row = mysqli_fetch_assoc($this->result))
                {
                    $resultArray['todayReminder'] = $row['todayReminder'];
                }
            }
            else
            {
                $resultArray['todayReminder'] = 0;
            }
        }

        return $resultArray;
    }

}

