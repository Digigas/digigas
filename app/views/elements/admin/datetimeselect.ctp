<?php
/*
 * usa così:
 *
 * echo $this->element('admin/datetimeselect', array('field' => 'fieldname', 'label' => __('etichetta', true), 'model' => 'NomeModello'));
 * il parametro model è facoltativo
 */

if(!isset($model)) {
    $model = $this->model;
}
if(isset($this->data)) {
    $date = date('Y-m-d', strtotime($this->data[$model][$field]));
} else {
    $date = date('Y-m-d');
}

if(isset($field) && isset($label)) {

    $output = $this->Form->input($model.'.'.$field.'.date', array(
        'value' => $date,
        'label' => $label,
        'type' => 'text',
        'class' => 'calendar',
        'div'=> false));
    $output .= $this->Html->tag('span', __('ore', true));
    $output .=  $this->Form->hour($model.'.'.$field, true, null, array('empty' => 'seleziona l\'ora'));
    $output .= $this->Html->tag('span', __('minuti', true));
    $output .= $this->Form->minute($model.'.'.$field, null, array('interval' => '15', 'empty' => false));
    echo $this->Html->div('input datetime', $output);
    
}
?>