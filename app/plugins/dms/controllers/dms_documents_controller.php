<?php
class DmsDocumentsController extends AppController {

	var $name = 'DmsDocuments';

	function index() {
	
		//$users = $this->DmsDocument->User->find('all');
		//$this->set(compact('users'));
		$user = $this->Session->read();
		/*/inbox
		
		$conditions =array('DmsDocument.user_id' => $user['Auth']['User']['id'],'DmsDocument.parent_id' => -1,'DmsDocument.type' => 'folder');
		$this->DmsDocument->recursive = -1;
		$inboxparent = $this->DmsDocument->find('all', array('conditions' => $conditions));
		
		for($j=0;$j<count($inboxparent);$j++){
			$inboxparent[$j]['child'] = $this->getChild($inboxparent[$j]['DmsDocument']['id']);			
		}
		
		
		//outbox
		$conditions =array('DmsDocument.user_id' => $user['Auth']['User']['id'],'DmsDocument.parent_id' => -2,'DmsDocument.type' => 'folder');
		$this->DmsDocument->recursive = -1;
		$outboxparent = $this->DmsDocument->find('all', array('conditions' => $conditions,'order'=>array('DmsDocument.type'=>'DESC','DmsDocument.name'=>'ASC')));
		
		for($j=0;$j<count($outboxparent);$j++){
			$outboxparent[$j]['child'] = $this->getChild($outboxparent[$j]['DmsDocument']['id']);			
		}
		*/
		
		//my files
		$conditions =array('DmsDocument.user_id' => $user['Auth']['User']['id'],'DmsDocument.parent_id' => -3,'DmsDocument.type' => 'folder');
		$this->DmsDocument->recursive = -1;
		$myfilesparent = $this->DmsDocument->find('all', array('conditions' => $conditions,'order'=>array('DmsDocument.type'=>'DESC','DmsDocument.name'=>'ASC')));
		
		for($j=0;$j<count($myfilesparent);$j++){
			$myfilesparent[$j]['child'] = $this->getChild($myfilesparent[$j]['DmsDocument']['id']);			
		}
		
		/*$results[0]['DmsDocument']['id'] = -1;
		$results[0]['DmsDocument']['name'] = 'Inbox';
		$results[0]['child'] = $inboxparent;
		
		$results[1]['DmsDocument']['id'] = -2;
		$results[1]['DmsDocument']['name'] = 'Outbox';
		$results[1]['child'] = $outboxparent;*/
		
		$results[2]['DmsDocument']['id'] = -3;
		$results[2]['DmsDocument']['name'] = 'My Files';
		$results[2]['child'] = $myfilesparent;
		
		$results[3]['DmsDocument']['id'] = -4;
		$results[3]['DmsDocument']['name'] = 'Public Files';
		//$results[3]['child'] = $myfilesparent;
		
		$this->set('results', $results); //tree structure
		
		$count_unread='';
		$count_brodcast='';
		
		/*
		$conditions_recipient =array('DmsRecipient.user_id' => $user['Auth']['User']['id'],'DmsRecipient.read' => 'false');
		$this->DmsRecipient->recursive = -1;
		$this->loadModel('DmsRecipient');
		$unreads = $this->DmsRecipient->find('all', array('conditions' => $conditions_recipient));
		foreach($unreads as $unread){
			$this->DmsMessage->recursive = -1;
			$this->loadModel('DmsMessage');
			$unread_message = $this->DmsMessage->read(null,$unread['DmsRecipient']['dms_message_id']);
			if(!empty($unread_message)){
				if($unread_message['DmsMessage']['broadcast'] == 0){
					$count_unread++;
				}
				else if($unread_message['DmsMessage']['broadcast'] == 1){
					$count_brodcast++;
				}
			}
		}	
		*/
		$this->set(compact('count_unread', 'count_brodcast'));
		/*
		$this->loadModel('People');
		$this->loadModel('User');
		$this->loadModel('Employee');
		$this->People->recursive = -1;
		$fields = array('People.first_name');
		$params = array('fields' => $fields,);
		$peoples = $this->People->find('all');
		$employees = array();
		foreach($peoples as $people){			
			$this->User->recursive = -1;
			$user = $this->User->find('first',array('conditions'=>array('User.person_id'=>$people['People']['id']))); 			
			
			$this->Employee->recursive = -1;
			$employee = $this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user['User']['id'],'Employee.status'=>'active'))); 
			if(!empty($employee)){
				$employees[] = $people;
			}
		}
		*/
		//$employees=null;
		//$this->set('peoples',$employees);
	}
	
	function getChild($parentId=null){ //folders only
		$conditions =array('DmsDocument.parent_id' =>$parentId ,'DmsDocument.type' => 'folder');
		$this->DmsDocument->recursive = -1;
		$children = $this->DmsDocument->find('all', array('conditions' => $conditions,'order'=>array('DmsDocument.type'=>'DESC','DmsDocument.name'=>'ASC')));
		if(!empty($children)){
			for($i=0;$i<count($children);$i++){				
				$children[$i]['child'] = $this->getChild($children[$i]['DmsDocument']['id']);
			}
			return $children;
		}
	}
	function getAllChildItems($parentId=null){ //all file types with tree structures
		$conditions =array('DmsDocument.parent_id' =>$parentId );
		$this->DmsDocument->recursive = -1;
		$children = $this->DmsDocument->find('all', array('conditions' => $conditions,'order'=>array('DmsDocument.type'=>'DESC','DmsDocument.name'=>'ASC')));
		if(!empty($children)){
			for($i=0;$i<count($children);$i++){				
				$children[$i]['child'] = $this->getAllChildItems($children[$i]['DmsDocument']['id']);
			}
			return $children;
		}
	}
	
	function getAllChildItemsclear($parentId=null){ //all file types just list style
		$conditions =array('DmsDocument.parent_id' =>$parentId );
		$this->DmsDocument->recursive = -1;
		$children = $this->DmsDocument->find('all', array('conditions' => $conditions,'order'=>array('DmsDocument.type'=>'DESC','DmsDocument.name'=>'ASC')));
		if(!empty($children)){
			for($i=0;$i<count($children);$i++){	
				if(is_array($this->getAllChildItemsclear($children[$i]['DmsDocument']['id'])))
				$children=array_merge($children, $this->getAllChildItemsclear($children[$i]['DmsDocument']['id']));
			}
			return $children;
		}
	}
	
	function createTreeZip($parentId=null,$path=null){ //all file types with tree structures
		$conditions =array('DmsDocument.parent_id' =>$parentId );
		$this->DmsDocument->recursive = -1;
		$children = $this->DmsDocument->find('all', array('conditions' => $conditions,'order'=>array('DmsDocument.type'=>'DESC','DmsDocument.name'=>'ASC')));
		
		if(!empty($children)){
			for($i=0;$i<count($children);$i++){	
				if($children[$i]['DmsDocument']['type'] == 'folder'){
					mkdir($path .DS. $children[$i]['DmsDocument']['name'], 0777);
					$this->createTreeZip($children[$i]['DmsDocument']['id'],$path .DS. $children[$i]['DmsDocument']['name']);
				}
				else if($children[$i]['DmsDocument']['type'] == 'file'){
					copy(FILES_DIR.DS. "uploads" .DS. $children[$i]['DmsDocument']['file_name'],$path .DS. $children[$i]['DmsDocument']['name']);
				}
			}			
		}
	}
	
	function zip($parentId=null){
		$folderName = $this->DmsDocument->read(null,$parentId);
		$name = microtime();
		mkdir(FILES_DIR.DS. "uploads" .DS. $name, 0777);
		$this->createTreeZip($parentId,FILES_DIR.DS. "uploads" .DS. $name);
		//header('Location: http://localhost/zip/zip.php?source='.$name.'&destination='.$folderName['DmsDocument']['name']);
		
		$source = FILES_DIR.DS. "uploads" .DS. $name;		
		$destination = $source.'.zip';

		if (!extension_loaded('zip') || !file_exists($source)) {
			return false;
		}

		$zip = new ZipArchive();
		if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
			return false;
		}    	
		$source = str_replace('\\', '/', realpath($source));
		if (is_dir($source) === true)
		{
			$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

			foreach ($files as $file)
			{
				$file = str_replace('\\', '/', $file);            

				if (is_dir($file) === true)
				{
					$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
				}
				else if (is_file($file) === true)
				{
					$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
				}
			}
		}
		else if (is_file($source) === true)
		{
			$zip->addFromString(basename($source), file_get_contents($source));
		}

		$zip->close();
		
		$it = new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS);
		$files2 = new RecursiveIteratorIterator($it,
					 RecursiveIteratorIterator::CHILD_FIRST);
		foreach($files2 as $file) {
			if ($file->isDir()){
				rmdir($file->getRealPath());
			} else {
				unlink($file->getRealPath());
			}
		}
		rmdir($source);
   
        $filedes=$destination;
		$destination = FILES_DIR.DS. "uploads" .DS . $folderName['DmsDocument']['name'].'.zip';		
		ob_get_clean();
		set_time_limit(0);
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);
		header("Content-Type: application/zip");
		header("Content-Disposition: attachment; filename=" . basename($destination) . ";" );
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . filesize($filedes));
		header("Accept-Ranges: none");
		ignore_user_abort(true);
		readfile($filedes);				
		
		
		@unlink($filedes);
	}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {
	}
	
	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
            $sort_col = array();
            foreach ($arr as $key => $row) {
                $sort_col[$key] = $row[$col];
            }

            array_multisort($sort_col, $dir, $arr);
        }
	function publicfiles(){
		$user = $this->Session->read();
		$user_id = $user['Auth']['User']['id'];
		
		$this->loadModel('Employee');
		$emp=$this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user_id)));
	
		$this->array_sort_by_column($emp['EmployeeDetail'], "start_date");
		$branch_id=$emp['EmployeeDetail'][count($emp['EmployeeDetail'])-1]['branch_id'];
		
		$conditions['DmsDocument.shared']=1;
		$allfolders=$this->DmsDocument->find('all', array('conditions' => $conditions,'order'=>array('DmsDocument.name'=>'ASC')));
		$this->loadModel('DmsShare');
		$final_folder_list=array();
		foreach($allfolders as $folder){ 
				//everyone access
				$conditionsx =array('DmsShare.dms_document_id' => $folder['DmsDocument']['id'],'DmsShare.everyone' => 1);
				$exst = $this->DmsShare->find('count', array('conditions' => $conditionsx));
			if($exst>0){
				$final_folder_list[]=$folder;
			}else{ //branch level
			$conditionsxx =array('DmsShare.dms_document_id' => $folder['DmsDocument']['id'],'DmsShare.branch_id' => $branch_id);
			$exst = $this->DmsShare->find('count', array('conditions' => $conditionsxx));
				if($exst>0){
					$final_folder_list[]=$folder;
				}else{ //individual level
					$conditionsxx =array('DmsShare.dms_document_id' => $folder['DmsDocument']['id'],'DmsShare.user_id' => $user_id);
					$exst = $this->DmsShare->find('count', array('conditions' => $conditionsxx));
					if($exst>0)
					$final_folder_list[]=$folder;
				}
			}
		}
		$this->set('dms_documents', $final_folder_list);
		$this->set('results',count($final_folder_list));
	
	}
	function list_data($id = null,$parent_id=null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		//$user_id = (isset($_REQUEST['user_id'])) ? $_REQUEST['user_id'] : -1;
		$user = $this->Session->read();
		$user_id=$user['Auth']['User']['id'];
		$parent_id = (isset($_REQUEST['parent_id'])) ? $_REQUEST['parent_id'] : 0;
		$back = (isset($_REQUEST['back'])) ? $_REQUEST['back'] : 0;
		$current_folder = (isset($_REQUEST['current_folder'])) ? $_REQUEST['current_folder'] : 0;
		
			//if($current_folder==-4)
			//	$parent_id=-4;

			if($back==1 && $current_folder>0){ // pressed up button
			//return to public if folder not yours
				$curfold=$this->DmsDocument->read(null, $current_folder);
				if($curfold['DmsDocument']['shared']==1 && $curfold['DmsDocument']['user_id']!=$user_id){
					$this->set('current',-4);
					$parent_id=-4;}
				else{
			$current=$this->DmsDocument->read(null,$current_folder);
			$parent_id=$current['DmsDocument']['parent_id'];
			}
			}
			
			if($parent_id==-3 || $parent_id==-2 || $parent_id==-1)
				$conditions['DmsDocument.user_id'] = $user_id;
						
			if($parent_id!=0){
			if($parent_id==-4){ //public folder
				
				$this->set('current',0);
				$this->publicfiles();

			}else{


			$conditions['DmsDocument.parent_id']=$parent_id;
			$this->set('current',$parent_id);
				//return to public if folder not yours
				//$curfold=$this->DmsDocument->read(null, $parent_id);
				//if($curfold['DmsDocument']['shared']==1 && $curfold['DmsDocument']['user_id']!=$user_id)
				//	$this->set('current',-4);
			$dms_documents=$this->DmsDocument->find('all', array('conditions' => $conditions,'order'=>array('DmsDocument.type'=>'DESC','DmsDocument.name'=>'ASC')));
			$ix=0;
				foreach($dms_documents as $dms_document){
				$conditionsx =array('DmsDocument.parent_id' => $dms_document['DmsDocument']['id']);
				$countch = $this->DmsDocument->find('count', array('conditions' => $conditionsx));
				if($countch>0)
				$dms_documents[$ix]['DmsDocument']['countch']=$countch;
				else
				$dms_documents[$ix]['DmsDocument']['countch']=null;
				$ix++;
				}
			$this->set('dms_documents',$dms_documents);
			$this->set('results', $this->DmsDocument->find('count', array('conditions' => $conditions)));
				
			}
			}else{

				$this->set('current',0);
				$this->set('results',10);
				$dms_documents[0]['DmsDocument']['id']='-3';
				$dms_documents[0]['DmsDocument']['name']='My Files';
				$dms_documents[0]['DmsDocument']['type']='folder';
				$dms_documents[0]['User']['id']= $user_id;
				/*
				$dms_documents[1]['DmsDocument']['id']='-1';
				$dms_documents[1]['DmsDocument']['name']='Inbox';
				$conditions['DmsDocument.parent_id']=-1;
				$conditions['DmsDocument.user_id']=$user_id;
				$conditions['DmsDocument.read']='false';
				$incnt=$this->DmsDocument->find('count', array('conditions' => $conditions));
				if($incnt>0){
				$dms_documents[1]['DmsDocument']['tag']=' <div style=\"color: white; position: relative; display: block; font-family: helvetica; top: -14px; width: 14px; right: -63px; background-color: red;\">'.$incnt.'</div>';
				}
				$dms_documents[1]['DmsDocument']['type']='folder';
				$dms_documents[1]['User']['id']= $user_id;
				$dms_documents[2]['DmsDocument']['id']='-2';
				$dms_documents[2]['DmsDocument']['name']='Outbox';
				$dms_documents[2]['DmsDocument']['type']='folder';
				$dms_documents[2]['User']['id']= $user_id;
				*/
				$dms_documents[1]['DmsDocument']['id']='-4';
				$dms_documents[1]['DmsDocument']['name']='Public';
				$dms_documents[1]['DmsDocument']['type']='folder';
				$dms_documents[1]['User']['id']= $user_id;
				for($j=0; $j<=1; $j++){
				$dms_documents[$j]['ParentDmsDocument']['name']='';
				$dms_documents[$j]['DmsDocument']['shared']='';
				$dms_documents[$j]['DmsDocument']['size']='';
				$dms_documents[$j]['DmsDocument']['file_type']='';
				$dms_documents[$j]['DmsDocument']['file_name']='';
				$dms_documents[$j]['DmsDocument']['share_to']='';
				$dms_documents[$j]['DmsDocument']['created']='';
				$dms_documents[$j]['DmsDocument']['modified']='';
				}
				$this->set('dms_documents',$dms_documents);
			}
		
	}
	function getfiletype($extension){
			$apps=array('apk','exe','bat','com','jar','vb','wsf');
			$vids=array('3gp','asf','avi','flv','m4v','mov','mp4','mpg','swf','wmv');
			$img=array('bmp','gif','png','jpg','psd','tif');
			$aud=array('aif','m4a','mp3','mpa','wav','wma');
			$compr=array('tar','zip','7z','gz','rar','tar.gz','zipx');
			$docs=array('doc','docx','txt','rtf','csv','pps','ppt','pptx','xml','xls');
			if(array_search(strtolower($extension),$apps))
			$this->data['DmsDocument']['file_type'] = 'application';
			elseif(array_search(strtolower($extension),$vids))
			$this->data['DmsDocument']['file_type'] = 'video';
			elseif(array_search(strtolower($extension),$img))
			$this->data['DmsDocument']['file_type'] = 'image';
			elseif(array_search(strtolower($extension),$aud))
			$this->data['DmsDocument']['file_type'] = 'audio';
			elseif(array_search(strtolower($extension),$compr))
			$this->data['DmsDocument']['file_type'] = 'compressed';
			elseif(array_search(strtolower($extension),$docs))
			$this->data['DmsDocument']['file_type'] = 'document';
			else
			$this->data['DmsDocument']['file_type'] = 'file';
			
			return $this->data['DmsDocument']['file_type'];
	}
	function sendfiles($id = null){
		//open view
	}
	
	function download($id=null){
		$record=$this->DmsDocument->read(null, $id);
		$file=FILES_DIR.DS . "uploads" . DS . $record['DmsDocument']['file_name'];
		if (!file_exists($file))			
			$file='/mnt'.DS . "uploads" . DS . $record['DmsDocument']['file_name'];
		
		/*if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename(str_replace(' ','-',$record['DmsDocument']['name'])));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		}*/
		$modules = apache_get_modules();
		if (in_array('mod_xsendfile', $modules)) {
		//header('Location: http://10.1.85.11/erpdownload.php?file='.$file.'&name='.);
		header ('X-Sendfile: '.$file);
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename(str_replace(' ','-',$record['DmsDocument']['name'])));
		exit;			
		}else{
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename(str_replace(' ','-',$record['DmsDocument']['name'])));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		}
	}
	function sendupload(){
		if (isset($_FILES['Filedata'])){
		$this->autoRender = false;
		$this->loadModel('DmsMessage');
		$mess=$this->DmsMessage->read(null,$_REQUEST['message_id']);
		
			//upload file
			$file=$_FILES['Filedata'];
			 if (isset($file)) {
							if (!is_dir(FILES_DIR .DS. "uploads"))
                                mkdir(FILES_DIR.DS. "uploads", 0777);
							$extension = end(explode(".", $file["name"]));
							$this->data['DmsDocument']['name'] = $file["name"];
							$this->data['DmsDocument']['type'] = 'file';
							$this->data['DmsDocument']['user_id'] = $_REQUEST['user_id'];
							$this->data['DmsDocument']['dms_message_id']=$_REQUEST['message_id'];
							$this->data['DmsDocument']['parent_id'] = -2;
							$this->data['DmsDocument']['size'] = $file["size"];
							$this->data['DmsDocument']['file_type'] = $this->getfiletype($extension);
							$key = md5(microtime().rand());
							$this->data['DmsDocument']['file_name'] = $key.'.'.$extension; 
                            $file["name"] = $key.'.'.$extension;
                            move_uploaded_file($file["tmp_name"], FILES_DIR.DS . "uploads" . DS . $file["name"]);
							$this->DmsDocument->create();
							$this->DmsDocument->save($this->data);
							foreach($mess['DmsRecipient'] as $recp){
								$this->data['DmsDocument']['user_id']=$recp['user_id'];
								$this->data['DmsDocument']['parent_id']=-1;
								$key = md5(microtime().rand());
								$this->data['DmsDocument']['file_name'] = $key.'.'.$extension; 
								$fromfile=FILES_DIR.DS . "uploads" . DS . $file["name"];
								$newfile=$key.'.'.$extension; 
								if(copy($fromfile, $newfile)){
								$this->DmsDocument->create();
								$this->DmsDocument->save($this->data);
								}
							}
							//print_r($this->data);
							echo '{"success":true}';
				}
		}
		
		if (!empty($this->data)) {
			if(!empty($this->data['DmsDocument']['employees'])){
			$user = $this->Session->read();
			$this->data['DmsMessage']['user_id']=$user['Auth']['User']['id'];
			$this->data['DmsMessage']['message']=$this->data['DmsDocument']['msg'];
			$this->data['DmsMessage']['number']=count($this->data['DmsDocument']['employees']);
			$this->data['DmsMessage']['old_record']='uploaded';
			$this->loadModel('DmsMessage');
			$this->DmsMessage->create();
			$this->DmsMessage->save($this->data);
			$message_id=$this->DmsMessage->getLastInsertId();
			$this->loadModel('DmsRecipient');
			foreach($this->data['DmsDocument']['employees'] as $emp){
				if (is_numeric($emp)){
					$this->data['DmsRecipient']['user_id']=$emp;
					$this->data['DmsRecipient']['dms_message_id']=$message_id;
					$this->DmsRecipient->create();
					$this->DmsRecipient->save($this->data);
				}
			}
			$this->set('message_id',$message_id);
			$this->set('user_id',$user['Auth']['User']['id']);
			}
		}
	}
	function senduploadxhr(){
	
	}
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid dms document', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->DmsDocument->recursive = 2;
		$this->set('dmsDocument', $this->DmsDocument->read(null, $id));
	}
	function is_permitted($parent_id,$perm,$user_id = null){
		if($user_id==null){
		$user = $this->Session->read();
		$user_id = $user['Auth']['User']['id'];
		}
		
		$this->loadModel('Employee');
		$emp=$this->Employee->find('first',array('conditions'=>array('Employee.user_id'=>$user_id)));
		if(empty($emp['EmployeeDetail']))
			return false;
		$this->array_sort_by_column($emp['EmployeeDetail'], "start_date");
		$branch_id=$emp['EmployeeDetail'][count($emp['EmployeeDetail'])-1]['branch_id'];
		$this->loadModel('DmsShare');
	while(true){
		$rec=$this->DmsDocument->read(null, $parent_id);
		if(empty($rec))
			return false;
		if($rec['DmsDocument']['shared']=1 && $rec['DmsDocument']['type']='folder'){
		
				//everyone access
				$conditionsx =array('DmsShare.dms_document_id' => $parent_id,'DmsShare.everyone' => 1,'DmsShare.'.$perm => 1);
				
				$exst = $this->DmsShare->find('count', array('conditions' => $conditionsx));
			if($exst>0){
				return true;
			}else{ //branch level
			$conditionsxx =array('DmsShare.dms_document_id' => $parent_id,'DmsShare.branch_id' => $branch_id,'DmsShare.'.$perm => 1);
			$exst = $this->DmsShare->find('count', array('conditions' => $conditionsxx));
				if($exst>0){
					return true;
				}else{ //individual level
					$conditionsxx =array('DmsShare.dms_document_id' => $parent_id,'DmsShare.user_id' => $user_id,'DmsShare.'.$perm => 1);
					$exst = $this->DmsShare->find('count', array('conditions' => $conditionsxx));
					if($exst>0)
						return true;
				}
			}
			$parent_id=$rec['DmsDocument']['parent_id'];
			if($parent_id==-1 || $parent_id==-2 || $parent_id==-3 || $parent_id==-4){
				return false;
			}
		}else{
			$parent_id=$rec['DmsDocument']['parent_id'];
			if($parent_id==-1 || $parent_id==-2 || $parent_id==-3 || $parent_id==-4){
				return false;
			}
		}
	}
	}
	function add($id = null) {
		if (!empty($this->data)) {
		$user = $this->Session->read();
		$conditions =array('DmsDocument.user_id' => $user['Auth']['User']['id'],'DmsDocument.id' => $this->data['DmsDocument']['parent_id'],'DmsDocument.type' => 'folder');
		$myfilesparent = $this->DmsDocument->find('count', array('conditions' => $conditions));
		if($this->data['DmsDocument']['parent_id']=='-3')
			$myfilesparent=1;
		if($myfilesparent>0 || $this->is_permitted($this->data['DmsDocument']['parent_id'],'write')){
			$user_id=$user['Auth']['User']['id'];
			if($this->is_permitted($this->data['DmsDocument']['parent_id'],'write')){
				$rec=$this->DmsDocument->read(null, $this->data['DmsDocument']['parent_id']);
				$user_id=$rec['DmsDocument']['user_id'];
				$this->data['DmsDocument']['shared_by']=$user['Auth']['User']['id'];
			}
			
			$conditionsx =array('DmsDocument.parent_id' => $this->data['DmsDocument']['parent_id'],'DmsDocument.name' => $this->data['DmsDocument']['name']);
			if($this->data['DmsDocument']['parent_id']==-3)//if on my folder which is common to every one
				$conditionsx =array('DmsDocument.user_id' => $user['Auth']['User']['id'],'DmsDocument.parent_id' => $this->data['DmsDocument']['parent_id'],'DmsDocument.name' => $this->data['DmsDocument']['name']);
			$exst = $this->DmsDocument->find('count', array('conditions' => $conditionsx));
			if($exst<=0){
			$this->DmsDocument->create();
			$this->autoRender = false;
			$this->data['DmsDocument']['type'] = 'folder';
			$this->data['DmsDocument']['user_id'] = $user_id;
			if ($this->DmsDocument->save($this->data)) {
				$this->Session->setFlash(__('Folder Created', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Folder could not be created. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
			}else{
				$this->Session->setFlash(__('Folder with the same name exist here, try a different name.', true), '');
				$this->render('/elements/failure');
			}
		}else{
			$this->Session->setFlash(__('You dont have access to create folder here', true), '');
			$this->render('/elements/failure');
			}
		
		}
		if($id)
			$this->set('parent_id', $id);
		else
			$this->set('parent_id', -4);
		$users = $this->DmsDocument->User->find('list');
		$parent_dms_documents = $this->DmsDocument->ParentDmsDocument->find('list');
		$this->set(compact('users', 'parent_dms_documents'));
	}
	
	function removecontent($id=null){
	$this->autoRender = false;
	$user = $this->Session->read();
	$record=$this->DmsDocument->read(null, $id);
	if($user['Auth']['User']['id']==$record['DmsDocument']['user_id'] || $this->is_permitted($this->data['DmsDocument']['parent_id'],'delete')){
		if($record['DmsDocument']['type']=='folder'){
			if(is_array($this->getAllChildItemsclear($id)))
				foreach($this->getAllChildItemsclear($id) as $itms){
					if($itms['DmsDocument']['type']=='file'){
						$this->DmsDocument->delete($itms['DmsDocument']['id']);
					//unlink(FILES_DIR.DS . "uploads" . DS . $itms['DmsDocument']['file_name']);
					}
				}
				//$this->DmsDocument->delete($id);
				echo 'Folder content cleaned successfully';
		}
	}else{
		echo 'You dont have permission for the action required';
	}	
	}
	
	
	function remove($id=null){
	$this->autoRender = false;
	$user = $this->Session->read();
	$record=$this->DmsDocument->read(null, $id);
	if($user['Auth']['User']['id']==$record['DmsDocument']['user_id'] || $this->is_permitted($this->data['DmsDocument']['parent_id'],'delete')){
		if($record['DmsDocument']['type']=='folder'){
			if(is_array($this->getAllChildItemsclear($id)))
				foreach($this->getAllChildItemsclear($id) as $itms){
					$this->DmsDocument->delete($itms['DmsDocument']['id']);
					unlink(FILES_DIR.DS . "uploads" . DS . $itms['DmsDocument']['file_name']);
				}
				$this->DmsDocument->delete($id);
				echo 'Item removed successfully';
		}else{
			$this->DmsDocument->delete($id);
			unlink(FILES_DIR.DS . "uploads" . DS . $record['DmsDocument']['file_name']);
			echo 'Item removed successfully';
		}
	}else{
		echo 'You Dont have permission to remove this item';
	}
	
	}
	function unshare($id = null ){
	$user = $this->Session->read();
	$record=$this->DmsDocument->read(null, $id);
	if($user['Auth']['User']['id']==$record['DmsDocument']['user_id']){
		$this->data['DmsDocument']['id']=$id;
		$this->data['DmsDocument']['shared']=0;
			if ($this->DmsDocument->save($this->data)) {
			$this->loadModel('DmsShare');
			$this->DmsShare->deleteAll(array('DmsShare.dms_document_id' => $this->data['DmsDocument']['id']), false);
				$this->Session->setFlash(__('This folder is not visible to other users anymore', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Error. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
	}else{
		$this->Session->setFlash(__('You dont have access for the operation', true), '');
		$this->render('/elements/failure');
	}
	}
	function share($id = null){
	if (!empty($this->data)) {
	$user = $this->Session->read();
		$conditions =array('DmsDocument.user_id' => $user['Auth']['User']['id'],'DmsDocument.id' => $this->data['DmsDocument']['id'],'DmsDocument.type' => 'folder');
		$access = $this->DmsDocument->find('count', array('conditions' => $conditions));
		if($access>0){
	
			$this->data['DmsDocument']['shared']=1;
			$this->DmsDocument->save($this->data);
			
			$this->loadModel('DmsShare');
			$this->DmsShare->deleteAll(array('DmsShare.dms_document_id' => $this->data['DmsDocument']['id']), false);
			
		if(isset($this->data['DmsDocument']['all'])){
			$this->data['DmsShare']['dms_document_id']=$this->data['DmsDocument']['id'];
			$this->data['DmsShare']['everyone']=1;
			$this->data['DmsShare']['read']=1;
			$this->DmsShare->create();
			$this->DmsShare->save($this->data);
		}else{
			foreach($this->data['DmsDocument']['branches'] as $recd){
				$this->data2['DmsShare']['dms_document_id']=$this->data['DmsDocument']['id'];
				$this->data2['DmsShare']['read']=1;
				if (is_numeric($recd)){
					$this->data2['DmsShare']['branch_id']=$recd;
					$this->DmsShare->create();
					$this->DmsShare->save($this->data2);
				}
			}
		}
		if(isset($this->data['DmsDocument']['all2'])){
			$this->data3['DmsShare']['dms_document_id']=$this->data['DmsDocument']['id'];
			$this->data3['DmsShare']['everyone']=1;
			$this->data3['DmsShare']['read']=1;
			$this->data3['DmsShare']['write']=1;
			$this->DmsShare->create();
			$this->DmsShare->save($this->data3);
		}else{
		foreach($this->data['DmsDocument']['employees2'] as $recd){
				$this->data3['DmsShare']['dms_document_id']=$this->data['DmsDocument']['id'];
				$this->data3['DmsShare']['read']=1;
				$this->data3['DmsShare']['write']=1;
				if (is_numeric($recd)){
					$this->data3['DmsShare']['user_id']=$recd;
					$this->DmsShare->create();
					$this->DmsShare->save($this->data3);
				}
		}
		foreach($this->data['DmsDocument']['branches2'] as $recd){
				$this->data5['DmsShare']['dms_document_id']=$this->data['DmsDocument']['id'];
				$this->data5['DmsShare']['read']=1;
				$this->data5['DmsShare']['write']=1;
				if (is_numeric($recd)){
					$this->data5['DmsShare']['branch_id']=$recd;
					$this->DmsShare->create();
					$this->DmsShare->save($this->data5);
				}
			}
		}
		foreach($this->data['DmsDocument']['employees3'] as $recd){
				$this->data4['DmsShare']['dms_document_id']=$this->data['DmsDocument']['id'];
				$this->data4['DmsShare']['read']=1;
				$this->data4['DmsShare']['write']=1;
				$this->data4['DmsShare']['delete']=1;
				if (is_numeric($recd)){
					$this->data4['DmsShare']['user_id']=$recd;
					$this->DmsShare->create();
					$this->DmsShare->save($this->data4);
				}
		}
		foreach($this->data['DmsDocument']['branches3'] as $recd){
				$this->data6['DmsShare']['dms_document_id']=$this->data['DmsDocument']['id'];
				$this->data6['DmsShare']['read']=1;
				$this->data6['DmsShare']['write']=1;
				$this->data6['DmsShare']['delete']=1;
				if (is_numeric($recd)){
					$this->data6['DmsShare']['branch_id']=$recd;
					$this->DmsShare->create();
					$this->DmsShare->save($this->data6);
				}
			}
		$this->Session->setFlash(__('Folder Shared!', true), '');
        $this->render('/elements/success');
		}else{
$this->Session->setFlash(__('You dont have access to share this item', true), '');
            $this->render('/elements/failure');
		}
	}
	$this->set('folder_id', $id);
	}
	function upload($parent = null) {

		if (isset($_FILES['Filedata'])){
		if(isset($_FILES['parent_id']))
			$_REQUEST['parent_id']=$_FILES['parent_id'];
		//print_r($_FILES);
		$this->autoRender = false;
		$conditions =array('DmsDocument.user_id' => $_REQUEST['user_id'],'DmsDocument.id' => $_REQUEST['parent_id'],'DmsDocument.type' => 'folder');
		$myfilesparent = $this->DmsDocument->find('count', array('conditions' => $conditions));
		if($_REQUEST['parent_id']=='-3')
			$myfilesparent=1;
		if($myfilesparent>0 || $this->is_permitted($_REQUEST['parent_id'],'write',$_REQUEST['user_id'])){
			$user_id=$_REQUEST['user_id'];
			if($this->is_permitted($_REQUEST['parent_id'],'write',$_REQUEST['user_id'])){
				$rec=$this->DmsDocument->read(null, $_REQUEST['parent_id']);
				$user_id=$rec['DmsDocument']['user_id'];
				$this->data['DmsDocument']['shared_by']=$_REQUEST['user_id'];
			}
			//upload file
			$file=$_FILES['Filedata'];
			 if (isset($file)) {
				if (!is_dir(FILES_DIR .DS. "uploads"))
                                mkdir(FILES_DIR.DS. "uploads", 0777);
							$extension = end(explode(".", $file["name"]));
					if($_REQUEST['parent_id']==-3)
						$conditionsx['DmsDocument.user_id'] = $_REQUEST['user_id'];
			 $conditionsx =array('DmsDocument.parent_id' => $_REQUEST['parent_id'],'DmsDocument.name' => $file["name"]);
			$exst = $this->DmsDocument->find('count', array('conditions' => $conditionsx));
			if($exst<=0){							
							$this->data['DmsDocument']['name'] = $file["name"];
							$this->data['DmsDocument']['type'] = 'file';
							$this->data['DmsDocument']['user_id'] = $user_id;
							$this->data['DmsDocument']['parent_id'] = $_REQUEST['parent_id'];
							$this->data['DmsDocument']['size'] = $file["size"];
							$this->data['DmsDocument']['file_type'] = $this->getfiletype($extension);
							$key = md5(microtime().rand());
							$this->data['DmsDocument']['file_name'] = $key.'.'.$extension; 
                            $file["name"] = $key.'.'.$extension;
                            move_uploaded_file($file["tmp_name"], FILES_DIR.DS . "uploads" . DS . $file["name"]);
							$this->DmsDocument->create();
							$this->DmsDocument->save($this->data);
							echo '{"success":true}';
					}else{
						$message="File with the same name exist here";
						echo '{"success":false,"error":'.json_encode($message).'}';
					}
				}
		}else{
			$message="You Don't Have Access to Upload In This Folder";
			echo '{"success":false,"error":'.json_encode($message).'}';
		}
			exit();
		}
		$this->set('parent_id',$parent);
		$user = $this->Session->read();
		$this->set('user_id',$user['Auth']['User']['id']);
			
	}
	
	function uploadxhr($parent = null) {
		
		if(isset($_SERVER)){
		$this->autoRender = false;
		$user = $this->Session->read();
		$this->loadModel('DmsMessage');
		$mess=$this->DmsMessage->read(null,$_REQUEST['message_id']);
		
		
							if (!is_dir(FILES_DIR .DS. "uploads"))
                                mkdir(FILES_DIR.DS. "uploads", 0777);
							$extension = end(explode(".", $_SERVER["HTTP_X_FILE_NAME"]));
							$this->data['DmsDocument']['name'] = $_SERVER["HTTP_X_FILE_NAME"];
							$this->data['DmsDocument']['type'] = 'file';
							$this->data['DmsDocument']['user_id'] = $user['Auth']['User']['id'];
							$this->data['DmsDocument']['dms_message_id']=$_SERVER['HTTP_EXTRAPOSTDATA_MESSAGE_ID'];
							$this->data['DmsDocument']['parent_id'] = -2;
							$this->data['DmsDocument']['size'] = $_SERVER["CONTENT_LENGTH"];
							$this->data['DmsDocument']['file_type'] = $this->getfiletype($extension);
							$key = md5(microtime().rand());
							$this->data['DmsDocument']['file_name'] = $key.'.'.$extension; 
                            $file["name"] = $key.'.'.$extension;
							$this->DmsDocument->create();
							$this->DmsDocument->save($this->data);
							$file = file_get_contents('php://input');
							file_put_contents(FILES_DIR.DS . "uploads" . DS . $file["name"], $file);
							foreach($mess['DmsRecipient'] as $recp){
								$this->data['DmsDocument']['user_id']=$recp['user_id'];
								$this->data['DmsDocument']['parent_id']=-1;
								$key = md5(microtime().rand());
								$this->data['DmsDocument']['file_name'] = $key.'.'.$extension; 
								$fromfile=FILES_DIR.DS . "uploads" . DS . $file["name"];
								$newfile=$key.'.'.$extension; 
								if(copy($fromfile, $newfile)){
								$this->DmsDocument->create();
								$this->DmsDocument->save($this->data);
								}
							}
							//print_r($this->data);
							echo '{"success":true}';
		
		
		}
			
	}
	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid dms document', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->DmsDocument->save($this->data)) {
				$this->Session->setFlash(__('The dms document has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The dms document could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('dms__document', $this->DmsDocument->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$users = $this->DmsDocument->User->find('list');
		$parent_dms_documents = $this->DmsDocument->ParentDmsDocument->find('list');
		$this->set(compact('users', 'parent_dms_documents'));
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for dms document', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->DmsDocument->delete($i);
                }
				$this->Session->setFlash(__('Dms document deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Dms document was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->DmsDocument->delete($id)) {
				$this->Session->setFlash(__('Dms document deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Dms document was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>