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
_auth();
$ui->assign('_title', $_L['Transactions'].'- '. $config['CompanyName']);
$ui->assign('_st', 'Transactions');
$ui->assign('_application_menu', 'transactions');
$action = $routes['1'];
$user = User::_info();
$ui->assign('user', $user);
$mdate = date('Y-m-d');
switch ($action) {

    case 'balance-sheet':

      $d = ORM::for_table('sys_accounts')->where_not_equal('balance','0.00')->order_by_desc('balance')->find_many();
      $tbal = ORM::for_table('sys_accounts')->where_not_equal('balance','0.00')->sum('balance');
      $ui->assign('d',$d);
      $ui->assign('tbal',$tbal);

        $ui->assign('xfooter',Asset::js(array('numeric')));

        $ui->assign('xjq', '

 $(\'.amount\').autoNumeric(\'init\', {

    aSign: \''.$config['currency_code'].' \',
    dGroup: '.$config['thousand_separator_placement'].',
    aPad: '.$config['currency_decimal_digits'].',
    pSign: \''.$config['currency_symbol_position'].'\',
    aDec: \''.$config['dec_point'].'\',
    aSep: \''.$config['thousands_sep'].'\'

    });

 ');

        $ui->display('balance-sheet.tpl');
        break;

    default:
        echo 'action not defined';
}