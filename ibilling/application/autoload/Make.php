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
Class Make{


  public static function make_csv ($query,$filename=''){
        global $dbh;
        if($filename==''){
            $filename=date('Y-m-d-H-i-s').'.csv';
        }
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result){

            header( 'Content-Type: text/csv' );
            header( 'Content-Disposition: attachment;filename='.$filename);

            if ($stmt->rowCount() > 0) {
                $fp = fopen('php://output', 'w');
                foreach($result as $value) {

                    fputcsv($fp, $value);
                }
                return true;
            }
            else {

                return false;
            }
            fclose($fp);

        }
        else {
            return false;
        }
    }

    public static function make_pdf($title,$hstring,$style,$html){

        $html = <<<EOT
$style
$html
EOT;


    }


}
