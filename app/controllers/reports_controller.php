<?php

class ReportsController extends AppController {

    var $name = 'Reports';

    function index($id = null) {
        // $conditions['ReportGroup.parent_id']=$id;
       $conditions['ReportGroup.id']=$this->childrens($id);
           array_push($conditions['ReportGroup.id'],$id);
        
        $report_groups = $this->Report->ReportGroup->generateTreeList($conditions,null,null,'--');
        
        
        $this->set(compact('report_groups'));
        //print_r($report_groups);
        $this->set('group_id', $id);
    }

	function index3($id = null) {
        // $conditions['ReportGroup.parent_id']=$id;
       $conditions['ReportGroup.id']=$this->childrens($id);
           array_push($conditions['ReportGroup.id'],$id);
        
        $report_groups = $this->Report->ReportGroup->generateTreeList($conditions,null,null,'--');
        
        
        $this->set(compact('report_groups'));
        //print_r($report_groups);
        $this->set('group_id', $id);
    }
    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function search() {
        
    }
    function childrens($id){
        $this->loadModel('ReportGroup');
        $this->ReportGroup->recursive = 0;
        $lists=$this->ReportGroup->find('list',array('conditions'=>array('ReportGroup.parent_id'=>$id),'fields'=>array('ReportGroup.id')));
        foreach($lists as $key){
            $lists=array_merge($lists,$this->childrens($key));
        }
        return $lists;
    }
    function list_data($id = null) {
        //$id = null;
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $report_group_id = (isset($_REQUEST['report_group_id'])) ? $_REQUEST['report_group_id'] : -1;
       
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($id) {
        $conditions['Report.report_group_id']=$this->childrens($id);
           array_push($conditions['Report.report_group_id'],$id);
        }
        if ($report_group_id != -1) {
        $conditions['Report.report_group_id']=$this->childrens($report_group_id);
           array_push($conditions['Report.report_group_id'],$report_group_id);
        }

        $this->set('reports', $this->Report->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->Report->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid report', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Report->recursive = 1;
        $report = $this->Report->read(null, $id);
        $fieldsx = $report['ReportField'];


        $this->loadModel('Field');
        $this->Field->recursive = 0;
        $i = 0;
        $fields;
        foreach ($fieldsx as $fieldx) {
//$params = explode(',', $fieldx);
            $field = $this->Field->read(null, $fieldx['field_id']);

            $fields[$i]['type'] = $field['Field']['type'];
            $fields[$i]['fieldLabel'] = $fieldx['Renamed'];
            $fields[$i]['name'] = $fieldx['getas'];
            $fields[$i]['params'] = $field['Field']['params'];
            $fields[$i]['data'] = false;

            if ($field['Field']['type'] == 'combo') {

                if ($field['Field']['store'] == 'choices') {
                    $fields[$i]['data'] = true;
                    $lists = explode(',', $field['Field']['choices']);
                    $s = 0;
                    foreach ($lists as $list) {
                        $option = explode('=>', $list);
                        $fields[$i]['store'][$s]['id'] = $option[0];
                        $fields[$i]['store'][$s]['name'] = $option[1];
                        $s++;
                    }
                } elseif ($field['Field']['store'] == 'SQL') {
                    
                } elseif ($field['Field']['store'] == 'PHP') {
                    $fields[$i]['data'] = true;
                    eval($field['Field']['PHP']);
                    $s = 0;
                    foreach ($querys as $key => $query) {
                        $fields[$i]['store'][$s]['id'] = $key;
                        $fields[$i]['store'][$s]['name'] = $query;
                        $s++;
                    }
                }
            }
            $i++;
        }
        $this->set('fields', $fields);


        $rowsx = explode('|', $report['Report']['rows']);
        $i = 0;
        foreach ($rowsx as $rowx) {
            $rows[$i]['id'] = $i;
            $rows[$i]['name'] = $rowx;
            $rows[$i]['checked'] = true;
            $i++;
        }
        $this->set('report', $report);
        $this->set('rows', $rows);
        $this->set('id', $id);
    }

    function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);
    }

    function report($id = null,$param=null) {
		if(isset($id)){
			$this->data['Report']['id']=$id;
			$this->data['Report']['output']='PHP';
			$this->data['Report']['manual']='true';			
			$this->data['Report']['param']=$param;
		}
		$this->autoRender = false;
        $this->Report->recursive = 1;

        $report = $this->Report->read(null, $this->data['Report']['id']);

		
        $results;
        if ($report['Report']['type'] == 'PHP') {

            eval($report['Report']['PHP']);
        }
		
// print_r($results);
        if ($report['Report']['output'] == 'Table') {
			
            $rowsx = explode('|', $this->data['Report']['rows']);
            $i = 0;
            foreach ($rowsx as $rowx) {
                $rowe = explode(',', $rowx);
                if (!empty($rowe))
                    if ($rowe[3] == 'true') {
                        $rows[$i]['id'] = $rowe[0];
                        $rows[$i]['order'] = $rowe[1];
                        $rows[$i]['name'] = $rowe[2];
                        $i++;
                    }
            }
            $this->array_sort_by_column($rows, "order", SORT_ASC);
			
            $output = '<p align="center"><img src="http://10.1.85.11/AbayERP/app/webroot/img/logo.png" /></p>';
            $output = $output . $report['Report']['before_html'];
            $output = $output . '<h2 align="center">' . $report['Report']['name'] . '</h2><h3 align="center">' . $this->data['Report']['title'] . '</h3>';
				
			if(!empty($this->data['field']['from'])){
				$from = date_create($this->data['field']['from']);
				$to = date_create($this->data['field']['to']);
				$output = $output . '<h4 align="left"> ' . date_format($from,"M d, Y") . ' <----> '. date_format($to,"M d, Y") .'</h4>';
			}
			
            $output = $output . '<table align="center"  cellspacing=0 >';
            $output = $output . $report['Report']['column_group'];
            $output = $output . '<tr style="border:3px solid black">';
            foreach ($rows as $rowx) {
                $output = $output . '<th  style="border-top:1px solid gray;border-right:1px solid gray;padding:5px;min-height:20px;">' . $rowx['name'] . '</th>';
            }
            $output = $output . '</tr>';

            foreach ($results as $result) {	
                $output = $output . '<tr style="font-family:Arial, Helvetica, sans-serif;font-size:14px;">';
                if ($color == 'lightblue')
                    $color = 'white';
                else
                    $color = 'lightblue';
                foreach ($rows as $row) {
                    if (is_numeric(str_replace(',','',$result[$row['id']])))
                        $result[$row['id']] = '<p style="text-align: right;margin:0px"> ' . $result[$row['id']] . '</p>';
                    $output = $output . '<td style="background-color:' . $color . ';border-right:1px solid gray;padding:5px;min-height:20px;">' . $result[$row['id']] . '</td>';
                }
                $output = $output . '</tr>';
            }
            $output = $output . '</table>';
            $output = $output . '<p align="center">' . $report['Report']['after_html'] . '</p>';

            if ($this->data['Report']['output'] == 'HTML') {
				header('Content-Type: text/html; charset=utf-8');
                echo $output;
            }
            if ($this->data['Report']['output'] == 'Exel') {
                $file = $report['Report']['name'] . ".xls";
                header("Content-type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=$file");
                echo $output;
            }
            if ($this->data['Report']['output'] == 'PDF') {
                require_once(APPLIBS . DS . 'html2pdf' . DS . 'html2pdf.class.php');
                $h2p = new HTML2PDF('P', 'A4', 'en');
                $h2p->writeHTML($output);
                $file = $report['Report']['name'] . ".pdf";
                $h2p->Output($file);
                
            }
        }
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->Report->create();
            $this->autoRender = false;
            if ($this->Report->save($this->data)) {
                $this->Session->setFlash(__('The report has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The report could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
        $report_groups = $this->Report->ReportGroup->generatetreelist(null, null, null, '---');
        $this->set(compact('report_groups'));
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid report', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Report->save($this->data)) {
                $this->Session->setFlash(__('The report has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The report could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('report', $this->Report->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $report_groups = $this->Report->ReportGroup->generatetreelist(null, null, null, '---');
//$payrolls = $this->Report->Payroll->find('list');
        $this->set(compact('report_groups'));
    }

    function editphp($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid report', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Report->save($this->data)) {
                $this->Session->setFlash(__('The report has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The report could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('report', $this->Report->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $report_groups = $this->Report->ReportGroup->find('list');
//$payrolls = $this->Report->Payroll->find('list');
        $this->set(compact('report_groups', 'payrolls'));
    }

    function editsql($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid report', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Report->save($this->data)) {
                $this->Session->setFlash(__('The report has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The report could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('report', $this->Report->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $report_groups = $this->Report->ReportGroup->find('list');
//$payrolls = $this->Report->Payroll->find('list');
        $this->set(compact('report_groups', 'payrolls'));
    }

    function editcustom($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid report', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Report->save($this->data)) {
                $this->Session->setFlash(__('The report has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The report could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('report', $this->Report->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $report_groups = $this->Report->ReportGroup->find('list');
//$payrolls = $this->Report->Payroll->find('list');
        $this->set(compact('report_groups', 'payrolls'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for report', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Report->delete($i);
                }
                $this->Session->setFlash(__('Report deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Report was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Report->delete($id)) {
                $this->Session->setFlash(__('Report deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Report was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

/* Pagination for reporting as backup
 *  $ii = 0;
  $limit = count($results) - 1;
  if (isset($this->data['Report']['start']))
  $ii = $this->data['Report']['start'];
  if (isset($this->data['Report']['limit']))
  $limit = $this->data['Report']['limit'];
  for ($ii; $ii < $limit; $ii++) {
  $output = $output . '<tr style="font-family:Arial, Helvetica, sans-serif;font-size:14px;">';
  if ($color == 'lightblue')
  $color = 'white';
  else
  $color = 'lightblue';
  foreach ($rows as $row) {
  if (is_numeric($result[$row['id']]))
  $results[$ii][$row['id']] = '<p style="text-align: right;margin:0px"> ' . $results[$ii][$row['id']] . '</p>';
  $output = $output . '<td style="background-color:' . $color . ';border-right:1px solid gray;padding:5px;min-height:20px;">' . $results[$ii][$row['id']] . '</p></td>';
  }
  $output = $output . '</tr>';
  }
  $output = $output . '</table>';
  $output = $output . '<p align="center">' . $report['Report']['after_html'] . '</p>';
  echo $output;
  /*pagination
  echo '<p align="center"><form action="" method="POST">';
  foreach ($this->data['Report'] as $key => $fld) {
  echo '<input type="hidden" name="data[Report][' . $key . ']" value="' . $fld . '" />';
  }
  foreach ($this->data['field'] as $key => $fld) {
  echo '<input type="hidden" name="data[field][' . $key . ']" value="' . $fld . '" />';
  }
  echo 'Per Page: <input size="3" name="data[Report][limit]" value="' . $limit . '"><input type="submit" value="Go">';
  echo '</form>';
  echo '<form action="" method="POST">';
  foreach ($this->data['Report'] as $key => $fld) {
  echo '<input type="hidden" name="data[Report][' . $key . ']" value="' . $fld . '" />';
  }
  foreach ($this->data['field'] as $key => $fld) {
  echo '<input type="hidden" name="data[field][' . $key . ']" value="' . $fld . '" />';
  }
  echo '<select name="myselect" id="myselect" onchange="this.form.submit()">';
  $pagn=(count($results) - 1)/$limit;
  for($pg=1; $pg<$pagn; $pg++){
  echo '<option value="'.$pg.'">'.$pg.'</option>';
  }
  echo '</select></form></p>';
 * 
 */
?>