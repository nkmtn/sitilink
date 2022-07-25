<?php

/**
 * @autor nkmtn.github.io
 */

/**
 * @charset UTF-8
 *
 * Задание Task2. Работа с массивами и строками.
 *
 * Есть список временных интервалов (интервалы записаны в формате чч:мм-чч:мм).
 *
 * Необходимо написать две функции:
 *
 *
 * Первая функция должна проверять временной интервал на валидность
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
 * 	возвращать boolean
 *
 *
 * Вторая функция должна проверять "наложение интервалов" при попытке добавить новый интервал в список существующих
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
 *  возвращать boolean
 *
 *  "наложение интервалов" - это когда в промежутке между началом и окончанием одного интервала,
 *   встречается начало, окончание или то и другое одновременно, другого интервала
 *
 *  пример:
 *
 *  есть интервалы
 *  	"10:00-14:00"
 *  	"16:00-20:00"
 *
 *  пытаемся добавить еще один интервал
 *  	"09:00-11:00" => произошло наложение
 *  	"11:00-13:00" => произошло наложение
 *  	"14:00-16:00" => наложения нет
 *  	"14:00-17:00" => произошло наложение
 */

# Можно использовать список:

$list = array (
    '09:00-11:00',
    '11:00-13:00',
    '15:00-16:00',
    '17:00-20:00',
    '20:30-21:30',
    '21:30-22:30',
);

/**
 * Комментарии к заданию:
 *
 * Интервал должен быть записан в рамках одних суток в 24 часовом формате (с 00:00 до 23:59)
 * Следовательно левая честь не может быть больше правой + отсеивание нулевых интервалов.
 *
 */

const MINUTES_IN_DAY = 24 * 60;

const TIME_FRAME_PATTERN = "/(\d\d):(\d\d)-(\d\d):(\d\d)/";

/**
 * Проверка валидности формата записи интервала
 *
 * Не пройдет проверку если:
 * 0) не соответствует формату паттерна
 * 1) число минут в левой или правой части больше чем в сутках
 * Task2) левая часть интервала больше или равна правой
 *
 * @param string $interval
 * @return bool
 */
function isValidTimeInterval(string $interval) : bool {
    $pieces = [];
    if (!preg_match(TIME_FRAME_PATTERN, $interval, $pieces)) {
        return false;
    }

    if (
        (int) $pieces[0] * (int) $pieces[1] > MINUTES_IN_DAY
        || (int) $pieces[2] * (int) $pieces[3] > MINUTES_IN_DAY
        || (int) $pieces[0] * MINUTES_IN_DAY + (int) $pieces[1]
            >= (int) $pieces[2] * MINUTES_IN_DAY + (int) $pieces[3]
    ) {
        return false;
    }

    return true;
}

/**
 * Функция проверки возможности добавления нового интервала.
 *
 * Новый интервал - [a, b]
 * Существующий - [c, d]
 * Интервал нельзя добавить если (a <= c && b > c) || (a >= c && b <= d) || (a < d && b >= d)
 *
 * @param string $new
 * @return bool
 */
function canAddTheInterval(string $new) : bool {
    if (!isValidTimeInterval($new)) {
        return false;
    }

    $newInMinutes = fromStringToMinutes($new);
    $list = $GLOBALS['list'];
    foreach ($list as $interval) {
        $intervalInMinutes = fromStringToMinutes($interval);
        if (
            ($newInMinutes[0] <= $intervalInMinutes[0]
                && $newInMinutes[1] > $intervalInMinutes[0])
            || ($newInMinutes[0] >= $intervalInMinutes[0]
                && $newInMinutes[1] <= $intervalInMinutes[1])
            || ($newInMinutes[0] < $intervalInMinutes[1]
                && $newInMinutes[1] >= $intervalInMinutes[1])
        ) {
            return false;
        }
    }
    return true;
}

/**
 * Функция приведения времени из формата 'hh:mm-hh:mm'
 * в [hh * MINUTES_IN_DAY + mm, hh * MINUTES_IN_DAY + mm]
 * @param string $interval
 * @return int[]
 */
function fromStringToMinutes(string $interval) : array {
    if (!isValidTimeInterval($interval)) {
        throw new InvalidArgumentException("incorrect interval in schedule");
    }

    $pieces = [];
    preg_match(TIME_FRAME_PATTERN, $interval, $pieces);
    return [(int) $pieces[0] * MINUTES_IN_DAY + (int) $pieces[1], (int) $pieces[2] * MINUTES_IN_DAY + (int) $pieces[3]];
}

/**
 * Нужно протестировать как минимум:
 */
var_dump(canAddTheInterval('07:30-08:59')); // true
var_dump(canAddTheInterval('07:00-09:00')); // true
var_dump(canAddTheInterval('08:20-09:30')); // false
var_dump(canAddTheInterval('09:00-10:00')); // false
var_dump(canAddTheInterval('09:00-11:00')); // false
var_dump(canAddTheInterval('12:30-14:00')); // false
var_dump(canAddTheInterval('13:00-14:00')); // true
var_dump(canAddTheInterval('13:30-14:30')); // true
var_dump(canAddTheInterval('24:30-25:30')); // false
var_dump(canAddTheInterval('15:30-14:30')); // false

