<?php

class Validator {
    function __construct() {
        $this->error = new UserError();
    }
    public function getErrors() {
        return  $this->error->get();
    }
    public function validate($rules, $data) {
        // check if empty
        if(empty($data)) {
            $this->error->addErrorCode(111);
            return false;
        }
        foreach($rules as $rule_key => $rule_str ) {
            // get index value as array element value from data array that equal to current rule index
            $index = array_filter(array_keys($data), function($d_key) use ($rule_key) { 
                return $rule_key === $d_key;
            });

            // when filter returns false and it's required, then adds error and moves to the next array element(if exists)
            if($index === false) {
                if(strpos($rule_str, 'required') !== false)
                    $this->error->addErrorCode(123);
                return;
            }

            // swaps the array key and it's value, then replaces the value from data array
            $value = array_intersect_key($data, array_flip($index));

            // if rule has "|" character, then splits it up and creates an array, otherwise creates an array with one element 
            $rule_arr = !empty($rule_str) && strpos($rule_str,'|') !== false ? explode('|',$rule_str) : [$rule_str];

            // goes thought the rules to validate it one by one until it returns false and ends the cycle or the cycle ends
            foreach($rule_arr as $rule) {
                if(!$this->_validate($rule, $value[$rule_key]))
                    break;
            }
        }
        // if errors were found then the validator returns false otherwise true
        if($this->error->getNumberOfErrors() !== 0)
            return false;
        return true;
    }
    private function _validate($rule, $value) {
        $rule_value = [];
        // if rule contains "-" character, then splits it up to rule and rule value
        if(strpos($rule, '-')) {
            $rule_value = explode('-',$rule);
            $rule = $rule_value[0];
            $rule_value = $rule_value[1];
        }
            
        switch($rule) {
            case "required": 
                if(empty($value) && $value !== 0 || empty($value) && $value === "") {
                    $this->error->addErrorCode(123);
                    return false;
                }
                break;
            case "maxLength": 
                if(strlen($value) !== 0 && !empty($value)) {
                    if(strlen($value) > intval($rule_value)) {
                        $this->error->addErrorCode(124);
                        return false;
                    }
                }
                break;
            case "minLength": 
                if(strlen($value) !== 0 && !empty($value)) {
                    if(strlen($value) < intval($rule_value)) {
                        $this->error->addErrorCode(125);
                        return false;
                    }
                }
                break;
            case "letter":
                if(strlen($value) !== 0 && !empty($value)) {
                    if(preg_match('/^[A-Za-z]*$/',$value)) {
                        $this->error->addErrorCode(125);
                        return false;
                    }
                }
                break;
            case "number":
                if(strlen($value) !== 0 && !empty($value)) {
                    if(preg_match('/^[1-9][0-9]*$/',$value)) {
                        $this->error->addErrorCode(125);
                        return false;
                    }
                }
                break;
            case "password":
                if(strlen($value) !== 0 && !empty($value)) {
                    if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$.,%]{8,24}$/',$value) !== 1) {
                        $this->error->addErrorCode(125);
                        return false;
                    }
                }
                break;
            case "username":
                if(strlen($value) !== 0 && !empty($value)) {
                    if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$.,%]{3,16}$/',$value) !== 1) {
                        $this->error->addErrorCode(125);
                        return false;
                    }
                }
                break;
        }
        return true;
    }
}

?>