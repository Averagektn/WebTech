<!--По аналогии с классом FormBuilder создайте класс TableBuilder для автоматизации формирования HTML-таблиц-->

<?php

require_once ('TableBuilder.php');

$tableBuilder = new TableBuilder();
$tableBuilder->addColumn('name', 'Name');
$tableBuilder->addColumn('age', 'Age');

$tableBuilder->addRow(['name' => 'Test_row_1', 'age' => 25]);
$tableBuilder->addRow(['name' => 'Test_row_2', 'age' => 30]);

//$tableBuilder->setCellText('name', 'name', 'Test');

$tableHtml = $tableBuilder->getTable();
echo $tableHtml;