<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Component', 'Controller');
/**
 * Description of DialogComponent
 *
 * @author ivan
 */
class DialogComponent extends Component {

	const SESSION_KEY = '__dialog';
	
	private $_dialogData = '';
	private $_isActive = false;
	private $_defaultDialogData = array(
		'width'			=> 400,
		'height'		=> 200,
		'template'		=> false,
		'templateUrl'   => false,
		'content'		=> false,
		'title'			=> '',
		'params'		=> array(),
		'autoOpen'		=> true,
		'dialogId'		=> 'dialog',
		'hideFooter'	=> false,
		'hideXButton' => false,
	);

	/**
	 *
	 * @var SessionComponent
	 */
	public $components = array('Session');

	public function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);

		$this->_defaultDialogData += $settings;
		$this->_defaultDialogData['dialogId'] .= rand(0,9999999);
	}

	public function initialize(Controller $controller) {
		parent::initialize($controller);
		// check if we have a dialog to show from a previous page. Execute before the controller action is executed
		// because we may want to save the dialog for the next page load
		if ($this->Session->check(self::SESSION_KEY)) {
			// we need to show a dialog from a prevous page
			$this->_dialogData = $this->Session->read(self::SESSION_KEY);

			$this->setActive();
		}
	}
	
	public function beforeRender(Controller $controller) {
		parent::beforeRender($controller);

		$html = '';
		
		if ($this->isActive()) {
			// the dialog has to be shown only once - so remove it from the session
			$this->Session->delete(self::SESSION_KEY);

			$view = new View($controller);
			$view->viewPath = 'Dialogs'; // render an element

			$view->hasRendered = false;

			$view->set($this->_dialogData);
			$view->set('content', $this->getContent($view));

			$view->hasRendered = false;
			$view->plugin = 'BootstrapDialog';
			$html = $view->render('dialog', false); // get the rendered markup
		}
		
		$controller->set('dialog', $html);
	}
	
	/**
	 * Sets a dialog to be shown on this page laod
	 * 
	 * @param array|string $dialogData array (
	 * 			'width'			=> 400,
	 *			'height'		=> 200,
	 *			'template'		=> false,
	 *			'templateUrl'   => false,
	 *			'content'		=> false,
	 *			'title'			=> '',
	 *			'params'		=> array(),
	 *			'autoOpen'		=> true,
	 *			'dialogId'		=> 'dialog'.rand(0,9999999),
	 *			'hideFooter'	=> false
	 *		);
	 * @return string the id of the dialog wrapping element
	 */
	public function setDialogForCurrnetPage($dialogData) {
		$this->setDialogData($dialogData);
		$this->setActive();

		return $this->_dialogData['dialogId'];
	}
	
	/**
	 * Sets a dialog to be shown on the next page laod
	 *
	 * @param array|string $dialogData array (
	 * 			'width'			=> 400,
	 *			'height'		=> 200,
	 *			'template'		=> false,
	 *			'templateUrl'   => false,
	 *			'content'		=> false,
	 *			'title'			=> '',
	 *			'params'		=> array(),
	 *			'autoOpen'		=> true,
	 *			'dialogId'		=> 'dialog'.rand(0,9999999),
	 *			'hideFooter'	=> false
	 *		);
	 */
	public function setDialogForNextReload($dialogData) {
		$this->setDialogData($dialogData);
		$this->Session->write(self::SESSION_KEY, $this->_dialogData);
	}
	
	public function setDialogData($dialogData) {
		if (is_string($dialogData)) {
			$dialogData = array('template' => $dialogData);
		}

		$this->_dialogData = $dialogData + $this->_defaultDialogData;
	}
	
	public function setActive() {
		$this->_isActive = true;
	}
	
	public function isActive() {
		return $this->_isActive;
	}
	
	public function getContent(View $view) {
		if (!empty($this->_dialogData['content'])) {
			// the content is already calculated - just return it
			return $this->_dialogData['content'];
		} else if (!empty($this->_dialogData['templateUrl'])) {
			// the content should be fetched by an ajax request
			$view->plugin = 'BootstrapDialog';
			return $view->render('dialog_ajax', false); // get the rendered markup
		} else if (!empty($this->_dialogData['template'])) {
			// the content is stored in a template - we have to load it, thus
			return $view->render($this->_dialogData['template'], false); // get the rendered markup
		} else {
			return '';
		}
	}

	public function suppressDialog() {
		$this->_isActive = false;
	}
}
