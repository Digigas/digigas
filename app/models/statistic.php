<?php
class Statistic extends AppModel {
	var $name = "Statistic";
	var $useTable = false;
	var $relatedModels = array('OrderedProduct', 'Seller', 'User');

	function __construct($id = false, $table = null, $ds = null) {

		foreach($this->relatedModels as $model) {
			$this->{$model} = ClassRegistry::init($model);
		}
		
		return parent::__construct($id, $table, $ds);
	}

	function getYears() {
		$years = $this->OrderedProduct->find('all', array(
			'conditions' => array(
				'OrderedProduct.paid' => 1,
				'OrderedProduct.retired' => 1),
			'fields' => array('YEAR(OrderedProduct.created) as year'),
			'group' => 'YEAR(OrderedProduct.created)',
			'recursive' => -1
		));
		$years = Set::extract('/0/year', $years);
		return $years;
	}

	function globalValueForYear($year = false) {
		if(!$year) {
			$year = date('Y');
		}

		$globalValue = $this->OrderedProduct->find('all', array(
			'conditions' => array(
				'OrderedProduct.paid' => 1,
				'OrderedProduct.retired' => 1,
				'OrderedProduct.created BETWEEN ? AND ?' => array(
					date('Y-m-d', strtotime($year . '-01-01')),
					date('Y-m-d', strtotime($year . '-12-31'))
				)),
			'fields' => array(
				'SUM(OrderedProduct.value) AS total',
				'COUNT(OrderedProduct.id) AS orders'),
			'group' => array('OrderedProduct.seller_id'),
			'order' => array('orders DESC'),
			'contain' => array('Seller.name')
		));
		return $globalValue;
	}

	function monthlyBySeller($year = false) {
		if(!$year) {
			$year = date('Y');
		}

		$activeSellers = $this->getActiveSellers(true);
		$monthlyValue = $this->OrderedProduct->find('all', array(
			'conditions' => array(
				'OrderedProduct.seller_id' => $activeSellers,
				'OrderedProduct.paid' => 1,
				'OrderedProduct.retired' => 1,
				'OrderedProduct.created BETWEEN ? AND ?' => array(
					date('Y-m-d', strtotime($year . '-01-01')),
					date('Y-m-d', strtotime($year . '-12-31'))
				)),
			'fields' => array(
				'OrderedProduct.seller_id',
				'MONTH(OrderedProduct.created) as month',
				'SUM(OrderedProduct.value) AS total'),
			'group' => array(
				'OrderedProduct.seller_id',
				'MONTH(OrderedProduct.created)'),
			'contain' => array('Seller.name')
		)); 
		$monthlyValue = Set::combine($monthlyValue, '{n}.0.month', '{n}.0.total', '{n}.OrderedProduct.seller_id');

		$sellersID = $this->getActiveSellers();
		$monthlyBySeller = array();
		foreach($sellersID as $seller_id => $name) {
			$tmp = array(
				'id' => $seller_id,
				'name' => $name
			);
			if(isset($monthlyValue[$seller_id])) {
				$tmp['months'] = $monthlyValue[$seller_id];
			} else {
				$tmp['months'] = array();
			}
			$monthlyBySeller[] = $tmp;
		}

		return $monthlyBySeller;
	}

	function monthlyByUser($year = false) {
		if(!$year) {
			$year = date('Y');
		}

		$activeUsers = $this->getActiveUsers(true);
		$monthlyValue = $this->OrderedProduct->find('all', array(
			'conditions' => array(
				'OrderedProduct.user_id' => $activeUsers,
				'OrderedProduct.paid' => 1,
				'OrderedProduct.retired' => 1,
				'OrderedProduct.created BETWEEN ? AND ?' => array(
					date('Y-m-d', strtotime($year . '-01-01')),
					date('Y-m-d', strtotime($year . '-12-31'))
				)),
			'fields' => array(
				'OrderedProduct.user_id',
				'MONTH(OrderedProduct.created) as month',
				'COUNT(OrderedProduct.hamper_id) as orders',
				'SUM(OrderedProduct.value) AS total'),
			'group' => array(
				'OrderedProduct.user_id',
				'MONTH(OrderedProduct.created)'),
			'recursive' => -1
		)); debug($monthlyValue);
		
		$orders = array();
		foreach($monthlyValue as $order) {
			if(isset($orders[$order['OrderedProduct']['user_id']])) {
				$orders[$order['OrderedProduct']['user_id']] += (int)$order['0']['orders'];
			} else {
				$orders[$order['OrderedProduct']['user_id']] = (int)$order['0']['orders'];
			}
		}

		$monthlyValue = Set::combine($monthlyValue, '{n}.0.month', '{n}.0.total', '{n}.OrderedProduct.user_id');

		$users = $this->getActiveUsers();
		$monthlyByUser = array();
		foreach($users as $user_id => $name) {
			$tmp = array(
				'id' => $user_id,
				'name' => $name
			);
			if(isset($monthlyValue[$user_id])) {
				$tmp['months'] = $monthlyValue[$user_id];
			} else {
				$tmp['months'] = array();
			}
			if(isset($orders[$user_id])) {
				$tmp['orders'] = $orders[$user_id];
			} else {
				$tmp['orders'] = 0;
			}
			$monthlyByUser[] = $tmp;
		}

		return $monthlyByUser;
	}

	function totalByUser($year = false) {
		if(!$year) {
			$year = date('Y');
		}
		
		$activeUsers = $this->getActiveUsers(true);
		$globalValue = $this->OrderedProduct->find('all', array(
			'conditions' => array(
				'OrderedProduct.paid' => 1,
				'OrderedProduct.retired' => 1,
				'OrderedProduct.created BETWEEN ? AND ?' => array(
					date('Y-m-d', strtotime($year . '-01-01')),
					date('Y-m-d', strtotime($year . '-12-31'))
				)),
			'fields' => array(
				'SUM(OrderedProduct.value) AS total',
				'COUNT(OrderedProduct.id) AS orders'),
			'group' => array('OrderedProduct.user_id'),
			'order' => array('orders DESC'),
			'contain' => array('User' => array('first_name', 'last_name'))
		));
		return $globalValue;
	}

	function getActiveSellers($id_only = false) {
		$sellers = $this->Seller->find('all', array(
			'conditions' => $this->Seller->findActive(true),
			'fields' => array('id', 'name'),
			'order' => array('Seller.name ASC'),
			'recursive' => -1
		));
		if($id_only) {
			$sellers = Set::extract('/Seller/id', $sellers);
		} else {
			$sellers = Set::combine($sellers, '{n}.Seller.id', '{n}.Seller.name');
		}
		return $sellers;
	}

	function getActiveUsers($id_only = false) {
		$users = $this->User->find('all', array(
			'conditions' => $this->User->findActive(true),
			'fields' => array('id', 'fullname'),
			'order' => array('User.last_name ASC'),
			'recursive' => -1
		));
		if($id_only) {
			$users = Set::extract('/User/id', $users);
		} else {
			$users = Set::combine($users, '{n}.User.id', '{n}.User.fullname');
		}
		return $users;
	}
}