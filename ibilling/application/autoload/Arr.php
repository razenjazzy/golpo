<?php
// *************************************************************************
// *                                                                       *
// * iBilling -  Accounting, Billing Software                              *
// * Copyright (c) Baizid Arefin. All Rights Reserved                      *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: razen.jazzy@gmail.com                                                *
// * Website: http://www.golpocom.com                                *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// * If you Purchased from Codecanyon, Please read the full License from   *
// * here- http://codecanyon.net/licenses/standard                         *
// *                                                                       *
// *************************************************************************

Class Arr{

    public static function str_to_arr($str){
        $pieces = explode(',', $str);
        foreach ($pieces as $p){

        }
    }


    public static function arr_to_str($arr){
        $str = '';
        if(is_array($arr)){
            foreach($arr as $a){
                $str .= $a.',';
            }
            $str = rtrim($str,',');
        }
        return $str;
    }

}