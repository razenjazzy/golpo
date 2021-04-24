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
$ui->assign('_application_menu', 'plugins');
$dir = $routes['1'];
$cont = $routes['2'];
$path = 'application/plugins/'.$dir.'/'.$cont.'.php';
$pl_path = 'application/plugins/'.$dir.'/';
if(file_exists($path)){
    $_pd = 'application/plugins/'.$dir.'/';
    $ui->assign('_pd','application/plugins/'.$dir.'/');
    require($path);

}
else{
//    echo $path;
    r2(U.'dashboard/','e',$_L['Plugin Not Found']);
}
