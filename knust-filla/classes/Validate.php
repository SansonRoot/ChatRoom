<?php

/**
 * Created by PhpStorm.
 * User: SANSON ROOT
 * Date: 11/12/2015
 * Time: 10:34 PM
 */
class Validate
{
    private $_errors,
        $_passed = false,
        $_db=null;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array())
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                $value = trim($source[$item]);


                if($rule==='required'&& empty($value)){
                   $this->addErrors("Please enter {$item}");
                }else if (!empty($value)){
                    switch($rule){
                        case 'email':
                            if(!self::emailValid($value)){
                                $this->addErrors("Invalid email");
                            }
                        break;
                        case 'min':
                            if(strlen($value)<$rule_value){
                                $this->addErrors("{$item} must be at least {$rule_value} characters");
                            }
                            break;
                        case 'max':
                            if(strlen($value) > $rule_value){
                                $this->addErrors("{$item} must be less than {$rule_value} characters");
                            }
                            break;
                        case 'matches':
                            if($value!=$source[$rule_value]){
                                $this->addErrors("Passwords must match");
                            }
                            break;
                        case 'unique':
                            $this->_db->get($rule_value,array($item,'=',$value));
                            if($this->_db->count()){
                                $this->addErrors("{$item} already exists");
                            }
                            break;
                    }
                }
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }

        return $this;
    }

    private function addErrors($error)
    {
        $this->_errors[] = $error;
    }

    public function passed()
    {
        return $this->_passed;
    }

    public function errors()
    {
        return $this->_errors;
    }

    private static function emailValid($email)
    {
        $offset = 0;
        $found = true;
        $dotPos = strpos($email, '.', $offset);
        while ($found) {

            if (!$dotPos) {
                $found = false;
            }
            $offset = $dotPos + 1;
            $dotPos = strpos($email, '.', $offset);
        }

        $atPos = strpos($email, '@', 0);


        if ($atPos < 1 || $dotPos - $atPos < 2) {
            return false;
        }
        return true;
    }
}