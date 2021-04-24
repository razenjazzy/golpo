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
Class Reorder
{
    public static function js($i)
    {
        return '


    $(function() {
        $("#sorder").sortable({ opacity: 0.6, cursor: \'move\', update: function() {
            var order = $(this).sortable("serialize") + \'&action=' . $i . '\';
            $("#resp").html(\'Saving...\');
            $.post("'.U.'reorder/reorder-post", order, function(theResponse){
                $("#resp").html(theResponse);
            });
        }
        });
    });


';
    }
}