<?php
class TakentrainingsController extends AppController {

	var $name = 'Takentrainings';
	
	function index() {
		$trainings = $this->Takentraining->Training->find('all');
		$this->set(compact('trainings'));
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	function report($id = null){
		if (!empty($this->data)) {
			$this->autoRender = false;
			if($this->data['Takentraining']['training_id']=='All')
				$this->data['Takentraining']['training_id']='%%';
			if($this->data['Takentraining']['position_id']=='All')
				$this->data['Takentraining']['position_id']='%%';
			if($this->data['Takentraining']['branch_id']=='All')
				$this->data['Takentraining']['branch_id']='%%';
	
			$conditions=" AND `p`.`Position` LIKE '".$this->data['Takentraining']['position_id']."' ";
			$conditions.=" AND `p`.`Branch` LIKE '".$this->data['Takentraining']['branch_id']."' ";
			/*if($this->data['Takentraining']['from']!='')
				$this->data['Takentraining']['from']=' `from` >= "'.$this->data['Takentraining']['from'].'" ';
			if($this->data['Takentraining']['to']!='')
				$this->data['Takentraining']['to']=' AND `to` <= "'.$this->data['Takentraining']['to'].'"';
			*/
//$data=  $this->Takentraining->query("SELECT  * FROM  `viewemployee` WHERE `status` LIke 'Active' AND `Record Id` NOT IN (SELECT `Record Id` FROM `viewtraining` WHERE  ".$this->data['Takentraining']['from']." ".$this->data['Takentraining']['to']." AND `Training` Like '".$this->data['Takentraining']['training_id']."' ) ");

//$basictable ="SELECT `e`.`Record Id`,`e`.`First Name`,`e`.`Middle Name`,`e`.`Last Name`,`p`.`Position`,`p`.`Branch` FROM `viewemployee` AS `e`,`viewemployement` AS `p` WHERE `e`.`Status`='Active' AND `e`.`Record Id`=`p`.`Record Id` AND `p`.`End Date`='9999-99-99' GROUP BY `e`.`Record Id` ";
$basictable = "SELECT `e`.`Record Id`,`e`.`First Name`,`e`.`Middle Name`,`e`.`Last Name`,`e`.`Sex`,`e`.`Birth Date`,`e`.`Date of employment`,`p`.`Start Date`,`p`.`Position`,`p`.`Branch` FROM `viewemployee` AS `e` INNER JOIN `viewemployement` AS `p` ON `e`.`Record Id`=`p`.`Record Id` WHERE `e`.`Status`='Active' AND `p`.`End Date`='9999-99-99' $conditions GROUP BY `e`.`Record Id` ";

$data=  $this->Takentraining->query("SELECT  * FROM ($basictable) AS `a` WHERE `a`.`Record Id` NOT IN (SELECT `Record Id` FROM `viewtraining` WHERE  `Training` Like '".$this->data['Takentraining']['training_id']."' ) "); 
  //print_r($data);   // $data=  $this->Takentraining->query("SELECT * FROM `viewtraining`  WHERE   ".$this->data['Takentraining']['from']." AND  `trainings` Like '".$this->data['Takentraining']['training']."' ");

	  $output= '<table>';
	  $output.= '<tr style="background-color: lightblue;"><td>No</td><td>Full Name</td><td>Gender</td><td>Date of Birth</td><td>Date of employment</td><td>Position</td><td>Start date for position</td><td>Branch</td></tr>';
	  $i=1;
	  foreach($data as $dt){
			if($i % 2 == 0 )
				$output.= '<tr>';
				else
				$output.= '<tr style="background-color:#eee">';
				$output.= '<td>'.$i.'</td>';
				$output.= '<td>'.$dt['a']['First Name'].' '.$dt['a']['Middle Name'].' '.$dt['a']['Last Name'].'</td>';
				$output.= '<td>'.$dt['a']['Sex'].'</td>';
				$output.= '<td>'.$dt['a']['Birth Date'].'</td>';
				$output.= '<td>'.$dt['a']['Date of employment'].'</td>';
				$output.= '<td>'.$dt['a']['Position'].'</td>';
				$output.= '<td>'.$dt['a']['Start Date'].'</td>';
				$output.= '<td>'.$dt['a']['Branch'].'</td>';
				$output.= '</tr>';
				$i++;
		
		}
			if($id=='excel'){
				$file = "report.xls";
                header("Content-type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=report");
                echo $output;
			}else
			 echo $output;
			
		}
		if($id)
		$this->set('parent_id', $id);
		$trainings = $this->Takentraining->Training->find('list',array('order'=> 'name'));
		$positions = $this->Takentraining->Stafftooktraining->Position->find('list',array('order'=> 'name'));
		$branches = $this->Takentraining->Stafftooktraining->Branch->find('list',array('order'=> 'name'));
		foreach($trainings as $key => $value){
			$trainings[$value] = $value;
			unset($trainings[$key]);
		}
		foreach($positions as $key => $value){
			$positions[$value] = $value;
			unset($positions[$key]);
		}
		foreach($branches as $key => $value){
			$branches[$value] = $value;
			unset($branches[$key]);
		}
		$this->set(compact('trainings'));
		$this->set(compact('branches'));
		$this->set(compact('positions'));
	}
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$training_id = (isset($_REQUEST['training_id'])) ? $_REQUEST['training_id'] : -1;
		if($id)
			$training_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($training_id != -1) {
            $conditions['Takentraining.training_id'] = $training_id;
        }
		 $this->Takentraining->recursive=1;
		$this->set('takentrainings', $this->Takentraining->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start,'order'=>'Takentraining.created DESC')));
		$this->set('results', $this->Takentraining->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid takentraining', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Takentraining->recursive = 2;
		$this->set('takentraining', $this->Takentraining->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Takentraining->create();
			$this->autoRender = false;
			if ($this->Takentraining->save($this->data)) {
				$this->Session->setFlash(__('The takentraining has been saved', true).'\',"id":\''.$this->Takentraining->id , '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The takentraining could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		if($id)
			$this->set('parent_id', $id);
		$trainings = $this->Takentraining->Training->find('list',array('order'=> 'name'));
		$trainingvenues = $this->Takentraining->Trainingvenue->find('list',array('order'=> 'name'));
		$this->Takentraining->Trainer->recursive = 0;
		$trainers = $this->Takentraining->Trainer->find('all',array('order'=> 'name'));
		$trainers_customized=Array();
		$i=0;
		foreach($trainers as $trainer){
			if($trainer['Trainer']['type']=='INTERNAL')
				$trainers_customized[$trainers[$i]['Trainer']['id']]=$trainers[$i]['Trainer']['name'].' Staff';
			else
				$trainers_customized[$trainers[$i]['Trainer']['id']]=$trainers[$i]['Trainer']['name'];
			$i++;
		}
		$trainers=$trainers_customized;
		$trainingtargets = $this->Takentraining->Trainingtarget->find('list',array('order'=> 'name'));
		$this->set(compact('trainings', 'trainingvenues', 'trainers', 'trainingtargets'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid takentraining', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Takentraining->save($this->data)) {
				$this->Session->setFlash(__('The takentraining has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The takentraining could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('takentraining', $this->Takentraining->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$trainings = $this->Takentraining->Training->find('list',array('order'=> 'name'));
		$trainingvenues = $this->Takentraining->Trainingvenue->find('list',array('order'=> 'name'));
		$trainers = $this->Takentraining->Trainer->find('all',array('order'=> 'name'));
		$trainers_customized=Array();
		$i=0;
		foreach($trainers as $trainer){
			if($trainer['Trainer']['type']=='INTERNAL')
				$trainers_customized[$trainers[$i]['Trainer']['id']]=$trainers[$i]['Trainer']['name'].' Staff';
			else
				$trainers_customized[$trainers[$i]['Trainer']['id']]=$trainers[$i]['Trainer']['name'];
			$i++;
		}
		$trainers=$trainers_customized;
		$trainingtargets = $this->Takentraining->Trainingtarget->find('list',array('order'=> 'name'));
		$this->set(compact('trainings', 'trainingvenues', 'trainers', 'trainingtargets'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for takentraining', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Takentraining->delete($i);
                }
				$this->Session->setFlash(__('Takentraining deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Takentraining was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Takentraining->delete($id)) {
				$this->Session->setFlash(__('Takentraining deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Takentraining was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>