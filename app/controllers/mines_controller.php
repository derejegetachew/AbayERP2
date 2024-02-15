<?php

class MinesController extends AppController {

    var $name = 'Mines';
    var $tables = array('viewemployee'=>'Employee Info','viewcontact'=>'Contact Info','viewemployement'=>'Employment Record', 'vieweducation'=>'Education/Training','viewleave'=>'Leave Balance','viewexperience'=>'External Experience','viewlanguage'=>'Languages','viewloan'=>'Loans','viewpayroll'=>'Payroll','viewtermination'=>'Termination','viewtraining'=>'Training Record');
    var $tablee = array('viewemployee','viewcontact','viewemployement', 'vieweducation','viewleave','viewexperience','viewlanguage','viewloan','viewpayroll','viewtermination','viewtraining');

    function index() {
        
    }

    function search() {
        
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");

        $this->set('mines', $this->Mine->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->Mine->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid mine', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Mine->recursive = 2;
        $this->set('mine', $this->Mine->read(null, $id));
    }

function generate(){

 $this->autoRender = false;
$all=explode('splithere',$_GET['param0']);
$param=$all[0];
$view=$all[1];
$tbls=explode('*',$all[2]);
$crits=explode('=_=',$param);
$wherecl='';
$showcl='';
foreach($tbls as $tbl){
if($tbl!=''){
$cols = $this->Mine->query('SHOW COLUMNS FROM `' . $this->tablee[$tbl].'`');
foreach($cols as $ckey=>$col){
$i=0;
$tempwhere='';
$j=0;
foreach($crits as $crit){
$temp=explode('*',$crit);
if($temp[0]==$tbl && $temp[1]==$ckey)
if($temp[0]!='' && $temp[1]!='' && $temp[2]!=''){
if($i==0){
$comma=' ( ';
if($wherecl!='')
$comma=' AND ';
$i=1;
}else $comma='';
if($j==0)
$commar='( ';
else $commar=' OR ';
$tempwhere=$tempwhere.$comma.$commar."`".$this->tablee[$temp[0]]."`.`".$col['COLUMNS']['Field']."` ".$temp[2];$j++;
}}
if($j>0)
$tempwhere=$tempwhere.' )';
$wherecl=$wherecl.$tempwhere;
}}
}
if($wherecl!='')
$wherecl=$wherecl.' )';

$i=0;
$views=explode('=_=',$view);
foreach($views as $fld){
$temp=explode('*',$fld);
if($temp[0]!='' && $temp[1]!=''){
$cols = $this->Mine->query('SHOW COLUMNS FROM ' . $this->tablee[$temp[0]]);
if($i==0)
$comma='';
else $comma=' , ';
$showcl=$showcl.$comma."`".$this->tablee[$temp[0]]."`.`".$cols[$temp[1]]['COLUMNS']['Field']."` ";
$i++;
}}
$joins='';
foreach($tbls as $tbl){
if($tbl!='' && $this->tablee[$tbl]!='viewemployee')
$joins=$joins.' JOIN `'.$this->tablee[$tbl].'` USING (`Record Id`)';
}
if($_GET['param1']=='Unique data')
$groupby=' GROUP BY `viewemployee`.`Record Id` ';
else $groupby='';
$query= 'SELECT '.$showcl.' FROM `viewemployee` '.$joins.' WHERE '.$wherecl.$groupby;
//echo $query;
$result=$this->Mine->query($query);
/*
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Data.csv"');
foreach($result as $res){
foreach($res as $re){
foreach($re as $key=>$r){
echo $key.',';
}}break;}
echo "\n";
foreach($result as $res){
foreach($res as $re){
foreach($re as $r){
echo $r.',';
}}
echo "\n";
}
*/

$out = fopen('php://output', 'w');
$ost="<table><tr>";
$arrhead=array();
foreach($result as $res){
foreach($res as $re){
foreach($re as $key=>$r){
$arrhead[]= $key;
$ost.="<td>".$key."</td>";
}}break;}
$ost.="</tr>";
//fputcsv($out, $arrhead);

foreach($result as $res){
$arrdata=array();
$ost.="<tr>";
foreach($res as $re){
foreach($re as $r){
$arrdata[]=$r;
$ost.="<td>".$r."</td>";
}
}
$ost.="</tr>";
//fputcsv($out, $arrdata);
}
$ost.="</table>";


//header("Content-Type: application/csv");
//header("Content-Disposition: attachment;Filename=data.csv");
//readfile($out);
//fclose($out);
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=report");
echo $ost;
}
    function add($id = null) {
        if (!empty($this->data)) {
            $this->Mine->create();
            $this->autoRender = false;
            if ($this->Mine->save($this->data)) {
                $this->Session->setFlash(__('The mine has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The mine could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        
        $i = 0;
        $jarray = '';
	$crits = '';
	$chfield='';
        $store = ' var data = [';
        foreach ($this->tables as $table=>$key) {
            $store = $store . "['$key'],";
            $cols = $this->Mine->query('SHOW COLUMNS FROM ' . $table);
            $jarray = $jarray . '  var field' . $i . ' = [';
	    $chfield=$chfield.'var fieldcheck'.$i.'=[];';
		$j=0;
            foreach ($cols as $col) {
                $jarray = $jarray . "['" . $col['COLUMNS']['Field'] . "'],";
		$crits=$crits.'var table'.$i.'field'.$j.'=[];';$j++;
            }
            $jarray = $jarray . '];';
            $i++;
        }
        $store = $store . "];var store = new Ext.data.ArrayStore({
        fields: [
           {name: 'table'}
        ]
    });
      store.loadData(data);";
        $jarray = $jarray ;
        echo $jarray;
        echo $store;
	echo $crits;
	echo $chfield;

    }

function addfield() {
$i = 0;
        $jarray = '';
	$crits = '';
	$chfield='';
        $store = ' var datav = [';
        foreach ($this->tables as $table=>$key) {
            $store = $store . "['$key'],";
            $cols = $this->Mine->query('SHOW COLUMNS FROM ' . $table);
            $jarray = $jarray . '  var fieldv' . $i . ' = [';
	    $chfield=$chfield.'var fieldcheckv'.$i.'=[];';
		$j=0;
            foreach ($cols as $col) {
                $jarray = $jarray . "['" . $col['COLUMNS']['Field'] . "'],";
		$crits=$crits.'var tablev'.$i.'fieldv'.$j.'=[];';$j++;
            }
            $jarray = $jarray . '];';
            $i++;
        }
        $store = $store . "];var storev = new Ext.data.ArrayStore({
        fields: [
           {name: 'table'}
        ]
    });
      storev.loadData(datav);";
        $jarray = $jarray ;
        echo $jarray;
        echo $store;
	echo $crits;
	echo $chfield;

    }

function addcriteria($id = null) {
$data['table']=$this->params['url']['table'];
$data['field']=$this->params['url']['field'];
$this->set('data',$data);

    }

function editcriteria($id = null) {
$data['table']=$this->params['url']['table'];
$data['field']=$this->params['url']['field'];
$data['criteria']=$this->params['url']['criteria'];
$this->set('data',$data);

    }
function distinct(){
$table=$this->params['url']['table'];
$field=$this->params['url']['field'];
$cols = $this->Mine->query('SHOW COLUMNS FROM ' . $this->tablee[$table]);
//$cols[$field]['COLUMNS'] have property for field
$row=$cols[$field]['COLUMNS']['Field'];
$distinct=$this->Mine->query("SELECT DISTINCT  `$row` FROM `".$this->tablee[$table]."` ORDER BY `$row`");
$i=0;
$distincts[0]='';
 //if(count($distinct)<300)
	foreach($distinct as $distinc){
		$distincts[$i]=$distinc[$this->tablee[$table]][$row];
		$i++;
	}
$this->set('distincts',$distincts);
}

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid mine', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Mine->save($this->data)) {
                $this->Session->setFlash(__('The mine has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The mine could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('mine', $this->Mine->read(null, $id));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for mine', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Mine->delete($i);
                }
                $this->Session->setFlash(__('Mine deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Mine was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Mine->delete($id)) {
                $this->Session->setFlash(__('Mine deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Mine was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

?>