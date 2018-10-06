<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of APIPage
 *
 * @author Ibrahim
 */
class APIPage {
    /**
     * 
     * @param ClassAPI $class
     */
    public function __construct($class) {
        Page::lang('en');
        Page::dir('ltr');
        Page::title($class->getName());
        Page::document()->getBody()->setClassName('api-page');
        Page::description($class->getDescription());
        Page::document()->getHeadNode()->addCSS(Page::cssDir().'/api-page.css');
        WebFioriGUI::createTitleNode($class->getLongName());
        $this->createClassDescriptionNode($class);
        Page::insert($class->getFunctionsSummaryNode());
        Page::insert($class->getFunctionsDetailsNode());
        Page::render();
    }
    /**
     * 
     * @param ClassAPI $class
     */
    private function createClassDescriptionNode($class) {
        $node = WebFioriGUI::createRowNode(FALSE, FALSE);
        $descNode = new PNode();
        $descNode->addText($class->getDescription());
        $node->addChild($descNode);
        Page::insert($node);
    }
}
