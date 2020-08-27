<?php
function date_range($first, $last)
{
    $period = new DatePeriod(
        new DateTime($first),
        new DateInterval('P1D'),
        new DateTime($last)
    );

    foreach ($period as $date)
        $dates[] = $date->format('Y-m-d');

    return $dates;
}
// test: print_r(date_range('2014-06-22', '2014-07-02'));
?>