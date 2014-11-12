<?php
class DashboardController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
		/*init ke dua */
    }
    public function indexAction()
    {   
		$this->homeAction();
		$this->readExecutor();
		$this->readTimeserver();
		$this->readSuplier();
    }	
	
	
	public function homeAction()
    {	
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
            $this->_redirect('/');
        }		
        $this->view->name = $data->name;  		
    }
	
	public function readExecutor()
	{
		$currpage = "1";
		$where = "1";
		try {
	        $dbconn = DB_CONFIG::dbconn();
	    
			$sql = $dbconn->select()
					->from("purchase")
					->where("status = 0")
					->order("tanggal");			
		   	$this->view->purchase = $dbconn->fetchAll($sql);			
						
	    } catch(Zend_Db_Exception $e){
	        echo $e->getMessage();
	    }
	}
	
	public function readSuplier()
	{		
		try {
	        $dbconn = DB_CONFIG::dbconn();
	    
			$sql = $dbconn->select("id")
					->from("suplier")
					->order("id");	
		   	$this->view->suplier = $dbconn->fetchAll($sql);			
						
	    } catch(Zend_Db_Exception $e){
	        echo $e->getMessage();
	    }
	}
	
	public function readTimeserver()
	{
		try {
	        $dbconn = DB_CONFIG::dbconn();
	    
			$sql = $dbconn->select()
					->from("waktutrx");								
		   	$this->view->timetrans = $dbconn->fetchAll($sql);			
						
	    } catch(Zend_Db_Exception $e){
	        echo $e->getMessage();
	    }
	}
	
	
	
}