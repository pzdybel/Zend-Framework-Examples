<?php

class Application_Form_Test extends Zend_Form
{
	public function init()
	{
		$ac = new ZendX_JQuery_Form_Element_AutoComplete("ac1");
		$ac->setLabel("Autocomplete: ");
		$ac->setJqueryParams(array(
			'data' => array('Zend', 'Zend Framework', 'PHP', 'JSP', 'ASP')
		));
		
		$ac_ajax = new ZendX_JQuery_Form_Element_AutoComplete("ac2");
		$ac_ajax->setLabel("Autocomplete Ajax: ");
		$ac_ajax->setJQueryParams(array(
			'data' => '/index/autocomplete',
			'delay' => 300,
			'minLength' => 3
		));

		$submit = new Zend_Form_Element_Submit('Click');
		
		$this->addElements(array(
			$ac,
			$ac_ajax,
			$submit
		));
		$this->setAction('#');
	}
}