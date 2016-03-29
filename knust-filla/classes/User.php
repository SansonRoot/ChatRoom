<?php

/**
 * Created by PhpStorm.
 * User: SANSON ROOT
 * Date: 11/12/2015
 * Time: 10:35 PM
 */
class User
{
    private $_db,
            $_sessionName,
            $_isLoggedIn,
            $_data;

    public function __construct($user = '', $table = 'users')
    {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');

        if (!$user) {
            if (Session::exist($this->_sessionName)) {
                $user = Session::get($this->_sessionName);
                if ($this->find($user, $table)) {
                    $this->_isLoggedIn = true;
                } else {
                    //logout
                }
            }
        } else {
            $this->find($user, $table);
        }

    }

    public function create($table, $fields = array())
    {
        if (!$this->_db->insert($table, $fields)) {
            throw new Exception ("Error in creating account");
        }
    }

    public function find($user = null, $table)
    {
        if ($user) {
            $field = is_numeric($user) ? 'id' : 'username';
            $data=$this->_db->get($table, array($field, '=', $user));
            if ($data->count()) {
                $this->_data = $data->first();
                return $this;
            }
        }
        return false;

    }

    public function login($username = null, $password = null, $table)
    {
        $user = $this->find($username, $table);

        if ($user) {
            if ($this->data()->Password === Hash::make($password, $this->data()->Salt)) {
                Session::put($this->_sessionName, $this->data()->ID);
                $this->_isLoggedIn=true;
                return true;
            }
        }
        return false;
    }

    public function update($table = 'administrators',$data, $fields)
    {
        return $this->_db->update($table,'ID', $data, $fields);
    }


    public function saveImage($imageName)
    {
        $location = 'dist/img/profile/';
        if (!empty($_FILES["{$imageName}"]["name"])) {
            if (!getimagesize($_FILES["{$imageName}"]["tmp_name"]) == FALSE) {
                $image = $_FILES["{$imageName}"]["tmp_name"];
                $name = $_FILES["{$imageName}"]["name"];


                $rand = rand(1000, 9999);
                $string = $location . $name;

                if (file_exists($string)) {

                    $offset = 0;
                    $found = true;
                    $dotPos = strpos($string, '.', $offset);
                    while ($found) {

                        if (!$dotPos) {
                            $found = false;
                        }
                        $offset = $dotPos + 1;
                        $dotPos = strpos($string, '.', $offset);

                    }
                    $extension = substr($string, ($dotPos + 1));

                    $newname = $rand . '.' . $extension;
                    $location .= $newname;
                } else {
                    $location .= $name;
                }
                if (move_uploaded_file($image, $location)) {
                    return $location;
                }

            }
        }

        return 'dist/img/avatar.png';
    }

    public function logout()
    {
        Session::delete($this->_sessionName);
    }

    public function data()
    {
        return $this->_data;
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }

}
