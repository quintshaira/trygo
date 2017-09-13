<?php
function Get_quarter_dates($year,$querter)
{
    switch ($querter) {
        case (1):
            $sd='01/01/'.$year;
            $nd='31/03/'.$year;
            break;
        case (2):
            $sd='01/04/'.$year;
            $nd='30/06/'.$year;
            break;
        case (3):
            $sd='01/07/'.$year;
            $nd='30/09/'.$year;
            break;
        case (4):
            $sd='01/10/'.$year;
            $nd='31/12/'.$year;
            break;
    }
    return array('sd'=>$sd,'nd'=>$nd);
}


function convertDateInDBFormat($date, $seperator, $format)
{
    $date_array = explode($seperator, $date);

    if($format == 'dmy') {
        $new_date = $date_array[2] . '-' . $date_array[1] . '-' . $date_array[0];
    } else if ($format == 'mdy'){
        $new_date = $date_array[2] . '-' . $date_array[0] . '-' . $date_array[1];
    } else { // ymd
        $new_date = $date_array[0] . '-' . $date_array[1] . '-' . $date_array[2];
    }

    return $new_date;
}



function agentGradeWisePoint($grade)
{
    if($grade == 'A') {
        $pt = 5;
    } else if($grade == 'B') {
        $pt = 4;
    } else if($grade == 'C') {
        $pt = 3;
    } else if($grade == 'D') {
        $pt = 2;
    } else if($grade == 'E') {
        $pt = 1;
    } else {
        $pt = 0;
    }

    return $pt;
}


function supervisorGradeWisePoint($grade)
{
    if($grade == 'Good') {
        $pt = 4;
    } else if($grade == 'Satisfactory') {
        $pt = 3;
    } else if($grade == 'Fair') {
        $pt = 2;
    } else if($grade == 'Unsatisfactory') {
        $pt = 1;
    } else {
        $pt = 0;
    }

    return $pt;
}
?>