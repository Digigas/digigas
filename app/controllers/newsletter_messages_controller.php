<?php
class NewsletterMessagesController extends AppController {

    var $name = 'NewsletterMessages';
    var $components = array('Email');
    var $helpers = array('Absolutize');

    function beforeFilter() {
        $this->set('activemenu_for_layout', 'tools');
		$this->set('title_for_layout', __('Newsletter', true));

        parent::beforeFilter();
    }

    function admin_index() {
        $this->NewsletterMessage->recursive = 0;
        $this->paginate = array('order' => 'sent_date desc');
        $this->set('newsletterMessages', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('%s non valida', true), 'Newsletter'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('newsletterMessage', $this->NewsletterMessage->read(null, $id));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->NewsletterMessage->create();

            //imposto valori di default
            $this->data['NewsletterMessage']['user_id'] = $this->Auth->user('id');
            $this->data['NewsletterMessage']['sent_date'] = null;
            if(empty($this->data['NewsletterMessage']['reply_to']))
            {
                $this->data['NewsletterMessage']['reply_to'] = Configure::read('email.from');
            }

            $message = $this->NewsletterMessage->save($this->data);
            if ($message && $this->_send($message)) {
                $this->NewsletterMessage->saveSentDate($this->NewsletterMessage->getInsertId());
                $this->Session->setFlash(__('Il messaggio è stato inviato correttamente', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Si è verificato un errore nell\'invio del messaggio, riprova', true));
            }
        }
        $usergroups = $this->NewsletterMessage->Usergroup->generatetreelist(array('Usergroup.active' => 1), null, null, '- ');
        $this->set(compact('usergroups'));
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Id non valido per la %s', true), 'newsletter'));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->NewsletterMessage->delete($id)) {
            $this->Session->setFlash(sprintf(__('%s eliminata', true), 'Newsletter'));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(sprintf(__('La %s non è stata eliminata', true), 'Newsletter'));
        $this->redirect(array('action' => 'index'));
    }

    function admin_send($id) {
        $message = $this->NewsletterMessage->read(null, $id);
        if ($message && $this->_send($message)) {
            $this->NewsletterMessage->saveSentDate($id);
            $this->Session->setFlash(__('Il messaggio è stato inviato correttamente', true));
        } else {
            $this->Session->setFlash(__('Si è verificato un errore nell\'invio del messaggio, riprova', true));
        }
        $this->redirect(array('action' => 'index'));
    }

    //invia email a tutti gli utenti appartenenti al gruppo selezionato e ai suoi sottogruppi
    function _send($message) {
        //seleziono tutti i sottogruppi attivi
        $this->NewsletterMessage->Usergroup->recursive = -1;
        $baseGroup = $this->NewsletterMessage->Usergroup->findById($message['NewsletterMessage']['usergroup_id']);
        $usergroups = $this->NewsletterMessage->Usergroup->find('all', array(
            'conditions' => array(
                'lft >= ' => $baseGroup['Usergroup']['lft'],
                'rght <= ' => $baseGroup['Usergroup']['rght'],
                'active' => 1
            ),
            'fields' => array('id')
        ));
        $usergroupsIds = Set::extract('/Usergroup/id', $usergroups); //<- sottogruppi

        $users = $this->NewsletterMessage->User->find('all', array(
            'conditions' => array(
                'User.active' => 1,
                'usergroup_id' => $usergroupsIds),
            'fields' => array('email'),
            'recursive' => -1
        ));
        $users = Set::extract('/User/email', $users);

        $errors = array();
        foreach($users as $user) {
            $this->Email->reset();

            $this->Email->to = $user;
            $this->Email->subject = '['.Configure::read('GAS.name').'] '.$message['NewsletterMessage']['title'];
            $this->Email->from = Configure::read('email.from');
            $this->Email->replyTo = $message['NewsletterMessage']['reply_to'];
            $this->Email->sendAs = 'html';
            $this->Email->template = 'admin_newsletter_message';

            $title = $message['NewsletterMessage']['title'];
            $text = $message['NewsletterMessage']['text'];

            $this->set(compact('user', 'title', 'text'));

            if(!$this->Email->send()) {
                $this->log($this->name.'->'.$this->action.' email not sent to: '.$user, 'newsletter_mail_errors');
                $errors[] = $user;
            }
        }

        if(empty($errors)) {
            return true;
        } else {            
            return $errors;
        }
    }
}
?>