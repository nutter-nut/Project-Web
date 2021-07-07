<?php

namespace App;

use Nantaburi\Mongodb\MongoNativeDriver\Model;

class Payment extends Model
{
    protected $connection = "mongodb";

    protected  $database = "abpon01" ;

    protected  $collection = "payment" ;  

    protected $schema = [
        'payment' => [
            "id" => [
                'AutoInc' => true,
                // 'AutoIncStartwith' => 10,
                // 'Index' => true,
                'Unique' => true
            ],
            "order_id",
            "payment_type",
            "transaction_type",
            "pymt_method",
            "service_id",
            "payment_id",
            "order_number",
            "amount",
            "currency_code",
            "hash_value",
            "hash_value2",
            "txn_id",
            "issuing_bank",
            "txn_xtatus",
            "auth_code",
            "bank_refNo",
            "token_type",
            "token",
            "resp_time",
            "txn_message",
            "card_no_mask",
            "card_holder",
            "card_type",
            "card_exp",
            "created_at",
            "updated_at"
        ],
    ];
}
