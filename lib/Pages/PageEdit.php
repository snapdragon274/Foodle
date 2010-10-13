<?php

class Pages_PageEdit extends Pages_PageFoodle {
	
	
	function __construct($config, $parameters) {
		parent::__construct($config, $parameters);
		
		$this->timezone = new TimeZone();
	}
	

	protected function saveChanges() {

		$this->foodle->updateFromPost($this->user);
		#echo '<pre>'; print_r($foodle); exit;
		$this->foodle->save();
		
		$newurl = FoodleUtils::getUrl() . 'foodle/' . $this->foodle->identifier . '?tab=3';
		SimpleSAML_Utilities::redirect($newurl);
		exit;
	}

	protected function presentInTimeZone() {
	}
	
	// Process the page.
	function show() {

		if (isset($_REQUEST['save'])) $this->saveChanges();

		$t = new SimpleSAML_XHTML_Template($this->config, 'foodlecreate.php', 'foodle_foodle');

		$t->data['authenticated'] = $this->auth->isAuth();
		
		$t->data['user'] = $this->user;
		
		$t->data['edit'] = TRUE;
		
		$t->data['timezone'] = $this->timezone;
		$t->data['ftimezone'] = $this->foodle->timezone;

		$t->data['name'] = $this->foodle->name;
		$t->data['identifier'] = $this->foodle->identifier;
		$t->data['descr'] = $this->foodle->descr;
		$t->data['expire'] = $this->foodle->expire;
		$t->data['anon'] = $this->foodle->allowanonymous;
		
		$t->data['maxcol'] = $this->foodle->maxcolumn;
		$t->data['maxnum'] = $this->foodle->maxentries;
		

		
		$t->data['columns'] = $this->foodle->columns;
		
		$t->data['isDates'] = $this->foodle->onlyDateColumns();

		$t->data['expire'] = $this->foodle->getExpireTextField();

		$t->data['bread'] = array(
			array('href' => '/', 'title' => 'bc_frontpage'), 
			array('href' => '/foodle/' . $this->foodle->identifier, 'title' => $this->foodle->name), 
			array('title' => 'bc_edit')
		);
		$t->show();


	}
	
}

