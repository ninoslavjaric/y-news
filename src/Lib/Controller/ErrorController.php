<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/10/17
 * Time: 9:52 PM
 */

namespace Bravo\Lib\Controller;


use Bravo\Lib\Controller;
use Bravo\Lib\Http\Response;

class ErrorController extends Controller
{
    public function getIndex(\Exception $e):Response{
        return new Response(['title'=>"Exception occurred", 'error'=>$e], "error/index");
    }
    public function getError(\Exception $e):Response{
        return new Response(['title'=>"Error occurred", 'error'=>$e], "error/index");
    }
}