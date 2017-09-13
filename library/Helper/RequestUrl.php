<?php
	class Helper_RequestUrl extends Zend_Controller_Action_Helper_Abstract{		
		
		//Get geo code of any location
		//http://codewelt.com/gcar?startAt=120%20S%20Diamond%20St%20Mercer,%20PA%2016137&lat=41.2265977&lng=-80.2387818
			 
	    /**
	     * @var Zend_Loader_PluginLoader
	     */
		public $pluginLoader;
		
		/**
	     * Constructor: initialize plugin loader
	     *
	     * @return void
	     */ 
	    public function __construct(){
        	$this->pluginLoader = new Zend_Loader_PluginLoader();
    	}
    	/**
    	 * Generate the XML file from the property select query
    	 * @param String $propertyQuery
    	 * @param String $xmlFileName
    	 * @return String $xmlFileName
    	 */		 
		public function getRequestUrl($pageName){
        $expPageUrl=end(explode("/",$pageName));

			return $expPageUrl;			
		}
		
		public function direct($pageName){
	        return $this->getRequestUrl($pageName);
	    }	
	}
?>