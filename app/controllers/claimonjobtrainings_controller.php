<?php
class ClaimonjobtrainingsController extends AppController {

	var $name = 'Claimonjobtrainings';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('claimonjobtrainings', $this->Claimonjobtraining->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Claimonjobtraining->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid claimonjobtraining', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Claimonjobtraining->recursive = 2;
		$this->set('claimonjobtraining', $this->Claimonjobtraining->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Claimonjobtraining->create();
			$this->autoRender = false;
			if ($this->Claimonjobtraining->save($this->data)) {
				$this->Session->setFlash(__('The claimonjobtraining has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The claimonjobtraining could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid claimonjobtraining', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Claimonjobtraining->save($this->data)) {
				$this->Session->setFlash(__('The claimonjobtraining has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The claimonjobtraining could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('claimonjobtraining', $this->Claimonjobtraining->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for claimonjobtraining', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Claimonjobtraining->delete($i);
                }
				$this->Session->setFlash(__('Claimonjobtraining deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Claimonjobtraining was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Claimonjobtraining->delete($id)) {
				$this->Session->setFlash(__('Claimonjobtraining deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Claimonjobtraining was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
			/*-------------------------this is added by Temesgen to generate Report starting--------------------------*/
	function generate_report() {
		if(!empty($this->data)){
			$this->autoRender = false;
		  $this->loadModel('Claimonjobtraining');
			$conditions['Claimonjobtraining.placement_date >='] = date('Y-m-d', strtotime($this->data['claimonjobtrainingApplication']['fromDt']));
            $conditions['Claimonjobtraining.placement_date <='] = date('Y-m-d', strtotime($this->data['claimonjobtrainingApplication']['toDt']));
			
			$this->Claimonjobtraining->recursive = -1;
            $applist = $this->Claimonjobtraining->find('all', array('conditions' => $conditions));
			
			$out='<table cellspacing=0 border=1 style="display:block;margin-left:20px;width:100%;"><tr><td >No</td><td >Name</td>';
			$out.='<td >Branch</td><td >Position</td><td >Date of Employment</td><td >Placement Date</td><td >Date Responded</td><td >No of Days</td>';
			$out.='<td >Payment Month</td><td >Placement Branch</td><td >Basic Salary</td>';
			$out.='<td >Transport</td><td >Hardship</td><td >Pension</td><td >Total</td></tr>';
			$i=1;
			$j=1;
			
			foreach ($applist as $app) {
				$out.='<tr>';
					$out.='<td style="text-align: right;margin:0px;padding:2px;">'.$i.'</td>';
					$out.='<td style="text-align: right;margin:0px;padding:2px;">'.$app['Claimonjobtraining']['name'].'</td>';
					$out.='<td style="padding:2px;">'.$app['Claimonjobtraining']['branch'].'</td>';
					$out.='<td style="padding:2px;">'.$app['Claimonjobtraining']['position'].'</td>';
					$out.='<td style="padding:2px;">' .$app['Claimonjobtraining']['date_of_employment'].'</p></td>';
					$out.='<td style="padding:2px;">'.$app['Claimonjobtraining']['placement_date'].'</td>';
					$out.='<td style="padding:2px;">'.$app['Claimonjobtraining']['date_responded'].'</td>';
					$out.='<td style="padding:2px;">' .$app['Claimonjobtraining']['no_of_days'].'</td>';
					$out.='<td style="padding:2px;">'.$app['Claimonjobtraining']['payment_month'].'</td>';
					$out.='<td style="padding:2px">' .$app['Claimonjobtraining']['placement_branch'].'</td>';
					$out.='<td style="padding:2px">' .$app['Claimonjobtraining']['basic_salary'].'</td>';
					$out.='<td style="padding:2px">' .$app['Claimonjobtraining']['transport'].'</td>';
					$out.='<td style="padding:2px">' .$app['Claimonjobtraining']['hardship'].'</td>';
					$out.='<td style="padding:2px">' .$app['Claimonjobtraining']['pension'].'</td>';
					$out.='<td  style="padding:2px">' .$app['Claimonjobtraining']['total'].'</td>';
					$out.='</tr>';
					$i++;$j++;
			}
			$out.='</table>';
			header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=report");
            echo $out;
		}
	}
	/*-------------------------this is added by Temesgen to generate Report ending----------------------------*/
}
?>