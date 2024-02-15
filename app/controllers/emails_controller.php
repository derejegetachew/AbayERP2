<?php

require_once(APPLIBS . DS . "PHPMailer" . DS . "class.phpmailer.php");

class EmailsController extends AppController {

    var $name = 'Emails';

    function index() {
        
    }

    function search() {
        
    }

    function batch_emails($id = null) {
        $this->autoRender = false;
        while (1 == 1) {
            $conditions['Email.status'] = 'not_sent';
            $email = $this->Email->find('first', array('conditions' => $conditions));

            if (empty($email))
                break;
            //foreach($emails as $email){
            if ($this->smtpmailer($email['Email']['to'], $email['Email']['from'], $email['Email']['from_name'], $email['Email']['name'], $email['Email']['body'], false)) {
                $this->data['Email']['id'] = $email['Email']['id'];
                $this->data['Email']['status'] = 'sent';
                $this->Email->save($this->data);
            }
            sleep(4);
        }
    }

    function smtpmailer($to, $from, $from_name, $subject, $body, $is_gmail = true) {

        $mail = new PHPMailer();  // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only

        $mail->SMTPAuth = true;  // authentication enabled
        if ($is_gmail) {
            $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->Username = 'abay.erp@gmail.com';
            $mail->Password = 'X@43_mayl';
        } else {
            //$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
            $mail->SMTPSecure = 'tls';
            $mail->Host = '172.16.254.10';
            $mail->Port = 25;
            $mail->Username = 'abayERP';
            $mail->Password = '123456';
        }

        $mail->SetFrom($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->IsHTML(true);
        $mail->AddAddress($to);
        if (!$mail->Send()) {
            return 'Mail error: ' . $mail->ErrorInfo;
        } else {
            return true;
        }
    }

    function list_data($id = null) {
        $start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
        $limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");

        $this->set('emails', $this->Email->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
        $this->set('results', $this->Email->find('count', array('conditions' => $conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid email', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Email->recursive = 2;
        $this->set('email', $this->Email->read(null, $id));
    }

    function add($id = null) {
        if (!empty($this->data)) {
            $this->Email->create();
            $this->autoRender = false;
            if ($this->Email->save($this->data)) {
                $this->Session->setFlash(__('The email has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The email could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
    }

    function edit($id = null, $parent_id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid email', true), '');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $this->autoRender = false;
            if ($this->Email->save($this->data)) {
                $this->Session->setFlash(__('The email has been saved', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('The email could not be saved. Please, try again.', true), '');
                $this->render('/elements/failure');
            }
        }
        $this->set('email', $this->Email->read(null, $id));
    }

    function delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for email', true), '');
            $this->render('/elements/failure');
        }
        if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try {
                foreach ($ids as $i) {
                    $this->Email->delete($i);
                }
                $this->Session->setFlash(__('Email deleted', true), '');
                $this->render('/elements/success');
            } catch (Exception $e) {
                $this->Session->setFlash(__('Email was not deleted', true), '');
                $this->render('/elements/failure');
            }
        } else {
            if ($this->Email->delete($id)) {
                $this->Session->setFlash(__('Email deleted', true), '');
                $this->render('/elements/success');
            } else {
                $this->Session->setFlash(__('Email was not deleted', true), '');
                $this->render('/elements/failure');
            }
        }
    }

}

?>