<?php

require_once 'app/controllers/DisbursementController.php';

use app\controllers\DisbursementController;

$disbursement = new DisbursementController();
$disbursement->updatePeriodic();
