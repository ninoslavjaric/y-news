<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/19/17
 * Time: 2:11 PM
 */

namespace Bravo\Console;
use Bravo\Dto\Article;
use Bravo\Lib\Config;
use Bravo\Lib\Console;
use Bravo\Lib\Dto;

/**
 * Class NewsPuller
 * @package Bravo\Console
 * @name setup
 */
class Setup extends Console
{

    protected function execute()
    {
        $sql = PROJECT_ROOT."/sql/dbdump.sql";
        $sql = realpath($sql);
        if($sql){
            $username = Config::get("database.mysql.username");
            $password = Config::get("database.mysql.password");
            $dbname = Config::get("database.mysql.dbname");
            shell_exec("mysql -u {$username} -p{$password} {$dbname} -e 'source {$sql}'");
            echo "Setup done";
        }else{
            echo "Setup failed";
        }
    }
}