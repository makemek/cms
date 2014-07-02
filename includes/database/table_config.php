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
        const TITLE = 'TITLE';
        const CAMP_CODE = 'CAMP_CODE';
        const USSD = 'USSD';
        const SMS = 'SMS';
        const START_DATE = 'START';
        const EXPIRE_DATE = 'EXPIRE';
        const CARD = 'CARD';
        const CONDITION = 'COND';
        const SHOW_CARD = 'SHOW_CARD';
        const STORE = 'STORE';

        public static function name() {return 'Priv';}
    }
}
