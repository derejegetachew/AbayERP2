<?php
class ReportGroupsController extends AppController {

	var $name = 'ReportGroups';
	
function index() {
        
    }

    function search() {
        
    }

    function list_data($id = null) {
        $report_groups = $this->ReportGroup->find('all', array('order' => 'ReportGroup.lft ASC'));
        $tree_data = array();
        if (count($report_groups) > 0) {
            $tree_data = array($this->__getTreeArray($report_groups[0], $report_groups));
        }
        $this->set('report_groups', $tree_data);
    }

    function __getTreeArray($node, $adata) {
        $mynode = array();
        $mynode = array('id' => $node['ReportGroup']['id'], 'name' => $node['ReportGroup']['name'],'children' => array());
        $children = $this->__getChildNodes($node['ReportGroup']['id'], $adata);
        foreach ($children as $child) {
            $mynode['children'][] = $this->__getTreeArray($child, $adata);
        }
        return $mynode;
    }

    function __getChildNodes($p_id, $adata) {
        $ret = array();
        foreach ($adata as $ad) {
            if ($ad['ReportGroup']['parent_id'] == $p_id) {
                $ret[] = $ad;
            }
        }
        return $ret;
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid location', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->ReportGroup->recursive = 2;
        $this->set('location', $this->ReportGroup->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->ReportGroup->create();
            $this->autoRender = false;
            if ($this->ReportGroup->save($this->data)) {
                $this->Session->setFlash(__('The location has been saved', true));
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The location could not be saved. Please, try again.', true));
                $this->render('/elements/failure');
            }
        }
        if ($id)
            $this->set('parent_id', $id);
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid location', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->ReportGroup->save($this->data)) {
                $this->Session->setFlash(__('The location has been saved', true));
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The location could not be saved. Please, try again.', true));
                $this->render('/elements/failure');
            }
        }
        $this->set('report_group', $this->ReportGroup->read(null, $id));

        if ($parent_id) {
            $this->set('parent_id', $parent_id);
        }

        $parentReportGroups = $this->ReportGroup->ParentReportGroup->find('list');
        $this->set(compact('parentReportGroups'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for location', true));
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->ReportGroup->delete($i);
                }
                $this->Session->setFlash(__('ReportGroup deleted', true));
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('ReportGroup was not deleted', true));
                $this->render('/elements/failure');
            }
        } else {
            if ($this->ReportGroup->delete($id)) {
                $this->Session->setFlash(__('ReportGroup deleted', true));
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('ReportGroup was not deleted', true));
                $this->render('/elements/failure');
            }
        }
    }



}
?>