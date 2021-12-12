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
            $index = array_filter(array_keys($data), function($d_key) use ($rule_key) {
                return $rule_key === $d_key;
            });
            if($index === false) {
                if(strpos($rule_str, 'required') !== false)
                    $this->error->addErrorCode(123);
                return;
            }
            $value = array_intersect_key($data, array_flip($index));

            $rule_arr = !empty($rule_str) && strpos($rule_str,'|') !== false ? explode('|',$rule_str) : [$rule_str];
            foreach($rule_arr as $rule) {
                if(!$this->_validate($rule, $value[$rule_key]))
                    break;
            }
        }
        if($this->error->getNumberOfErrors() !== 0)
            return false;
        return true;
    }
    private function _validate($rule, $value) {
        $rule_value = [];
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
                if($value !== 0 && !empty($value)) {
                    if(strlen($value) > intval($rule_value)) {
                        $this->error->addErrorCode(124);
                        return false;
                    }
                }
                break;
            case "minLength": 
                if($value !== 0 && !empty($value)) {
                    if(strlen($value) < intval($rule_value)) {
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