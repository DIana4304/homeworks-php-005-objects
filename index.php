<?php
function buildSchedule(int $year, int $month, int $offLeft = 0): array
{
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $schedule = [];

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $dow = (int) date('w', mktime(0, 0, 0, $month, $day, $year)); 
        $isWorkDay = false;

        if ($offLeft > 0) {
            $offLeft--;
        } elseif ($dow === 0 || $dow === 6) {
        } else {
            $isWorkDay = true;
            $offLeft = 2;
        }

        $schedule[] = ['day' => $day, 'dow' => $dow, 'work' => $isWorkDay];
    }

    return $schedule;
}

/**
 * Вывод графика одного месяца 
 */
function printMonth(int $year, int $month, int $offLeft = 0): void
{
    $monthNames = [
        1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',
        5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
        9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь',
    ];
    $dowNames = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'];

    echo "\033[1m" . $monthNames[$month] . ' ' . $year . "\033[0m\n";

    foreach (buildSchedule($year, $month, $offLeft) as $day) {
        $label = sprintf('%02d (%s)', $day['day'], $dowNames[$day['dow']]);
        if ($day['work']) {
            echo "\033[32m {$label} + \033[0m\n";
        } else {
            echo " {$label}\n";
        }
    }
    echo "\n";
}

printMonth((int) date('Y'), (int) date('n'));
