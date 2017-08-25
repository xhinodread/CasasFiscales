<?php 
class UsersController extends AppController {
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login');
  }
	
	public function isAuthorized($user = null) { return true;}
	
	public function index() {
		$this->render(false);
		//echo '<pre>'.print_r( $this->User->find('all') ).'</pre>';
	}
	
	public function login() {
    if( $this->request->is('post') ) {
			// debug($this->Auth->login());
			if( $this->Auth->login() ) {
				// $this->Flash->loguin('Bienvenido');
				return $this->redirect($this->Auth->redirectUrl());
			}else{
				$varsMsg = '<br>Talvez su cuenta se encuentra bloqueada o inactiva.';
				// '<br>'.!($this->Auth->login()).', '.($this->Auth->login()).'<br>-'.print_r($this->Auth->login(), 1).print_r($this->request->data, 1);
				$this->Flash->login_error('Nombre de usuario o contraseña incorrectos, reintente...'.$varsMsg.'...');
			}
    }
	}
	
	public function logout() {
  	return $this->redirect($this->Auth->logout());
	}
	
}
?>