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
?>