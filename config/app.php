<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/15/17
 * Time: 2:20 PM
 */
return [
    'debug' =>  true,
    '404'   =>  [
        'controller'    =>  \Bravo\Controller\FourOFourController::class,
        'method'        =>  "getIndex",
    ],
    'navigation'    =>  [
        'main'  =>  [
            ['title' =>  "Home", 'href' =>  "/"],
            ['title' =>  "Science", 'href' =>  "/news/science"],
            ['title' =>  "Tech", 'href' =>  "/news/tech"],
            ['title' =>  "World", 'href' =>  "/news/world"],
            ['title' =>  "Politics", 'href' =>  "/news/politics"],
            ['title' =>  "Health", 'href' =>  "/news/health"],
            ['title' =>  "Contact", 'href' =>  "/contact"],
        ],
        'footer'    =>  [
            ['title' =>  "Home", 'href' =>  "/"],
            ['title' =>  "About us", 'href' =>  "/about"],
            ['title' =>  "Contact", 'href' =>  "/contact"],
        ],
    ],
    'reCaptcha' =>  [
        'secret'    =>  "6LdtZDoUAAAAAP50PaqwRXuD32CDaw18kZQxSTsn",
        'key'       =>  "6LdtZDoUAAAAAAO2o4fAvSzWQquyyp0li8jAmUBL",
    ],
    'fbAppId'   =>  "136678420285291",
    'google-analytics'  =>  "UA-68703861-6",
    'contact-email'     =>  "jaricninoslav@gmail.com",
];