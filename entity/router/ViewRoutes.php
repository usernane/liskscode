<?php

/*
 * The MIT License
 *
 * Copyright 2018 ibrah.
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
 * A class that only has a function to create views routes.
 *
 * @author Ibrahim
 * @version 1.0
 */
class APIRoutes {
    /**
     * Create all views routes. Include your own here.
     * @since 1.0
     */
    public static function create(){
        Router::view('/s/welcome', '/setup/welcome.php');
        Router::view('/s/database-setup', '/setup/database-setup.php');
        Router::view('/s/smtp-account', '/setup/email-account.php');
        Router::view('/s/admin-account', '/setup/admin-account.php');
        Router::view('/s/website-config', '/setup/website-config.php');
        Router::view('/login', '/login.php');
        Router::view('/home', '/home.php');
        Router::view('/activate-account', '/activate-account.php');
        Router::view('/logout', '/logout.php');
        Router::view('/new-password', '/new-password.php');
        Router::view('/', '/default.html');
    }
}