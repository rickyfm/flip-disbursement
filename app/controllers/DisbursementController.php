<?php
namespace app\controllers;

require_once __DIR__.'/../models/Disbursement.php';
require_once __DIR__.'/../Api.php';

use App\Api as API;
use App\Models\Disbursement as Model;

class DisbursementController
{
    protected static $url = "https://nextar.flip.id/disburse";

    public function createOrUpdate($argv)
    {
        if (count($argv) < 2 || (count($argv) > 2 && count($argv) < 5) || count($argv) > 5) {
            echo "wrong argument!\n";
            echo "example create: php disbursement.php bni 87452834 10000 'testing'\n";
            echo "example update: php disbursement.php 43597233\n";
            return;
        }

        $update = true;
        $data = null;

        $id = $argv[1];
        if (count($argv) == 5) {
            $update = false;
            $data = [
              'bank_code'      => $argv[1],
              'account_number' => $argv[2],
              'amount'         => $argv[3],
              'remark'         => $argv[4],
            ];
        }


        if ($update) {
            $response = json_decode(API::request(static::$url.'/'.$id, 'GET'));
        } else {
            $response = json_decode(API::request(static::$url, 'POST', $data));
        }

        if (isset($response->errors)) {
            print($response->errors[0]->message);
            exit;
        }

        $model = new Model;
        if ($update) {
            $model->update($id, $response);
            print("Update Disbursement successfull \n");
        } else {
            $model->setIdDisbursement($response->id);
            $model->setAmount($response->amount);
            $model->setStatus($response->status);
            $model->setTimestamp($response->timestamp);
            $model->setBankCode($response->bank_code);
            $model->setAccountNumber($response->account_number);
            $model->setBeneficiaryName($response->beneficiary_name);
            $model->setRemark($response->remark);
            $model->setReceipt($response->receipt);
            if($response->time_served !== '0000-00-00 00:00:00'){
              $model->setTimeServed($response->time_served);
            }
            $model->setFee($response->fee);
            $model->save();

            print("Create Disbursement successfull \n");
        }
        print_r($response);
    }

    public function updatePeriodic()
    {
        $model = new Model;
        $data = $model->getPendingStatus();
        $argv = [];
        foreach ($data as $id_disbursement) {
            $argv = [
              "update",$id_disbursement
            ];
            $this->createOrUpdate($argv);
        }
    }
}
