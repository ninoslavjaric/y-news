<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/17/17
 * Time: 4:30 PM
 */

namespace Bravo\Controller;


use Bravo\Lib\Controller;
use Bravo\Lib\Http\Response;

class FourOFourController extends Controller
{
    public function getIndex(){
        return new Response([], "index/404");
    }
}