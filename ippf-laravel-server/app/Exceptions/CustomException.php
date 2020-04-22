<?php namespace App\Exceptions;

use Exception;

class CustomException extends Exception {
	public $dataArray;

    public function __construct($dataArray, $message, $code, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
        $this->dataArray = $dataArray;
    }
}
// throw new CustomException;