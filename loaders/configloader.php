<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/8/17
 * Time: 11:10 PM
 */

/**
 * @return array
 */
function getCfg(){
    $configProp = [];
    foreach (glob(PROJECT_ROOT."/config/*.php") as $cfgf) {
        $configProp[basename($cfgf, ".php")] = include $cfgf;
    }
    return $configProp;
}

\Bravo\Lib\Config::init(getCfg());