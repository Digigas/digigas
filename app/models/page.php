<?php
//App::import('Model', 'AppModelI18n'); // spostato in bootstrap

class Page extends AppModel
{
    var $name = "Page";
    
    var $actsAs = array(
        'Tree',
        'Sluggable'=>array('label'=>array('menu'), 'overwrite' => true), 
        'Containable'
        );

    var $validate = array(
        'parent_id'=>array('rule' => 'validateParentId'),
        'menu'=>array('rule'=>'notEmpty'),
        'title'=>array('rule'=>'notEmpty')
    );

    function beforeValidate()
    {
		// se la posizione rimane invariata, cancello il parametro parent_id per non far rigenerare l'albero
		//(il che modifica la posizione dell'elemento in modo indesiderato)
        if(!$this->id)  //non faccio niente in caso di nuova pagina
        {
            if($this->data['Page']['parent_id'] == '')
                unset($this->data['Page']['parent_id']);
            return true;
        }
		$parent_id = $this->field('Page.parent_id');
		if(!($this->data['Page']['parent_id'] == '' && $parent_id != 0))
		{
			if(isset($this->data['Page']['parent_id']) && 
			($parent_id == $this->data['Page']['parent_id'] || $this->data['Page']['parent_id'] == ''))
				unset($this->data['Page']['parent_id']);
		}
        return true;
    }

	function toggle_active($id)
	{
		$values = $this->find('first', array(
			'conditions'=>array('id'=>$id),
			'fields'=>array('Page.active', 'Page.lft', 'Page.rght')
			));
		$value = $values['Page']['active'];
		//$value = $this->field('active', array('id'=>$id));
		switch($value)
		{
			case 1:
				$value = 0;
				break;
			case 0:
				$value = 1;
				break;
		}
		/*
		$this->create(array('id'=>$id));
		$this->saveField('active', $value);
		*/
		$this->updateAll(array('active'=>$value), array('lft >='=>$values['Page']['lft'], 'rght <='=>$values['Page']['rght']));
	}

    function afterSave($created)
    {
        parent::afterSave($created);

        $this->updateDepth($created);
        
        return true;
    }

    /*
     * aggiorna il campo depth
     */
    function updateDepth($created)
    {
        $data = $this->find('first', array(
            'fields'=>array('lft', 'rght', 'depth'),
            'conditions'=>array('id'=>$this->id),
            'contain'=>array()));
        $prevDepth = $data[$this->name]['depth'];

        //populate depth field
        $depth = $this->find('count', array(
            'fields' => 'id',
            'conditions'=>array(
                'lft < '=> $data[$this->name]['lft'],
                'rght > '=> $data[$this->name]['rght']),
            'recursive' => -1));

        if($created) {
            //is a new page
            $difference = $depth;
        } else {
            //existing page
            $difference = $prevDepth - $depth;

            //can have children, then try to update children depth
            $children = $this->children($this->id, false, 'id');
            $children = Set::extract('/Page/id', $children);
            $this->updateAll(array('depth' => 'depth - '.$difference), array('id' => $children));
        }

        $this->saveField('depth', $depth, array('callbacks' => false));
    }
}
?>