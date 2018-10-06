<?php

class LegalController extends ControllerBase
{

    public function faqAction()
    {
    	// pass data to view
        $this->view->user = $this->_user;
    }

    public function termsAction()
    {
    	// pass data to view
        $this->view->user = $this->_user;
    }

    public function privacyAction()
    {
    	// pass data to view
        $this->view->user = $this->_user;
    }

}

