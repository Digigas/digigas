<?php
class Usergroup extends AppModel {
    var $name = 'Usergroup';

    var $hasMany = array('User', array('dependent'=>  false));

    var $actsAs = array('Tree');
    
}