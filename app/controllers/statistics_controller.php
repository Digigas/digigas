<?php
class StatisticsController extends AppController {
	var $name = 'Statistics';

	function beforeFilter()
    {
        $this->set('activemenu_for_layout', 'tools');

		$years = $this->Statistic->getYears();
		$this->set('years', $years);

        return parent::beforeFilter();
    }

	function admin_index($year = false) {
		if(!$year) {
			$year = date('Y');
		}

		$totalBySellerThisYear = $this->Statistic->globalValueForYear($year);
		$totalBySellerLastYear = $this->Statistic->globalValueForYear(date('Y', strtotime($year . ' -1 year')));
		$monthlyBySeller =  $this->Statistic->monthlyBySeller($year);
		
		$this->set(compact('year', 'totalBySellerThisYear', 'totalBySellerLastYear', 'monthlyBySeller'));
	}

	function admin_monthly_by_user($year = false) {
		if(!$year) {
			$year = date('Y');
		}
		$totalByUserThisYear = $this->Statistic->totalByUser($year);
		$totalByUserLastYear = $this->Statistic->totalByUser(date('Y', strtotime($year . ' -1 year')));
		$monthlyByUser =  $this->Statistic->monthlyByUser($year);
		$this->set(compact('year', 'totalByUserThisYear', 'totalByUserLastYear', 'monthlyByUser'));
	}
}