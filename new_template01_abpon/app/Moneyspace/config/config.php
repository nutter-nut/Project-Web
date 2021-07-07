<?php
namespace App\Moneyspace\config;
class Config {


	private $secret_id  = "NLT78840R24TN4SBHJ0Z";
	private $secret_key = "YMRvV0YThr2LR65upG8Qy8V22j5F8y7pTf6V0jQLW1lb57i5OqjWo0GKHZ3FKH4d5W039F36D312J7GK";
	// private $secret_id  = "5QH384811CU9WQ3K46DG";
	// private $secret_key = "DcAmTr9MD05Z2Y6a4Nd0XoBuV33pYPBCs87i5XnZwJe8UWY9cRb29sgdp1a72no1874h9GC6RMRIVk22";



	////////////////////////////////////////////////////////////////////////////////////////

	public function getSecret_id() {
		return $this->secret_id;
	}
	public function getSecret_key() {
		return $this->secret_key;
	}

}