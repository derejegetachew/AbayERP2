<?php
class TextMessagesController extends AppController {

	var $name = 'TextMessages';
	
	function index() {
	}
	
	function getPhone($data = '', $multi = false) {
		$data = str_replace('/', ' ', $data);
		$data = str_replace('.', '. ', $data);
		$data = str_replace(',', ' ', $data);
		$data = str_replace('  ', ' ', $data);
		
		$numbers = explode(' ', $data);
		$nums = '';
		foreach($numbers as $to) {
			// clear the $to data
			$to = str_replace('-', '', $to);
			$to = str_replace('+', '', $to);
			
			$findme   = '251'; // it starts with 251
			$pos = strpos($to, $findme);
			if($pos !== false && $pos == 0) {
				$to = substr($to, 1);
			}
			$findme   = '2510'; // it starts with 2510
			$pos = strpos($to, $findme);
			if($pos !== false && $pos == 0) {
				$to = '2519' . substr($to, 5);
			}
			$findme   = '09'; // it starts with 09
			$pos = strpos($to, $findme);
			if($pos !== false && $pos == 0 && substr($to, 0, 3) != '251') {
				$to = '2519' . substr($to, 2);
			}

			$findme   = '9'; // it starts with 9
			$pos = strpos($to, $findme);
			if($pos !== false && $pos == 0 && substr($to, 0, 3) != '251') {
				$to = '2519' . substr($to, 1);
			}

			// finally
			if(substr($to, 0, 4) != '2519' || strlen($to) != 12) {
				// leave it
			} else {
				if($multi){
					if($nums != '')
						$nums .= ',' . $to;
					else
						$nums = $to;
				} else {
					return $to;
				}
			}
		}
		return $nums;
	}
	
	function getPhone2($data = '', $multi = false, $cif = '') {
		$original_data = $data;
		$data = str_replace('/', ' ', $data);
		$data = str_replace('.', '. ', $data);
		$data = str_replace(',', ' ', $data);
		$data = str_replace('  ', ' ', $data);
		$findme   = '251'; // it starts with 251
		$pos = strpos($data, $findme);
		if($pos !== FALSE && $pos == 0){
			$data = '+' . $data;
		}
		$data = str_replace(' 251', ' +251', $data);
		$data = str_replace('+2510', '0', $data);
		$data = str_replace('+251-0', '0', $data);
		$data = str_replace('+251', '0', $data);
		$data = str_replace('-', '', $data);
		
		$alphas = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", ":", "*");
		$data = str_replace($alphas, '', strtoupper($data));
		
		$numbers = explode(' ', $data);
		$nums = '';
		foreach($numbers as $to) {
			// clear the $to data
			$to = str_replace('-', '', $to);
			$to = str_replace('+', '', $to);
			
			$findme   = '251'; // it starts with 251
			$pos = strpos($to, $findme);
			if($pos !== false && $pos == 0) {
				//$to = substr($to, 3);
			}
			$findme   = '2510'; // it starts with 2510
			$pos = strpos($to, $findme);
			if($pos !== false && $pos == 0) {
				$to = '2519' . substr($to, 5);
			}
			$findme   = '09'; // it starts with 09
			$pos = strpos($to, $findme);
			if($pos !== false && $pos == 0 && substr($to, 0, 3) != '251') {
				$to = '2519' . substr($to, 2);
			}

			$findme   = '9'; // it starts with 9
			$pos = strpos($to, $findme);
			if($pos !== false && $pos == 0 && substr($to, 0, 3) != '251') {
				$to = '2519' . substr($to, 1);
			}

			// finally
			if(substr($to, 0, 4) != '2519' || strlen($to) != 12) {
				// leave it
			} else {
				if($multi){
					if($nums != ''){
						if(strpos($nums, $to) === FALSE) {
							$nums .= ',' . $to;
						}
					} else {
						$nums = $to;
					}
				} else {
					return $to;
				}
			}
		}
		if($nums == ''){
			//$this->log('Got ' . $nums . ' from ' . $original_data . ' (CIF: ' . $cif . ')', 'pphone');
		}
		return $nums;
	}

	function list_clear_phones() {
		$this->layout = 'ajax';
		$listfile = 'atm3';
		$spaceline="                                                                                                               ";
		//$message = "???? ?????? ??? ?.?. ???????? ??? ?????? ???? ??? ????? ????????? ??????? ?????? ?? ??? (25%) ?????? ????? ?????? ??? 750 ???? ?? ???????                                 ???????? ?? ??? ??????? ???????? ????? ??.?? ?? ?? ?? ???? ?????? ???????? ?? ??? (25%) ??????? ???????? ?????? ??? ??? ???? ???? 30 ?? 2009 ?.? ????? ??? ??????? ???? ??? ????? ???????                                             ???? ????                                                  ???? ????";
		//$messagelong="????? ???? ??? ????!";
		
		
		
		$row = 0;
		$count = 0;
		if (($handle = fopen(IMAGES . "$listfile.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			
			$messagelong="ውድ የዓባይ ባንክ ወኪል";
			
			//$messagelong="Dear Abay Bank Customer!";
			//$messagelong="Dear Abay Bank's Agent!";
		//$messagelong.=$spaceline."?? 25 ?? 2009 ?.?. ?????? ??? ???? ???? ?? ????? ???? ????? ?????? ???? ????? ?????? ?????? ???????? ???? ??????? ?? 7 ?? 2009 ?.?. ???? ??? ??? ??? ?? ??????? ???????::".$spaceline."???????? ???";
		//$messagelong.=$spaceline."??? ??? ???? ????? ????? ?????? ?????? ????? ??? ????? ???????? ????? ??? ??? ?????? ????????? ????? ??????? ???? ?????? ???? ??? ????? ?????? ????? ???? ?????? ?????  ???? ??? '" . $data[1] . "' ???? ??? ????? ??????? ????? *812[[HASH]] ????? ?? ??????? ???? ??? (??)  '" . $data[2] . "' ?????? ???? ????? ???? ??? ????? www.abaybank.com.et / mobile_activation / ???? ??? : + 215-115-571229 ?????";
		
		//$messagelong.=$spaceline."Kindly update your Abay Mobile Banking to version 1.0.4. Go to Play Store, search 'Abay Mobile Banking' and press 'Update'. Version 1.0.4 includes very important updates. Thank you for choosing Abay Bank.";
		//$messagelong.=$spaceline."This is a gentle reminder for you to migrate your Abay Mobile Banking application if you haven't yet done so. Your Token is '" . $data[1] . "' for Application and PIN '" . $data[2] . "' for Short code (*812[[HASH]]). Download application from www.abaybank.com.et/downloads/mobile/abay.apk or Google Play (abay mobile banking ). For more information Call: 251-115-571229";
		$messagelong.=$spaceline."የዓባይ በደጄን የውክልና ባንክ አገልግሎት ለመስጠት መመዝገቦ ይታወቃል ነገር ግን በተለያየ ምክንያት እስከ አሁን ድረስ ሞባይል ስልክዎ ላይ የተጫነልዎን ወይም በ*812[[HASH]] አጭር ኮድ የሚሰጡትን የውክልና ባንክ አገልግሎቶች አልተጠቀሙበትም፡፡ ለመጠቀም ያስቸገርዎ ነገር ካለ ወይም ፒን ኮድ ከቅርንጫፍዎ ካልወሰዱ የተመዘገቡበትን ቅርንጫፍ እንዲያነጋግሩ ወይንም ዋናው መስሪያ ቤት የሚገኙ የደንበኛ አገልግሎትን በ ስልክ ቁጥር +251-115-571229 እንዲያነጋግሩ በትህትና እንጠይቃለን፡፡ ለትብብርዎ እናመሰግናልን!";
		$messagelong.=$spaceline."ዓባይ ባንክ አ.ማ.";
		
		
		//$messagelongEn="To All Abay Industrial Development S.C. Shareholders";		
		
		$message2 = $messagelong;
		$message_html2 = str_replace(' ', '+', $message2);
		//$message_html2 = encodeURIComponent($message_html2);
		
				$num = count($data);
				$row++;
				$d = $data[0];
				$d = str_replace('+251', '0', $d);
				//for ($c=0; $c < $num; $c++) {
				//	echo $data[$c] . "<br />\n";
				//}
				if($d <> ''){
					$phones = explode(' ', $d);
					foreach($phones as $phone) {
						$p = $this->getPhone2($phone,true);
						//echo $p . '<br/>';
						if($p <> '') {
						$pieces = explode(",", $p);
							foreach($pieces as $piece){
								$count++;
								
								//@file_get_contents("http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to=$piece&msg=$message_html2");
								echo 'Sent to '.$count.'::' . $piece . '<br/>';
							}
						}
					}
				}
			}
			fclose($handle);
		}
		$this->log($count . ' items sent out of ' . $row . ' for branch ' . $listfile, 'shareholdersending');
		$this->set('msg', '');
	}
	function send_it() {
		$this->layout = 'ajax';
		$listfile = 'atm3';//shlist for test
		$spaceline="                                                                                                                                              ";
		
		//$messagelong="Dear Applicants; ".$spaceline;
		//$messagelong.="You will have interview exam for the post of Client Relations Officer II";
		//$messagelong.=" at Head Office , A/A Saturday December 09, 2017 at 3:30 -local time/Morning/";
		//$messagelong.=$spaceline."Abay Bank S.C";
		//$messagelong="???? ?????? ??? ? /? ???????? ???";
		//$messagelong.=$spaceline."???? ??? ?/????? ??? ??? ?? ????? ???? ????? ?? ????? ????? ?????? ??? ?????? ?????? ??? ?????? ???? ?????? ???? ?????? ????? ??????? ??????? ????? ???? ???? ?????? 50% ??? ???????? ??? ???? 30/2010 ??? ???????? ????????";
		//$messagelong.=$spaceline."???????? ???";
		
		$messagelong="ውድ የዓባይ ባንክ ደንበኛ";
		$messagelong.=$spaceline."የኤቲኤም ካርድ እንዲሰጥዎ መጠየቅዎ ይታወቃል ነገር ግን በተለያየ ምክንያት እስከ አሁን ድረስ ካርድዎን አልወሰዱም ወይንም አልተጠቀሙበትም፡፡ በተሰጥዎት ካርድ ላይ ችግር ካለ ወይም ካርዱን ከቅርንጫፍዎ ካልወሰዱ የተመዘገቡበትን ቅርንጫፍ እንዲያነጋግሩ በትህትና እንጠይቃለን፡፡ ለትብብርዎ እናመሰግናልን!";
		$messagelong.=$spaceline."ዓባይ ባንክ አ.ማ.";
		
		$message_html2 = str_replace(' ', '+', $messagelong);
				
		$row = 0;
		$count = 0;
		if (($handle = fopen(IMAGES . "$listfile.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	
		//$message_html2 = encodeURIComponent($message_html2);
		
				$num = count($data);
				$row++;
				$d = $data[0];
				$d = str_replace('+251', '0', $d);
				//for ($c=0; $c < $num; $c++) {
				//	echo $data[$c] . "<br />\n";
				//}
				if($d <> ''){
					$phones = explode(' ', $d);
					foreach($phones as $phone) {
						$p = $this->getPhone2($phone,true);
						//echo $p . '<br/>';
						if($p <> '') {
						$pieces = explode(",", $p);
							foreach($pieces as $piece){
								$count++;
								
								//@file_get_contents("http://10.1.85.10/sms_manager/send.php?redirect='.urlencode($_SERVER["REDIRECT_URL"]).'&to=$piece&msg=$message_html2");
								echo 'Sent to '.$count.'::' . $piece . '<br/>';
							}
						}
					}
				}
			}
			fclose($handle);
		}
		$this->log($count . ' items sent out of ' . $row . ' for branch ' . $listfile, 'shareholdersending');
		$this->set('msg', '');
	}
	function search() {
	}
        
        
            function batch_messages(){
               $this->autoRender = false;
		$conditions['TextMessage.status']='not_sent';
		$messages=$this->TextMessage->find('all', array('conditions' => $conditions));
                foreach($messages as $message){
                    
                    $this->sms(substr($message['TextMessage']['name'], 1), $message['TextMessage']['text']);
                    $this->data['id']=$message['TextMessage']['id'];
                    $this->data['status']='sent';
                    $this->TextMessage->save($this->data);
                    //print_r($this->data);
                    
                }
        }
        
	function sms($from,$text){
        $this->autoRender = false;
       /* shell_exec('cd\\');
        shell_exec('cd GalaxyS2RootNew\files');
        shell_exec('adb wait-for-device');
        shell_exec('adb shell am start -a android.intent.action.SENDTO -d sms:+251912179525 --es sms_body "PHP Automated" --ez exit_on_sent true');
        //exec('adb shell input keyevent 66');
        * 
        */
     $unixtime = time();

// Sets up your exe or other path.
$cmd = 'C:\\GalaxyS2RootNew\\files\\adb.exe';

// Setup an array of arguments to be sent.
$arg[] = '1';
$arg[] = '2';
$arg[] = '3';
$arg[] = '4';
$arg[] = '5';

// Pick a place for the temp_file to be placed.
$outputfile = 'C:\\GalaxyS2RootNew\\files\\tmp\\unixtime.txt';

// Setup the command to run from "run"
//$cmdline = "cmd /C $cmd " . implode(' ', $arg) . " > $outputfile";
sleep(1);
$cmdx= 'shell am start -a android.intent.action.SENDTO -d sms:+251'.$from.' --es sms_body "'.$text.'" --ez exit_on_sent true';
$cmdline = "cmd /C $cmd " . $cmdx; 
// Make a new instance of the COM object
$WshShell = new COM("WScript.Shell"); 

// Make the command window but don't show it.
$oExec = $WshShell->Run($cmdline, 0, true);
sleep(2);
$cmdx= "shell input keyevent 66";
$cmdline = "cmd /C $cmd " . $cmdx;
$oExec = $WshShell->Run($cmdline, 0, true);
// Read the file file.
$output = file($outputfile);

//print_r($output);
// Delete the temp_file.
//unlink($outputfile);
        //print_r($cmd);
       // echo $rtn;
    }
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		
		$this->set('text_messages', $this->TextMessage->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->TextMessage->find('count', array('conditions' => $conditions)));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid text message', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->TextMessage->recursive = 2;
		$this->set('textMessage', $this->TextMessage->read(null, $id));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$this->TextMessage->create();
			$this->autoRender = false;
			if ($this->TextMessage->save($this->data)) {
				$this->Session->setFlash(__('The text message has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The text message could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid text message', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->autoRender = false;
			if ($this->TextMessage->save($this->data)) {
				$this->Session->setFlash(__('The text message has been saved', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('The text message could not be saved. Please, try again.', true), '');
				$this->render('/elements/failure');
			}
		}
		$this->set('text__message', $this->TextMessage->read(null, $id));
		
			
	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for text message', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->TextMessage->delete($i);
                }
				$this->Session->setFlash(__('Text message deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Text message was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->TextMessage->delete($id)) {
				$this->Session->setFlash(__('Text message deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Text message was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>