<?php
namespace Cms_core\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
 
use Cms_core\Model\CMSUserTable;
use Cms_core\Form\Cmslogin;
 
class CMSAuthController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $authservice;
     
    public function getAuthService()
    {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('CMSAuthService');
        }
        return $this->authservice;
    }
     
    public function getSessionStorage()
    {
        if (!$this->storage) {
            $this->storage = $this->getServiceLocator()->get('Cms_core\Model\CMSUserStorage');
        }
        return $this->storage;
    }
     
    public function loginAction()
    {
        //if already login, redirect to success page
        if ($this->getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('cms_core');
        }
        
        $boolCaptcha = isset($this->applicationConfig['main']['cms']['login']['captcha'])?$this->applicationConfig['main']['cms']['login']['captcha']:false;
        $form = new CMSLogin($boolCaptcha);
        
        $viewModel = new ViewModel(array(
            'form'     => $form,
            'messages' => $this->flashmessenger()->getMessages(),
            'applicationConfig' => $this->applicationConfig['main']['cms'],
        ));
        $viewModel->setTerminal(true);//disable layout
        return $viewModel;
    }
     
    public function authenticateAction()
    {
        $boolCaptcha = $this->applicationConfig['main']['cms']['login']['captcha'];
        $sessionExpiry = $this->applicationConfig['main']['cms']['login']['login_session'];
        $form = new CMSLogin($boolCaptcha);
        $redirect = 'cms_auth';
         
        $request = $this->getRequest();
        if ($request->isPost()){
            $form->setData($request->getPost());
            if ($form->isValid()){
                //check authentication...
                $this->getAuthService()
                     ->getAdapter()
                     ->setIdentity($request->getPost('lg_username'))
                     ->setCredential($request->getPost('lg_password'));
                                        
                $result = $this->getAuthService()->authenticate();
                foreach($result->getMessages() as $message)
                {
                    //save message temporary into flashmessenger
                    $this->flashmessenger()->addMessage($message);
                }
                 
                if ($result->isValid()) {
                    $redirect = 'cms_core';
                    //check if it has rememberMe :
                    $this->getSessionStorage()->setRememberMe($request->getPost('rememberme'), $sessionExpiry);
                    $this->getAuthService()->setStorage($this->getSessionStorage());

                    $this->getAuthService()->getStorage()->write($request->getPost('lg_username'));
                }
            }
        }

        return $this->redirect()->toRoute($redirect);
    }
     
    public function logoutAction()
    {
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();

        $this->flashmessenger()->addMessage("You've been logged out");
        return $this->redirect()->toRoute('cms_auth');
    }
}