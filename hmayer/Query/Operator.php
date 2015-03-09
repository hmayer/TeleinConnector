<?php

namespace hmayer\Query;

/**
 * Description of Operator
 *
 * @author mayer
 */
class Operator
{

    private $operator = "";
    private $error_code = 0;

    private function handleOperatorQuery($stream)
    {
        list($op, $msisdn) = preg_split('/#/', $stream);
        unset($msisdn);
        if (strlen($op) == 2) {
            $this->operator = $op;
            $this->error_code = 0;
        } else {
            $this->operator = "99";
            $this->error_code = 1;
        }
    }
    
    private function handleRn1Query($stream)
    {
        list($op, $msisdn) = preg_split('/#/', $stream);
        unset($msisdn);
        if (strlen($op) > 2) {
            $this->operator = $op;
            $this->error_code = 0;
        } else {
            $this->operator = "99999";
            $this->error_code = 1;
        }
    }

    public function __construct($stream)
    {
        if (\hmayer\Config\Settings::getValue('query') == 'operator') {
            $this->handleOperatorQuery($stream);
        } else {
            $this->handleRn1Query($stream);
        }
    }

    public function getOperator()
    {
        return $this->operator;
    }

    public function errorCode()
    {
        return $this->error_code;
    }

    public function agiFormat()
    {
        $agi = "SET VARIABLE TELEIN_ERROR {$this->errorCode()}\n";
        $agi .= "SET VARIABLE TELEIN_ROUTE {$this->getOperator()}\n";
        return $agi;
    }

}
