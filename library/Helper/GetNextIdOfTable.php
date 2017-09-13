<?php
    class Helper_GetNextIdOfTable extends Zend_Controller_Action_Helper_Abstract{     
        
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
        public function getNextIdOfTable($table_name){
            $DB = Zend_Registry::get('DB');    
           
            $get_last_id = "SHOW TABLE STATUS LIKE '$table_name'" ;
            $ex_last_id  = $DB->fetchAssoc($get_last_id);
            $insert_id   = $ex_last_id[$table_name]['Auto_increment'];
            return $insert_id;         
        }
        
        public function direct($table_name){
            return $this->getNextIdOfTable($table_name);
        }   
    }
?>