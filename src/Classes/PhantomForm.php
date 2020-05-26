<?php
/**
 * Created by PhpStorm.
 * User: rehash
 * Date: 5.09.18 г.
 * Time: 11:10
 */

namespace dvplex\Phantom\Classes;


class PhantomForm {
    public function __construct() {

    }

    public static function generate($data, $module, $name, $action) {
        if (preg_match('/Without Module/', $module)) {
            $path = 'app/Forms/';
            $namespace = 'App\\Forms';
        }
        else {

            $path = $module . '/Forms/';
            $namespace = str_replace('/', '\\', $module) . '\\Forms';
        }
        $fld = explode(',', $data);
        $nlines = $options = '';
        foreach ($fld as $k => $fl) {
            $opts = explode('|',$fl);
            if(isset($opts[1])){
                $oo =explode(';',$opts[1]);
                foreach ($oo as $ooo) {
                    $options!='' && $options.=' ';
                    $ooo = explode(':',$ooo);
                    $options.=$ooo[0].'='.'"'.$ooo[1].'"';
                }
            }
            $dt = explode(':', $opts[0]);
            $r = file_get_contents(__DIR__ . '/../Stubs/Form/' . $dt[1] . '.stub');
            if ($k==0)
                $af = 'Autofocus';
            else
                $af ='';
            $r = str_replace(['$FIELD_TYPE$', '$FIELD_NAME$', '$FIELD_LABEL$', '$AUTOFOCUS$','$OPTIONS$'], [$dt[1], $dt[0], $dt[2],$af,$options], $r);
            $nlines != '' && $nlines .= "\n";
            $nlines .= $r;
        }
        $r = file_get_contents(__DIR__ . '/../Stubs/Form/skeleton.stub');
        $r = str_replace(['$FORM_ACTION$', '$FORM_BODY$'], [$action, $nlines], $r);
        if (!is_dir(base_path($path)))
            mkdir(base_path($path));
        $c = file_get_contents(__DIR__ . '/../Stubs/Form/class_skeleton.stub');
        $c = str_replace(['$CLASS_NAME$', '$CLASS_CONTENT$', '$NAMESPACE$'], [$name, $r, $namespace], $c);
        file_put_contents(base_path($path) . $name . '.php', $c);

        return "Successfully created " . base_path($path) . $name . '.php';
    }
}
