<?php
class DmsMessagesController extends AppController {

	var $name = 'DmsMessages';
	
	function index() {
	
		//$users = $this->DmsMessage->User->find('all');
		//$this->set(compact('users'));
	}
	
	function index2($id = null) {
			die();
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = 30;		
		
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';
		
		
        eval("\$conditions = array( " . $conditions . " );");
		
		$person_id = (isset($_REQUEST['person_id'])) ? $_REQUEST['person_id'] : 0;
		if($person_id !=0){
			//$this->loadModel('User');
			//$this->User->recursive=-1;
			//$user = $this->User->find('first', array('conditions' => array('User.person_id' =>$person_id)));
			$conditions['DmsMessage.user_id'] = $person_id; 
			$limit=300;
		}
		
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];
		
		if ($id != -1 && $id != null) {		
			if(!empty($this->params['form'])){		
				$id = $this->params['form']['id'];
			}
            $conditions['DmsMessage.id'] = $id;
			
			
        }
        
        $back_date=date('Y-m-d', strtotime("-6 months"));
       
       // var_dump($back_date);

		$conditions['DmsMessage.broadcast'] = 0;
    $conditions['DmsMessage.active'] = 1;
		$this->DmsMessage->User->unbindModel(array('belongsTo' => array('Branch','Payroll'),'hasAndBelongsToMany' => array('Group')));
		$this->DmsMessage->DmsRecipient->unbindModel(array('belongsTo' => array('User','DmsMessage')));
		$this->DmsMessage->recursive = 2;		
		$dms_messages=$this->DmsMessage->find('all', array('joins' => array(
        array(
            'table' => 'dms_recipients',
            'alias' => 'DmsRecipient',
            'type' => 'INNER',
            'conditions' => array(
                'DmsRecipient.dms_message_id = DmsMessage.id'
            )
        )
		),'conditions' => array('DmsRecipient.user_id' => $user_id,'DmsRecipient.active' => '1',$conditions), 'limit' => $limit, 'offset' => $start,'order'=>'DmsMessage.created DESC'));
		$this->loadModel('Employee');
		$this->Employee->unbindModel(array('belongsTo' => array('EmpLoc','ContactLocation','User'),'hasMany' => array('Education','Experience','Language','Offspring','Termination','Loan')));
		$this->Employee->recursive=2;
		$i=0;
		foreach($dms_messages as $dms_message){
			$emp=$this->Employee->find('all',array('conditions'=>array('Employee.user_id'=>$dms_message['DmsMessage']['user_id'])));
			$dms_messages[$i]['EmployeeDetail']=$emp[0]['EmployeeDetail'];
			$i++;
		}
		$this->set('dms_messages', $dms_messages);
		//$this->set('results', count($dms_messages));
		$this->set('results', $this->DmsMessage->find('count', array('joins' => array(
        array(
            'table' => 'dms_recipients',
            'alias' => 'DmsRecipient',
            'type' => 'INNER',
            'conditions' => array(
                'DmsRecipient.dms_message_id = DmsMessage.id'
            )
        )
		),'conditions' => array('DmsRecipient.user_id' => $user_id,'DmsRecipient.active' => '1',$conditions))));
	}
	function list_data2($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = 30;		
		
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';
		
		
		
        eval("\$conditions = array( " . $conditions . " );");
		
		$person_id = (isset($_REQUEST['person_id'])) ? $_REQUEST['person_id'] : 0;
		if($person_id !=0){
			//$this->loadModel('User');
			//$this->User->recursive=-1;
			//$user = $this->User->find('first', array('conditions' => array('User.person_id' =>$person_id)));
			$conditions['DmsMessage.user_id'] = $person_id; 
			$limit=40;
		}
		
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];
		
		if ($id != -1 && $id != null) {		
			if(!empty($this->params['form'])){		
				$id = $this->params['form']['id'];
			}
            $conditions['DmsMessage.id'] = $id;
        }
		$conditions['DmsMessage.broadcast'] = 1;
		$this->DmsMessage->User->unbindModel(array('belongsTo' => array('Branch','Payroll'),'hasAndBelongsToMany' => array('Group')));
		$this->DmsMessage->unbindModel(array('belongsTo' => array(),'hasMany' => array('DmsRecipient')));
		$this->DmsMessage->recursive = 2;		
		/*$dms_messages=$this->DmsMessage->find('all', array('joins' => array(
        array(
            'table' => 'dms_recipients',
            'alias' => 'DmsRecipient',
            'type' => 'INNER',
            'conditions' => array(
                'DmsRecipient.dms_message_id = DmsMessage.id'
            )
        )
		),'conditions' => array('DmsRecipient.user_id' => $user_id,'DmsRecipient.active' => '1',$conditions), 'limit' => $limit, 'offset' => $start,'order'=>'DmsMessage.created DESC'));
		*/
		$this->DmsMessage->recursive=2;
		
		$dms_messages=$this->DmsMessage->find('all',array('conditions'=>array('DmsMessage.broadcast'=>1), 'limit' => $limit, 'offset' => $start,'order'=>'DmsMessage.created DESC'));
		$this->loadModel('Employee');
		$this->Employee->unbindModel(array('belongsTo' => array('EmpLoc','ContactLocation','User'),'hasMany' => array('Education','Experience','Language','Offspring','Termination','Loan')));
		$this->Employee->recursive=2;
		$i=0;
		foreach($dms_messages as $dms_message){
			$emp=$this->Employee->find('all',array('conditions'=>array('Employee.user_id'=>$dms_message['DmsMessage']['user_id'])));
			$dms_messages[$i]['EmployeeDetail']=$emp[0]['EmployeeDetail'];
			$i++;
		}
		$this->set('dms_messages', $dms_messages);
			//$this->set('results',count($dms_messages));
		$this->set('results', $this->DmsMessage->find('count', array('joins' => array(
        array(
            'table' => 'dms_recipients',
            'alias' => 'DmsRecipient',
            'type' => 'INNER',
            'conditions' => array(
                'DmsRecipient.dms_message_id = DmsMessage.id'
            )
        )
		),'conditions' => array('DmsRecipient.user_id' => $user_id,'DmsRecipient.active' => '1',$conditions))));
	}
	function list_data1($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = 30;		
		
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';
		
        eval("\$conditions = array( " . $conditions . " );");
		
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];
		
		if ($id != -1 && $id != null) {		
			if(!empty($this->params['form'])){		
				$id = $this->params['form']['id'];
			} 
        }
		$this->DmsMessage->recursive = 2;		
     $conditions['DmsMessage.active'] = 1;
		$dms_messages=$this->DmsMessage->find('all', array('conditions' => array('DmsMessage.user_id' => $user_id,$conditions), 'limit' => $limit, 'offset' => $start,'order'=>'DmsMessage.created DESC'));
		$i=0;
		$this->loadModel('User');
		foreach($dms_messages as $dms_message){
			if(count($dms_message['DmsRecipient'])>1)
				$dms_messages[$i]['DmsMessage']['Receiver']='Multiple Recipients - '.count($dms_message['DmsRecipient']);
			else{
				$this->User->recursive = 1;	
				$this->User->unbindModel(array('belongsTo' => array('Branch','Payroll'),'hasAndBelongsToMany' => array('Group')));
			    $usr=$this->User->read(null, $dms_message['DmsRecipient'][0]['user_id']);
				$dms_messages[$i]['DmsMessage']['Receiver']=$usr['Person']['first_name'].' '.$usr['Person']['middle_name'];
				if($dms_message['DmsRecipient'][0]['read']==1)
					$dms_messages[$i]['DmsMessage']['Receiver'].=' <b style="color: gray;font-size: 9px;font-style: italic;">Seen</b><br>';
				else
					$dms_messages[$i]['DmsMessage']['Receiver'].=' <b style="color: black;font-size: 9px;font-style: italic;">Not Seen</b><br>';
			}
			$i++;
		}
		$this->set('dms_messages', $dms_messages);
		$this->set('results', $this->DmsMessage->find('count', array('conditions' => array('DmsMessage.user_id' => $user_id,$conditions))));
	}
	
	function list_data3($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 20;		
		
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';
		
        eval("\$conditions = array( " . $conditions . " );");
		
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];
		
		if ($id != -1 && $id != null) {		
			if(!empty($this->params['form'])){		
				$id = $this->params['form']['id'];
			} 
			
			$this->DmsMessage->DmsRecipient->updateAll(
				array('DmsRecipient.read' => "true"),
				array('DmsRecipient.user_id' => $user_id,'DmsRecipient.dms_message_id'=>$id)
			);
        }
		$conditions['DmsMessage.id'] = $id;
		$this->DmsMessage->recursive = 2;		
		$dms_messages=$this->DmsMessage->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start,'order'=>'DmsMessage.created DESC'));
		$this->set('dms_messages', $dms_messages);
		$this->set('results', count($dms_messages));
	}
	function view_detail($id = null , $typ = null){
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];
		
		if ($id != -1 && $id != null) {			
			$this->DmsMessage->DmsRecipient->updateAll(
				array('DmsRecipient.read' => "true"),
				array('DmsRecipient.user_id' => $user_id,'DmsRecipient.dms_message_id'=>$id)
			);
        }
		$conditions['DmsMessage.id'] = $id;
		$this->DmsMessage->recursive = 2;	
		$mess=$this->DmsMessage->read(null, $id);
		
		if($typ=='inbox'){
		
		$this->loadModel('Employee');
		$this->Employee->recursive=2;
		$emp=$this->Employee->find('all',array('conditions'=>array('Employee.user_id'=>$mess['DmsMessage']['user_id'])));
		$mess['EmployeeDetail']=$emp[0]['EmployeeDetail'];
		$branch='';
		$position='';
		if(isset($mess['EmployeeDetail']))
		foreach($mess['EmployeeDetail'] as $empx){
		if($empx['end_date']=='0000-00-00'){
			$branch=$empx['Branch']['name'];
			$position=$empx['Position']['name'];
		}}
		echo '<div style=" background-color: lightgray;color: gray;font-family:fantasy;font-size: 12px;font-weight:bolder;height: 72px;padding: 6px;width: 590px;">From :<div style=" display: inline-flex;margin-left: 5px;">'.$mess['User']['Person']['first_name'].' '.$mess['User']['Person']['middle_name'].'<br>'.$branch.'<br>'.$position.'<br>'.$mess['DmsMessage']['created'].'</div>';
		echo '<div>&nbsp&nbsp&nbsp&nbsp&nbspTo :';
		if(count($mess['DmsRecipient'])>1)
			echo ' &nbspYou and <a href="/AbayERP/dms/dms_messages/view_senders/'.$id.'/inbox" style="color:black">'.(count($mess['DmsRecipient'])-1) .' Users </a>';
		else
			echo ' &nbspYou';
		echo '&nbsp&nbsp&nbsp&nbsp<a style="color:highlight;cursor: pointer;text-decoration: underline;" onclick="parent.myApp.dlms('.$id.')">Reply</a> | <a style="color:saddlebrown;cursor: pointer;text-decoration: underline;" onclick="parent.myApp.dlmf('.$id.')">Forward</a></div></div>';
		}//if inbox
		
		if($typ=='sent'){
		
		echo '<div style=" background-color: lightgray;color: gray;font-family:fantasy;font-size: 12px;font-weight:bolder;padding: 6px;width: 590px;">';
		echo 'To : ';
		if(count($mess['DmsRecipient'])>1)
			echo '<a href="/AbayERP/dms/dms_messages/view_senders/'.$id.'/sent" style="color:black">'.count($mess['DmsRecipient']) .' Users </a>';
		else{
		$this->loadModel('Employee');
		$this->Employee->recursive=2;
		$this->Employee->unbindModel(array('belongsTo' => array('EmpLoc','ContactLocation','User'),'hasMany' => array('Education','Experience','Language','Offspring','Termination','Loan')));
		$emp=$this->Employee->find('all',array('conditions'=>array('Employee.user_id'=>$mess['DmsRecipient'][0]['user_id'])));
		$mess['EmployeeDetail']=$emp[0]['EmployeeDetail'];
		$branch='';
		$position='';
		if(isset($mess['EmployeeDetail']))
		foreach($mess['EmployeeDetail'] as $empx){
		if($empx['end_date']=='0000-00-00'){
			$branch=$empx['Branch']['name'];
			$position=$empx['Position']['name'];
		}}
				$this->loadModel('User');
				$this->User->recursive = 1;
				$this->User->unbindModel(array('belongsTo' => array('Branch','Payroll'),'hasAndBelongsToMany' => array('Group')));
			    $usr=$this->User->read(null, $mess['DmsRecipient'][0]['user_id']);
		echo '<div style=" display: inline-flex;margin-left: 5px;">'. $usr['Person']['first_name'].' '.$usr['Person']['middle_name'].'<br>'.$branch.'<br>'.$position.'<br>'.$mess['DmsMessage']['created'].'</div>';
				
			}
		echo '<div style="margin-left: 24px;"><a  style="color:saddlebrown;cursor: pointer;text-decoration: underline;" onclick="parent.myApp.dlmf('.$id.')">Forward</a></div></div>';
		}
		echo '<div style=" text-transform: capitalize;font-family: Georgia;  font-size: 22px; margin: 16px;">'.$mess['DmsMessage']['name'].'</div>';
		echo '<hr style="color: gainsboro;width: 500px;">';		
		echo '<div style=" font-family: Georgia;font-size: 13px;padding: 26px;font-family:Verdana;color:gray">'.$mess['DmsMessage']['message'].'</div>';
		if(count($mess['DmsAttachment'])>0){
		echo '<hr style="color: gainsboro;width: 500px;margin: 0 0 0 24px;">';	
		echo '<div style="background-color: whitesmoke;color: highlight;font-family: caption;margin-left: 24px;padding: 5px; width: 489px;">Attachments</div>';
		echo '<hr style="width: 500px;margin: 0 0 0 24px;">';	
		echo '<ul style="margin-left: 37px; padding: 8px;list-style-type: circle;">';
		foreach($mess['DmsAttachment'] as $attachment){
		echo "<li style=\"margin-bottom: -17px;\"><a style=\"text-decoration: none;font-size: 12px;color:brown\" href=\"/AbayERP/dms/dms_attachments/download/".$attachment['id']."\">".$attachment['name']."</a></li>&nbsp&nbsp&nbsp";
		}
		echo '</ul>';
		}
	}
	function view_senders($id = null, $typ = null){
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];
		
		if ($id != -1 && $id != null) {			
			$this->DmsMessage->DmsRecipient->updateAll(
				array('DmsRecipient.read' => "true"),
				array('DmsRecipient.user_id' => $user_id,'DmsRecipient.dms_message_id'=>$id)
			);
        }
		$conditions['DmsMessage.id'] = $id;
		$this->DmsMessage->recursive = 2;	
		$mess=$this->DmsMessage->read(null, $id);
		$this->loadModel('Employee');
		$this->Employee->recursive=2;
		$emp=$this->Employee->find('all',array('conditions'=>array('Employee.user_id'=>$mess['DmsMessage']['user_id'])));
		$mess['EmployeeDetail']=$emp[0]['EmployeeDetail'];
		$branch='';
		$position='';
		if(isset($mess['EmployeeDetail']))
		foreach($mess['EmployeeDetail'] as $empx){
		if($empx['end_date']=='0000-00-00'){
			$branch=$empx['Branch']['name'];
			$position=$empx['Position']['name'];
		}}
		if($typ=='inbox'){
		echo '<div style=" background-color: lightgray;color: gray;font-family:fantasy;font-size: 12px;font-weight:bolder;height: 72px;padding: 6px;width: 590px;">From :<div style=" display: inline-flex;margin-left: 5px;">'.$mess['User']['Person']['first_name'].' '.$mess['User']['Person']['middle_name'].'<br>'.$branch.'<br>'.$position.'<br>'.$mess['DmsMessage']['created'].'</div>';
		echo '<div>&nbsp&nbsp&nbsp&nbsp&nbspTo :';
		if(count($mess['DmsRecipient'])>1)
			echo ' &nbspYou and '.(count($mess['DmsRecipient'])-1) .' Users  </div>';
		else
			echo ' &nbspYou.</div>';
		echo '</div>';
		}
		echo '<div style=" text-transform: capitalize;font-family: Georgia;  font-size: 22px; margin: 16px;">Message Sent To</div>';
		$this->loadModel('User');
		echo '<div style="font-family: cursive;font-size: 12px;margin-left: 17px;">';
		foreach($mess['DmsRecipient'] as $recp){
			$this->User->recursive = 1;
			$this->User->unbindModel(array('belongsTo' => array('Branch','Payroll'),'hasAndBelongsToMany' => array('Group')));
			$usr=$this->User->read(null, $recp['user_id']);
			//echo $usr['Person']['first_name'].' '.$usr['Person']['middle_name'];
			//&& $typ=='sent'
			if($recp['read']==1 ){
				//echo '&nbsp&nbsp<b style="color:red">Seen</b>';
				echo  '<font color=green>' . $usr['Person']['first_name'].' '.$usr['Person']['middle_name'] . '</font>';
			}  else {
				echo   '<font color=lightgray>' . $usr['Person']['first_name'].' '.$usr['Person']['middle_name']. '</font>'; ;
			}
			/*
			$emp=$this->Employee->find('all',array('conditions'=>array('Employee.user_id'=>$recp['user_id'])));
			$mess['EmployeeDetail']=$emp[0]['EmployeeDetail'];
			$branch='';
			$position='';
				if(isset($mess['EmployeeDetail']))
				foreach($mess['EmployeeDetail'] as $empx){
				if($empx['end_date']=='0000-00-00'){
					$branch=$empx['Branch']['name'];
				}}
				echo " - ".$branch;
				*/
			echo '<br>';
		}
		echo '</div>';
	}
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid dms message', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->DmsMessage->recursive = 2;
		$this->set('dmsMessage', $this->DmsMessage->read(null, $id));
	}

	function auth_send($sender_id=null,$receivers=null,$subject=null,$message=null,$sms=null){
	
		$this->autoRender = false;
		$this->data['DmsMessage']['user_id'] = $sender_id;
		$this->data['DmsMessage']['message'] = $message;
		$this->data['DmsMessage']['name'] = $subject;
		$this->DmsMessage->create();
		if ($this->DmsMessage->save($this->data)) {
			$message_id=$this->DmsMessage->getLastInsertId();
			if($receivers!=null){
				$receivers=explode('-',$receivers);
				$this->loadModel('DmsRecipient');
				$this->loadModel('Employee');
				$this->Employee->recursive=1;
			foreach($receivers as $receiver){
					$this->data['DmsRecipient']['user_id']=$receiver;
					$this->data['DmsRecipient']['dms_message_id']=$message_id;
					$this->DmsRecipient->create();
					$this->DmsRecipient->save($this->data);
					
				if($sms==1){
					$employee=$this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$receiver)));
					if(isset($employee['Employee']) && !empty($employee['Employee'])){
						if($employee['Employee']['status']=='active'){
						$tel=$employee['Employee']['telephone'];
						$message=urlencode($message);
						file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$tel.'&msg='.$message);
						//echo "OK!";
						}
					}
				}
			}
			}
			
		}
		
	}
	
	function add($id = null){
	
		if (!empty($this->data)) {
		
		  // Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['DmsMessage']['message']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&#8217;',$content);
			$title=ereg_replace("'",'',$this->data['DmsMessage']['name']);
			$title=ereg_replace("&",'and',$this->data['DmsMessage']['name']);
			$contentsub = ereg_replace("'",'&#8217;',$this->data['DmsMessage']['name']);
			$user = $this->Session->read();			
			$this->data['DmsMessage']['user_id'] = $user['Auth']['User']['id'];
			$this->data['DmsMessage']['message'] = $content;
			$this->data['DmsMessage']['name'] = $contentsub;
			//$this->data['DmsMessage']['name'] = $this->data['DmsMessage']['subject'];
			
			$this->loadModel('User');
			$this->User->recursive=1;
			$employee_sen=$this->User->find('first',array('conditions'=>array('User.id'=>$user['Auth']['User']['id'])));
			$sender_name=$employee_sen['Person']['first_name'].' '.$employee_sen['Person']['middle_name'];
			$this->loadModel('Employee');
			$this->Employee->recursive=-1;
			//print_r($employee_sen);
			//echo $sender_name; exit();
			$this->DmsMessage->create();
			$this->autoRender = false;
				if(isset($this->data['DmsMessage']['all']))
					$this->data['DmsMessage']['broadcast']=1;
			if ($this->DmsMessage->save($this->data)) {
			
			$message_id=$this->DmsMessage->getLastInsertId();
			
					$user = $this->Session->read();
					$this->DmsMessage->DmsAttachment->updateAll(
							array('DmsAttachment.dms_message_id' => $message_id ),
							array('DmsAttachment.dms_message_id'=>$user['Auth']['User']['id'].'000000')
						);
			$this->loadModel('DmsRecipient');
			
			$sent=false;
			if(isset($this->data['DmsMessage']['all'])){
			$this->DmsMessage->User->recursive=0;
			$condi['User.is_active']=1;
			$users=$this->DmsMessage->User->find('all',array('conditions' =>$condi));
			//$users=$this->DmsMessage->User->find('all');
			foreach($users as $usr){
					$this->data['DmsRecipient']['user_id']=$usr['User']['id'];
					$this->data['DmsRecipient']['dms_message_id']=$message_id;
					$this->DmsRecipient->create();
					$this->DmsRecipient->save($this->data);
			}
			$sent=true;	
			}else{
			$receivers=array();
				$this->loadModel('DmsGroupList');
			foreach($this->data['DmsMessage']['groups'] as $grp){
				if (is_numeric($grp)){
					$conditions['DmsGroupList.dms_group_id'] = $grp;
					$positions=array();
					$branches=array();
					$grplists=$this->DmsGroupList->find('all', array('conditions' => $conditions));
					foreach($grplists as $grplist){
						if($grplist['DmsGroupList']['type']=='employee'){
							if(!in_array($grplist['DmsGroupList']['user_id'],$receivers))
								$receivers[]=$grplist['DmsGroupList']['user_id'];
						}
						if($grplist['DmsGroupList']['type']=='position'){
							$positions[]=$grplist['DmsGroupList']['position_id'];
						}
						if($grplist['DmsGroupList']['type']=='branch'){
							$branches[]=$grplist['DmsGroupList']['branch_id'];
						}
					}
							$posiq='';	$braq='';
							foreach($positions as $k=>$pos){
							$posiq.='`vx`.`position_id`='.$pos;
							if(++$k<count($positions))  $posiq.=' OR ';
							}
							foreach($branches as $k=>$bra){
							$braq.='`vx`.`branch_id`='.$bra;
							if(++$k<count($branches)) $braq.=' OR ';
							}
							if(count($positions)>0 || count($branches)>0){
							$query = "SELECT `v`.`user_id`,`vx`.`position_id`,`vx`.`branch_id` FROM `viewemployee` as `v`,`employee_details` AS `vx` WHERE `v`.`Record id`=`vx`.`employee_id` AND `v`.`Status`='active' AND `vx`.`end_date`='0000-00-00'";
							if($posiq!='') $query.=' AND ('. $posiq . ' ) ';
							if($braq!='') $query.=' AND ('. $braq . ' ) ';		
							$mix=$this->DmsGroupList->query($query);
								foreach($mix as $mx){
									if(!in_array($mx['v']['user_id'],$receivers))
									$receivers[]=$mx['v']['user_id'];
								}
							}
				}
			}
			foreach($this->data['DmsMessage']['employees'] as $emp){
				if (is_numeric($emp)){
					if(!in_array($emp,$receivers))
						$receivers[]=$emp;
				}
			}
			//print_r($receivers);
			if(!empty($receivers)){
			foreach($receivers as $receiver){
					$this->data['DmsRecipient']['user_id']=$receiver;
					$this->data['DmsRecipient']['dms_message_id']=$message_id;
					$this->DmsRecipient->create();
					$this->DmsRecipient->save($this->data);
					
						$employee=$this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$receiver)));
						if(isset($employee['Employee']) && !empty($employee['Employee'])){
						if($employee['Employee']['status']=='active'){
						$tel=$employee['Employee']['telephone'];
						
						$message="You have received message from ".$sender_name.", regarding ".$title." - AbayERP";

						$message=urlencode($message);
						file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$tel.'&msg='.$message);
						}
						}
			}
				$sent=true;
			}
			}
					if($sent==true){
						$this->Session->setFlash(__($message_id, true), '');
						$this->render('/elements/success');
					}else{
						$this->DmsMessage->delete($message_id);
						$this->Session->setFlash(__('The message could not be sent. No Receivers Found!', true), '');
						$this->render('/elements/failure');
					}
				}
			else {
				$this->Session->setFlash(__('The message could not be sent. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		if($id)
			$this->set('parent_id', $id);
		//$users = $this->DmsMessage->User->find('list');
		//$this->set(compact('users'));
	}
	else{
$user = $this->Session->read();
$this->DmsMessage->DmsAttachment->deleteAll(array( "DmsAttachment.dms_message_id" => $user['Auth']['User']['id'].'000000'    ));
}
	}
	function add_wz_param($receivers=null,$subject=null,$message=null){
			$this->set('receivers',$receivers);
			$this->set('subject',$subject);
			$this->set('message',$message);
			$user = $this->Session->read();
			$this->DmsMessage->DmsAttachment->deleteAll(array( "DmsAttachment.dms_message_id" => $user['Auth']['User']['id'].'000000'    ));
	}
function add2($id = null,$typ=null){
	
		if (!empty($this->data)) {
		
		  // Strip out carriage returns
            $content = ereg_replace("\r",'',$this->data['DmsMessage']['message']);
            // Handle paragraphs
            $content = ereg_replace("\n\n",'<br /><br />',$content);
            // Handle line breaks
            $content = ereg_replace("\n",'<br />',$content);
            // Handle apostrophes
            $content = ereg_replace("'",'&#8217;',$content);
			$contentsub = ereg_replace("'",'&#8217;',$this->data['DmsMessage']['name']);
			$user = $this->Session->read();			
			$this->data['DmsMessage']['user_id'] = $user['Auth']['User']['id'];
			$this->data['DmsMessage']['message'] = $content;
			$this->data['DmsMessage']['name'] = $contentsub;
			//$this->data['DmsMessage']['name'] = $this->data['DmsMessage']['subject'];
			$this->DmsMessage->create();
			$this->autoRender = false;
			if ($this->DmsMessage->save($this->data)) {
			
			$message_id=$this->DmsMessage->getLastInsertId();
			
					$user = $this->Session->read();
					$this->DmsMessage->DmsAttachment->updateAll(
							array('DmsAttachment.dms_message_id' => $message_id ),
							array('DmsAttachment.dms_message_id'=>$user['Auth']['User']['id'].'000000')
						);
			$this->loadModel('DmsRecipient');
			$this->loadModel('Employee');
			$this->Employee->recursive=3;
			$sent=false;
			if(isset($this->data['DmsMessage']['all'])){
			$this->DmsMessage->User->recursive=0;
			$users=$this->DmsMessage->User->find('all');
			foreach($users as $usr){
					$this->data['DmsRecipient']['user_id']=$usr['User']['id'];
					$this->data['DmsRecipient']['dms_message_id']=$message_id;
					$this->DmsRecipient->create();
					$this->DmsRecipient->save($this->data);
			}
			$sent=true;	
			}else{
			$receivers=array();
				$this->loadModel('DmsGroupList');
			foreach($this->data['DmsMessage']['groups'] as $grp){
				if (is_numeric($grp)){
					$conditions['DmsGroupList.dms_group_id'] = $grp;
					$grplists=$this->DmsGroupList->find('all', array('conditions' => $conditions));
					foreach($grplists as $grplist){
						if(!in_array($grplist['DmsGroupList']['user_id'],$receivers))
							$receivers[]=$grplist['DmsGroupList']['user_id'];
					}
				}
			}
			foreach($this->data['DmsMessage']['employees'] as $emp){
				if (is_numeric($emp)){
					if(!in_array($emp,$receivers))
						$receivers[]=$emp;
				}
			}
			//print_r($receivers);
			if(!empty($receivers)){
			foreach($receivers as $receiver){
					$this->data['DmsRecipient']['user_id']=$receiver;
					$this->data['DmsRecipient']['dms_message_id']=$message_id;
					$this->DmsRecipient->create();
					$this->DmsRecipient->save($this->data);
					
						$employee=$this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$receiver)));
						if(isset($employee['Employee']) && !empty($employee['Employee'])){
						$tel=$employee['Employee']['telephone'];
						$employee_sen=$this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['Auth']['User']['id'])));
						$sender_name=$employee_sen['User']['Person']['first_name'].' '.$employee_sen['User']['Person']['middle_name'];
						$message="You have received message from ".$sender_name." on AbayERP";
						$message=urlencode($message);
						file_get_contents('http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$tel.'&msg='.$message);
						}
			}
				$sent=true;
			}
			}
					if($sent==true){
						$this->Session->setFlash(__($message_id, true), '');
						$this->render('/elements/success');
					}else{
						$this->DmsMessage->delete($message_id);
						$this->Session->setFlash(__('The message could not be sent. No Receivers Found!', true), '');
						$this->render('/elements/failure');
					}
				}
			else {
				$this->Session->setFlash(__('The message could not be sent. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		if($id)
			$this->set('parent_id', $id);
		$users = $this->DmsMessage->User->find('list');
		$this->set(compact('users'));
	}else{
	$user = $this->Session->read();
$this->DmsMessage->DmsAttachment->deleteAll(array( "DmsAttachment.dms_message_id" => $user['Auth']['User']['id'].'000000'    ));
	$this->DmsMessage->recursive=2;
	$dms_message=$this->DmsMessage->read(null, $id);
	foreach($dms_message['DmsAttachment'] as $attachment){
		$this->data['DmsAttachment']['name']=$attachment['name'];
		$this->data['DmsAttachment']['file']=$attachment['file'];
		$this->data['DmsAttachment']['dms_message_id']=$user['Auth']['User']['id'].'000000';
		$this->DmsMessage->DmsAttachment->create();
		$this->DmsMessage->DmsAttachment->save($this->data);
	}
	$this->set('typ',$typ );
	$this->set('dms_message',$dms_message );
	}
	}
	
	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid dms message', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->DmsMessage->save($this->data)) {
				$this->Session->setFlash(__('The dms message has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The dms message could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('dms__message', $this->DmsMessage->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$users = $this->DmsMessage->User->find('list');
		$this->set(compact('users'));
	}
	function removeinbox($id = null){
		$ids=explode('-',$id);
		$user = $this->Session->read();
		foreach($ids as $idd){
					$this->DmsMessage->DmsRecipient->updateAll(
							array('DmsRecipient.active'=>'0'),
							array('DmsRecipient.dms_message_id' => $idd,'DmsRecipient.user_id'=>$user['Auth']['User']['id'])
						);
		}
		echo 'Messages removed';
	 //$this->Session->setFlash(__('Messages removed', true), '');
	//$this->render('/elements/success');
	}
	
	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for dms message', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->DmsMessage->delete($i);
                }
				$this->Session->setFlash(__('Dms message deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Dms message was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->DmsMessage->delete($id)) {
				$this->Session->setFlash(__('Dms message deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Dms message was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	function getRead(){
		$messageid = $this->params['messageid'];
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];
		$this->loadModel('DmsRecipient');
		$conditions = array('DmsRecipient.dms_message_id' => $messageid, 'DmsRecipient.user_id' => $user_id);
		$this->DmsRecipient->recursive = -1;
		$recipient = $this->DmsRecipient->find('first',array('conditions' => $conditions));	
		return $recipient;
	}
}
?>