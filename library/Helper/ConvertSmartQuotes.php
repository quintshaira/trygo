<?php
class Helper_ConvertSmartQuotes extends Zend_Controller_Action_Helper_Abstract{ 
    /**
     * @var Zend_Loader_PluginLoader
     */
    public $pluginLoader;
        
    /**
     * Constructor: initialize plugin loader
     *
     * @return void
     */ 
    public function __construct()
    {
        $this->pluginLoader = new Zend_Loader_PluginLoader();
    }
        
        
    /**
     * Convert smart quotes which can be copied from other word docement and not supported in html.
     * @param String $string
     * @return String $new_string
     */      
    public function convertSmartQuotes($string) 
    {   
    	$search = array(chr(145), 
                        chr(146), 
                        chr(147), 
                        chr(148), 
                        chr(151)); 
     
        $replace = array("'", 
                         "'", 
                         '"', 
                         '"', 
                         '-'); 
     
        $new_string = str_replace($search, $replace, $string); 
        
        return $new_string;  
     }
        
        

     public function direct($string)
     {
     	return $this->convertSmartQuotes($string); 
     }   
}
?>