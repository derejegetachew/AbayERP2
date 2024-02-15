<?php
class ClaimoffjobtrainingsController extends AppController {

	var $name = 'Claimoffjobtrainings';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('claimoffjobtrainings', $this->Claimoffjobtraining->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->Claimoffjobtraining->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid claimoffjobtraining', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Claimoffjobtraining->recursive = 2;
		$this->set('claimoffjobtraining', $this->Claimoffjobtraining->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->Claimoffjobtraining->create();
			$this->autoRender = false;
			if ($this->Claimoffjobtraining->save($this->data)) {
				$this->Session->setFlash(__('The claimoffjobtraining has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The claimoffjobtraining could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid claimoffjobtraining', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->Claimoffjobtraining->save($this->data)) {
				$this->Session->setFlash(__('The claimoffjobtraining has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The claimoffjobtraining could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('claimoffjobtraining', $this->Claimoffjobtraining->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for claimoffjobtraining', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->Claimoffjobtraining->delete($i);
                }
				$this->Session->setFlash(__('Claimoffjobtraining deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Claimoffjobtraining was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->Claimoffjobtraining->delete($id)) {
				$this->Session->setFlash(__('Claimoffjobtraining deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Claimoffjobtraining was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
	
	/*-------------------------this is added by Temesgen to generate Report starting--------------------------*/
	function generate_report() {
		if(!empty($this->data)){
			$this->autoRender = false;
		  $this->loadModel('Claimoffjobtraining');
			$conditions['Claimoffjobtraining.starting_date >='] = date('Y-m-d', strtotime($this->data['claimoffjobtrainingApplication']['fromDt']));
            $conditions['Claimoffjobtraining.starting_date <='] = date('Y-m-d', strtotime($this->data['claimoffjobtrainingApplication']['toDt']));
			
			$this->Claimoffjobtraining->recursive = -1;
            $applist = $this->Claimoffjobtraining->find('all', array('conditions' => $conditions));
			
			$out='<table cellspacing=0 border=1 style="display:block;margin-left:20px;width:100%;"><tr><td >No</td><td >Name</td>';
			$out.='<td >Branch</td><td >Training Title</td><td >Position</td><td >Venue</td><td >Date Responded</td><td >Starting Date</td>';
			$out.='<td >Ending Date</td><td >Perdiem</td><td >Transport</td>';
			$out.='<td >Accomadation</td><td >Refreshment</td><td >Total</td></tr>';
			$i=1;
			$j=1;
			
			foreach ($applist as $app) {
				$out.='<tr>';
					$out.='<td style="text-align: right;margin:0px;padding:2px;">'.$i.'</td>';
					$out.='<td style="text-align: right;margin:0px;padding:2px;">'.$app['Claimoffjobtraining']['name'].'</td>';
					$out.='<td style="padding:2px;">'.$app['Claimoffjobtraining']['branch'].'</td>';
					$out.='<td style="padding:2px;">'.$app['Claimoffjobtraining']['training_title'].'</td>';
					$out.='<td style="padding:2px;">' .$app['Claimoffjobtraining']['position'].'</p></td>';
					$out.='<td style="padding:2px;">'.$app['Claimoffjobtraining']['venue'].'</td>';
					$out.='<td style="padding:2px;">'.$app['Claimoffjobtraining']['date_responded'].'</td>';
					$out.='<td style="padding:2px;">' .$app['Claimoffjobtraining']['starting_date'].'</td>';
					$out.='<td style="padding:2px;">'.$app['Claimoffjobtraining']['ending_date'].'</td>';
					$out.='<td style="padding:2px">' .$app['Claimoffjobtraining']['perdiem'].'</td>';
					$out.='<td style="padding:2px">' .$app['Claimoffjobtraining']['transport'].'</td>';
					$out.='<td style="padding:2px">' .$app['Claimoffjobtraining']['accomadation'].'</td>';
					$out.='<td style="padding:2px">' .$app['Claimoffjobtraining']['refreshment'].'</td>';
					$out.='<td  style="padding:2px">' .$app['Claimoffjobtraining']['total'].'</td>';
					$out.='</tr>';
					$i++;$j++;
			}
			$out.='</table>';
			header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=report.xls");
            echo $out;
		}
	}
	/*-------------------------this is added by Temesgen to generate Report ending----------------------------*/
}
?>