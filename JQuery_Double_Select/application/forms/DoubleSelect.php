<?php

class Application_Form_DoubleSelect extends Zend_Form
{
	public function init()
	{
		$a = new Zend_Form_Element_Select('album');
		$a->id = 'albums';
		$a->setLabel('Albumy:');
		$a->addMultiOption('-1', '-- wybierz album --');
		$a->addMultiOptions($this->getAttrib('albums'));
		$a->addValidator('GreaterThan', false, array(
        	'min' => 0,
            'messages' => array('notGreaterThan' => 'Wybierz album.')
        ));
		
		$c = new Zend_Form_Element_Select('category');
		$c->id = 'albums_categories';
		$c->setLabel('Kategorie:');
		$c->addMultiOption('-1', '-- wybierz kategorie --');
		$categories = $this->getAttrib('categories');
		if(!empty($categories))	$c->addMultiOptions($categories);
		$c->addValidator('GreaterThan', false, array(
        	'min' => 0,
            'messages' => array('notGreaterThan' => 'Wybierz kategorię.')
        ));
        
		$submit = new Zend_Form_Element_Submit('Click');
		
		$this->addElements(array(
			$a,
			$c,
			$submit
		));
	}
}