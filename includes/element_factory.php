<?php
class ElementFactory
{
    public static function drop_down_menu($list, $name, $size, $multi_select=false) {
        $format_name = $name;
        if($multi_select) {
            $multi_select = "multiple";
            $format_name .= '[]';
        }
        else
            $multi_select = '';

        $output = "<select name=\"{$format_name}\" {$multi_select} size=\"{$size}\"> ";

        foreach($list as $value) {
            //$is_select = $this->menu_is_selected($name, $value);
            $output .= "<option value=\"{$value}\" >{$value}</option>";
        }
        $output .= "</select>";
        return $output;
    }

    public static function multi_checkbox($list, $name) {
        $name .= '[]';


    }
}