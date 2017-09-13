<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap{

	protected function _initDbConfig()
	{
		$config = new Zend_Config($this->getOptions());
		$params	= $config->database->toArray();
		
		$DB = new Zend_Db_Adapter_Pdo_Mysql($params);
		//$DB->setFetchMode(Zend_Db::FETCH_OBJ);
		$DB->setFetchMode(Zend_Db::FETCH_ASSOC);
		Zend_Registry::set('DB',$DB);
	}
	
	
	protected function _initLayoutHelper()
	{
		$this->bootstrap('frontController');
		$layout = Zend_Controller_Action_HelperBroker::addHelper(new Amz_Controller_Action_Helper_LayoutLoader());
	}
	
	
	protected function _initSetHelper()
	{
		Zend_Controller_Action_HelperBroker::addPrefix('Helper');
	
	}

}
?>