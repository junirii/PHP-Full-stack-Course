<?php
    $num = 11;
    $odd_even = "홀";

    if($num % 2 === 0)
    {
        $odd_even = "짝";
    }
    
    print "${num}은 ${odd_even}수입니다.";

    // 키포인트 또는 달라지는 점을 초점으로 설계하면 훨씬 깔끔하다
?>