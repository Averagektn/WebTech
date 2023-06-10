<!--Создайте класс Logger, который будет при создании объекта позволять указы-вать, выводить ли сообщение на
экран или в файл, а также будет добавлять к каждому сообщению (в начало) дату и время-->

<?php

require_once('Logger.php');

$logger = new Logger(true, true, "Res.txt");
$logger->log('Something happened!');
echo '<br>';
$logger->log('Test');