<!--Создайте класс FormBuilder, который будет позволять формировать HTML-форму-->

<?php

require_once('FormBuilder.php');

$formBuilder = new FormBuilder(FormBuilder::METHOD_POST, '../task_2_2/index.php', 'Send!');
$formBuilder->addTextField('someName', 'Default value');
$formBuilder->addRadioGroup('someRadioName', ['A', 'B']);
$formBuilder->getForm();