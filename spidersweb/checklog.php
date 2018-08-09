<?php
session_start();
function checkLogStatus()
{
    if($_SESSION['logflag']==1){
        return true;
    }else{
        return false;
    }
}