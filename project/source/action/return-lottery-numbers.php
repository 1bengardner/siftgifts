<?php
$possible_numbers = range(1, 50);
$chosen_numbers = array();
for ($i = 1; $i <= 7; $i++) {
  $chosen_numbers[] = array_splice($possible_numbers, rand(0, count($possible_numbers)-1), 1)[0];
}
return $chosen_numbers;
?>