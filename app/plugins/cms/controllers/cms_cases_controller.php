<?php
class CmsCasesController extends AppController {

	var $name = 'CmsCases';
	
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('send_sms', 'send_sms_review','cheque_point_sms','Deposit_sms');
	}
	
	function index() {
		//$branches = $this->CmsCase->Branch->find('all');
		//$this->set(compact('branches'));
		
		$user = $this->Session->read();	
		$this->set('user_id',$user['Auth']['User']['id']);
		$this->set('groups',$user['Auth']['Group']);
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 40;
		$search_id = (isset($_REQUEST['search_id'])) ? $_REQUEST['search_id'] : 3;
		$search_status = (isset($_REQUEST['search_status'])) ? $_REQUEST['search_status'] : -1;
		if($id){
			$search_id = ($id) ? $id : -1;
			$search_status = ($id) ? $id : -1;
		}
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$user = $this->Session->read();
		$this->loadModel('Employee');
		$this->Employee->unbindModel(array('belongsTo' => array('EmpLoc','ContactLocation'),'hasMany' => array('Education','Experience','Language','Offspring','Termination','Loan')));
		$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));
		$count = count($emp['EmployeeDetail']);
		if ($search_id == -1) {			
            if(empty($conditions)){
				$conditions['CmsCase.searchable'] = 1;
				$conditions['CmsCase.status'] = 'closed';
			}
			else if(!empty($conditions)){				
				$this->loadModel('CmsAssignment');
				//$this->CmsAssignment->recursive =-1;
				$cases= $this->CmsAssignment->find('list', array('conditions' => array('CmsAssignment.assigned_to'=>$user['Auth']['User']['id'],'CmsAssignment.status'=>1),'fields'=>array('CmsAssignment.cms_case_id')));
				$conditions = array_merge(array("OR" => array('CmsCase.id' => $cases,'CmsCase.user_id' => $user['Auth']['User']['id'])),$conditions);
				
				if($search_status != -1){
					$conditions['CmsCase.status'] = $search_status;
				}
				else if($search_status == -1){
					$conditions['CmsCase.status !='] = 'closed';
				}
			}
        }else if($search_id == 1){
		
			$group_id = null;
			$this->loadModel('CmsGroup');
			//$this->CmsGroup->recursive =-1;
			$group = $this->CmsGroup->find('all', array('conditions' => array('user_id' => $user['Auth']['User']['id'])));
			
			if($group != null){
				foreach($group as $g){
					$groupid[]=$g['CmsGroup']['id'];
					$branchid[]=$g['CmsGroup']['branch_id'];
				}
				$conditions['CmsCase.cms_group_id'] = $groupid;
				$conditions['CmsCase.branch_id'] = $branchid;
			}
			else if($group == null){
				$this->loadModel('Supervisor');
				//$this->Supervisor->recursive =-1;
				$superviser = $this->Supervisor->find('first', array('conditions' => array('emp_id' => $emp['Employee']['id'])));
				//$this->Employee->recursive =-1;
				
				$emp_one = $this->Employee->find('first',array('conditions'=>array('Employee.id'=>$superviser['Supervisor']['sup_emp_id'])));
				//$this->CmsGroup->recursive =-1;
				$group = $this->CmsGroup->find('all', array('conditions' => array('user_id' => $emp_one['Employee']['user_id'])));
				if($group != null){
					foreach($group as $g){
						$groupid[]=$g['CmsGroup']['id'];
					}
					$conditions['CmsCase.cms_group_id'] = $groupid;
					//$conditions['CmsCase.cms_group_id'] = $g['CmsGroup']['id'];
				}
				else if($group == null){
					$employees = $this->requestAction(array('controller' => 'holidays', 'action' => 'supervised'), array('pass' => array('emp_id'=>$emp['Employee']['id'])));					
					$users=array();
					$groupsid = array();
					foreach($employees as $employee){
						$emp = $this->Employee->read(null,$employee);
						$users[] = $emp['Employee']['user_id'];
					}
					//$this->CmsGroup->recursive =-1;
					$groups = $this->CmsGroup->find('all', array('conditions' => array("OR "=>array('user_id' => $users))));
					foreach($groups as $group){
						$groupsid[]=$group['CmsGroup']['id'];						
					}					
					$groupcond=array("OR "=>array("CmsCase.cms_group_id" => $groupsid));
					$conditions['CmsCase.cms_group_id'] = $groupsid;					
				}
				$conditions['CmsCase.branch_id'] = $emp['EmployeeDetail'][$count - 1]['branch_id'];
			}
			
			$conditions['CmsCase.status'] = 'created';
			
			if($user['Auth']['User']['id'] == 82){
				$conditions['CmsCase.cms_group_id'] = array(3,4,5,6,7,8);
				$conditions['CmsCase.branch_id'] = array(118,183);
			}
			else if($user['Auth']['User']['id'] == 71){
				$conditions['CmsCase.cms_group_id'] = array(3,4);
				$conditions['CmsCase.branch_id'] = array(118);
			}
			
		}else if($search_id == 2){
			$this->loadModel('CmsAssignment');
			//$this->CmsAssignment->recursive =-1;
			$cases= $this->CmsAssignment->find('list', array('conditions' => array('CmsAssignment.assigned_to'=>$emp['Employee']['user_id'],'CmsAssignment.status'=>1),'fields'=>array('CmsAssignment.cms_case_id')));
			$conditions = array_merge(array("OR" => array('CmsCase.id' => $cases)), $conditions);
			
			if($search_status != -1){
				$conditions['CmsCase.status'] = $search_status;
			}
			else if($search_status == -1){
				$conditions['CmsCase.status !='] = 'closed';
			}
		}else if($search_id == 3){
			$conditions['CmsCase.user_id'] = $emp['Employee']['user_id'];
			
			if($search_status != -1){
				$conditions['CmsCase.status'] = $search_status;
			}
			else if($search_status == -1){
				$conditions['CmsCase.status !='] = 'closed';
			}
		}
		else if($search_id == 4){
			$this->loadModel('CmsGroup');
			//$this->CmsGroup->recursive =-1;
			$group = $this->CmsGroup->find('first', array('conditions' => array('user_id' => $user['Auth']['User']['id'])));
			if($group != null){
				$conditions['CmsCase.cms_group_id'] = $group['CmsGroup']['id'];				
			}
			else if($group == null){
				$employees = $this->requestAction(array('controller' => 'holidays', 'action' => 'supervised'), array('pass' => array('emp_id'=>$emp['Employee']['id'])));					
				$users=array();
				$groupsid = array();
				foreach($employees as $employee){
					$emp = $this->Employee->read(null,$employee);
					$users[] = $emp['Employee']['user_id'];
				}
				//$this->CmsGroup->recursive = -1;
				$groups = $this->CmsGroup->find('all', array('conditions' => array("OR "=>array('user_id' => $users))));
				foreach($groups as $group){
					$groupsid[]=$group['CmsGroup']['id'];						
				}					
				$groupcond=array("OR "=>array("CmsCase.cms_group_id" => $groupsid));
				$conditions['CmsCase.cms_group_id'] = $groupsid;				
			}
			if($search_status != -1 and $search_status != 'created'){
				$conditions['CmsCase.status'] = $search_status;
			}
			else $conditions['CmsCase.status !='] = 'created';
		}
		//$this->CmsCase->recursive = -1;
		//pr($this->CmsCase->find('all', array('conditions' => $conditions,'order'=>'CmsCase.status desc','limit' => $limit, 'offset' => $start)));
		
		$this->set('cms_cases', $this->CmsCase->find('all', array('conditions' => $conditions,'order'=>'CmsCase.status desc','limit' => $limit, 'offset' => $start,'order'=>'CmsCase.ticket_number DESC')));
		$this->set('results', $this->CmsCase->find('count', array('conditions' => $conditions)));
	}
	
	function list_data_detail($id = null) {		
		if(!empty($this->params['form'])){		
			$id = $this->params['form']['id'];
		}
		$conditions = array('CmsCase.id' => $id);
		$this->set('cms_cases', $this->CmsCase->find('all', array('conditions' => $conditions)));
		$this->set('results', $this->CmsCase->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid cms case', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->CmsCase->recursive = 2;
		$this->set('cmsCase', $this->CmsCase->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
		
		  // Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['CmsCase']['content']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&apos;',$content);
			// double quotes
            $content = ereg_replace('"','&quot;',$content);
			// slash
            $content = ereg_replace("/", '&#47;',$content);
			// back slash
            $content = ereg_replace('\\\\', '&#92;',$content);
			
			 $contenttitle = ereg_replace("\r",'',$this->data['CmsCase']['name']);
            // Handle paragraphs
            $contenttitle = ereg_replace("\n\n",'<br /><br />',$contenttitle);
            // Handle line breaks
            $contenttitle = ereg_replace("\n",'<br />',$contenttitle);
            // Handle apostrophes
            $contenttitle = ereg_replace("'",'&apos;',$contenttitle);
			// double quotes
            $contenttitle = ereg_replace('"','&quot;',$contenttitle);
			// slash
            $contenttitle = ereg_replace("/",'&#47;',$contenttitle);
			// back slash
            $contenttitle = ereg_replace("\\\\",'&#92;',$contenttitle);
			
			$user = $this->Session->read();
			$this->data['CmsCase']['name'] = $contenttitle;
			$this->data['CmsCase']['user_id'] = $user['Auth']['User']['id'];
			$this->data['CmsCase']['status'] = 'created';
			$this->CmsCase->create();
			$this->autoRender = false;
			if ($this->CmsCase->save($this->data)) {
				$lastid = $this->CmsCase->getLastInsertId();
				$this->loadModel('CmsReply');
				$this->CmsReply->create();
				$this->data2['CmsReply']['content'] = $content;
				$this->data2['CmsReply']['cms_case_id'] = $lastid;
				$this->data2['CmsReply']['user_id'] = $user['Auth']['User']['id'];
				if($this->CmsReply->save($this->data2)){
					$lastid = $this->CmsReply->getLastInsertId();				
					$this->Session->setFlash(__($lastid, true), '');
					$this->render('/elements/success');
					
					$group = $this->CmsCase->CmsGroup->find('first', array('conditions' => array('CmsGroup.id' => $this->data['CmsCase']['cms_group_id'])));
					
					$this->loadModel('Employee');
					//$this->Employee->recursive = -1;
					$conditionsEmp = array('Employee.user_id' => $group['CmsGroup']['user_id']);
					$employee = $this->Employee->find('first', array('conditions' =>$conditionsEmp));
					$employees = $this->requestAction(array('controller' => 'holidays', 'action' => 'supervised'), array('pass' => array('emp_id'=>$employee['Employee']['id'])));				
					
					$message=urlencode('there is a new case created. Please reply as soon as possible');
					foreach($employees as $e){
						$emp = $this->Employee->read(null,$e);
						$count = count($emp['EmployeeDetail']);
						if($emp['Employee']['status'] == 'active'){
							$countemp = $this->requestAction(array('controller' => 'holidays', 'action' => 'supervised'), array('pass' => array('emp_id'=>$emp['Employee']['id'])));
							if(count($countemp) == 0){								
								if($this->data['CmsCase']['branch_id'] == $emp['EmployeeDetail'][$count - 1]['branch_id']){
									$sup_tel = $emp['Employee']['telephone'];
									if($sup_tel != '0919495646'){
										file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
									}
								}								
							}
						}
					}
				}
			} else {
				$this->Session->setFlash(__('The case could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$branches = $this->CmsCase->Branch->find('list', array('conditions' => array('Branch.id' => array(118,183))));
		$groups = $this->CmsCase->CmsGroup->find('list');
		$users = $this->CmsCase->User->find('list');
		$this->set(compact('branches', 'users','groups'));
		
		$count = 0;
		$value = $this->CmsCase->find('first',array('conditions' => array('CmsCase.ticket_number LIKE' => date("Ymd").'%'),'order'=>'CmsCase.ticket_number DESC'));
		if($value != null){
			$value = explode('/',$value['CmsCase']['ticket_number']);		
			$count = $value[1];
		}		       
        $this->set('count',$count);
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid cms case', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->CmsCase->save($this->data)) {
				$this->Session->setFlash(__('The cms case has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The cms case could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('cms_case', $this->CmsCase->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$branches = $this->CmsCase->Branch->find('list');
		$users = $this->CmsCase->User->find('list');
		$this->set(compact('branches', 'users'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for cms case', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->CmsCase->delete($i);
                }
				$this->Session->setFlash(__('Cms case deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Cms case was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->CmsCase->delete($id)) {
				$this->Session->setFlash(__('Cms case deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Cms case was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function close($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for case', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            
        } else {
			$this->CmsCase->id = $id;
            if ($this->CmsCase->saveField('status', 'Closed')) {
				$this->Session->setFlash(__('Issue closed', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Issue was not closed', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function transfer($id = null) {
		if (!empty($this->data)) {
			$this->loadModel('CmsGroup');
			$group = $this->CmsGroup->read(null, $this->data['CmsCase']['cms_group_id']);
			$this->CmsCase->id = $this->data['CmsCase']['cms_case_id'];
			if ($this->CmsCase->updateAll(
					array('CmsCase.cms_group_id' => $this->data['CmsCase']['cms_group_id'],'CmsCase.branch_id' => $group['CmsGroup']['branch_id']),
					// conditions
					array('CmsCase.id' => $this->data['CmsCase']['cms_case_id'])
				)) {								
				$this->Session->setFlash(__('Issue successfully transfered', true), '');
				$this->render('/elements/success');	
			} else {
				$this->Session->setFlash(__('The cms reply could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
		$this->set('parent_id', $id);
		$cms_groups = $this->CmsCase->CmsGroup->find('list');
		$this->set(compact('cms_groups'));
	}
	
	function search_group($id = null){
		
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 500;
		$branch_id = (isset($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : -1;
		if($id)
			$branch_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($branch_id != -1) {
            $conditions['CmsGroup.branch_id'] = $branch_id;
        }
		
		$this->set('groups', $this->CmsCase->CmsGroup->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->CmsCase->CmsGroup->find('count', array('conditions' => $conditions)));
	}
	
	function GetEmpName(){
		$id = $this->params['userid'];
		$this->loadModel('User');
		$this->User->unbindModel(array('belongsTo' => array('Branch','Payroll'),'hasAndBelongsToMany' => array('Group')));
		$this->User->recursive = 2;
		$emp = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		
		return $emp['Person']['first_name'].' '.$emp['Person']['middle_name']; 
	}
	
	function GetAssignedEmpName(){
		$id = $this->params['caseid'];
		$this->loadModel('CmsAssignment');
		$this->User->recursive = -1;
		$assignment = $this->CmsAssignment->find('first',array('conditions'=>array('CmsAssignment.cms_case_id'=>$id)));
		
		$this->loadModel('User');
		$this->User->recursive = 2;
		$this->User->unbindModel(array('belongsTo' => array('Branch','Payroll'),'hasAndBelongsToMany' => array('Group')));
		$emp = $this->User->find('first',array('conditions'=>array('User.id'=>$assignment['CmsAssignment']['assigned_to'])));
		
		return $emp['Person']['first_name'].' '.$emp['Person']['middle_name']; 
	}
	
	function GetBranch(){
		$id = $this->params['userid'];		
			
		$this->loadModel('Employee');
		$this->Employee->unbindModel(array('belongsTo' => array('EmpLoc','ContactLocation'),'hasMany' => array('Education','Experience','Language','Offspring','Termination','Loan')));
		$emp = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$id)));
		$emp_details = $this->Employee->EmployeeDetail->find('first',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp['Employee']['id']),'order'=>'EmployeeDetail.start_date DESC'));
		
		return $emp_details['Branch']['name']; 
	}
	
	function send_sms() {
		$date = date('N');
		if($date != 7){
			$this->CmsCase->recursive = -1;
			$cases = $this->CmsCase->find('all', array('conditions' => array('CmsCase.status' => 'Solution Offered')));
			$this->loadModel('CmsReply');
			$this->loadModel('Employee');
			foreach($cases as $case){
				if($case['CmsCase']['sms'] == 1){
					$this->CmsReply->recursive =-1;			
					$conditionsReply =array('CmsReply.cms_case_id' => $case['CmsCase']['id']);
					$reply= $this->CmsReply->find('first', array('conditions' => $conditionsReply, 'order' => 'CmsReply.id DESC'));

					$firstdate = new DateTime($reply['CmsReply']['created']);
					$lastdate = new DateTime('now');
					$totaldate = $firstdate->diff($lastdate);
					if($totaldate->d >= 4){	
						$this->CmsCase->updateAll(
							array('CmsCase.status' => "'Closed'",'CmsCase.sms' => 2),
							// conditions
							array('CmsCase.id' => $case['CmsCase']['id'])
						);
					}
				}
				else if($case['CmsCase']['sms'] == 0){				 
					 $this->CmsReply->recursive =-1;			
					 $conditionsReply =array('CmsReply.cms_case_id' => $case['CmsCase']['id']);
					 $reply= $this->CmsReply->find('first', array('conditions' => $conditionsReply, 'order' => 'CmsReply.id DESC'));

					$firstdate = new DateTime($reply['CmsReply']['created']);
					$lastdate = new DateTime('now');
					$totaldate = $firstdate->diff($lastdate);
					if($totaldate->d >= 2){					
						$this->Employee->recursive = -1;
						$conditionsEmp = array('Employee.user_id' => $case['CmsCase']['user_id']);
						$employee = $this->Employee->find('first', array('conditions' =>$conditionsEmp));
						$sup_tel=$employee['Employee']['telephone'];
						$message=urlencode('Please close your case that is answered before 2 days ago on Case Management System');
						file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
						
						$this->CmsCase->id = $case['CmsCase']['id'];
						$this->CmsCase->saveField('sms', 1);
					}
				}
			}
        }
		$date1 = date('d-m-Y');
		echo "send_sms" . $date1;
    }
	
	function send_sms_review() {		
		$date = date('N');
		if($date != 7){
			$this->CmsCase->recursive = -1;
			$cases = $this->CmsCase->find('all', array('conditions' => array('CmsCase.status' => 'Review Update')));
			$this->loadModel('CmsReply');
			$this->loadModel('Employee');
			foreach($cases as $case){
				
				$this->CmsReply->recursive =-1;			
				$conditionsReply =array('CmsReply.cms_case_id' => $case['CmsCase']['id']);
				$reply= $this->CmsReply->find('first', array('conditions' => $conditionsReply, 'order' => 'CmsReply.id DESC'));

				$firstdate = new DateTime($reply['CmsReply']['created']);
				$lastdate = new DateTime('now');
				$totaldate = $firstdate->diff($lastdate);
				if($totaldate->d >= 3){	
					$this->CmsCase->updateAll(
						array('CmsCase.status' => "'Closed'",'CmsCase.sms' => 2),
						// conditions
						array('CmsCase.id' => $case['CmsCase']['id'])
					);
				}
			
				else if($totaldate->d < 3){
									
					$this->Employee->recursive = -1;
					$conditionsEmp = array('Employee.user_id' => $case['CmsCase']['user_id']);
					$employee = $this->Employee->find('first', array('conditions' =>$conditionsEmp));
					$sup_tel=$employee['Employee']['telephone'];
					$message=urlencode('Please reply your case referenced by '.$case['CmsCase']['ticket_number'].'on Case Management System');
					file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);				
				
				}
			}
        }
		$date1 = date('d-m-Y');
		echo "send_sms_review" . $date1;
    }
	
	function cheque_point_sms(){		
		$date = date('N');
		if($date != 7){
			$dbhost = "10.1.3.89";
			$dbuser = "abay";
			$dbpass = "abay";
			$db = "CHQPNT";
			
			$conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". $conn ->error);		
			
			$current_time;
			$date_mysql = "select now()";
			$result_date_mysql = $conn->query($date_mysql);
			while($row_date_mysql = $result_date_mysql->fetch_assoc()){
				$current_time = $row_date_mysql["now()"];
				$current_time = strtotime($current_time);
			}
			
			$this->loadModel('EmployeeDetail');
			$this->loadModel('Branch');
			//////////////////////////////////   IN CHEQUE   //////////////////////////////////////////////////////////////////////
			$sql = "SELECT * FROM INCHEQUE  WHERE AUTHORIZED = 0";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					$sys_date = $row["SYSTDATE"];
					
					$sys_date = strtotime($sys_date);
					
					$diff = $current_time - $sys_date;
					$hours = $diff/ (60 * 60);
					
					if($hours <= 48 and $hours >= 44){
						$sql_batch = "SELECT * FROM BATCH  WHERE BATCHID = ".$row["BATCHID"];
						$result_batch = $conn->query($sql_batch);
						while($row_batch = $result_batch->fetch_assoc()){
							$sql_branch = "SELECT * FROM BRANCH  WHERE BANKID = 19 AND BRANCHID = ".$row_batch["BRANCHID"];
							$result_branch = $conn->query($sql_branch);
							if($result_branch->num_rows > 0){
								while($row_branch = $result_branch->fetch_assoc()){
									
									$this->Branch->recursive = -1;
									$position = array(71, 93, 121, 122, 131, 329, 330, 331, 332, 333, 340, 351, 352, 354, 386, 412, 20, 38, 60, 220, 335);
									$conditionsBranch = array('Branch.fc_code' => $row_branch['UPLOADCODE']);
									$branch = $this->Branch->find('first', array('conditions' =>$conditionsBranch));
									$conditionsEmpDetail = array('EmployeeDetail.branch_id' => $branch['Branch']['id'], 'EmployeeDetail.position_id' => $position, 'EmployeeDetail.end_date' => '0000-00-00');
									$employeeDetail = $this->EmployeeDetail->find('all', array('conditions' =>$conditionsEmpDetail));
									
									foreach($employeeDetail as $empDetail){
										if($empDetail['Employee']['status'] == 'active'){
											$sup_tel=$empDetail['Employee']['telephone'];
											$message=urlencode('There is uncompleted INCHEQUE in your branch with PROC NO = '.$row["PROCNO"] .'. Please respond on cheque point system');
											file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
											
											$sup_tel='0912838019';
											$message=urlencode('There is uncompleted INCHEQUE in '.$branch["Branch"]["name"]. 'with PROC NO = '.$row["PROCNO"] .'.');
											file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
										
										}
									}
								}
							}
						}
					}
				}
			}
			
			/////////////////////////////////////// OUT CHEQUE   ////////////////////////////////////////////////////////////////////////
			$sql = "SELECT * FROM OUTCHEQUE  WHERE AUTHORIZED = 0";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					$sys_date = $row["SYSTDATE"];
					
					$sys_date = strtotime($sys_date);
					
					$diff = $current_time - $sys_date;
					$hours = $diff/ (60 * 60);
					
					if($hours <= 48 and $hours >= 44){					
						$sql_branch = "SELECT * FROM BRANCH  WHERE BANKID = 19 AND BRANCHID = ".$row["CUSTBRANCH"];
						$result_branch = $conn->query($sql_branch);
						if($result_branch->num_rows > 0){
							while($row_branch = $result_branch->fetch_assoc()){
								
								$this->Branch->recursive = -1;
								$position = array(71, 93, 121, 122, 131, 329, 330, 331, 332, 333, 340, 351, 352, 354, 386, 412, 20, 38, 60, 220, 335);
								$conditionsBranch = array('Branch.fc_code' => $row_branch['UPLOADCODE']);
								$branch = $this->Branch->find('first', array('conditions' =>$conditionsBranch));
								$conditionsEmpDetail = array('EmployeeDetail.branch_id' => $branch['Branch']['id'], 'EmployeeDetail.position_id' => $position, 'EmployeeDetail.end_date' => '0000-00-00');
								$employeeDetail = $this->EmployeeDetail->find('all', array('conditions' =>$conditionsEmpDetail));
								
								foreach($employeeDetail as $empDetail){
									if($empDetail['Employee']['status'] == 'active'){
										$sup_tel=$empDetail['Employee']['telephone'];
										$message=urlencode('There is uncompleted OUTCHEQUE in your branch with PROC NO = '.$row["PROCNO"] .'. Please respond on cheque point system');
										file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);exit;
									
										$sup_tel='0912838019';
										$message=urlencode('There is uncompleted OUTCHEQUE in '.$branch["Branch"]["name"]. 'with PROC NO = '.$row["PROCNO"] .'.');
										file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
										
									}
								}
							}
						}
					}
				}
			}
			
			//////////////////////////////////   IN RTGS   //////////////////////////////////////////////////////////////////////
			$sql = "SELECT * FROM INRTGS  WHERE AUTHORIZED = 0";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					$sys_date = $row["SYSTDATE"];
					
					$sys_date = strtotime($sys_date);
					
					$diff = $current_time - $sys_date;
					$hours = $diff/ (60 * 60);
					
					if($hours <= 48 and $hours >= 44){
						$sql_batch = "SELECT * FROM BATCH  WHERE BATCHID = ".$row["BATCHID"];
						$result_batch = $conn->query($sql_batch);
						while($row_batch = $result_batch->fetch_assoc()){
							$sql_branch = "SELECT * FROM BRANCH  WHERE BANKID = 19 AND BRANCHID = ".$row_batch["BRANCHID"];
							$result_branch = $conn->query($sql_branch);
							if($result_branch->num_rows > 0){
								while($row_branch = $result_branch->fetch_assoc()){
									
									$this->Branch->recursive = -1;
									$position = array(71, 93, 121, 122, 131, 329, 330, 331, 332, 333, 340, 351, 352, 354, 386, 412, 20, 38, 60, 220, 335);
									$conditionsBranch = array('Branch.fc_code' => $row_branch['UPLOADCODE']);
									$branch = $this->Branch->find('first', array('conditions' =>$conditionsBranch));
									$conditionsEmpDetail = array('EmployeeDetail.branch_id' => $branch['Branch']['id'], 'EmployeeDetail.position_id' => $position, 'EmployeeDetail.end_date' => '0000-00-00');
									$employeeDetail = $this->EmployeeDetail->find('all', array('conditions' =>$conditionsEmpDetail));
									
									foreach($employeeDetail as $empDetail){
										if($empDetail['Employee']['status'] == 'active'){
											$sup_tel=$empDetail['Employee']['telephone'];
											$message=urlencode('There is uncompleted INRTGS in your branch with PROC NO = '.$row["PROCNO"] .'. Please respond on cheque point system');
											file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
										
											$sup_tel='0912838019';
											$message=urlencode('There is uncompleted INRTGS in '.$branch["Branch"]["name"]. 'with PROC NO = '.$row["PROCNO"] .'.');
											file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
										
										}
									}
								}
							}
						}
					}
				}
			}
			
			//////////////////////////////////   OUT RTGS   //////////////////////////////////////////////////////////////////////
			$sql = "SELECT * FROM OUTRTGS  WHERE AUTHORIZED = 0";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					$sys_date = $row["SYSTDATE"];
					
					$sys_date = strtotime($sys_date);
					
					$diff = $current_time - $sys_date;
					$hours = $diff/ (60 * 60);
					
					if($hours <= 48 and $hours >= 44){
						$sql_batch = "SELECT * FROM BATCH  WHERE BATCHID = ".$row["BATCHID"];
						$result_batch = $conn->query($sql_batch);
						while($row_batch = $result_batch->fetch_assoc()){
							$sql_branch = "SELECT * FROM BRANCH  WHERE BANKID = 19 AND BRANCHID = ".$row_batch["BRANCHID"];
							$result_branch = $conn->query($sql_branch);
							if($result_branch->num_rows > 0){
								while($row_branch = $result_branch->fetch_assoc()){
									
									$this->Branch->recursive = -1;
									$position = array(71, 93, 121, 122, 131, 329, 330, 331, 332, 333, 340, 351, 352, 354, 386, 412, 20, 38, 60, 220, 335);
									$conditionsBranch = array('Branch.fc_code' => $row_branch['UPLOADCODE']);
									$branch = $this->Branch->find('first', array('conditions' =>$conditionsBranch));
									$conditionsEmpDetail = array('EmployeeDetail.branch_id' => $branch['Branch']['id'], 'EmployeeDetail.position_id' => $position, 'EmployeeDetail.end_date' => '0000-00-00');
									$employeeDetail = $this->EmployeeDetail->find('all', array('conditions' =>$conditionsEmpDetail));
									
									foreach($employeeDetail as $empDetail){
										if($empDetail['Employee']['status'] == 'active'){
											$sup_tel=$empDetail['Employee']['telephone'];
											$message=urlencode('There is uncompleted OUTRTGS in your branch with PROC NO = '.$row["PROCNO"] .'. Please respond on cheque point system');
											file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
										
											$sup_tel='0912838019';
											$message=urlencode('There is uncompleted OUTRTGS in '.$branch["Branch"]["name"]. 'with PROC NO = '.$row["PROCNO"] .'.');
											file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
										
										}
									}
								}
							}
						}
					}
				}
			}
			
			$conn->close();
		}
	}
	
	function Deposit_sms(){
		$this->loadModel('Employee');
		$this->loadModel('Flexcube');
		$employees = $this->Employee->query($cmd);
		$cmd = "SELECT e.Telephone,ve.branch_code  from viewemployee e inner join viewemployement ve on e.`record id`=ve.`record id` WHERE  Status='active' AND POSITION IN('Branch Manager A','Branch Manager B','Branch Manager C','A/Branch Manager') AND ve.`branch_code` > 101 and ve.`branch_code` < 500 AND ve.`end DATE`='9999-99-99'";
		$employees = $this->Employee->query($cmd);
		foreach($employees as $emp){
			$depo ="SELECT SUM(A.LCY_CURR_BALANCE) FROM abyfclive.sttm_cust_account A WHERE A.BRANCH_CODE = 102 AND A.DR_GL IN (SELECT GL_CODE FROM ABY_DEPOSIT_SMRY_GL WHERE GL_CATEGORY in ( 'SA','SAH','DD','TD','FX'))";
			$deposit = $this->Flexcube->query($depo);
			pr($deposit);
		}
	}
}
?>