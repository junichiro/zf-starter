<?php
class E3_Util {

    public function createHashedPassword($salt, $pass) {
        return $salt." ".sha1($salt.$pass);
    }

}