<!--Создайте класс SafeFormBuilder, унаследованный от класса FormBuilder из первого задания, который будет
анализировать суперглобальные массивы $_POST и $_GET и (если там есть данные, полученные при предыдущей
отправки формы) формировать значения по умолчанию для соответствующих полей.-->

<?php

require_once('SafeFormBuilder.php');

$_POST += ['name' => 'Test_name', 'age' => 'Test_age'];
$_GET += ['category' => 'Test_category'];

$safeFormBuilder = new SafeFormBuilder(FormBuilder::METHOD_POST, 'process.php', 'Submit');
$safeFormBuilder->addTextField('name', '');
$safeFormBuilder->addTextField('age', '');
$safeFormBuilder->addTextField('category', '');

$safeFormBuilder->addTextField('someName', '');

$safeFormBuilder->getForm();