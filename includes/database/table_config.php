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

    class Tenant_tbl implements Table
    {
        const NAME_TH = 'NAME_TH';
        const NAME_EN = 'NAME_EN';

        const ACCESS_CH = 'ACCESS_CH';
        const PRIORITY = 'PRIORITY';
        const TUREYOU_CAT = 'TRUEYOU';

        const INFO = 'INFO';
        const WAP = 'WAP';

        const THUMB1 = 'THUMB1';
        const THUMB2 = 'THUMB2';
        const THUMB3 = 'THUMB3';
        const THUMB4 = 'THUMB4';
        const THUMB5 = 'THUMB5';
        const THUMB_HIGHLIGHT = 'THUMB_HILIGHT';

        const STATUS = 'STATUS';

        public static function name() {return 'Tenant';}
    }
}
