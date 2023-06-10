<?php
session_start();

$registration_page = file_get_contents('templates/Registration.tpl');

echo $registration_page;