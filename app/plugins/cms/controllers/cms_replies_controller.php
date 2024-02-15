<?php
class CmsRepliesController extends CmsAppController {

	var $name = 'CmsReplies';
	
	function index() {
		$cms_cases = $this->CmsReply->CmsCase->find('all');
		$this->set(compact('cms_cases'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
function list_data($id = null,$type = null,$user_id = null,$supervisorbtn = null){		
		if(!empty($this->params['form'])){		
			$id = $this->params['form']['id'];
		}
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 500;
		
		$type = (isset($_REQUEST['type'])) ? $_REQUEST['type'] : $type;
		$cmscase_id = $id;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($cmscase_id != -1) {
            $conditions['CmsReply.cms_case_id'] = $cmscase_id;
        }
		$cms_replies = $this->CmsReply->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));
		$case = $this->CmsReply->CmsCase->read(null,$cmscase_id);		
		
		echo '<div style=" background-color: #BDBDBD;color: gray;font-family:courier;font-size: 13px;font-weight:bolder;height: 25px;padding: 6px;">';

		if($case['CmsCase']['status'] == 'created' && $case['CmsCase']['user_id'] == $user_id)
		{
			echo '<a style="color:#FF0000;cursor: pointer;text-decoration: underline;" onclick="parent.cmsd('.$id.')">Delete</a> | ';			
		}
		if($case['CmsCase']['status'] == 'created' && $type != 4)
		{
			echo '<a style="color:#0040FF;cursor: pointer;text-decoration: underline;" onclick="parent.cmsa('.$id.')">Assign</a> | ';	
		}
		if($case['CmsCase']['status'] == 'Work On Progress' && ($type == 2 or $type == 3))
		{
			echo '<a style="color:#0040FF;cursor: pointer;text-decoration: underline;" onclick="parent.cmsr('.$id.')">Reply</a> | ';
		}
		else if($case['CmsCase']['status'] == 'Review Update' && ($type == 2 or $type == 3))
		{
			echo '<a style="color:#0040FF;cursor: pointer;text-decoration: underline;" onclick="parent.cmsr('.$id.')">Reply</a> | ';
		}
		else if($case['CmsCase']['status'] == 'Review Update' && ($type == 3 or $type == 2))
		{
			echo '<a style="color:#0040FF;cursor: pointer;text-decoration: underline;" onclick="parent.cmsr1('.$id.')">Reply</a> | ';
		}
		else if($case['CmsCase']['status'] == 'Solution Offered' && $type == 3){
			echo '<a style="color:#0040FF;cursor: pointer;text-decoration: underline;" onclick="parent.cmsr1('.$id.')">Reply</a> | ';
			echo '<a style="color:#FFFF00;cursor: pointer;text-decoration: underline;" onclick="parent.cmsc('.$id.')">Close</a> | ';
		}
		if($case['CmsCase']['status'] == 'Work On Progress' && $type == 4)
		{
			echo '<a style="color:#0040FF;cursor: pointer;text-decoration: underline;" onclick="parent.cmsa('.$id.')">ReAssign</a> | ';
		}
		if($case['CmsCase']['status'] == 'Work On Progress' && $type == 2 && $supervisorbtn == true)
		{
			echo '<a style="color:#0040FF;cursor: pointer;text-decoration: underline;" onclick="parent.cmsa('.$id.')">ReAssign</a> | ';
		}
		if($case['CmsCase']['status'] == 'created' && $type == 1)
		{					
			echo '<a style="color:#0040FF;cursor: pointer;text-decoration: underline;" onclick="parent.cmst('.$id.')">Transfer</a> | ';
		}
		echo '</div>';	
		
		foreach($cms_replies as $cms_reply){
			if($case['CmsCase']['user_id'] == $cms_reply['CmsReply']['user_id']){
				echo '<div style="background-color: #A9E2F3;border-radius: 5px;box-shadow: 0 0 6px #B2B2B2;display: inline-block;padding: 10px 18px;position: relative;vertical-align: top;float: left; margin: 5px 45px 5px 20px;">' ;	
			}
			else{
				echo '<div style="background-color: #E0F8F7;border-radius: 5px;box-shadow: 0 0 6px #B2B2B2;display: inline-block;padding: 10px 18px;position: relative;vertical-align: top;float: right;margin: 5px 20px 5px 45px;">' ;
			}
						
					echo '<div  style="margin: 0px; padding: 5px; font-family: tahoma;font-size: 13px;color: black; white-space: normal;">' . $cms_reply['CmsReply']['content'].'</br></div>'; 
					if(count($cms_reply['CmsAttachment']) >0){ 
							echo '<hr><span style="color:brown;">Attachments</span><hr>'; 
					}
					echo '<ul style="margin-left: 37px; padding: 8px;list-style-type: circle;">';
					foreach($cms_reply['CmsAttachment'] as $attachment){
						echo "<li style=\"margin-bottom: -17px;\"><a style=\"text-decoration: none;font-size: 12px;color:brown\" href=\"/AbayERP/cms/cmsAttachments/download/".$attachment['id']."\">".$attachment['name']."</a></li>&nbsp&nbsp&nbsp";
					}
					echo '</ul>';				
					echo '<p style="padding-right: 25px; float:right;">by <b> ';
					$result = explode('~',$this->requestAction(
						array(
							'controller' => 'cms_replies', 
							'action' => 'GetEmpName'), 
						array('userid' => $cms_reply['User']['id'])));
					echo $result[0].'</br><i>';
					echo $result[1].'</b></i></p></br></br>';
					echo '<p style="padding-right: 25px; float:right;">';
					echo $cms_reply['CmsReply']['created'];
					echo '</p></div>';
		}
	}
	
	function list_data11($id = null) {
		if(!empty($this->params['form'])){		
			$id = $this->params['form']['id'];
		}
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 500;
		
		$cmscase_id = $id;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($cmscase_id != -1) {
            $conditions['CmsReply.cms_case_id'] = $cmscase_id;
        }
		$this->set('cms_replies', $this->CmsReply->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->CmsReply->find('count', array('conditions' => $conditions)));
	}
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid cms reply', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->CmsReply->recursive = 2;
		$this->set('cmsReply', $this->CmsReply->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->CmsReply->create();
			$this->autoRender = false;
			$user = $this->Session->read();
			$this->data['CmsReply']['user_id'] = $user['Auth']['User']['id'];
			
			// Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['CmsReply']['content']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&apos;',$content);
			
			$this->data['CmsReply']['content'] = $content;
			
			if ($this->CmsReply->save($this->data)) {
				$lastid = $this->CmsReply->getLastInsertId();				
				$this->Session->setFlash(__($lastid, true), '');
				$this->render('/elements/success');
				
				$this->loadModel('CmsCase');
				$this->CmsCase->id = $this->data['CmsReply']['cms_case_id'];
				$this->CmsCase->saveField('status',$this->data['CmsReply']['status']);				
				
				$case = $this->CmsCase->read(null, $this->data['CmsReply']['cms_case_id']);
				if($case['CmsCase']['user_id'] != $user['Auth']['User']['id']){
					$this->loadModel('Employee');
					$this->Employee->recursive = -1;
					$conditionsEmp = array('Employee.user_id' => $case['CmsCase']['user_id']);
					$employee = $this->Employee->find('first', array('conditions' =>$conditionsEmp));
					$sup_tel=$employee['Employee']['telephone'];
					$message=urlencode('there is a reply to your case. Please check on Case Management System');
					file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
					
					if($sup_tel =='0911727654' || $sup_tel =='0912655313' || $sup_tel =='0911563235'){
						$this->loadModel('User');
						$this->User->recursive = 1;
						$this->User->unbindModel(array('belongsTo' => array('Branch','Payroll'),'hasAndBelongsToMany' => array('Group')));
						$emp = $this->User->find('first',array('conditions'=>array('User.id'=>$user['Auth']['User']['id'])));				
						$messagecustom=urlencode($this->data['CmsReply']['content'].'  by: '.$emp['Person']['first_name'].' '.$emp['Person']['middle_name']);
						$telephone = '0912122045';
						file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$telephone.'&msg='.$messagecustom);
					}
					
					if($case['CmsCase']['level'] == 'critical'){
						$this->loadModel('Supervisor');
						$supervisor = $this->Supervisor->find('first', array('conditions' => array('emp_id' => $emp['Employee']['id'])));
						$emp_one = $this->Employee->find('first',array('conditions'=>array('Employee.id'=>$supervisor['Supervisor']['sup_emp_id'])));
						$conditionsEmp1 = array('Employee.user_id' => $emp_one['Employee']['user_id']);
						$employee1 = $this->Employee->find('first', array('conditions' =>$conditionsEmp1));
						$sup_tel1=$employee1['Employee']['telephone'];
						$message1=urlencode('there is a reply for a critical case of your branch. Please check on Case Management System');
						file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel1.'&msg='.$message1);	

						if($sup_tel1 =='0911727654' || $sup_tel1 =='0912655313' || $sup_tel1 =='0911563235'){
							$this->loadModel('User');
							$this->User->recursive = 1;
							$this->User->unbindModel(array('belongsTo' => array('Branch','Payroll'),'hasAndBelongsToMany' => array('Group')));
							$emp = $this->User->find('first',array('conditions'=>array('User.id'=>$user['Auth']['User']['id'])));				
							$messagecustom=urlencode($this->data['CmsReply']['content'].'  by: '.$emp['Person']['first_name'].' '.$emp['Person']['middle_name']);
							$telephone = '0912122045';
							file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$telephone.'&msg='.$messagecustom);
						}
					}
				}
				else if($case['CmsCase']['user_id'] == $user['Auth']['User']['id']){
					$this->loadModel('CmsAssignment');
					$this->CmsAssignment->recursive = -1;
					$conditionscase = array('CmsAssignment.cms_case_id' => $case['CmsCase']['id']);
					$assignment = $this->CmsAssignment->find('first', array('conditions' =>$conditionscase,'order'=>'CmsAssignment.id DESC'));
					
					$this->loadModel('Employee');
					$this->Employee->recursive = -1;
					$conditionsEmp = array('Employee.user_id' => $assignment['CmsAssignment']['assigned_to']);
					$employee = $this->Employee->find('first', array('conditions' =>$conditionsEmp));
					$sup_tel=$employee['Employee']['telephone'];
					$message=urlencode('there is a reply for a case with ticket number '.$case['CmsCase']['ticket_number'].'. Please check on Case Management System');
					file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
					
					if($sup_tel =='0911727654' || $sup_tel =='0912655313' || $sup_tel =='0911563235'){
						$this->loadModel('User');
						$this->User->recursive = 1;
						$this->User->unbindModel(array('belongsTo' => array('Branch','Payroll'),'hasAndBelongsToMany' => array('Group')));
						$emp = $this->User->find('first',array('conditions'=>array('User.id'=>$user['Auth']['User']['id'])));				
						$messagecustom=urlencode($this->data['CmsReply']['content'].'  by: '.$emp['Person']['first_name'].' '.$emp['Person']['middle_name']);
						$telephone = '0912122045';
						file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$telephone.'&msg='.$messagecustom);
					}
				}
			} else {
				$this->Session->setFlash(__('The cms reply could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$cms_cases = $this->CmsReply->CmsCase->find('list');
		$users = $this->CmsReply->User->find('list');
		$this->set(compact('cms_cases', 'users'));
	}
	
	function add_1($id = null) {
		if (!empty($this->data)) {
			$this->CmsReply->create();
			$this->autoRender = false;
			$user = $this->Session->read();
			$this->data['CmsReply']['user_id'] = $user['Auth']['User']['id'];
			
			// Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['CmsReply']['content']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&apos;',$content);
			
			$this->data['CmsReply']['content'] = $content;
			
			if ($this->CmsReply->save($this->data)) {
				$lastid = $this->CmsReply->getLastInsertId();				
				$this->Session->setFlash(__($lastid, true), '');
				$this->render('/elements/success');
				
				$this->loadModel('CmsCase');
				$this->CmsCase->id = $this->data['CmsReply']['cms_case_id'];
				$this->CmsCase->saveField('status','Work On Progress');				
				
				$case = $this->CmsCase->read(null, $this->data['CmsReply']['cms_case_id']);
				if($case['CmsCase']['user_id'] != $user['Auth']['User']['id']){
					$this->loadModel('Employee');
					$this->Employee->recursive = -1;
					$conditionsEmp = array('Employee.user_id' => $case['CmsCase']['user_id']);
					$employee = $this->Employee->find('first', array('conditions' =>$conditionsEmp));
					$sup_tel=$employee['Employee']['telephone'];
					$message=urlencode('there is a reply to your case. Please check on Case Management System');
					file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
					
					if($case['CmsCase']['level'] == 'critical'){
						$this->loadModel('Supervisor');
						$supervisor = $this->Supervisor->find('first', array('conditions' => array('emp_id' => $emp['Employee']['id'])));
						$emp_one = $this->Employee->find('first',array('conditions'=>array('Employee.id'=>$supervisor['Supervisor']['sup_emp_id'])));
						$conditionsEmp1 = array('Employee.user_id' => $emp_one['Employee']['user_id']);
						$employee1 = $this->Employee->find('first', array('conditions' =>$conditionsEmp1));
						$sup_tel1=$employee1['Employee']['telephone'];
						$message1=urlencode('there is a reply for a critical case of your branch. Please check on Case Management System');
						file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel1.'&msg='.$message1);						
					}
				}
				else if($case['CmsCase']['user_id'] == $user['Auth']['User']['id']){
					$this->loadModel('CmsAssignment');
					$this->CmsAssignment->recursive = -1;
					$conditionscase = array('CmsAssignment.cms_case_id' => $case['CmsCase']['id']);
					$assignment = $this->CmsAssignment->find('first', array('conditions' =>$conditionscase,'order'=>'CmsAssignment.id DESC'));
					
					$this->loadModel('Employee');
					$this->Employee->recursive = -1;
					$conditionsEmp = array('Employee.user_id' => $assignment['CmsAssignment']['assigned_to']);
					$employee = $this->Employee->find('first', array('conditions' =>$conditionsEmp));
					$sup_tel=$employee['Employee']['telephone'];
					$message=urlencode('there is a reply for a case with ticket number '.$case['CmsCase']['ticket_number'].'. Please check on Case Management System');
					file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$sup_tel.'&msg='.$message);
				}
			} else {
				$this->Session->setFlash(__('The cms reply could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$cms_cases = $this->CmsReply->CmsCase->find('list');
		$users = $this->CmsReply->User->find('list');
		$this->set(compact('cms_cases', 'users'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid cms reply', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->CmsReply->save($this->data)) {
				$this->Session->setFlash(__('The cms reply has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The cms reply could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('cms__reply', $this->CmsReply->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$cms_cases = $this->CmsReply->CmsCase->find('list');
		$users = $this->CmsReply->User->find('list');
		$this->set(compact('cms_cases', 'users'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for cms reply', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->CmsReply->delete($i);
                }
				$this->Session->setFlash(__('Cms reply deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Cms reply was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->CmsReply->delete($id)) {
				$this->Session->setFlash(__('Cms reply deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Cms reply was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function GetEmpName(){
		$id = $this->params['userid'];
		$this->loadModel('User');
		$this->User->recursive = 1;
		$this->User->unbindModel(array('belongsTo' => array('Branch','Payroll'),'hasAndBelongsToMany' => array('Group')));
		$emp = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		
		$this->loadModel('Employee');
		$this->Employee->recursive = -1;
		$conditionsEmp = array('Employee.user_id' => $id);
		$employee = $this->Employee->find('first', array('conditions' =>$conditionsEmp));
		$sup_tel=$employee['Employee']['telephone'];
					
		return $emp['Person']['first_name'].' '.$emp['Person']['middle_name'].'~'.$sup_tel; 
	}
}
?>