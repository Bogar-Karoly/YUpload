<?php

class Validator {
    function __construct() {
        $this->error = new UserError();
    }
    public function validate($rules, $data, $deep = false) { // deep means that it will try to search in sub objects
        // check if empty
        if(empty($data)) {
            $this->error->addCode(111);
            return false;
        }
        foreach($rules as $rule_key => $rule_str ) {
            $index = array_filter(array_keys($data), function($d_key) use ($rule_key) {
                return $rule_key === $d_key;
            });
            if($index === false) {
                if(strpos($rule_str, 'required') !== false)
                    $this->error->addCode(112);
                return;
            }
            $value = array_intersect_key($data, array_flip($index));
            $rule_arr = !empty($rule_str) && strpos($rule_str,'|') !== false ? explode('|',$rule_str) : [$rule_str];
            foreach($rule_arr as $rule) {
                if(!$this->_validate($rule, $value))
                    break;
            }
        }
        if($this->error->getNumberOfErrors() !== 0)
            return false;
        return true;
    }
    private function _validate($rule, $value) {
        switch($rule) {
            case "required": 
                if(empty($rule)) {
                    if($value !== 0 || $value === "") {
                        $this->error_code->add(123);
                        return false;
                    }
                }
                break;
            case "maxLength": 
                if(empty($rule)) {
                    if($value !== 0 || $value === "") {
                        $this->error_code->add(123);
                        return false;
                    }
                }
                break;
            case "minLength": 
                    if($value !== 0 || $value === "") {
                        $this->error_code->add(123);
                        return false;
                    }
                break;
        }
        return true;
    }
}

?>