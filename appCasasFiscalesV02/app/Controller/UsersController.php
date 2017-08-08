<?php 
App::uses('FuncionesHelper', 'View/Helper');
App::uses('HttpSocket', 'Network/Http');
class UsersController extends AppController {

	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }
	
	public function login() {
    if ($this->request->is('post')) {
        if ($this->Auth->login()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        $this->Flash->error(__('Invalid username or password, try again'));
    }
	}
	
	public function logout() {
    return $this->redirect($this->Auth->logout());
	}
	
	
}
?>