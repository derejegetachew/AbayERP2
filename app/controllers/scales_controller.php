<?php

class ScalesController extends AppController {

    var $name = 'Scales';

    function index() {
        $grades = $this->Scale->Grade->find('all');
        $this->set(compact('grades'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function index3($id = null) {
        $grades = $this->Scale->Grade->find('all');
        $this->set(compact('grades'));

        $steps = $this->Scale->Step->find('all');
        $this->set(compact('steps'));
    }

    function list_data3($id = null) {
        $grades = $this->Scale->Grade->find('all');
        $this->set(compact('grades'));
        $steps = $this->Scale->Step->find('all');
        $this->set(compact('steps'));

        foreach ($grades as $grade) {
            $tempstring = '';
            foreach ($steps as $step) {
                $conditions['Scale.grade_id'] = $grade['Grade']['id'];
                $conditions['Scale.step_id'] = $step['Step']['id'];
                $scale = $this->Scale->find('all', array('conditions' => $conditions));
                if (!empty($scale))
                    $tempstring = $tempstring . ',' . $scale[0]['Scale']['salary'];
            }
            $scales[$grade['Grade']['name']] = explode(',', $tempstring);
            ;
        }
        //print_r($scales);
        $this->set('scales', $scales);
    }

    function add3() {
        if(isset($_POST)){
            $grade='';
            $this->loadModel('Step');
            foreach($_POST as $key => $value){
                $tmpost=explode('_',$key);

                if($tmpost[1]=='grade-id'){
                    $grade=$value;
                    $grade=str_replace('"', '', $grade);
                    
                }
                elseif($tmpost[1]=='grade'){
                    
                }else{                   
                $conditionx['Step.name']=$tmpost[1];
                $this->Step->recursive = -1;
                $stp = $this->Step->find('all', array('conditions' => $conditionx));
                
                    $conditions['Scale.step_id']=$stp[0]['Step']['id'];
                    $conditions['Scale.grade_id']=$grade;
                    $dt['Scale'] = array("salary" => $value);
                   // $this->Scale->create();
                    $this->Scale->updateAll(array("salary" => $value), array('Scale.step_id' => $stp[0]['Step']['id'],'Scale.grade_id'=>$grade));
                    //echo 'Grade: '.$grade.' '.$stp[0]['Step']['id'].': '.$value.'<br>';
                }
                
            }
        }
        exit();
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $grade_id = (isset($_REQUEST['grade_id'])) ? $_REQUEST['grade_id'] : -1;
        if ($id)
            $grade_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($grade_id != -1) {
            $conditions['Scale.grade_id'] = $grade_id;
        }

        $this->set('scales', $this->Scale->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->Scale->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid scale', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Scale->recursive = 2;
        $this->set('scale', $this->Scale->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->Scale->create();
            $this->autoRender = false;
            if ($this->Scale->save($this->data)) {
                $this->Session->setFlash(__('The scale has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The scale could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $grades = $this->Scale->Grade->find('list');
        $steps = $this->Scale->Step->find('list');
        $this->set(compact('grades', 'steps'));
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid scale', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Scale->save($this->data)) {
                $this->Session->setFlash(__('The scale has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The scale could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('scale', $this->Scale->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $grades = $this->Scale->Grade->find('list');
        $steps = $this->Scale->Step->find('list');
        $this->set(compact('grades', 'steps'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for scale', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Scale->delete($i);
                }
                $this->Session->setFlash(__('Scale deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Scale was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Scale->delete($id)) {
                $this->Session->setFlash(__('Scale deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Scale was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

?>