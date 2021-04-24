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
class Template
{
    protected $contents;
    protected $values = array();

    public function __construct($contents)
    {
        $this->contents = $contents;
    }

    public function set($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function output()
    {

        $output = $this->contents;

        foreach ($this->values as $key => $value) {
            $tagToReplace = '{{' . $key . '}}';
            $output = str_replace($tagToReplace, $value, $output);
        }

        return $output;
    }
}