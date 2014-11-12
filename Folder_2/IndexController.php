<?php
class IndexController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }
    public function indexAction()
    {   
		$this->homeAction();
	 	$this->login();
    }	
	public function login()
	{		
		if($this->_request->getPost('login')) {	
			$user = $this->_request->getPost('username');
			$pass = md5($this->_request->getPost('password'));
			
			try {
				$dbconn = DB_CONFIG::dbconn();
				$pengacak = "ABFJDH4857HDGG635JFK";
				$passEnkrip = md5($pengacak . $pass . $pengacak);
				$sql = $dbconn->select()
						->from("users")
						->where("username='$user' and password = '$passEnkrip'");
				//echo $sql;	
				$result = $dbconn->fetchOne($sql);
					if($result){
						 $storage = new Zend_Auth_Storage_Session();
						 $storage->write($user);
						 $this->_redirect('/dashboard');
					}
					$this->_helper->flashMessenger->addMessage("Authentication error.");
					$this->_redirect('/'); 
				
			} catch(Zend_Db_Exception $e){
				echo $e->getMessage();
			}	
		}
	}
	public function homeAction()
    {	
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
            	//blm login	
        }else{
			echo "<pre><code> Anda tidak perlu login, Sesi anda belum berakhir!</code></pre> ";		
		} 	
    }
}