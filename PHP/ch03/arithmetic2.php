<?php
    // 증감 연산자

    $n1 = 10;
    $n1++;

    print "$n1 <br>";
    ++$n1;
    print "$n1 <br>";

    print "-------------<br>";

    $n2 = 10;
    $sum = 10 + $n2++;
    print "$sum <br>";
    $sum = 10 + ++$n2;
    print "$sum <br>";
    print "$n2 <br>";
    
    print "-------------<br>";

    $n3 = 10;
    $n3 = $n3 + 2; 
    print "$n3 <br>";
    $n3 = $n3 + 2; 
    print "$n3 <br>";
    
    print "-------------<br>";

    $n4 = 10;
    // 위의 식을 축약해서 표현. 산술대입연산자
    $n4 += 2;
    print "$n4 <br>";

    print "-------------<br>";

    $oprd1 = 10;
    $oprd2 = '10';

    // == 비교는 자료형태에 상관없이 안에 있는 값만 비교한다
    // === 비교는 모두 비교한다.(권장)

    $result = $oprd1 == $oprd2;
    print "$oprd1 == $oprd2 : $result <br>";

    $result = $oprd1 === $oprd2;
    print "$oprd1 === $oprd2 : $result <br>";

    $result = $oprd1 != $oprd2;
    print "$oprd1 != $oprd2 : $result <br>";

    $result = $oprd1 !== $oprd2;
    print "$oprd1 != $oprd2 : $result <br>";

    print "-------------<br>";


?>