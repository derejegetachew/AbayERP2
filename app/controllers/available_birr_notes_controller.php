<?php
class AvailableBirrNotesController extends AppController {

	var $name = 'AvailableBirrNotes';
	
	function index() {
		if($this->Auth->user('id')==1){	
		$this->Session->write('is_admin_logged', 'true');
		}
		$this->AvailableBirrNote->Branch->recursive=0;
		$this->AvailableBirrNote->recursive=0;
		$branches = $this->AvailableBirrNote->Branch->find('all');
		$this->set(compact('branches'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	function report($asofdate = null){
	//...
	//..
	//echo "";
	
	}
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$branch_id_for_search = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1; 
		$branch_id = $this->Auth->user('branch_id');
		$logged_user_id=$this->Auth->user('id');
		if($id)
		$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

		eval("\$conditions = array( " . $conditions . " );");
		
		//check if branch id for search purpose isn't set, 
		//and also check if branch id on session is set and the logged user is not admin
		$admin_logged=$this->Session->read('is_admin_logged');
		if ($branch_id != -1 && $branch_id_for_search==-1 && $admin_logged !='true') {
            $conditions['AvailableBirrNote.branch_id'] = $branch_id;
		}
		
		
		if($branch_id_for_search!=-1 && $admin_logged=='true'){
		   $conditions['AvailableBirrNote.branch_id'] = $branch_id_for_search;	
		}
		
		$available_birr_notes= $this->AvailableBirrNote->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));
		$this->set('availableBirrNotes', $available_birr_notes);
		$this->set('results', $this->AvailableBirrNote->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid available birr note', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->AvailableBirrNote->recursive = 2;
		$this->set('availableBirrNote', $this->AvailableBirrNote->read(null, $id));
	}
        function display_missed_reports(){

		$days[] ='';
		$foundMissedReport=0;
	$conditions['AvailableBirrNote.branch_id'] = $this->Auth->user('branch_id');
	// Start date
	   $date = '2020-10-12';
	// End date
	  $end_date = date ("Y-m-d");
	while (strtotime($date) <= strtotime($end_date)) {
		$conditions['AvailableBirrNote.date_of'] = $date;
		if(!($this->AvailableBirrNote->find('all', array('conditions' => $conditions)))){
		//check if date was sunday and was also holiday
	       if(!(date('l', strtotime($date))=='Sunday') && $date!='2020-10-29'){
				$foundMissedReport=1;
			$days[] =$date .' '. date('l', strtotime($date));
		}
		
		}
		
        $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
	 }
	 if($foundMissedReport==0){
		 $days[]="Seems like Your branch submitted all reports correctly and there is no any missed report";
	 }
	 $this->set('missedReportDays', $days);

	}

	function add($id = null) {
		if (!empty($this->data)) {

                        $date = str_replace('/', '-', $this->data['AvailableBirrNote']['date_of']);
			if($this->AvailableBirrNote->find('all', 
			    array('conditions'=>array('AvailableBirrNote.date_of'=>date('Y-m-d', strtotime($date)) , 'AvailableBirrNote.branch_id'=>$this->Auth->user('branch_id'))))){
			$this->Session->setFlash(__('You already saved birr note with this date, you can only edit.', true), '');
				$this->render('/elements/failure3');
	
			}
			else{
                        $this->AvailableBirrNote->create();
			$this->autoRender = false;
			//$this->data['AvailableBirrNote']['branch_id']=$this->getBranchId();
			$this->data['AvailableBirrNote']['branch_id']=$this->Auth->user('branch_id');
			$this->data['AvailableBirrNote']['user_id']=$this->Auth->user('id');
			if ($this->AvailableBirrNote->save($this->data)) {
				$this->Session->setFlash(__('The available birr note has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Seems like Your session has timed out, could not be saved. Please, log in and try again.', true), '');
				$this->render('/elements/failure3');
			}
				
			}

			
		}
		if($id)
			$this->set('parent_id', $id);
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid available birr note', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->AvailableBirrNote->save($this->data)) {
				$this->Session->setFlash(__('The available birr note has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The available birr note could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('available_birr_note', $this->AvailableBirrNote->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$branches = $this->AvailableBirrNote->Branch->find('list');
		$users = $this->AvailableBirrNote->User->find('list');
		$this->set(compact('branches', 'users'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for available birr note', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->AvailableBirrNote->delete($i);
                }
				$this->Session->setFlash(__('Available birr note deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Available birr note was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->AvailableBirrNote->delete($id)) {
				$this->Session->setFlash(__('Available birr note deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Available birr note was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}


}
?>