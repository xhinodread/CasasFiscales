<?
App::uses('BaseAuthorize', 'Controller/Component/Auth');

class LdapAuthorize extends BaseAuthorize {
    public function authorize($user, CakeRequest $request) {
        // Do things for LDAP here.
    }
}
?>