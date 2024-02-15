<?php
class JobsController extends AppController {

	var $name = 'Jobs';
	
	function index() {
		//$grades = $this->Job->Grade->find('all');
		//$this->set(compact('grades'));
	}
	function index_post() {
		//$grades = $this->Job->Grade->find('all');
		//$this->set(compact('grades'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}
	function index4($id = null) {
		$this->set('parent_id', $id);
	}
    function index3() {
		//$grades = $this->Job->Grade->find('all');
		//$this->set(compact('grades'));
   
  
   
   	$this->loadModel('Employee');
		$this->Employee->recursive=-1;		
		$emp = $this->Employee->findByuser_id($this->Session->read('Auth.User.id'));
    $emp_date=date_create($emp['Employee']['date_of_employment']);
    $now=date_create(date('Y/m/d'));
    $diff=date_diff($emp_date,$now)->y;
    
    if($diff<1){
     $disable='false';
     $message="Sorry You have not fulfilled the one year minimum work experience at Abay Bank S.C to apply for jobs.";
    }else{
     $disable='true';
     $message="Apply for Vacancy!!";
    }
    $this->set(compact('disable','message'));
    
	}
	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$grade_id = (isset($_REQUEST['grade_id'])) ? $_REQUEST['grade_id'] : -1;
		if($id)
			$grade_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($grade_id != -1) {
            $conditions['Job.grade_id'] = $grade_id;
        }
		
		$this->set('jobs', $this->Job->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start,'order'=>'created DESC')));
		$this->set('results', $this->Job->find('count', array('conditions' => $conditions)));
	}
        
     function list_data3($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$conditions['Job.end_date >='] = date('Y-m-d');
		$conditions['Job.start_date <='] = date('Y-m-d');
		$conditions['Job.status'] = 'Open';
		$this->set('jobs', $this->Job->find('all', array('conditions' => $conditions, 'order'=>'end_date DESC')));
		$this->set('results', $this->Job->find('count', array('conditions' => $conditions)));
	}
	
	        
     function list_data4($id = null) {
		$this->loadModel('Employee');
		$this->Employee->recursive=-1;		
		$emp = $this->Employee->findByuser_id($this->Session->read('Auth.User.id'));
		//print_r($emp);
		//$emp['Employee']['id']=781;
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		
       // $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        //eval("\$conditions = array( " . $conditions . " );");
		$this->loadModel('Application');
		$conditions['Application.employee_id'] = $emp['Employee']['id'];
		//$xx=$this->Application->find('all', array('conditions' => $conditions, 'order'=>'created DESC'));
   
   //var_dump($this->Application->find('all', array('conditions' => $conditions, 'order'=>'Application.created DESC')));die();

		$this->set('jobs', $this->Application->find('all', array('conditions' => $conditions, 'order'=>'Application.created DESC')));
		$this->set('results', $this->Application->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid job', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Job->recursive = 2;
		$this->set('job', $this->Job->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
		$user = $this->Session->read();
		$this->data['Job']['created_by']=$user['Auth']['User']['id'];
                        // Strip out carriage returns
                        //$this->data['Job']['description'] = ereg_replace("\r",'',$this->data['Job']['description']);
                        // Handle paragraphs
                        //$this->data['Job']['description'] = ereg_replace("\n\n",'</p><p>',$this->data['Job']['description']);
                        // Handle line breaks
                        //$this->data['Job']['description'] = ereg_replace("\n",'<br />',$this->data['Job']['description']);
						
						$location='';
						foreach($this->data['Job']['location'] as $key=>$loc){
						$location.=$loc;
						if((count($this->data['Job']['location'])-1)!=$key)
						$location.=',';
						}
						$this->data['Job']['location']=$location;
						$this->data['Job']['status']='Open';
						//print_r($this->data);
			$this->Job->create();
			$this->autoRender = false;
			if ($this->Job->save($this->data)) {
				$this->Session->setFlash(__('The Internal Vacancy has been Posted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The job could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
			$this->loadModel('Position');
		$positions = $this->Position->find('list');
		
		$pos=array();
		foreach($positions as $ps){
		$pos[$ps]=$ps;
		}
		//print_r($pos);
		$this->set('positions',$pos);
		$this->loadModel('Location');
		$locations = $this->Location->find('list');
		$this->loadModel('Branch');
		$branches = $this->Branch->find('list');
		$loc=array();
		foreach($locations as $ls){
		$loc[$ls]=$ls.' Area';
		}
		foreach($branches as $ls){
		$loc[$ls]=$ls;
		}
		$this->set('locations',$loc);
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid job', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
		$user = $this->Session->read();
		$this->data['Job']['modified_by']=$user['Auth']['User']['id'];
        
                        // Strip out carriage returns
                        //$this->data['Job']['description'] = ereg_replace("\r",'',$this->data['Job']['description']);
                        // Handle paragraphs
                        //$this->data['Job']['description'] = ereg_replace("\n\n",'</p><p>',$this->data['Job']['description']);
                        // Handle line breaks
                       // $this->data['Job']['description'] = ereg_replace("\n",'<br />',$this->data['Job']['description']);
			$this->autoRender = false;
			if ($this->Job->save($this->data)) {
				$this->Session->setFlash(__('Changes have been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The job could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('job', $this->Job->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		//$grades = $this->Job->Grade->find('list');
		//$locations = $this->Job->Location->find('list');
		$this->set(compact('grades', 'locations'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for job', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Job->delete($i);
                }
				$this->Session->setFlash(__('Job deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Job was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Job->delete($id)) {
				$this->Session->setFlash(__('Job deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Job was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>