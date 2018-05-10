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

//first, load the root file
require_once '../root.php';

if(WebsiteFunctions::get()->getMainSession()->validateToken() === TRUE){
    header('location: home');
}
Page::get()->loadTranslation(TRUE);
$pageLbls = LANGUAGE['pages']['login'];
Page::get()->setTitle($pageLbls['title']);
Page::get()->setDescription($pageLbls['description']);
Page::get()->loadTheme();
$document = Page::get()->getDocument();
$document->getHeadNode()->addCSS('publish/themes/greeny/css/login.css');
$document->getHeadNode()->addJs('publish/themes/greeny/js/login.js');
$container = new HTMLNode();
$document->addNode($container);
$container->setClassName('pa-container');
$container->addChild(createLoginForm($pageLbls));
echo $document->toHTML(FALSE);
//end of page setup.

function createLoginForm($pageLbls){
    $form = new HTMLNode('form');
    $form->setID('login-form');
    $form->setAttribute('method', 'post');
    $form->setWritingDir(Page::get()->getWritingDir());
    $form->setID('login-form');
    $form->setClassName('pa-row');
    $formLabeldiv = new HTMLNode();
    $usernameDiv = new HTMLNode();
    $usernameDiv->setAttribute('style', 'background-color: #2d8659');
    $usernameDiv->setClassName('pa-row');
    $usernameDiv->addChild(new Label($pageLbls['labels']['username']));
    $usernameDiv->addChild(new Br());
    $usernameDiv->addChild(new Input('text'));
    $usernameDiv->childNodes()->get(2)->setID('username-input');
    $usernameDiv->childNodes()->get(2)->setAttribute('required');
    $passwordDiv = new HTMLNode();
    $passwordDiv->setAttribute('style', 'background-color: #2d8659');
    $passwordDiv->setClassName('pa-row');
    $passwordDiv->addChild(new Label($pageLbls['labels']['password']));
    $passwordDiv->addChild(new Br());
    $passwordDiv->addChild(new Input('password'));
    $passwordDiv->childNodes()->get(2)->setID('password-input');
    $passwordDiv->childNodes()->get(2)->setAttribute('required');
    $messageDiv = new HTMLNode();
    $messageDiv->setAttribute('style', 'background-color: #2d8659');
    $messageDiv->setClassName('pa-row');
    $messageDiv->addChild(new Label(''));
    $messageDiv->childNodes()->get(0)->setID('message');
    $keepLoginDiv = new HTMLNode();
    $keepLoginDiv->setAttribute('style', 'background-color: #2d8659');
    $keepLoginDiv->setClassName('pa-row');
    $keepLoginDiv->addChild(new Input('checkbox'));
    $keepLoginDiv->addChild(new Label($pageLbls['labels']['keep-me-logged']));
    $keepLoginDiv->childNodes()->get(0)->setID('keep-me-logged');
    $submitDiv = new HTMLNode();
    $submitDiv->setAttribute('style', 'background-color: #2d8659');
    $submitDiv->setClassName('pa-row');
    $submitDiv->addChild(new Input('submit'));
    $submitDiv->childNodes()->get(0)->setID('login-button');
    $submitDiv->childNodes()->get(0)->setValue($pageLbls['actions']['login']);
    $submitDiv->childNodes()->get(0)->setAttribute('onclick','return login()');
    $formLabeldiv->setAttribute('style', 'margin-bottom: 18%;text-align: center;');
    $form->addChild($formLabeldiv);
    $form->addChild($usernameDiv);
    $form->addChild($passwordDiv);
    $form->addChild($keepLoginDiv);
    $form->addChild($messageDiv);
    $form->addChild($submitDiv);
    $formLabeldiv->addChild(new Label($pageLbls['labels']['main']));
    return $form;
}
