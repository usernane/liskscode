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

/**
 * An API used to give users access to system resources.
 *
 * @author Ibrahim
 * @version 1.0
 */
require_once '../root.php';
class AuthAPI extends API{
    public function __construct() {
        parent::__construct();
        $this->setVersion('1.0.0');
        $a1 = new APIAction();
        $a1->addRequestMethod('POST');
        $a1->setName('login');
        $a1->addParameter(new RequestParameter('username', 'string'));
        $a1->addParameter(new RequestParameter('password', 'string'));
        $a1->addParameter(new RequestParameter('session-duration', 'integer',TRUE));
        $a1->addParameter(new RequestParameter('refresh-timeout', 'string',TRUE));
        $this->addAction($a1);
        
        $a2 = new APIAction();
        $a2->addRequestMethod('POST');
        $a2->setName('logout');
        $this->addAction($a2);
    }
    
    public function processRequest() {
        $inputs = $this->getInputs();
        $action = $this->getAction();
        if($action == 'login'){
            if(isset($inputs['username'])){
                if(isset($inputs['password'])){
                    if(isset($inputs['session-duration'])){
                        $duration = $inputs['session-duration'];
                    }
                    else{
                        $duration = 30;
                    }
                    if(isset($inputs['refresh-timeout'])){
                        if($inputs['refresh-timeout'] == 'true'){
                            $refTimeout = TRUE;
                        }
                        else{
                            $refTimeout = FALSE;
                        }
                    }
                    else{
                        $refTimeout = FALSE;
                    }
                    $r = UserFunctions::get()->authenticate($inputs['username'], $inputs['password'], $inputs['username'],$duration,$refTimeout);
                    if($r == TRUE){
                        if(UserFunctions::get()->getMainSession()->getUser()->getStatus() == 'S'){
                            $this->sendResponse('Account Suspended',TRUE,401);
                            UserFunctions::get()->getMainSession()->kill();
                        }
                        else{
                            $this->sendResponse('Logged In', FALSE, 200, '"session":'.UserFunctions::get()->getMainSession()->toJSON());
                        }
                    }
                    else if($r == MySQLQuery::QUERY_ERR){
                        $this->databaseErr();
                    }
                    else{
                        $this->sendResponse('Inncorect username, email or password.', TRUE, 401);
                    }
                }
                else{
                    $this->missingParam('password');
                }
            }
            else{
                $this->missingParam('username');
            }
        }
        else if($action == 'logout'){
            SessionManager::get()->kill();
            $this->sendResponse('Logged Out', FALSE, 200);
        }
    }

    public function isAuthorized() {
        return TRUE;
    }
}
$api = new AuthAPI();
$api->process();
