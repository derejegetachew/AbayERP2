<?php
//use App\libs\SimpleXLSX;
//use Cake\Filesystem\File;
use Vendor\SimpleXLSX;
//App::import('Vendor', 'SimpleXLSX.php');

class InternationalDelinquentsController extends AppController {

	var $name = 'InternationalDelinquents';
	
	function index() {
	}
	

	function search() {
	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';
        // print_r($start." ".$limit);
        // die();

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('international_delinquents', $this->InternationalDelinquent->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));

		$this->set('results', $this->InternationalDelinquent->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid international delinquent', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->InternationalDelinquent->recursive = 2;
		$this->set('internationalDelinquent', $this->InternationalDelinquent->read(null, $id));
	}
	function loop(){
		/*
			//update sttm table
			$delcs=$this->InternationalDelinquent->query('SELECT * FROM `international_delinquents` WHERE 1');
			foreach($delcs as $delc){
				$input_words = Array();
				$input_words = explode(" ",$delc['international_delinquents']['name']);
				$count = sizeof($input_words);
				//-------------------------------------
				$soundex_words = Array();
				$soundex_any="";
				foreach($input_words as  $key =>$word) {
					$soundex_words[$key] = soundex($word);
				}
				$soundex_any = implode(" ", $soundex_words);
				$this->InternationalDelinquent->query("UPDATE `international_delinquents` SET `soundex_name`='".$soundex_any."' WHERE `id`=".$delc['international_delinquents']['id']."");
			}	
			*/
		//update sttm table
		/*
			$delcs=$this->InternationalDelinquent->query('SELECT * FROM `flex_all_customers` WHERE 1');
			foreach($delcs as $delc){
				$input_words = Array();
				$input_words = explode(" ",$delc['flex_all_customers']['name']);
				$count = sizeof($input_words);
				//-------------------------------------
				$soundex_words = Array();
				$soundex_any="";
				foreach($input_words as  $key =>$word) {
					$soundex_words[$key] = soundex($word);
				}
				$soundex_any = implode(" ", $soundex_words);
				$this->InternationalDelinquent->query("UPDATE `flex_all_customers` SET `soundex_name`='".$soundex_any."' WHERE `id`=".$delc['flex_all_customers']['id']."");
			}
		
*/
	}
	function fetch_intdenlq(){
	$this->autoRender = false;
	//$delcs=$this->InternationalDelinquent->query("SELECT * FROM `flex_all_customers` ORDER BY STR_TO_DATE(`creation_date`, '%m/%d/%Y')  DESC LIMIT 1");
	//$lday=$delcs[0]['flex_all_customers']['creation_date'];
	//$lday=date('Y-m-d',strtotime($lday));
	//$tday=date('Y-m-d',strtotime($lday." +30 days"));
/*$con = oci_connect("sms_notification", "Smsnotification#123", '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = fcubsdb0-scan)(PORT = 1521)) (CONNECT_DATA = (SERVICE_NAME = ABAYDB) (SID = ABAYDB)))');
print_r($con);
exit();*/
	$this->loadModel('Flexcube');
		
	$query = "select customer_no, full_name, TO_CHAR(cif_creation_date, 'MM/DD/YYYY')
							from ABYFCLIVE.sttm_customer
						 where rownum < 100";
	
	$customer = $this->Flexcube->query($query);
	print_r($customer);
	exit();
		foreach($customer as $cust){
				$input_words = Array();
				$input_words = explode(" ",$cust['0']['full_name']);
				$count = sizeof($input_words);
				//-------------------------------------
				$soundex_words = Array();
				$soundex_any="";
				foreach($input_words as  $key =>$word) {
					$soundex_words[$key] = soundex($word);
				}
				$soundex_any = implode(" ", $soundex_words);
				$this->InternationalDelinquent->query("INSERT INTO `flex_all_customers`( `name`, `soundex_name`, `account`, `creation_date`) VALUES ('".$cust['0']['full_name']."','".$soundex_any."','".$cust['0']['customer_no']."','".$cust['0']['TO_CHAR(cif_creation_date']."')");
			echo 'done<br>';
		}	
	
	}
	
	function search_intdenlq(){	
$this->autoRender = false;
			//search full text normal
			$result=array();
			$ri=0;
			$delcs=$this->InternationalDelinquent->query('SELECT * FROM `international_delinquents` WHERE 1');
			
			foreach($delcs as $delc){
				$xx=$this->InternationalDelinquent->query("SELECT `branch`,`account`,`name`,MATCH (`name`) AGAINST ('".trim($delc['international_delinquents']['name'])."' IN NATURAL LANGUAGE MODE) AS `relevance` FROM `flex_all_customers` WHERE MATCH (`name`) AGAINST ('".trim($delc['international_delinquents']['name'])."' IN NATURAL LANGUAGE MODE) LIMIT 1");
				//Print_r($xx);
				if($xx[0][0]['relevance']>15){
					$ri++;
					$result[$ri]['name']=date('F d/y');
					$result[$ri]['deliquent_name']=$delc['international_delinquents']['name'];
					$result[$ri]['deliquent_nationality']=$delc['international_delinquents']['Nationality'];
					$result[$ri]['deliquent_source']=$delc['international_delinquents']['source'];
					$result[$ri]['flex_name']=$xx[0]['flex_all_customers']['name'];
					$result[$ri]['sort1']=number_format($xx[0][0]['relevance']);
					$result[$ri]['sort2']=number_format($xx[0][0]['relevance']);
					//$result[$ri]['flex_branch']=$xx[0]['flex_all_customers']['branch'];
					$result[$ri]['flex_account']=$xx[0]['flex_all_customers']['account'];			
					$result[$ri]['type']='search1';
					if($xx[0][0]['relevance']>15 && $xx[0][0]['relevance']<25)
					$result[$ri]['accuracy']='LOW';
					else
					$result[$ri]['accuracy']='MIDIUM';
					
				}
			}	


			//search soundex nested with full text normal
			$delcs=$this->InternationalDelinquent->query('SELECT * FROM `international_delinquents` WHERE 1');
			foreach($delcs as $delc){
				$xx=$this->InternationalDelinquent->query("SELECT `branch`,`account`,`name`,MATCH (`soundex_name`) AGAINST ('".trim($delc['international_delinquents']['soundex_name'])."' IN NATURAL LANGUAGE MODE) AS `relevance` FROM `flex_all_customers` WHERE MATCH (`soundex_name`) AGAINST ('".trim($delc['international_delinquents']['soundex_name'])."' IN NATURAL LANGUAGE MODE) LIMIT 6");
				$too_similar="";
				$sm_pc=0;
				$i=0;$j=0;
				foreach($xx as $x){
				similar_text(strtoupper($delc['international_delinquents']['name']), strtoupper($x['flex_all_customers']['name']), $similarity_pst);
					if (number_format($similarity_pst, 0) > 80){
						$too_similar=$x['flex_all_customers']['name'];
						$sm_pc=number_format($similarity_pst, 0);
						$j=$i;
					}
						$i++;
				}
				if($too_similar!=""){
					if($sm_pc>80){
					$ri++;
						$result[$ri]['name']=date('F d/y');
						$result[$ri]['deliquent_name']=$delc['international_delinquents']['name'];
						$result[$ri]['deliquent_nationality']=$delc['international_delinquents']['Nationality'];
						$result[$ri]['deliquent_source']=$delc['international_delinquents']['source'];
						$result[$ri]['flex_name']=$too_similar;
						$result[$ri]['sort1']=number_format($xx[$j][0]['relevance']);
						$result[$ri]['sort2']=$sm_pc;
						//$result[$ri]['flex_branch']=$xx[$j]['flex_all_customers']['branch'];
						$result[$ri]['flex_account']=$xx[$j]['flex_all_customers']['account'];	
						$result[$ri]['type']='search2';
						if($sm_pc>80 && $sm_pc<90)
							$result[$ri]['accuracy']='MIDIUM';
						else
							$result[$ri]['accuracy']='HIGH';
						}
				}
			}

			

			//search exact
			$delcs=$this->InternationalDelinquent->query('SELECT * FROM `international_delinquents` WHERE 1');
			
			foreach($delcs as $delc){
				$xx = Array();
				$xx=$this->InternationalDelinquent->query("SELECT count(*),`branch`,`account`,`name` FROM `flex_all_customers` WHERE `name` = '".trim($delc['international_delinquents']['name'])."' AND `name` <> ''");
				//Print_r($xx);
				if($xx[0][0]['count(*)']>=1){
				$ri++;
						$result[$ri]['name']=date('F d/y');
						$result[$ri]['deliquent_name']=$delc['international_delinquents']['name'];
						$result[$ri]['deliquent_nationality']=$delc['international_delinquents']['Nationality'];
						$result[$ri]['deliquent_source']=$delc['international_delinquents']['source'];
						$result[$ri]['flex_name']=$xx[0]['flex_all_customers']['name'];
						//$result[$ri]['flex_branch']=$xx[0]['flex_all_customers']['branch'];
						$result[$ri]['flex_account']=$xx[0]['flex_all_customers']['account'];	
						$result[$ri]['type']='exact';
						$result[$ri]['sort2']=100;
						$result[$ri]['accuracy']='HIGH';
					}
				}
				
			
			//Save Result
			foreach($result as $res){
				$sql="INSERT INTO `intdeliq_reports`(`name`, `deliquent_name`, `deliquent_nationality`, `deliquent_source`, `flex_name`, `flex_branch`, `flex_account`, `sort1`, `sort2`, `type`, `accuracy`) VALUES ( '$res[name]','$res[deliquent_name]','$res[deliquent_nationality]','$res[deliquent_source]','$res[flex_name]','$res[flex_branch]','$res[flex_account]','$res[sort1]','$res[sort2]','$res[type]','$res[accuracy]')";
			
			$this->InternationalDelinquent->query($sql);
			}
				
	}
	
	function daily_upload($source=null){
		/*$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
		if($source==1)
		$source='UN';
		else
		$source='DPRK';
		
		$url = 'http://10.1.50.58/unr/redirect.php?source='.$source;

		$downloadedFileContents = file_get_contents($url,false, $context);
		$xmldata = simplexml_load_string($downloadedFileContents);
		$json = json_encode($xmldata);
		$array = json_decode($json,TRUE);
		*/
		$fileName = 'sanction.xml';
		//unlink($fileName);

		if($source==1){
			$newURL="http://scsanctions.un.org/resources/xml/en/consolidated.xml";
			//$newURL="http://10.1.50.177/resources/xml/en/consolidated.xml";
			$source='UN';
		}
		elseif($source==2){
			$newURL="http://www.treasury.gov/ofac/downloads/consolidated/consolidated.xml";//URL to access OFAC consolidated list
			//$newURL="http://10.1.50.177/resources/xml/en/consolidated.xml";
			$source='OFAC';
		}
		else{
			$newURL="http://scsanctions.un.org/dprk";
			//$newURL="http://10.1.50.177/dprk";
			$source='DPRK';
		}
		//header('Location: '.$newURL);
		$sProxyUrl='10.1.50.177:80';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $newURL); // Target URL
		curl_setopt($ch, CURLOPT_PROXY, $sProxyUrl); // Proxy IP:Port
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, FALSE);
		// curl_setopt($ch, CURLOPT_PROXYUSERPWD, "proxy_user:pass"); // Proxy Username/Password
		curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 600);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:5.0) Gecko/20100101 Firefox/5.0'); // some browser user agent string
		curl_setopt($ch, CURLOPT_REFERER, $newURL);
		$aHeaders = array( 'Expect:', 
		  'Accept-Language: en-us; q=0.5,en; q=0.3', 
		  'Accept: text/html,application/xhtml+xml,application/xml; q=0.9,*/*; q=0.8');
		 curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeaders);
		$result = curl_exec($ch);
		//print_r($result);
		$xmldata = simplexml_load_string($result);
		$json = json_encode($xmldata);
		$array = json_decode($json,TRUE);
		
		curl_close($ch);
		$svr=array();
		if($source == 'OFAC')//if OFAC
		{
			foreach($array['sdnEntry'] as $xml)
			{
				if(!array_key_exists($xml['uid'],$svr))
				{
					$svr[$xml['uid']]['id']=$xml['uid'];//$xml['uid'] = 6908555
				}
				$sdnType = isset($xml['sdnType']) && !empty($xml['sdnType'])?$xml['sdnType']:"";
				$svr[$xml['uid']]['sdnType']=$sdnType;
				if ($sdnType == "Individual")//For individuals 
				{
					if($xml['firstName']!=''){
						if(!array_key_exists($xml['uid'],$svr))
							$svr[$xml['uid']]['id']=$xml['uid'];//$xml['uid'] = 6908555
							
						if(array_key_exists('name',$svr[$xml['uid']])){
							if(!(strlen($xml['firstName']) != strlen(utf8_decode($xml['firstName']))))
							  $svr[$xml['uid']]['name']=$xml['firstName'].' '.$xml['lastName'];
						}else
							$svr[$xml['uid']]['name']=$xml['firstName'].' '.$xml['lastName'];
					}
					if(isset($xml['placeOfBirthList']['placeOfBirthItem']['placeOfBirth']))//Nationality  
					{	
						if(strlen($xml['placeOfBirthList']['placeOfBirthItem']['placeOfBirth'])>1)
						{
							$svr[$xml['uid']]['Nationality']=$xml['placeOfBirthList']['placeOfBirthItem']['placeOfBirth'];				
						}
					}							
					
				} 
				else//for Companies 
				{
					$lastName = isset($xml['lastName']) && !empty($xml['lastName'])?$xml['lastName']:"";
					$svr[$xml['uid']]['name'] = $lastName;
				}
				$svr[$xml['uid']]['BOD'] = (isset($xml['dateOfBirthList']['dateOfBirthItem']['dateOfBirth']) && !empty($xml['dateOfBirthList']['dateOfBirthItem']['dateOfBirth'])) ? $xml['dateOfBirthList']['dateOfBirthItem']['dateOfBirth'] : "" ;

				if(isset($xml['placeOfBirthList']['placeOfBirthItem']['placeOfBirth']))//Nationality  
				{	
					if(strlen($xml['placeOfBirthList']['placeOfBirthItem']['placeOfBirth'])>1)
					{
						$svr[$xml['uid']]['Nationality']=$xml['placeOfBirthList']['placeOfBirthItem']['placeOfBirth'];				
					}
				}
				else
				{
					$svr[$xml['uid']]['Nationality'] = "";
				}	
			}
		}
		else
		{
			foreach($array['INDIVIDUALS']['INDIVIDUAL'] as $xml){
				if($xml['FIRST_NAME']!=''){
					if(!array_key_exists($xml['DATAID'],$svr))
						$svr[$xml['DATAID']]['id']=$xml['DATAID'];//$xml['DATAID'] = 6908555
						
					if(array_key_exists('name',$svr[$xml['DATAID']])){
						if(!(strlen($xml['FIRST_NAME']) != strlen(utf8_decode($xml['FIRST_NAME']))))
						  $svr[$xml['DATAID']]['name']=$xml['FIRST_NAME'].' '.$xml['SECOND_NAME'].' '.$xml['THIRD_NAME'];
					}else
						$svr[$xml['DATAID']]['name']=$xml['FIRST_NAME'].' '.$xml['SECOND_NAME'].' '.$xml['THIRD_NAME'];
				}//extracts full name and stores data at $xml['DATAID'] index of $svr array							
				if(isset($xml['INDIVIDUAL_DATE_OF_BIRTH']) && !empty($xml['INDIVIDUAL_DATE_OF_BIRTH']))
						$svr[$xml['DATAID']]['BOD']=implode(" / ",$xml['INDIVIDUAL_DATE_OF_BIRTH']);//Date of birts
				if(isset($xml['NATIONALITY']['VALUE']))//Nationality	
					if(strlen($xml['NATIONALITY']['VALUE'])>1)
						$svr[$xml['DATAID']]['Nationality']=$xml['NATIONALITY']['VALUE'];					
			}
			foreach($array['ENTITIES']['ENTITY'] as $xml){
				if($xml['FIRST_NAME']!=''){
					if(!array_key_exists($xml['DATAID'].'C',$svr))//Extracts id from entity
						$svr[$xml['DATAID'].'C']['id']=$xml['DATAID'];
						
					if(array_key_exists('name',$svr[$xml['DATAID'].'C'])){
						if(!(strlen($xml['FIRST_NAME']) != strlen(utf8_decode($xml['FIRST_NAME']))))
						  $svr[$xml['DATAID'].'C']['name']=$xml['FIRST_NAME'];//first name
					}else
						$svr[$xml['DATAID'].'C']['name']=$xml['FIRST_NAME'];
				}
			}
		}

				
		if(!empty($svr)){			
			$this->InternationalDelinquent->query("DELETE FROM `international_delinquents` WHERE `source`='".$source."'");
			foreach($svr as $svd)
			{
				$input_words = Array();
				$input_words = explode(" ",$svd['name']);
				$count = sizeof($input_words);
				//-------------------------------------
				$soundex_words = Array();
				$soundex_any="";
				foreach($input_words as  $key =>$word) 
				{
					$soundex_words[$key] = soundex($word);
				}
				$soundex_any = implode(" ", $soundex_words);
				
				$this->InternationalDelinquent->query("INSERT INTO `international_delinquents`( `name`, `soundex_name`, `Nationality`, `BOD`,`source`) VALUES ('".mysql_real_escape_string($svd['name'])."','".mysql_real_escape_string($soundex_any)."','".mysql_real_escape_string($svd['Nationality'])."','".$svd['BOD']."','".$source."')");
			}
		}
			//---------------------
	}
	function upload($id = null) 
	{
		if (!empty($this->data)) 
		{			
			
			$this->autoRender = false;
			$this->layout = 'ajax'; 
	
		
			$file = $this->data['InternationalDelinquent']['file'];
            $file_name = basename($file['name']);
            $fext = substr($file_name, strrpos($file_name, "."));
            $fname = time(); // str_replace($fext, "", $file_name);
            $file_name = $fname . $fext;

           if (!is_dir('files' .DS. "sanctions"))
                mkdir('files'  .DS. 'sanctions', 0777);

            if (!move_uploaded_file($file['tmp_name'], 'files'  .DS. 'sanctions' . DS . $file_name)) 
            {
                $file_name = 'No file';
            }           
			$svr=array();
			$check = true;
			// var_dump($this->data['InternationalDelinquent']['source']);
			// die();
			$src= $this->data['InternationalDelinquent']['source'];
			if($this->data['InternationalDelinquent']['source']=='UN' || $this->data['InternationalDelinquent']['source']=='DPRK'){
				$xmldata = simplexml_load_file('files'  .DS. 'sanctions' . DS . $file_name) or die("Failed to load");
				//print_r($xmldata);
				$json = json_encode($xmldata);
				$array = json_decode($json,TRUE);
				//print_r($array['ENTITIES']['ENTITY']);
				
				foreach($array['INDIVIDUALS']['INDIVIDUAL'] as $xml)
				{
					if($xml['FIRST_NAME']!='')
					{
						if(!array_key_exists($xml['DATAID'],$svr))
							$svr[$xml['DATAID']]['id']=$xml['DATAID'];
							
						if(array_key_exists('name',$svr[$xml['DATAID']])){
							if(!(strlen($xml['FIRST_NAME']) != strlen(utf8_decode($xml['FIRST_NAME']))))
							  $svr[$xml['DATAID']]['name']=$xml['FIRST_NAME'].' '.$xml['SECOND_NAME'].' '.$xml['THIRD_NAME'];
						}else
							$svr[$xml['DATAID']]['name']=$xml['FIRST_NAME'].' '.$xml['SECOND_NAME'].' '.$xml['THIRD_NAME'];
					}
							
					if(isset($xml['INDIVIDUAL_DATE_OF_BIRTH']) && !empty($xml['INDIVIDUAL_DATE_OF_BIRTH']))
							$svr[$xml['DATAID']]['BOD']=implode(" / ",$xml['INDIVIDUAL_DATE_OF_BIRTH']);
					if(isset($xml['NATIONALITY']['VALUE']))	
						if(strlen($xml['NATIONALITY']['VALUE'])>1)
							$svr[$xml['DATAID']]['Nationality']=$xml['NATIONALITY']['VALUE'];
					
				}
				foreach($array['ENTITIES']['ENTITY'] as $xml)
				{
					if($xml['FIRST_NAME']!=''){
						if(!array_key_exists($xml['DATAID'].'C',$svr))
							$svr[$xml['DATAID'].'C']['id']=$xml['DATAID'];
							
						if(array_key_exists('name',$svr[$xml['DATAID'].'C'])){
							if(!(strlen($xml['FIRST_NAME']) != strlen(utf8_decode($xml['FIRST_NAME']))))
							  $svr[$xml['DATAID'].'C']['name']=$xml['FIRST_NAME'];
						}
						else
							$svr[$xml['DATAID'].'C']['name']=$xml['FIRST_NAME'];
					}
				}
			}
			
			if($this->data['InternationalDelinquent']['source']=='EU'){
				if (file_exists('files'  .DS. 'sanctions' . DS . $file_name)){
					$handle = fopen('files'  .DS. 'sanctions' . DS . $file_name, "r");
				  $ix=0;
					while (($datax = fgetcsv($handle, 1000, ";")) !== FALSE) {
						if($ix>0){
						
								if($datax[17]!=''){
									if(!array_key_exists($datax[1],$svr))
										$svr[$datax[1]]['id']=$datax[1];
										
									if(array_key_exists('name',$svr[$datax[1]])){
										if(!(strlen($datax[17]) != strlen(utf8_decode($datax[17]))))
										$svr[$datax[1]]['name']=$datax[17];
									}else
										$svr[$datax[1]]['name']=$datax[17];
								}
								if(strlen($datax[40])>1)
									$svr[$datax[1]]['BOD']=$datax[40];
								if(strlen($datax[41])>1)
									$svr[$datax[1]]['Nationality']=$datax[41];

						}						
							
						$ix++;
					}
					fclose($handle);
				}
			}
			if($this->data['InternationalDelinquent']['source']=='OFAC')
			{
				$xmldata = simplexml_load_file('files'  .DS. 'sanctions' . DS . $file_name) or die("Failed to load");
				$json = json_encode($xmldata);
				$array = json_decode($json,TRUE);
				foreach($array['sdnEntry'] as $xml)
				{
					if(!array_key_exists($xml['uid'],$svr))
					{
						$svr[$xml['uid']]['id']=$xml['uid'];//$xml['uid'] = 6908555
					}
					$sdnType = isset($xml['sdnType']) && !empty($xml['sdnType'])?$xml['sdnType']:"";
					$svr[$xml['uid']]['sdnType']=$sdnType;
					if ($sdnType == "Individual") 
					{
						if($xml['firstName']!=''){
							if(!array_key_exists($xml['uid'],$svr))
								$svr[$xml['uid']]['id']=$xml['uid'];//$xml['uid'] = 6908555
								
							if(array_key_exists('name',$svr[$xml['uid']])){
								if(!(strlen($xml['firstName']) != strlen(utf8_decode($xml['firstName']))))
								  $svr[$xml['uid']]['name']=$xml['firstName'].' '.$xml['lastName'];
							}else
								$svr[$xml['uid']]['name']=$xml['firstName'].' '.$xml['lastName'];
						}
						if(isset($xml['placeOfBirthList']['placeOfBirthItem']['placeOfBirth']))//Nationality  
						{	
							if(strlen($xml['placeOfBirthList']['placeOfBirthItem']['placeOfBirth'])>1)
							{
								$svr[$xml['uid']]['Nationality']=$xml['placeOfBirthList']['placeOfBirthItem']['placeOfBirth'];				
							}
						}							
						
					} 
					else 
					{
						$lastName = isset($xml['lastName']) && !empty($xml['lastName'])?$xml['lastName']:"";
						$svr[$xml['uid']]['name'] = $lastName;
					}

					if(isset($xml['dateOfBirthList']['dateOfBirthItem']['dateOfBirth']) && !empty($xml['dateOfBirthList']['dateOfBirthItem']['dateOfBirth']))
					{
							$svr[$xml['uid']]['BOD']=$xml['dateOfBirthList']['dateOfBirthItem']['dateOfBirth'];
					}
					else
					{
						$svr[$xml['uid']]['BOD'] = "";
					}
					if(isset($xml['placeOfBirthList']['placeOfBirthItem']['placeOfBirth']))//Nationality  
					{	
						if(strlen($xml['placeOfBirthList']['placeOfBirthItem']['placeOfBirth'])>1)
						{
							$svr[$xml['uid']]['Nationality']=$xml['placeOfBirthList']['placeOfBirthItem']['placeOfBirth'];				
						}
					}
					else
					{
						$svr[$xml['uid']]['Nationality'] = "";
					}	
				}
				
			}
			if($src=='PEP')
			{
				if (file_exists('files'  .DS. 'sanctions' . DS . $file_name)){
					$handle = fopen('files'  .DS. 'sanctions' . DS . $file_name, "r");
					for ($i = 0; $datax = fgetcsv($handle ); ++$i) {
						$num = count($datax);
						if ($i==0) continue;
						$id = $datax[0];
						$name = $datax[1];
						$amh_name = $datax[2];
						$position = $datax[3];
						$place_of_assignment = $datax[4];
						$detail = $datax[5];
						//$svr[$id]['id']=$id;
						$svr[$id]['name']=$name;
						//$svr[$id]['Nationality']="Ethiopian";
						//$svr[$id]['BOD']="Ethiopian";
						// echo $id . " ".$name . " ".$amh_name . " ".$position. " ".$place_of_assignment. " ".$detail . "<br />\n";
					}
					fclose($handle);
				}
			
				//print_r($svr);die();
			}
			if(!empty($svr))
			{	
				$this->InternationalDelinquent->query("DELETE FROM `international_delinquents` WHERE `source`='".$this->data['InternationalDelinquent']['source']."'");
				if($src=='PEP')
				{
					$nationality = "Ethiopian";
					$bod = "";
					foreach($svr as $svd){
						$input_words = Array();
						$input_words = explode(" ",$svd['name']);
						$count = sizeof($input_words);
						//-------------------------------------
						$soundex_words = Array();
						$soundex_any="";
						foreach($input_words as  $key =>$word) {
							$soundex_words[$key] = soundex($word);
						}
						$soundex_any = implode(" ", $soundex_words);
						$this->InternationalDelinquent->query("INSERT INTO `international_delinquents`( `name`, `soundex_name`, `Nationality`, `BOD`,`source`) 
						VALUES ('".mysql_real_escape_string($svd['name'])."','".mysql_real_escape_string($soundex_any)."','".mysql_real_escape_string($nationality)."',
									'".$bod."','".$src."')");
					}
				}
				else
				{
					foreach($svr as $svd){
						$input_words = Array();
						$input_words = explode(" ",$svd['name']);
						$count = sizeof($input_words);
						//-------------------------------------
						$soundex_words = Array();
						$soundex_any="";
						foreach($input_words as  $key =>$word) {
							$soundex_words[$key] = soundex($word);
						}
						$soundex_any = implode(" ", $soundex_words);
						
						$this->InternationalDelinquent->query("INSERT INTO `international_delinquents`( `name`, `soundex_name`, `Nationality`, `BOD`,`source`) VALUES ('".mysql_real_escape_string($svd['name'])."','".mysql_real_escape_string($soundex_any)."','".mysql_real_escape_string($svd['Nationality'])."','".$svd['BOD']."','".$this->data['InternationalDelinquent']['source']."')");
					}
				}
			}
			else
				$check=false;
			
			if($check == true){
				$this->Session->setFlash(__('Process Completed Successfuly!', true), '');
				$this->render('/elements/success');
			}
			else {
				$this->Session->setFlash(__('Error!', true), '');
				$this->render('/elements/failure');
			}			
		}
	}
	function add($id = null) {
		if (!empty($this->data)) {
			$this->InternationalDelinquent->create();
			$this->autoRender = false;
			if ($this->InternationalDelinquent->save($this->data)) {
				$this->Session->setFlash(__('The international delinquent has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The international delinquent could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid international delinquent', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->InternationalDelinquent->save($this->data)) {
				$this->Session->setFlash(__('The international delinquent has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The international delinquent could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('international_delinquent', $this->InternationalDelinquent->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for international delinquent', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->InternationalDelinquent->delete($i);
                }
				$this->Session->setFlash(__('International delinquent deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('International delinquent was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->InternationalDelinquent->delete($id)) {
				$this->Session->setFlash(__('International delinquent deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('International delinquent was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>