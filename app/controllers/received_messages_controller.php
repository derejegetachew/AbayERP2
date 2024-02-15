<?php
class ReceivedMessagesController extends AppController {

	var $name = 'ReceivedMessages';
	
    var $components = array('RequestHandler');
	var $helpers = array('Xml');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('*');
	}
	
	function index() {	
		$this->layout = 'xml';
		$received_messages = $this->ReceivedMessage->find('all');
        $this->set('received_messages', $received_messages);
	}

	function add($id = null) {
		$this->layout = 'xml';
        if ($this->ReceivedMessage->save($this->data)) {
             $message = 'Created';
        } else {
            $message = 'Error';
        }
        $this->set('message' , $message);
	}
	
	function receive($from, $msg) {
		$this->layout = 'xml';
		$this->data = array('ReceivedMessage' => array('from' => $from, 'message' => $msg, 'status' => 'N'));
		if ($this->ReceivedMessage->save($this->data)) {
            $msg = 'Accepted';
        } else {
            $msg = 'Error';
        }
        $this->set(compact("msg"));
    }
}
?>