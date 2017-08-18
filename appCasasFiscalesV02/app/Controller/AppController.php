<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('AuthComponent', 'Controller/Component');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	//public $components = array('Session', 'Flash', 'DebugKit.Toolbar', 'Auth');
	//public $components = array('Session', 'Flash', 'DebugKit.Toolbar');
	
	/***
																				'loginAction' => array(
																					'controller' => 'users',
																					'action' => 'login',
																			),
	**/ 
	public $components = array('Session', 'Flash', 'DebugKit.Toolbar',
														'Auth'=>array(
																			'loginRedirect' => array('controller'=>'servicios', 'action'=>'index'),
																			'logoutRedirect' => array('controller'=>'users', 'action'=>'login'),
																			'authError' => 'Sin autorizacion',
																			'authorize' => array('Controller')
																		)
														);
	/*****/
	public $helpers = array('Html', 'Form', 'Flash', 'Session');
	public $urlSocket = 'http://192.168.200.113:8080/tests/setSocketCasasFiscales.php';
	
	public $msgAsignaciones = array( 'parametros' => 'Parametros no Validos' );
	
	/*
	public function beforeFilter(){
		$this->Auth->allow('login', 'logout');
		$this->set('current_user', $this->Auth->user());
	}
	*/
	 public function isAuthorized($user) {
		 /*
        // Admin can access every action
        if (isset($user['usertipo_id']) && $user['usertipo_id'] === '1') {
            return true;
        }
        if (isset($user['usertipo_id']) && $user['usertipo_id'] === '2') {
            return true;
        }
        if (isset($user['usertipo_id']) && $user['usertipo_id'] === '3') {
            return true;
        }
        // Default deny
            return false;
		*/
		 return true;
	 }
	
	 public function beforeFilter() {
		 $this->set('current_user', $this->Auth->user());
	 }
	
}
