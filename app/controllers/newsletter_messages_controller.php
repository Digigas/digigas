<?php
class NewsletterMessagesController extends AppController {

    var $name = 'NewsletterMessages';
    var $components = array('Email');

    function beforeFilter() {
        $this->set('activemenu_for_layout', 'tools');
        parent::beforeFilter();
    }

    function admin_index() {
        $this->NewsletterMessage->recursive = 0;
        $this->set('newsletterMessages', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Invalid %s', true), 'newsletter message'));
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
        $usergroups = $this->NewsletterMessage->Usergroup->find('list', array('conditions' => array('Usergroup.active' => 1)));
        $this->set(compact('usergroups'));
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'newsletter message'));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->NewsletterMessage->delete($id)) {
            $this->Session->setFlash(sprintf(__('%s deleted', true), 'Newsletter message'));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Newsletter message'));
        $this->redirect(array('action' => 'index'));
    }

    function send($id) {
        $message = $this->NewsletterMessage->read(null, $id);
        if ($message && $this->_send($message)) {
            $this->NewsletterMessage->saveSentDate($id);
            $this->Session->setFlash(__('Il messaggio è stato inviato correttamente', true));
        } else {
            $this->Session->setFlash(__('Si è verificato un errore nell\'invio del messaggio, riprova', true));
        }
        $this->redirect(array('action' => 'index'));
    }

    function _send($message) {
        $users = $this->NewsletterMessage->User->find('all', array(
            'conditions' => array(
                'User.active' => 1,
                'usergroup_id' => $message['NewsletterMessage']['usergroup_id']),
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