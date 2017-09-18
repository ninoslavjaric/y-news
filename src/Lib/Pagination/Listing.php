<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/18/17
 * Time: 3:36 PM
 */

namespace Bravo\Lib\Pagination;


class Listing extends \ArrayIterator
{
    /**
     * @return string
     */
    public function __toString()
    {
        $markup = "<nav aria-label=\"pagination\">";
        $markup .= "<ul class=\"pagination\">";
        $markup .= "{content}";
        $markup .= "</ul>";
        $markup .= "</nav>";
        $content = "";
        foreach ($this as $item){
            $content .= $item;
        }
        return str_replace("{content}", $content, $markup);
    }

}