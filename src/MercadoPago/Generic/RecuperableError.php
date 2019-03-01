<?php
 
namespace MercadoPago;

class RecuperableError {

    public $message = "";
    public $status = "";
    public $error = "";

    public $cause = array();

    function __construct($message, $error, $status) {
        $this->message = $message;
        $this->status = $status;
        $this->error = $error;
    }

    public function add_cause($code, $description){
        $error_cause = new MercadoPago\ErrorCause();
        $error_cause->code = $code;
        $error_cause->description = $description;
        array_push($this->cause, $error_cause);
    }

    public function __toString()
    {
        return $this->error . ": " . $this->message;
    }

}

?>