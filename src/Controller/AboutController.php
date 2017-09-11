<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/12/17
 * Time: 12:20 AM
 */

namespace Bravo\Controller;


use Bravo\Lib\Http\Response;

class AboutController
{
    public function getIndex(){
        return new Response(['test'=>"testiranje"]);
    }
}