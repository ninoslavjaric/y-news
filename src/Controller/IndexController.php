<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/10/17
 * Time: 5:05 PM
 */

namespace Bravo\Controller;


use Bravo\Lib\Controller;
use Bravo\Lib\Http\Response;

class IndexController extends Controller
{
    public function getIndex(){
        $t = 123;
        return new Response(['test'=>"testiranje"]);
    }
}