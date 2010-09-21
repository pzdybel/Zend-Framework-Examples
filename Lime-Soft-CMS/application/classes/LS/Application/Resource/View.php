<?php

class LS_Application_Resource_View extends Zend_Application_Resource_ResourceAbstract
{

	protected $_view;

	public function init()
	{
		return $this->getView();
	}

	public function getView()
	{
		if(null===$this->_view) {

			$options = $this->getOptions();

			$view = new Zend_View();
			Zend_Dojo::enableView($view);

			$view->doctype('XHTML1_STRICT');
			$view->headTitle($options['title']);
			$view->headMeta()
				->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8')
				->appendName('keywords', 'limesoft,cms');

			$dir = $options['dojo']['dir'];
			$view->dojo()
				->addStyleSheet(APPLICATION_URL . $dir . '/dojo/resources/dojo.css')
				->addStyleSheetModule('limesoft.themes.' . $options['theme']['limesoft'])
				->addStyleSheetModule('dijit.themes.' . $options['theme']['dojotoolkit'])
				->setDjConfigOption('parseOnLoad', false)
				->setDjConfigOption('locale', $options['locale'])
				->setLocalPath(APPLICATION_URL . $dir . '/dojo/dojo.js')
				->registerModulePath('limesoft', APPLICATION_URL . $dir . '/limesoft')
				->requireModule('dijit.layout.BorderContainer')
				->requireModule('dijit.layout.ContentPane')
				->requireModule('limesoft.base')
				->requireModule('limesoft.Header')
				->requireModule('limesoft.Content')
				->requireModule('limesoft.Footer')
				->requireModule('limesoft.Login')
				->addOnLoad('function(){dojo.addClass(dojo.body(),"' . $options['theme']['dojotoolkit'] . '");dojo.parser.parse();}')
				->addOnLoad(LS_GUI_Bootstrap::generate())
				->enable();

			$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
			$viewRenderer->setView($view);

			$this->_view = $view;
		}

		return $this->_view;
	}

}
