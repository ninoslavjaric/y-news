<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/12/17
 * Time: 12:20 AM
 */

namespace Bravo\Controller;


use Bravo\Lib\Controller;
use Bravo\Lib\Http\Response;

class AboutController extends Controller
{
    public function getIndex(){
        return new Response(['title'=>"About us"], "about/index");
    }
}