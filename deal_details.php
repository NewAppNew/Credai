<?php

class dealDetail
{
    public $db;
    public $result;
    public $idDeal;
    //update seller details
    public $idSeller;
    public $S_occupation;
    public $S_aadharNo;
    public $S_PANNumber;
    public $S_licenseNo;
    public $S_address;
    public $owner;

    //update buyer details
    public $idBuyer;
    public $B_occupation;
    public $B_aadharNo;
    public $B_PANNumber;
    public $B_licenseNo;
    public $B_address;
    
    //update vehicle details
    public $idVehicle;
    public $vehicleName;
    public $varient;
    public $dealAmount;
    public $advancedAmount;
    public $amountPaid;
    public $amountWithUs;
    public $receivableAmount;
    public $paybleAmount;
    public $CASEAmount;
    public $commissionBuyer;
    public $commissionSeller;
    public $insurance;
    public $tax;
    public $taxdue;
    public $accidental;
    public $noc;
    public $loan;
    public $loanAmount;
    public $bankname;
    public $branch;
    public $loanInstallments;
    public $stepany;
    public $exraKey;
    public $tyreCondition;

    //insert RTO work
    public $trasnfer;
    public $NOC;
    public $HP;
    public $PUC;
    public $paperTransferDate;
    public $registerDate;
    public $transactionMode;
    public $transactionId;
    public $idDealer;
    public $transRemark;
    public $chequeNo;
    public $bankName;
    public $chequeDate;

    public function __construct($db)
    {
        $this->db = $db;
        $this->todaysDate = date("Y-m-d H:i:s");
         $this->todaysTime = date("H:i:s");
    }

    public function saveQuickReciept()
    {
        
        
        $dueAmount = (float)$this->dueAmount - (float)$this->amountPaid;
        $sql = "INSERT INTO transaction (idDeal, dealAmount, paidAmount, 
                        dueAmount, paidDate, paidTime,transactionMode, transactionId, transStatus, transRemark,chequeNo) 
                        VALUES ('$this->dealId','$this->dealAmount','$this->amountPaid','$dueAmount',
                        '$this->todaysDate', '$this->todaysTime','$this->transactionMode','$this->transactionId','Paid','$this->transRemark','$this->chequeNo')";
                        
        $this->result = $this->db->query($sql);

        $last_id = $this->db->insert_id;

        if($this->result)
        {
            if($dueAmount <= 0)
            {
                $sql = "UPDATE deal_details SET dealStatus='Completed' WHERE id='$this->dealId'";

                $this->result = $this->db->query($sql);

            }

            //fetch the reciept print preview data

            $sql = "SELECT DD.dealAmount,US.id AS buyerId,US.userFullName,
                    US.address,CD.vehicleName,CD.varient,TR.paidAmount,TR.id,TR.idDeal,TR.dueAmount,TR.dueAmount,TR.transRemark,TR.paidDate
                    FROM car_details AS CD
                    INNER JOIN deal_details AS DD ON DD.idVehicle = CD.id
                    INNER JOIN user AS US ON DD.idBuyer=US.id
                    INNER JOIN transaction AS TR ON TR.idDeal=DD.id
                    WHERE TR.id=$last_id";

            $this->result = $this->db->query($sql);        
            
            return $this->result;
        }
        
    }
    
    public function getNextDealId()
    {
        $sql = "SELECT AUTO_INCREMENT AS nextDealId FROM information_schema.TABLES WHERE TABLE_SCHEMA ='mithari_auto' AND TABLE_NAME ='deal_details'";

        $this->result = $this->db->query($sql);        
        
        if(mysqli_num_rows($this->result) > 0)
        {
            while($row1 = mysqli_fetch_assoc($this->result))
            {
                $nextDealId = $row1['nextDealId'];
            }
        }

        return $nextDealId;
    }

    public function getNextRecieptId()
    {
        $sql = "SELECT AUTO_INCREMENT AS nextRecId FROM information_schema.TABLES WHERE TABLE_SCHEMA ='mithari_auto' AND TABLE_NAME ='transaction'";
        

        $this->result = $this->db->query($sql);        
        
        if(mysqli_num_rows($this->result) > 0)
        {
            while($row1 = mysqli_fetch_assoc($this->result))
            {
                $nextRecId = $row1['nextRecId'];
            }
        }

        return $nextRecId;
    }

    public function getQuickRecieptData($vehicleNumber)
    {
        $sql = "SELECT DD.id AS dealId,DD.dealAmount,US.id AS buyerId,US.userFullName,US.address,CD.vehicleName,CD.varient
        FROM car_details AS CD
        INNER JOIN deal_details AS DD ON DD.idVehicle = CD.id
        INNER JOIN user AS US ON DD.idBuyer=US.id
        WHERE CD.vehicleNumber=$vehicleNumber";

        $this->result = $this->db->query($sql);        
        
        return $this->result;
    }
    public function getVehicleInformationByVNameVerient()
    {

    
        $sql = "SELECT CD.id AS vId,CD.vehicleName,CD.vehicleNumber,CD.varient,CD.bodyType,CD.modelYear,
        CD.fuelType,CD.expectedPrice,US.id AS uId,US.userFullName,US.mobileNo,US.address 
        FROM car_details AS CD
        INNER JOIN user AS US ON US.id=CD.sellerId
        WHERE CD.status='Active'";
        $this->result = $this->db->query($sql);


        return $this->result;
    }
    
    public function getVehicleInformationByNumber()
    {
        $sql = "SELECT CD.id AS vId,CD.vehicleName,CD.vehicleNumber,CD.varient,CD.bodyType,CD.modelYear,CD.bankName,
        CD.insurance,CD.taxDue,CD.tyreCondition,CD.accidental,CD.noc,CD.stepany,CD.extraKey,CD.loanAmount,CD.branch,
                CD.fuelType,CD.color,CD.passing,CD.chassisNo,CD.EngineNo,CD.kmsDriven,CD.average,
                CD.numberOfOwner,CD.expectedPrice,US.id AS uId,US.userFullName,US.mobileNo,US.address ,US.occupation 
                FROM car_details AS CD
                INNER JOIN user AS US ON US.id=CD.sellerId
                WHERE CD.vehicleNumber='$this->vehicleNumber' AND CD.status='Active'";
        $this->result = $this->db->query($sql);
        return $this->result;
    }

    public function confirmNewDeal()
    {
        //update Seller in user table
        $sql = "UPDATE user SET occupation='$this->S_occupation',aadharNo='$this->S_aadharNo', 
                PANNumber='$this->S_PANNumber',licenseNo='$this->S_licenseNo',address='$this->S_address'
                WHERE id=$this->idSeller";
        
        $this->result = $this->db->query($sql);
        
        //update Buyer in user table
        $sql = "UPDATE user SET occupation='$this->B_occupation',aadharNo='$this->B_aadharNo', 
                PANNumber='$this->B_PANNumber',licenseNo='$this->B_licenseNo',address='$this->B_address'
                WHERE id=$this->idBuyer";
        
        $this->result = $this->db->query($sql);

        //update Car details in car_details table

        $sql = "UPDATE car_details SET insurance='$this->insurance',tax='$this->tax', 
                taxdue='$this->taxdue',accidental='$this->accidental',noc='$this->noc',
                loan='$this->loan',loanAmount='$this->loanAmount',bankname='$this->bankname',
                branch='$this->branch',loanInstallments='$this->loanInstallments',
                stepany='$this->stepany',extraKey='$this->exraKey',tyreCondition='$this->tyreCondition'
                WHERE id=$this->idVehicle";
        
        $this->result = $this->db->query($sql);

        if($this->result)
        {
            //insert new deal details into deal_details table
            
            if($this->idDealer == NULL)
            {
                $this->idDealer = 0;
            }
            
            $sql = "INSERT INTO deal_details (idBuyer, idSeller, idVehicle, idDealer,dealStatus, 
                    dealAmount, advancedAmount, CASEAmount, commissionBuyer, commissionSeller, trasnfer, 
                    NOC, HP, PUC, dealDate, paperTransferDate, dealEntryDate, registerDate) 
                    VALUES ($this->idBuyer,$this->idSeller,$this->idVehicle,$this->idDealer,'Done',
                    '$this->dealAmount','$this->advancedAmount',
                    '$this->CASEAmount','$this->commissionBuyer','$this->commissionSeller',
                    '$this->trasnfer','$this->NOC','$this->HP','$this->PUC','$this->todaysDate',
                    '$this->paperTransferDate','$this->todaysDate','$this->registerDate')";
            $this->result = $this->db->query($sql);

            if($this->result)
            {
                $last_id = $this->db->insert_id;

                $dueAmount = (float)$this->dealAmount - (float)$this->amountPaid;

                
                $sql = "INSERT INTO transaction (idDeal, dealAmount, paidAmount, 
                        dueAmount, paidDate,paidTime, transactionMode, transactionId, transStatus,transRemark,chequeNo) 
                        VALUES ($last_id,'$this->dealAmount','$this->amountPaid','$dueAmount',
                        '$this->todaysDate',  '$this->todaysTime','$this->transactionMode','$this->transactionId','Advanced','$this->transRemark','$this->chequeNo')";
                        

                $this->result = $this->db->query($sql);

                if($dueAmount <= 0)
                {
                    $sql = "UPDATE deal_details SET dealStatus='Completed' WHERE id=$last_id";

                    $this->result = $this->db->query($sql);
                }
                return $last_id;
            }
            else
            {
                return false;
            }

           
        }

        
    }


    public function readDealById()
    {
        $sql = "SELECT US.* 
                FROM user AS US
                INNER JOIN deal_details AS DD ON DD.idBuyer=US.id
                WHERE DD.id=$this->idDeal";

        $this->result = $this->db->query($sql);
        
        $dealData = array();

        if(mysqli_num_rows($this->result) > 0)
        {
            while($row1 = mysqli_fetch_assoc($this->result))
            {
                $dealData['Bid'] = $row1['id'];
                $dealData['BFullName'] = $row1['userFullName'];
                $dealData['BmobileNo'] = $row1['mobileNo'];
                $dealData['Baddress'] = $row1['address'];
                $dealData['Boccupation'] = $row1['occupation'];
                $dealData['BaadharNo'] = $row1['aadharNo'];
                $dealData['BPANNumber'] = $row1['PANNumber'];
                $dealData['BlicenseNo'] = $row1['licenseNo'];
            }
        }
        

        
        $sql = "SELECT US.* 
                FROM user AS US
                INNER JOIN deal_details AS DD ON DD.idSeller=US.id
                WHERE DD.id=$this->idDeal";

        $this->result = $this->db->query($sql);        

        if(mysqli_num_rows($this->result) > 0)
        {
            while($row2 = mysqli_fetch_assoc($this->result))
            {
                $dealData['Sid'] = $row2['id'];
                $dealData['SFullName'] = $row2['userFullName'];
                $dealData['SmobileNo'] = $row2['mobileNo'];
                $dealData['Saddress'] = $row2['address'];
                $dealData['Soccupation'] = $row2['occupation'];
                $dealData['SaadharNo'] = $row2['aadharNo'];
                $dealData['SPANNumber'] = $row2['PANNumber'];
                $dealData['SlicenseNo'] = $row2['licenseNo'];
            }
        }
        else
        {
            return false;
        }

        

        $sql = "SELECT CD.* 
                FROM car_details AS CD
                INNER JOIN deal_details AS DD ON DD.idVehicle=CD.id
                WHERE DD.id=$this->idDeal";

        $this->result = $this->db->query($sql);

        if(mysqli_num_rows($this->result) > 0)
        {
             
            while($row3 = mysqli_fetch_assoc($this->result))
            {
                $dealData['Cid'] = $row3['id'];
                $dealData['vehicleName'] = $row3['vehicleName'];
                $dealData['vehicleNumber'] = $row3['vehicleNumber'];
                $dealData['varient'] = $row3['varient'];
                $dealData['bodyType'] = $row3['bodyType'];
                $dealData['color'] = $row3['color'];
                $dealData['fuelType'] = $row3['fuelType'];
                $dealData['passing'] = $row3['passing'];
                $dealData['modelYear'] = $row3['modelYear'];
                $dealData['insurance'] = $row3['insurance'];
                $dealData['insuranceLastDate'] = $row3['insuranceLastDate'];
                $dealData['numberOfOwner'] = $row3['numberOfOwner'];
                $dealData['average'] = $row3['average'];
                $dealData['kmsDriven'] = $row3['kmsDriven'];
                $dealData['accidental'] = $row3['accidental'];
                $dealData['EngineNo'] = $row3['EngineNo'];
                $dealData['chassisNo'] = $row3['chassisNo'];
                $dealData['tyreCondition'] = $row3['tyreCondition'];
                $dealData['tax'] = $row3['tax'];
                $dealData['expectedPrice'] = $row3['expectedPrice'];
                $dealData['expectedPriceWords'] = trim(getIndianCurrency($row3['expectedPrice']));
                $dealData['stepany'] = $row3['stepany'];
                $dealData['extraKey'] = $row3['extraKey'];
                $dealData['loan'] = $row3['loan'];
                $dealData['branch'] = $row3['branch'];
                $dealData['bankName'] = $row3['bankName'];
                $dealData['loanInstallments'] = $row3['loanInstallments'];
                $dealData['loanAmount'] = $row3['loanAmount'];

            }
        }
        else
        {
            return false;
        }
       

        $sql = "SELECT * FROM deal_details WHERE id=$this->idDeal";

        $this->result = $this->db->query($sql);

        if(mysqli_num_rows($this->result) > 0)
        {
             
            while($row4 = mysqli_fetch_assoc($this->result))
            {    
                          

                $dealData['idDeal'] = $row4['id'];
                $dealData['dealAmount'] = $row4['dealAmount'];
                $dealData['advancedAmount'] = $row4['advancedAmount'];
                $dealData['remainedAmount'] = (float)$row4['dealAmount'] - (float)$row4['advancedAmount'];
                $dealData['advancedAmountInwords'] = trim(getIndianCurrency($row4['advancedAmount']));
                $dealData['dealAmountWords'] = getIndianCurrency((float)$row4['dealAmount']);
                $dealData['dealDate'] =  date("d-M-Y  g:i A", strtotime($row4["dealDate"]));
                $dealData['commissionBuyer'] = $row4['commissionBuyer'];
                $dealData['commissionSeller'] = $row4['commissionSeller'];
                $dealData['trasnfer'] = $row4['trasnfer'];
                $dealData['NOC'] = $row4['NOC'];
                $dealData['HP'] = $row4['HP'];
                $dealData['paperTransferDate'] = $row4['paperTransferDate'];
                $dealData['registerDate'] = $row4['registerDate'];
                  
            }
        }
        else
        {
            return false;
        }
       

        $sql = "SELECT * FROM transaction WHERE idDeal=$this->idDeal";

        $this->result = $this->db->query($sql);

        if(mysqli_num_rows($this->result) > 0)
        {
             
            while($row5 = mysqli_fetch_assoc($this->result))
            {                  

                $dealData['transactionData'][] = $row5;            
                
            }
        }
        else
        {
            return false;
        }


        return $dealData;
    }
    public function getQuickReceiptByNumber()
    {
        $sql = "SELECT CD.id AS vId,CD.vehicleName,CD.vehicleNumber,CD.varient,CD.bodyType,CD.modelYear,
                CD.fuelType,CD.color,CD.passing,CD.chassisNo,CD.EngineNo,CD.kmsDriven,CD.average,
                CD.numberOfOwner,CD.expectedPrice,US.id AS uId,US.userFullName,US.mobileNo,US.address 
                FROM car_details AS CD
                INNER JOIN user AS US ON US.id=CD.sellerId
                WHERE CD.dealStatus='Done' AND CD.vehicleNumber='$vNumber'";
        $this->result = $this->db->query($sql);
        
        
        return $this->result;
    }
            public function getAllQuickprintById()
    {
       $sql = "SELECT DD.dealAmount,US.id AS buyerId,US.userFullName,US.mobileNo,
                    US.address,CD.vehicleName,CD.varient,CD.vehicleNumber,CD.EngineNo,CD.chassisNo,CD.modelYear,
                    TR.paidAmount,TR.id,TR.idDeal,TR.dueAmount,TR.dueAmount,TR.transRemark,TR.paidDate,TR.chequeNo,TR.transactionMode,TR.paidDate,TR.paidTime,TR.dealAmount
                    FROM car_details AS CD
                    INNER JOIN deal_details AS DD ON DD.idVehicle = CD.id
                    INNER JOIN user AS US ON DD.idBuyer=US.id
                    INNER JOIN transaction AS TR ON TR.idDeal=DD.id
                    WHERE TR.id = $this->id";
                       $this->result = $this->db->query($sql);  
                       $dealData = array();
                            if(mysqli_num_rows($this->result) > 0)
        {
            while($row1 = mysqli_fetch_assoc($this->result))
            {
                $dealData['Bid'] = $row1['id'];
                $dealData['BFullName'] = $row1['userFullName'];
                $dealData['Baddress'] = $row1['address'];
                   $dealData['BmobileNo'] = $row1['mobileNo'];
                     $dealData['vehicleName'] = $row1['vehicleName'];
                            $dealData['modelYear'] = $row1['modelYear'];
                        $dealData['dealAmount'] = $row1['dealAmount'];
                            $dealData['EngineNo'] = $row1['EngineNo'];
                        $dealData['chassisNo'] = $row1['chassisNo'];
                     $dealData['paidAmount'] = $row1['paidAmount'];
                          $dealData['transRemark'] = $row1['transRemark'];
                     $dealData['paidAmount'] = $row1['paidAmount'];
                     $dealData['dueAmount'] = $row1['dueAmount'];
                     
                                     $dealData['dueAmountWord'] = trim(getIndianCurrency($row1['dueAmount']));
                                       $dealData['dealAmountWord'] = trim(getIndianCurrency($row1['dealAmount']));
                                     $dealData['paidAmountWord'] = trim(getIndianCurrency($row1['paidAmount']));
                        $dealData['paidDate'] = $row1['paidDate'];
                                 $dealData['paidTime'] = $row1['paidTime'];
                     $dealData['chequeNo'] = $row1['chequeNo'];
                          $dealData['transactionMode'] = $row1['transactionMode'];
                          $dealData['vehicleNumber'] = $row1['vehicleNumber'];

            }
        }
            $sql1 = "SELECT US.* 
                FROM user AS US
                INNER JOIN deal_details AS DD ON DD.idSeller=US.id
                 INNER JOIN transaction AS TR ON TR.idDeal=DD.id
                WHERE TR.id=$this->id";
        $this->result1 = $this->db->query($sql1);     


        if(mysqli_num_rows($this->result1) > 0)
        {
            while($row3 = mysqli_fetch_assoc($this->result1))
            {
                $dealData['Sid'] = $row3['id'];
                $dealData['SFullName'] = $row3['userFullName'];
                $dealData['SmobileNo'] = $row3['mobileNo'];
                $dealData['Saddress'] = $row3['address'];
                $dealData['Soccupation'] = $row3['occupation'];
                $dealData['SaadharNo'] = $row3['aadharNo'];
                $dealData['SPANNumber'] = $row3['PANNumber'];
                $dealData['SlicenseNo'] = $row3['licenseNo'];
            }
        }
      return $dealData;

    }
 
        public function getRecordsQuickprintById()
    {
                 $sql = "SELECT US.* 
                FROM user AS US
                INNER JOIN deal_details AS DD ON DD.idBuyer=US.id
                WHERE DD.id=$this->idDeal";

        $this->result = $this->db->query($sql);
        
        $dealData = array();

        if(mysqli_num_rows($this->result) > 0)
        {
            while($row1 = mysqli_fetch_assoc($this->result))
            {
                $dealData['Bid'] = $row1['id'];
                $dealData['BFullName'] = $row1['userFullName'];
                $dealData['Baddress'] = $row1['address'];

            }
        }
        

        
        $sql = "SELECT US.* 
                FROM user AS US
                INNER JOIN deal_details AS DD ON DD.idSeller=US.id
                WHERE DD.id=$this->idDeal";

        $this->result = $this->db->query($sql);        

        

        $sql = "SELECT CD.* 
                FROM car_details AS CD
                INNER JOIN deal_details AS DD ON DD.idVehicle=CD.id
                WHERE DD.id=$this->idDeal";

        $this->result = $this->db->query($sql);

        if(mysqli_num_rows($this->result) > 0)
        {
             
            while($row3 = mysqli_fetch_assoc($this->result))
            {
                $dealData['Cid'] = $row3['id'];
                $dealData['vehicleName'] = $row3['vehicleName'];
                $dealData['vehicleNumber'] = $row3['vehicleNumber'];
            }
        }
        else
        {
            return false;
        }
       

        $sql = "SELECT * FROM deal_details WHERE id=$this->idDeal";

        $this->result = $this->db->query($sql);

        if(mysqli_num_rows($this->result) > 0)
        {
             
            while($row4 = mysqli_fetch_assoc($this->result))
            {    
                $dealData['idDeal'] = $row4['id'];
                $dealData['dealAmount'] = $row4['dealAmount'];
                
            }
        }
        else
        {
            return false;
        }
       

        $sql = "SELECT * FROM transaction WHERE idDeal=$this->idDeal";

        $this->result = $this->db->query($sql);

        if(mysqli_num_rows($this->result) > 0)
        {
             
            while($row5 = mysqli_fetch_assoc($this->result))
            {                  

                // $dealData['transactionData'][] = $row5;   
                   $dealData['id'] = $row5['id'];
                $dealData['dueAmount'] = $row5['dueAmount'];
                 $dealData['paidDate'] = $row5['paidDate'];
                $dealData['paidAmount'] = $row5['paidAmount'];
                $dealData['transRemark'] = $row5['transRemark'];
                $dealData['chequeNo'] = $row5['chequeNo'];
                $dealData['transactionMode'] = $row5['transactionMode'];
                
            }
        }
        else
        {
            return false;
        }


        return $dealData;
     
    }
  
}