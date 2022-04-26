<?php
    function generate_card($x, $y){
        echo "generating punch card [".$x.",".$y."].. \n";
        $x = $x*2;
        $current_line = 1;
        for($i = 0; $i < ($x * 2) + 1; $i++){
            $current_column = 1;
            do {
             if ($current_line <= 2 && $current_column <= 2){
                 $open  = ".";
                 $close = ".";
             }
             else{
                 $open  = "|";
                 $close = ".";
                 if($current_line % 2 != 0){
                      $open  = "+";
                      $close = "-";
                 }
                 
                //  echo '1 ';
             }
             if($current_column % 2 == 0){
                    echo $close;
                 }
                 else{
                     echo $open;
                }
             $current_column++;
            } while($current_column < ($y * 2));
            $current_line++;
            
            echo "\n";
        }
    }
    // $x = readline('Enter number of row: ');
    // $y = readline('Enter number of Column: ');
    // generate_card($x, $y);




    class Solution {

    
    function twoSum($nums, $target) {
        foreach($nums as $value){
            foreach($num as $sum_value){
                if($value !== $sumvalue && ($value + $sum_value) === $target){
                    return [array_search($value, $nums), array_search($sum_value, $nums) ];
                }
            }
            
        }
    }
}


phpinfo();