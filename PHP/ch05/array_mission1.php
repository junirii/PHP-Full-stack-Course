<?php
    $score_arr = array(100, 90, 33, 87, 65, 100, 99);
    $sum = 0;
    $len = count($score_arr);

    for($i=0; $i<$len; $i++)
    {
        $sum += $score_arr[$i];
    }

    $avg = $sum / $len;
    print "$sum<br>$avg";


?>