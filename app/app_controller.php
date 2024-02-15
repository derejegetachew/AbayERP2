<?php

class AppController extends Controller {

    public $components = array('Auth', 'Session', 'RequestHandler');
    public $helpers = array('ExtForm', 'Html', 'Javascript', 'Session', 'Text');

    /**
     * beforeFilter
     *
     * Application hook which runs prior to each controller action
     *
     * @access public
     */
    function beforeFilter() {

        parent::beforeFilter();
        $this->Auth->allow('*');
        
        //Create a global variable for views to use to send java script snippets to the browser
        $this->set('scripts_for_view', '');
        //Override default fields used by Auth component
        $this->Auth->fields = array('username' => 'username', 'password' => 'password');
        //Set application wide actions which do not require authentication
        $this->Auth->allow('display', 'about', 'logout', 'active_containers', 'edit_profile'); //IMPORTANT for CakePHP 1.2 final release change this to $this->Auth->allow(array('display'));
        //Set the default redirect for users who logout
        $this->Auth->logoutRedirect = '/';
        //Set the default redirect for users who login
        $this->Auth->loginRedirect = '/';
        //Extend auth component to include authorization via isAuthorized action
        $this->Auth->authorize = 'controller';
        //Restrict access to only users with an active account
        $this->Auth->userScope = array('User.is_active = 1');
        //Pass auth component data over to view files
        $this->layout = 'login';
		
		if($this->action !='login' && $this->action !='confirmresend' && $this->action !='signup'  && $this->action !='download' && $this->action !='confirmation' && $this->action !='disableuser' && $this->action !='empdetailupdate' && 
		$this->action !='search_emp2' && !($this->Session->check('Auth')) && $this->action !='send_sms' && $this->action !='send_sms_review' && $this->action !='rent_alert' && 
		$this->action !='search_intdenlq' && $this->action !='fetch_intdenlq' && $this->action !='wslogin' && $this->action !='search' && $this->action != 'daily_upload' && $this->action != 'batch_report' && $this->action != 'cheque_point_sms' && $this->action != 'profileremover'){
			$this->layout = 'login';
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}


        if (!defined('FILES_DIR'))
            define('FILES_DIR', "/erp/files");
            //define('FILES_DIR', "C:\\wamp\\www\\AbayERP\\app\\webroot\\files\\");


    $this->loadModel('BudgetYear');
         $by=$this->BudgetYear->find('all',array('order'=>array('BudgetYear.id desc limit 1')));
         $by=$by[0]['BudgetYear']['name'];
        $this->set(compact('by'));

    }

    /**
     * isAuthorized
     *
     * Called by Auth component for establishing whether the current authenticated
     * user has authorization to access the current controller:action
     *
     * @return true if authorised / false if not authorized
     * @access public
     */
    function isAuthorized() {
        return $this->__permitted($this->name, $this->action);
    }

    function isApplicable($actionName) {
        return true;
    }

	 function getRecentPosition($id=null){
        $this->loadModel('Employee');
        $this->loadModel('EmployeeDetail');
		$this->Employee->recursive=-1;
		$this->EmployeeDetail->recursive=1;
        $emp_id=$this->Employee->find('all',array('conditions'=>array('Employee.user_id'=>$id)));
		 if(!empty($emp_id)){
            $emp_id=$emp_id[0]['Employee']['id'];
            $emp_dt=$this->EmployeeDetail->find('all',array('conditions'=>array('EmployeeDetail.employee_id'=>$emp_id),'order'=>array('EmployeeDetail.end_date asc LIMIT 1')));
            return $emp_dt;	
		}else
			return null;
    }
    /**
     * __permitted
     *
     * Helper function returns true if the currently authenticated user has permission
     * to access the controller:action specified by $controllerName:$actionName
     * @return
     * @param $controllerName Object
     * @param $actionName Object
     */
    function __permitted($controllerName, $actionName) {
        //Ensure checks are all made lower case
        $controllerName = strtolower(Inflector::underscore($controllerName));
        $actionName = strtolower($actionName);
        //...then build permissions array and cache it
        $permissions = array();
        //If permissions have not been cached to session...
        if (!$this->Session->check('Permissions')) {
            $thisGroups = array();
            if ($this->Session->check('Auth')) {
                //everyone gets permission to logout
                $permissions[] = 'users:logout';
                $permissions[] = 'users:welcome';
                $permissions[] = 'users:change_password';
                $permissions[] = 'back_office:*';

                //Import the User Model so we can build up the permission cache
                App::import('Model', 'User');
                $thisUser = new User;
                //Now bring in the current users full record along with groups 
                $thisGroups = $thisUser->find(array('User.id' => $this->Session->read('Auth.User.id')));
                $thisGroups = $thisGroups['Group'];
				
				$recepos=$this->getRecentPosition($this->Session->read('Auth.User.id'));
				if(isset($recepos)){
					if (stripos($recepos[0]['Branch']['name'], "Branch") !== false){
						$thisGroups[]=array('id'=>'79','name'=>'Branch User');
					}
				}
            } else {
                App::import('Model', 'Group');
                $group = new Group;
                $thisGs = $group->find('all', array('conditions' => array('Group.name' => 'Guest')));

                foreach ($thisGs as $thisG) {
                    $thisGroups[] = array('id' => $thisG['Group']['id']);
                }
            }

            foreach ($thisGroups as $thisGroup) {
                $thisPermissions = $thisUser->Group->find(array('Group.id' => $thisGroup['id']));
                $thisPermissions = $thisPermissions['Permission'];
                foreach ($thisPermissions as $thisPermission) {
                    $permissions[] = $thisPermission['name'];
                }
            }
            //write the permissions array to session
            $this->Session->write('Permissions', $permissions);
        } else {
            //...they have been cached already, so retrieve them
            $permissions = $this->Session->read('Permissions');
        }
        //Now iterate through permissions for a positive match
        foreach ($permissions as $permission) {
            if ($permission == '*') {
                return true; //Super Admin Bypass Found
            }
            if (strtolower($permission) == $controllerName . ':*') {
                return true; //Controller Wide Bypass Found
            }
            if (strtolower($permission) == $controllerName . ':' . $actionName) {
                return true; //Specific permission found
            }
        }
        return false;
    }

    function CleanData($str = '') {
        return str_replace("'", "\\'", $str);
    }

}

?>
