<?php

// ** COLUMN name should be exactly the same as db table's column name **

// trueyou database
namespace trueyou
{
    interface Table
    {
        public static function name();
    }


    class Branch_tbl implements Table
    {
        const BRANCH = 'BNAME';
        const LATITUDE = 'LATITUDE';
        const LONGITUDE = 'LONGITUDE';
        const FLOOR1 = 'FLOOR1';
        const FLOOR2 = 'FLOOR2';

        public static function name() {return 'Branch';}
    }

    class Priv_tbl implements Table
    {
        public static function name() {return 'Priv';}
    }
}
