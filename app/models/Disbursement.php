<?php
namespace App\Models;

/**
 *
 */
class Disbursement
{
    protected static $tableName = 'disbursement';

    private $id_disbursement;
    private $amount;
    private $status;
    private $timestamp;
    private $bank_code;
    private $account_number;
    private $beneficiary_name;
    private $remark;
    private $receipt;
    private $time_served;
    private $fee;

    public function setIdDisbursement($id_disbursement)
    {
        $this->id_disbursement = $id_disbursement;
    }
    public function getIdDisbursement()
    {
        return $this->id_disbursement;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    public function getAmount()
    {
        return $this->amount;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setBankCode($bank_code)
    {
        $this->bank_code = $bank_code;
    }
    public function getBankCode()
    {
        return $this->bank_code;
    }

    public function setAccountNumber($account_number)
    {
        $this->account_number = $account_number;
    }
    public function getAccountNumber()
    {
        return $this->account_number;
    }

    public function setBeneficiaryName($beneficiary_name)
    {
        $this->beneficiary_name = $beneficiary_name;
    }
    public function getBeneficiaryName()
    {
        return $this->beneficiary_name;
    }

    public function setRemark($remark)
    {
        $this->remark = $remark;
    }
    public function getRemark()
    {
        return $this->remark;
    }

    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;
    }
    public function getReceipt()
    {
        return $this->receipt;
    }

    public function setTimeServed($time_served)
    {
        $this->time_served = $time_served;
    }
    public function getTimeServed()
    {
        return $this->time_served;
    }

    public function setFee($fee)
    {
        $this->fee = $fee;
    }
    public function getFee()
    {
        return $this->fee;
    }

    public function save()
    {
        require __DIR__.'/../connections/DB.php';

        $data = [
         'id_disbursement' => $this->getIdDisbursement(),
         'amount' => $this->getAmount(),
         'status' => $this->getStatus(),
         'timestamp' => $this->getTimestamp(),
         'bank_code' => $this->getBankCode(),
         'account_number' => $this->getAccountNumber(),
         'beneficiary_name' => $this->getBeneficiaryName(),
         'remark' => $this->getRemark(),
         'receipt' => $this->getReceipt(),
         'time_served' => $this->getTimeServed() ?? date('Y-m-d H:i:s'),
         'fee' => $this->getFee(),
      ];

        $columns = join(',', array_keys($data));
        $insert_values = array();
        foreach (array_values($data) as $field) {
            $insert_values[] = "'".$field."'";
        }
        $values = join(',', array_values($insert_values));
        $query = "INSERT INTO ".static::$tableName." ($columns) VALUES ($values)";

        if ($conn->query($query) === true) {
            echo "New record created successfully \n";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error . "\n";
        }

        $conn->close();
    }

    public function update($id, $data)
    {
        require __DIR__.'/../connections/DB.php';

        $first = true;
        $updateData = null;
        foreach ($data as $key=>$value) {
            if ($key == 'status' || $key == 'receipt' || $key == 'time_served') {
                if (!$first) {
                    $updateData .= ", ";
                }
                $updateData .= $value ? "$key='$value'" : "$key=null";
                $first = false;
            }
        }
        $query = "UPDATE ".static::$tableName." SET $updateData WHERE id_disbursement = $id";
        if ($conn->query($query) === true) {
            echo "Update record successfully \n";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error . "\n";
        }

        $conn->close();
    }

    public function getPendingStatus()
    {
        require __DIR__.'/../connections/DB.php';
        $query = "SELECT id_disbursement FROM disbursement WHERE status = 'PENDING'";

        $id_disbursement = [];
        if ($result = $conn -> query($query)) {
            while ($row = $result -> fetch_row()) {
                array_push($id_disbursement, $row[0]);
            }
            $result -> free_result();
            return $id_disbursement;
        } else {
            echo "Error: " . $query . "<br>" . $conn->error . "\n";
            exit();
        }

        $conn->close();
    }
}
