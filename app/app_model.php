<?php
class AppModel extends Model {

    function validateParentId() {
        //gestisco il salvataggio del campo parent_id nei modelli con TreeBehavior
        if(array_key_exists('Tree', $this->actsAs) || in_array('Tree', $this->actsAs)) {
            // se la posizione rimane invariata, cancello il parametro parent_id per non far rigenerare l'albero
            //(il che modifica la posizione dell'elemento in modo indesiderato)
            $_parent_field = $this->Behaviors->Tree->settings[$this->alias]['parent'];
            if(!$this->id)  //se è un nuovo record non faccio niente
            {
                if($this->data[$this->alias][$_parent_field] == '')
                    unset($this->data[$this->alias][$_parent_field]);
                return true;
            }
            $parent_id = $this->field($this->alias.'.'.$_parent_field);
            if(!($this->data[$this->alias][$_parent_field] == '' && $parent_id != '0')) {
                if(isset($this->data[$this->alias][$_parent_field]) &&
                    ($parent_id == $this->data[$this->alias][$_parent_field] || $this->data[$this->alias][$_parent_field] == ''))
                    unset($this->data[$this->alias][$_parent_field]);
            }
            return true;
        }
    }
    
    function findActive($returnConditions = false) {
        $columns = $this->getColumnTypes();
        $conditions = array();
        if(isset($columns['active'])) $conditions[$this->name.'.active'] = '1';
        if(isset($columns['date_on']) && isset($columns['date_off'])) {
            $conditions['or'] =  array(
                array($this->name.'.date_on <=' => date('Y-m-d'), $this->name.'.date_off >' => date('Y-m-d')),
                array($this->name.'.date_on <=' => date('Y-m-d'), $this->name.'.date_off' => '0000-00-00'),
                array($this->name.'.date_on' => '0000-00-00', $this->name.'.date_off >' => date('Y-m-d')),
                array($this->name.'.date_on' => '0000-00-00', $this->name.'.date_off' => '0000-00-00'));
            if(isset($conditions[$this->name.'.active'])) {
                $conditions['and'] = array($this->name.'.active' => '1');
                unset($conditions[$this->name.'.active']);
            }
        }
        if($returnConditions) return $conditions;
        //debug($conditions);
        return $this->find('all', array('conditions' => $conditions));
    }
}