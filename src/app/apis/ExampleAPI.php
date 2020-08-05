<?php

/*
 * The MIT License
 *
 * Copyright 2018 Ibrahim.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace webfiori\examples\webApis;

use restEasy\WebService;
use webfiori\entity\ExtendedWebServices;

//create class and extend the base class API
class ExampleAPI extends ExtendedWebServices {
    public function __construct() {
        parent::__construct();

        //create API action
        $a1 = new WebService('say-hello');

        //set action request method
        $a1->addRequestMethod('get');

        //add the action to the API
        $this->addAction($a1);
    }

    public function isAuthorized() {
        //check if the user 
        //is authorized to call the service.
        return true;
    }

    public function processRequest() {
        //get the name of the called service and process the request based on it
        $a = $this->getCalledServiceName();

        if ($a == 'say-hello') {
            //say hello by sending html document
            $lang = $this->getTranslation()->getCode();

            if ($lang == 'AR') {
                $this->send('text/html', '<html><head><title>قُل مرحباً</title></head><body><p dir="rtl">مرحباً بالعالم!</p></body></html>');
            } else {
                $this->send('text/html', '<html><head><title>Say Hello</title></head><body><p>hello world!</p></body></html>');
            }
        }
    }
}

return __NAMESPACE__;