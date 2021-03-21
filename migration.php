<?php

require __DIR__.'app/connections/DB.php';

try {
    $query = "CREATE TABLE IF NOT EXISTS `disbursement` (
        `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `id_disbursement` BIGINT NOT NULL,
        `amount` FLOAT NOT NULL,
        `status` varchar(20) NOT NULL,
        `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `bank_code` varchar(50) NOT NULL,
        `account_number` varchar(50) NOT NULL,
        `beneficiary_name` varchar(100) NOT NULL,
        `remark` text NOT NULL,
        `receipt` text NULL,
        `time_served` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
        `fee` decimal(10,2) NOT NULL,
        CONSTRAINT `id_disbursement` UNIQUE (`id_disbursement`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $conn->exec($queryDisbursement);
    print("Created table successfull.\n");
} catch (PDOException $e) {
    echo $e->getMessage();
    exit();
}
