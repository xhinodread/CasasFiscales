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
	
	var $components = array('Auth', 'Session', 'RequestHandler');
 
	var $user;

	function beforeFilter(){
		global $menus;
		$this->Auth->authenticate = array('Idbroker.Ldap'=>array('userModel'=>'Idbroker.LdapAuth'));
		//If you want to do your authorization from the isAuthorized Controller use the following
		// $this->Auth->authorize = array('Controller');
	}


	/*
	* This just says aslong as this is a valid user let them in, you can also modify this to restrict to a group
	*/
	public function isAuthorized(){
		$user = $this->Auth->user();
		if($user) return true;
		return false;
	}
	
}
