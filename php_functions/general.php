<?php

function createConnection(){
    $con = new mysqli('localhost','root','','sonicwaves');
    $con->set_charset("utf8");
    return $con;
}