<?php

class UserController extends Zend_Controller_Action
{
    public function init()
    {
        $this->_helper->AjaxContext()
            ->addActionContext('sign-up-send', 'json')
            ->addActionContext('sign-in-send', 'json')->initContext('json');
    }

    public function signUpAction()
    {
        if (!Mrl_User::isGuest()) {
            $this->_helper->redirector->gotoRoute(array(), 'home');
        }
    }

    public function signUpSendAction()
    {
        if (Mrl_User::isGuest() && $this->_request->isPost()) {
            $result = Service_User::signUp($this->_request->getPost());
            if (isset($result['errors'])) {
                $this->view->status = 'error';
                $this->view->message = $result['errors'];
            } else {
                $this->view->status = 'redirect';
                $this->view->url = $this->view->url(array(), 'home');
            }
        } else {
            $this->view->status = 'error';
        }
    }

    public function signInAction()
    {
        if (!Mrl_User::isGuest()) {
            $this->_helper->redirector->gotoRoute(array(), 'home');
        }
    }

    public function signInSendAction()
    {
        if (Mrl_User::isGuest() && $this->_request->isPost()) {
            $result = Service_User::signIn($this->_request->getPost());
            if (isset($result['errors'])) {
                $this->view->status = 'error';
                $this->view->message = $result['errors'];
            } else {
                $this->view->status = 'redirect';
                $this->view->url = $this->view->url(array(), 'home');
            }
        } else {
            $this->view->status = 'error';
        }
    }

    public function signOutAction()
    {
        if (!Mrl_User::isGuest()) {
            Service_User::signOut();
        }
        $this->_helper->redirector->gotoRoute(array(), 'home');
    }

}
