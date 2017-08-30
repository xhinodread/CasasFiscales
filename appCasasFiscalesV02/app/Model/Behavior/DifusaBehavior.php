<?

App::uses('ModelBehavior', 'Model');

class DifusaBehavior extends ModelBehavior {
	/*
	public function setup(Model $Model, $settings = array()) {
		if (!isset($this->settings[$Model->alias])) {
			$this->settings[$Model->alias] = array('recursive' => true, 'notices' => true, 'autoFields' => true);
		}
		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $settings);
	}
	*/
	
	public function inicio() {
		return 'inicio'.date('his');
	}
	
	public function CompararPersonas($elString) {
		if (Parametros.NombreTipoIdentificacion > 0 && CodigoUno.NombreTipoIdentificacion == CodigoDos.NombreTipoIdentificacion){
				return 1;
		}
		return 0;
	}
	
	
}
?>