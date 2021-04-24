<?php
//this script will run only in demo mode

if($_app_stage != 'Demo'){
    exit;
}

$action = route(1);

switch ($action){

    case 'admin':
        // auto login to admin


        Ib_Internal::autoLogin('demo@example.com','123456');


        break;

    case 'client':

        Ib_Internal::autoLogin('customer@example.com','123456','customer');

        break;

}

