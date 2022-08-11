<?php

$data = json_decode(file_get_contents('php://input'),true);
$text = $data['message']['text'];
$callback_data = $data['callback_query']['data'];

file_put_contents( 'file.txt', print_r($data, true), FILE_APPEND);

define('TOKEN', 'TOKEN');

// Функция вызова методов API
function sendTelegram($method, $response)
{
    $ch = curl_init('https://api.telegram.org/bot' . TOKEN . '/' . $method);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $res = curl_exec($ch);
    curl_close($ch);

    return $res;
}

// Ускорение плашки "Загрузка..." при нажатии на inline-кнопку
if (isset($data['callback_query']['data'])) {
    sendTelegram(
        'answerCallbackQuery',
        array (
            'callback_query_id' => $data['callback_query']['id'],
            'text' => '',
        )
    );
}

//Ответ бота
switch ($text) {
    //******************** СТАРТОВЫЙ ЭКРАН **************************
    case '/start':
        if ($text = '/start' and $data['message']['from']['id'] == '218314749') {
            sendTelegram(
                'sendMessage',
                array(
                    'chat_id' => $data['message']['chat']['id'],
                    'text' => file_get_contents(__DIR__ . '/texts/1-ый_экран/Приветствие.txt'),
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [
                                ['text' => 'Что читал Лев Толстой'],
                                ['text' => 'Читательский дневник'],
                            ],
                            [
                                ['text' => 'Подробнее о боте'],
                                ['text' => 'О музее'],
                            ],
                            [
                                ['text' => 'Статистика']
                            ]

                        ]
                    ])
                )
            );
        } else {
            $count_start_page = file_get_contents(__DIR__ . '/stats/Кнопка_Старт.txt');
            $count_start_page = (int)$count_start_page + 1;
            file_put_contents(__DIR__ . '/stats/Кнопка_Старт.txt', print_r($count_start_page, true));
            sendTelegram(
                'sendMessage',
                array(
                    'chat_id' => $data['message']['chat']['id'],
                    'text' => file_get_contents(__DIR__ . '/texts/1-ый_экран/Приветствие.txt'),
                    'reply_markup' => json_encode([
                        'resize_keyboard' => true,
                        'keyboard' => [
                            [
                                ['text' => 'Что читал Лев Толстой'],
                                ['text' => 'Читательский дневник'],
                            ],
                            [
                                ['text' => 'Подробнее о боте'],
                                ['text' => 'О музее'],
                            ]
                        ]
                    ])
                )
            );
        }
        break;

    //Статистика
    case 'Статистика':
        if ($text = 'Статистика' and $data['message']['from']['id'] == '218314749') {

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

            sendTelegram(
                'sendMessage',
                array(
                    'chat_id' => $data['message']['chat']['id'],
                    'text' => '/start: ' .  $count_start_page . PHP_EOL .
                        'Что читал Лев Толстой: ' . $count_what_read_page . PHP_EOL .
                        'Читательский дневник: ' . $count_read_diary . PHP_EOL .
                        'Подробнее о боте: ' . $count_about_bot . PHP_EOL .
                        'Подробнее о музее: ' . $count_about_museum . PHP_EOL .
                        'До 14: ' . $count_before_14 . PHP_EOL .
                        'От 14 до 20: ' . $count_between_14_20 . PHP_EOL .
                        'От 20 до 35: ' .  $count_between_20_35 . PHP_EOL .
                        'От 35 до 50: ' . $count_between_35_50 . PHP_EOL .
                        'От 50 до 63: ' . $count_between_50_63 . PHP_EOL

                )
            );
        }
        break;

    //Кнопка "Что читал Лев Толстой"
    case 'Что читал Лев Толстой':
        $count_what_read_page = file_get_contents(__DIR__ . '/stats/Кнопка_Что_читал_Лев_Толстой.txt');
        $count_what_read_page = (int)$count_what_read_page + 1;
        file_put_contents(__DIR__ . '/stats/Кнопка_Что_читал_Лев_Толстой.txt', print_r($count_what_read_page, true));
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/1-ый_экран/Что_читал_Лев_Толстой.txt'),
                'reply_markup' => json_encode([
                    'resize_keyboard' => true,
                    'keyboard' => [
                        [
                            ['text' => 'До 14 лет'],
                            ['text' => 'С 14 до 20 лет'],
                            ['text' => 'С 20 до 35 лет'],
                        ],
                        [
                            ['text' => 'С 35 до 50 лет'],
                            ['text' => 'С 50 до 63 лет'],

                        ]
                    ]
                ])
            )
        );
        break;

    //Кнопка "Скачать читательский дневник"
    case 'Читательский дневник':
        $count_read_diary = file_get_contents(__DIR__ . '/stats/Кнопка_читательский_дневник.txt');
        $count_read_diary = (int)$count_read_diary + 1;
        file_put_contents(__DIR__ . '/stats/Кнопка_читательский_дневник.txt', print_r($count_read_diary, true));
        sendTelegram(
            'sendDocument',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'document' => 'BQACAgIAAxkBAAILP2CD_u7s5vk2EzCTF3fLbiwHpJejAAJNEQACWwogSDm4OzI1RziCHwQ',
                'caption' => file_get_contents(__DIR__ . '/texts/Читательский_дневник.txt'),
            )
        );
        break;


    //Кнопка "Подробнее о марафоне
    case 'Подробнее о боте':
        $count_about_bot = file_get_contents(__DIR__ . '/stats/Кнопка_подробнее_о_боте.txt');
        $count_about_bot = (int)$count_about_bot + 1;
        file_put_contents(__DIR__ . '/stats/Кнопка_подробнее_о_боте.txt', print_r($count_about_bot, true));
        sendTelegram(
            'sendPhoto',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'photo' => curl_file_create(__DIR__ . '/images/About_bot.png'),
                'caption' => file_get_contents(__DIR__ . '/texts/1-ый_экран/Подробнее_о_боте.txt'),
                'reply_markup' => json_encode([
                    'one_time_keyboard' => true,
                    'resize_keyboard' => true,
                    'inline_keyboard' => [
                        [
                            ['text' => 'О музее', 'url' => 'https://ypmuseum.ru/about'],
                            ['text' => 'Лекция о библиотеке Толстого','url' => 'https://rutube.ru/video/c2a391e29f3cc04e780c998d9838d38e/'],
                        ]
                    ]
                ])
            )
        );
        break;

    //Кнопка "О музее"
    case 'О музее':
        $count_about_museum = file_get_contents(__DIR__ . '/stats/Кнопка_подробнее_о_музее.txt');
        $count_about_museum = (int)$count_about_museum + 1;
        file_put_contents(__DIR__ . '/stats/Кнопка_подробнее_о_музее.txt', print_r($count_about_museum, true));
        sendTelegram(
            'sendPhoto',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'photo' => curl_file_create(__DIR__ . '/images/About_museum.png'),
                'caption' => file_get_contents(__DIR__ . '/texts/1-ый_экран/О_музее.txt'),
                    'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Сайт музея', 'url' => 'https://ypmuseum.ru'],
                        ]
                    ]
                ])
            )
        );
        break;



    //Кнопка "до 14 лет"
    case 'До 14 лет':
        $count_before_14 = file_get_contents(__DIR__ . '/stats/Кнопка_до_14.txt');
        $count_before_14 = (int)$count_before_14 + 1;
        file_put_contents(__DIR__ . '/stats/Кнопка_до_14.txt', print_r($count_before_14, true));
        sendTelegram(
            'sendPhoto',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'photo' => curl_file_create(__DIR__ . '/images/before_14.png'),
                'caption' => file_get_contents(__DIR__ . '/texts/До_14_лет/До_14_лет.txt'),

                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Сказки тысячи и одной ночи 📚','callback_data'=>'Сказки тысячи и одной ночи'],
                        ],
                        [
                            ['text' => 'А. Погорельский. Черная курица 📚','callback_data'=>'А. Погорельский. Черная Курица'],
                        ],
                        [
                            ['text' => 'Русские былины о богатырях 📚','callback_data'=>'Русские былины'],
                        ],
                        [
                            ['text' => 'А. С. Пушкин. Наполеон 📚','callback_data'=> 'А. С. Пушкин. Наполеон'],
                        ],
                    ]
                ])
            )
        );
        break;

    //Кнопка "С 14 до 20 лет"
    case 'С 14 до 20 лет':
        $count_between_14_20 = file_get_contents(__DIR__ . '/stats/Кнопка_от_14_20.txt');
        $count_between_14_20 = (int)$count_between_14_20 + 1;
        file_put_contents(__DIR__ . '/stats/Кнопка_от_14_20.txt', print_r($count_between_14_20, true));
        sendTelegram(
            'sendPhoto',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'photo' => curl_file_create(__DIR__ . '/images/between_14_20.png'),
                'caption' => file_get_contents(__DIR__ . '/texts/14_20/14_20.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Л. Стерн. Сентиментальное путешествие по Франции и Италии 📚', 'callback_data' => 'Путешествие по Франции и Италии'],
                        ],
                        [
                            ['text' => ' А. Пушкин. Евгений Онегин 📚', 'callback_data' => 'А.Пушкин. Евгений Онегин'],
                        ],
                        [
                            ['text' => 'Произведения Н. Гоголя 📚', 'callback_data' => 'Произведения Гоголя'],
                        ],
                        [
                            ['text' => 'И. Тургенев. Записки охотника 📚' , 'callback_data' => 'И. Тургенев. Записки охотника'],
                        ],
                        [
                            ['text' => 'А. Дружинин. Полинька Сакс 📚', 'callback_data' => 'А. Дружинин. Полинька Сакс'],
                        ],
                        [
                            ['text' => 'Ч. Диккенс. Дэвид Копперфильд 📚', 'callback_data' => 'Ч. Диккенс. Дэвид Копперфильд'],
                        ],
                        [
                            ['text' => 'М. Лермонтов. Герой нашего времени 📚', 'callback_data' => 'М. Лермонтов. Герой нашего времени'],
                        ],
                        [
                            ['text' => 'Д. Григорович. Антон-Горемыка 📚', 'callback_data' => 'Д. Григорович. Антон-Горемыка'],
                        ],
                    ]
                ])
            )
        );
        break;

    //Кнопка "С 20 до 35 лет"
    case 'С 20 до 35 лет':
        $count_between_20_35 = file_get_contents(__DIR__ . '/stats/Кнопка_от_20_35.txt');
        $count_between_20_35 = (int)$count_between_20_35 + 1;
        file_put_contents(__DIR__ . '/stats/Кнопка_от_20_35.txt', print_r($count_between_20_35, true));
        sendTelegram(
            'sendPhoto',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'photo' => curl_file_create(__DIR__ . '/images/between_20_35.png'),
                'caption' => file_get_contents(__DIR__ . '/texts/20_35/20_35.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'В. Гюго. Собор Парижской Богоматери 📚', 'callback_data' => 'В. Гюго. Собор Парижской Богоматери'],
                        ],
                        [
                            ['text' => 'Ф. Тютчев. Стихотворения 📚', 'callback_data' => 'Ф. Тютчев. Стихотворения'],
                        ],
                        [
                            ['text' => 'Гомер. Одиссея. Илиада 📚', 'callback_data' => 'Гомер. Одиссея. Илиада'],
                        ],
                        [
                            ['text' => 'А. Фет. Стихотворения 📚', 'callback_data' => 'А. Фет. Стихотворения'],
                        ],
                        [
                            ['text' => 'Платон. Пир 📚', 'callback_data' => 'Платон. Пир'],
                        ],
                    ]
                ])
            )
        );
        break;

    //Кнопка "С 35 до 50 лет"
    case 'С 35 до 50 лет':
        $count_between_35_50 = file_get_contents(__DIR__ . '/stats/Кнопка_от_35_50.txt');
        $count_between_35_50 = (int)$count_between_35_50 + 1;
        file_put_contents(__DIR__ . '/stats/Кнопка_от_35_50.txt', print_r($count_between_35_50, true));
        sendTelegram(
            'sendPhoto',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'caption' => file_get_contents(__DIR__ . '/texts/35_50/35_50.txt'),
                'photo' => curl_file_create(__DIR__ . '/images/between_35_50.png'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Ксенофонт. Анабасис 📚', 'callback_data' => 'Ксенофонт. Анабасис'],
                        ],
                        [
                            ['text' => 'В. Гюго. Отверженные 📚', 'callback_data' => 'В. Гюго. Отверженные'],
                        ],
                        [
                            ['text' => 'Э. Троллоп. Смотритель 📚', 'callback_data' => 'Э. Троллоп. Смотритель'],
                        ],
                    ]
                ])
            )
        );
        break;

    //Кнопка "С 50 до 63 лет"
    case 'С 50 до 63 лет':
        $count_between_50_63 = file_get_contents(__DIR__ . '/stats/Кнопка_от_50_63.txt');
        $count_between_50_63 = (int)$count_between_50_63 + 1;
        file_put_contents(__DIR__ . '/stats/Кнопка_от_50_63.txt', print_r($count_between_50_63, true));
        sendTelegram(
            'sendPhoto',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'photo' => curl_file_create(__DIR__ . '/images/between_50_63.png'),
                'caption' => file_get_contents(__DIR__ . '/texts/50_63/50_63.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Книга бытия 📚', 'callback_data' => 'Книга Бытия'],
                        ],
                        [
                            ['text' => 'Б. Паскаль. Мысли 📚', 'callback_data' => 'Паскаль. Мысли'],
                        ],
                        [
                            ['text' => 'Лао-цзы. Дао дэ цзин (Книга пути и достоинства) 📚', 'callback_data' => 'Лао-цзы. Дао дэ цзин'],
                        ],
                    ]
                ])
            )
        );
        break;

    default:
        sendTelegram(
            'sendMessage',
            array (
                'chat_id' => $data['message']['chat']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/Заглушка.txt'),
                )
        );
}

            //********** Посты, после нажатия на inline-кнопки

switch ($callback_data) {

    case 'Читательский дневник':
        sendTelegram(
            'sendDocument',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'document' => 'BQACAgIAAxkBAAILP2CD_u7s5vk2EzCTF3fLbiwHpJejAAJNEQACWwogSDm4OzI1RziCHwQ',
                'caption' => file_get_contents(__DIR__ . '/texts/Читательский_дневник.txt'),
            )
        );
        break;

        //До 14 лет

    case 'Сказки тысячи и одной ночи':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/До_14_лет/Сказки_тысячи_и_одной_ночи.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/LIzivwTP',],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник',],
                        ],


                    ]

                ]))
        );
        break;

    case 'А. Погорельский. Черная Курица':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/До_14_лет/А_Погорельский_Черная_курица.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/xOyI4plb',],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник',],
                        ],
                    ]
                ])
            )
        );
        break;

    case 'Русские былины':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/До_14_лет/Русские_былины.txt'),

                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/ma8nKKWh',],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник',],
                        ],


                    ]

                ]))
        );
        break;

    case 'А. С. Пушкин. Наполеон':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/До_14_лет/Пушкин_Наполеон.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/QuSxeUIc',],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник',],
                        ],
                    ]
                ])
            )
        );
        break;

// От 14 до 20 лет
    case 'Путешествие по Франции и Италии':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/14_20/Л_Стерн_Путешествие_по_Франции.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/BKWz4rc0',],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник',],
                        ],
                    ]
                ])
            )
        );
        break;

    case 'А.Пушкин. Евгений Онегин':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/14_20/А_Пушкин_Евгений_Онегин.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/QMTXms87',],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник',],
                        ],
                    ]
                ])
            )
        );
        break;

    case 'Произведения Гоголя':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/14_20/Произведения_Гоголя.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Шинель', 'url' => 'https://ru.bookmate.com/books/TXNAahms'],
                        ],
                        [
                            ['text' => 'Повесть о том, как поссорился Иван Иванович с Иваном Никифоровичем', 'url' => 'https://ru.bookmate.com/books/AwxXkb9o'],
                        ],
                        [
                            ['text' => 'Невский проспект', 'url' => 'https://ru.bookmate.com/books/KUFT6gm4'],
                        ],
                        [
                            ['text' => 'Мертвые души', 'url' => 'https://ru.bookmate.com/books/CQWyL6jp '],
                        ],
                        [
                            ['text' => 'Вий', 'url' => 'https://ru.bookmate.com/books/WIRuaq5m'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

    case 'И. Тургенев. Записки охотника':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/14_20/И_Тургенев_Записки_Охотника.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/vHRQaq8a'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

    case 'А. Дружинин. Полинька Сакс':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/14_20/А_Дружинин_Полинька_Сакс.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/csJn9TQM'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

    case 'Ч. Диккенс. Дэвид Копперфильд':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/14_20/Ч_Диккенс_Дэвид_Копперфильд.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/JyTc2nBK'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

    case 'М. Лермонтов. Герой нашего времени':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/14_20/М_Лермонтов_Герой_нашего_времени.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/uyLBIgkq'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

    case 'Д. Григорович. Антон-Горемыка':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/14_20/Д_Григорович_Антон-Горемыка.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/HCVW6rbs'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

//С 20 до 35 лет
    case 'В. Гюго. Собор Парижской Богоматери':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/20_35/В_Гюго_Собор_Парижской_Богоматери.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/xBDEefg7'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

    case 'Ф. Тютчев. Стихотворения':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/20_35/Ф_Тютчев_Стихотворения.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/m842lx9f'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

        case 'Гомер. Одиссея. Илиада':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/20_35/Гомер_Одиссея_Илиада.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Одиссея', 'url' => 'https://ru.bookmate.com/books/NW6cGGTl'],
                        ],
                        [
                            ['text' => 'Илиада', 'url' => 'https://ru.bookmate.com/books/GACM2j7s '],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

    case 'А. Фет. Стихотворения':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/20_35/А_Фет_Стихотворения.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/WyeUhGkA'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

        case 'Платон. Пир':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/20_35/Платон_Пир.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/HXKBa9jn'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

//С 35 до 50 лет
    case 'Ксенофонт. Анабасис':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/35_50/Ксенофонт_Анабасис.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/UAMOK5mP'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

    case 'В. Гюго. Отверженные':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/35_50/В_Гюго_Отверженные.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Часть 1: Фантина', 'url' => 'https://ru.bookmate.com/audiobooks/f1RGNgQ6'],
                        ],
                        [
                            ['text' => 'Часть 2. Козетта. Часть 3. Муриус', 'url' => 'https://ru.bookmate.com/audiobooks/Goau3wUb'],
                        ],
                        [
                            ['text' => 'Часть 4. Идиллия улицы Плюмэ и эпопея улицы Сен-Дени', 'url' => 'https://ru.bookmate.com/audiobooks/Jq8Uf51r'],
                        ],
                        [
                            ['text' => 'Часть 5. Жан Вальжан', 'url' => 'https://ru.bookmate.com/audiobooks/ls3b8Mtl'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

    case 'Э. Троллоп. Смотритель':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/35_50/Э_Троллоп_Смотритель.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/ZwdDcul9'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

    //С 50 до 63 лет
    case 'Книга Бытия':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/50_63/Книга_Бытия.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/TFTPsl9e'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

    case 'Паскаль. Мысли':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/50_63/Паскаль_Мысли.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/QHDI1l6e'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;

    case 'Лао-цзы. Дао дэ цзин':
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['callback_query']['from']['id'],
                'text' => file_get_contents(__DIR__ . '/texts/50_63/Лао_Цзы.txt'),
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Читать', 'url' => 'https://ru.bookmate.com/books/zEZAgjjh'],
                        ],
                        [
                            ['text' => 'Читательский дневник', 'callback_data' => 'Читательский дневник'],
                        ],
                    ]
                ])
            )
        );
        break;
}