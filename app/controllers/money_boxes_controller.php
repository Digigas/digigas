<?php
class MoneyBoxesController extends AppController {

    var $name = 'MoneyBoxes';

    function beforeFilter() {
        parent::beforeFilter();

        $this->set('activemenu_for_layout', 'users');

        $this->Auth->deny($this->methods);
    }

    function index() {
        $this->MoneyBox->recursive = 0;
        $this->paginate = array(
            'conditions' => array('MoneyBox.user_id' => $this->Auth->user('id')),
            'order' => array('MoneyBox.created desc', 'MoneyBox.id desc'));
        $this->set('moneyBoxes', $this->paginate());

        $total = $this->MoneyBox->getTotal($this->Auth->user('id'));
        $this->set('total', $total);
    }
}
?>