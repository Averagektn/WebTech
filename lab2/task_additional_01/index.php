<?php

foreach ($_GET as $key => $value) {
    // Check parameter's type
    switch($value){
        case filter_var($value, FILTER_VALIDATE_INT): echo $value . " is int<br>"; break;
        case filter_var($value, FILTER_VALIDATE_FLOAT): echo $value . " is float<br>"; break;
        default: echo $value . " is string<br>";
    }
//    echo match ($value) {
//        filter_var($value, FILTER_VALIDATE_INT) => $value . " is int<br>",
//        filter_var($value, FILTER_VALIDATE_FLOAT) => $value . " is float<br>",
//        default => $value . " is string<br>",
//    };
}