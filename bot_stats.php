<?php

$count_start_page = file_get_contents(__DIR__ . '/stats/Кнопка_Старт.txt');
$count_what_read_page = file_get_contents(__DIR__ . '/stats/Кнопка_Что_читал_Лев_Толстой.txt');
$count_read_diary = file_get_contents(__DIR__ . '/stats/Кнопка_читательский_дневник.txt');
$count_about_bot = file_get_contents(__DIR__ . '/stats/Кнопка_подробнее_о_боте.txt');
$count_about_museum = file_get_contents(__DIR__ . '/stats/Кнопка_подробнее_о_музее.txt');
$count_before_14 = file_get_contents(__DIR__ . '/stats/Кнопка_до_14.txt');
$count_between_14_20 = file_get_contents(__DIR__ . '/stats/Кнопка_от_14_20.txt');
$count_between_20_35 = file_get_contents(__DIR__ . '/stats/Кнопка_от_20_35.txt');
$count_between_35_50 = file_get_contents(__DIR__ . '/stats/Кнопка_от_35_50.txt');
$count_between_50_63 = file_get_contents(__DIR__ . '/stats/Кнопка_от_50_63.txt');

echo "/start - " . $count_start_page . "</br>";
echo "Что читал Лев Толстой - " . $count_what_read_page . "</br>";
echo "Читательский дневник - " . $count_read_diary . "</br>";
echo "Подробнее о боте - " . $count_about_bot . "</br>";
echo "Подробнее о музее - " . $count_about_museum . "</br>";
echo "До 14 - " . $count_before_14 . "</br>";
echo "От 14 до 20 - " . $count_between_14_20 . "</br>";
echo "От 20 до 35 - " . $count_between_20_35 . "</br>";
echo "От 35 до 50 - " . $count_between_35_50 . "</br>";
echo "От 50 до 63 - " . $count_between_50_63 . "</br>";