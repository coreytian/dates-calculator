<?php

echo "Enter the dates your want to check (format dd/mm/yyyy - dd/mm/yyyy): \n";

$handle = fopen ("php://stdin","r");
// Continually wait for user input
while($line = trim(fgets($handle))){
    
    // Enter QUIT/quit to terminate 
    if(strtoupper($line) == 'QUIT'){ 
        exit("Bye!\n");
    }

    $pattern = '/^([\d]{2}\/[\d]{2}\/[\d]{4})( - )([\d]{2}\/[\d]{2}\/[\d]{4})$/';
    if(preg_match($pattern, $line, $group)){
        $date1 = explode('/', $group[1]);
        if(!checkdate($date1[1],$date1[0], $date1[2])){
            echo  $group[1]." is not a valid date.\nPlease re-enter the two dates:\n";
            continue;
        }
        $date2 = explode('/', $group[3]);
        if(!checkdate($date2[1],$date2[0], $date2[2])){
            echo  $group[3]." is not a valid date.\nPlease re-enter the two dates:\n";
            continue;
        }
        $date1 = DateTime::createFromFormat('d/m/Y H:i:s', $group[1]." 00:00:00");
        $date2 = DateTime::createFromFormat('d/m/Y H:i:s', $group[3]." 00:00:00");

        $dateMin = new DateTime('1901-01-01');
        $dateMax = new DateTime('2999-12-31');

        if($date1 < $dateMin || $date2 < $dateMin){
            echo  "Date cannot be before 01/01/1901.\nPlease re-enter the two dates:\n";
            continue;
        }
        if($date1 > $dateMax || $date2 > $dateMax){
            echo  "Date cannot be after 31/12/2999.\nPlease re-enter the two dates:\n";
            continue;
        }

        $interval = $date1->diff($date2);

        $days = $interval->days == 0?$interval->days:$interval->days - 1;

        echo "$days days. \n";
        echo "\nEnter the dates your want to check (format dd/mm/yyyy - dd/mm/yyyy): \n";
        continue;

    }else{
        echo "The input format is not correct. It should be dd/mm/yyyy - dd/mm/yyyy\nPlease re-enter the two dates:\n";
        continue;
    }
}

