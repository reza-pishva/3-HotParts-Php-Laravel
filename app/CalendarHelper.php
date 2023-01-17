<?php

namespace App;

class CalendarHelper
{
    public function jDisplay($timestamp)
    {
        list($hour, $minute, $second) = explode( ':', date( 'H:i:s', time() ) );
        $today = time() - ( $hour*3600+$minute*60+$second );
        if ( $timestamp > $today ) return 'امروز';
        elseif ( $timestamp > $today-86400 ) return 'دیروز';
        else return $this->jdate( $timestamp, false, true );
    }

    public function yearList($end=1970)
    {
        $year = (int)date('Y', time());
        return $this->_yearList($year, $end);
    }

    private function _yearList($year, $end)
    {
        if ( $year < $end ) return array();

        $years[] = $year;
        while ( $year > $end ) {
            $year--;
            $years[] = $year;
        }
        return $years;
    }

    public function jYearList($end=1340)
    {
        $list = explode(' ', $this->jdate( date('Y-m-d-D H:i:s', time()), true, false ) );
        $year = (int)$list[3];
        return $this->_yearList($year, $end);
    }

    public function jNow()
    {
        $list = explode(' ', $this->jdate( date('Y-m-d-D H:i:s', time()), true, false ) );
        return array(
            'year' => $list[3],
            'month' => $list[2],
            'day' => $list[1],
            'dayofweek' => $list[0],
            'time' => $list[4]
        );
    }

    public function gTime($date, $hour, $minute)
    {
        list($j_y,$j_m,$j_d) = explode('/', $date);
        list($g_y, $g_m, $g_d) = $this->jalali_to_gregorian($j_y,$j_m,$j_d);
        $hour = str_pad( $hour, 2, '0', STR_PAD_LEFT );
        $minute = str_pad( $minute, 2, '0', STR_PAD_LEFT );
        $time_str = $g_y.'-'.$g_m.'-'.$g_d.' '.$hour.':'.$minute.':00';
        $time = strtotime($time_str);
        $time -= 12600;
        return $time;
    }

    public function jdate($datetime, $hastime=false, $localize=true)
    {
        list ($date,$time) = explode (' ', $datetime);
        $dateArray = explode ('-', $date);
        if ( count($dateArray) == 4 ) {
            list ($g_y, $g_m, $g_d,$g_w) = $dateArray;
        } else {
            list ($g_y, $g_m, $g_d) = $dateArray;
            $g_w = '';
            $jw = '';
        }
        $jy=$g_y;
        $i=$g_m-1;
        $j_day_no=$g_d-1;
        if($g_y>1600)
        {
            $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
            $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

            $div = create_function('$a,$b','return (int) ($a / $b);');

            $gy = $g_y-1600;
            $gm = $g_m-1;
            $gd = $g_d-1;
            $g_day_no = 365*$gy+$div($gy+3,4)-$div($gy+99,100)+$div($gy+399,400);

            for ($i=0; $i < $gm; ++$i)
                $g_day_no += $g_days_in_month[$i];

            if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0))) {
                /* leap and after Feb */
                $g_day_no++;
            }

            $g_day_no += $gd;

            $j_day_no = $g_day_no-79;

            $j_np = $div($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */
            $j_day_no = $j_day_no % 12053;

            $jy = 979+33*$j_np+4*$div($j_day_no,1461); /* 1461 = 365*4 + 4/4 */
            $j_day_no %= 1461;

            if ($j_day_no >= 366)
            {
                $jy += $div($j_day_no-1, 365);
                $j_day_no = ($j_day_no-1)%365;
            }

            for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i)
                $j_day_no -= $j_days_in_month[$i];
        }

        if ($localize == false )
            $jm = $i+1;
        else
            switch($i){
                case 0:
                    $jm="فروردین";
                    break;
                case 1:
                    $jm="اردیبهشت";
                    break;
                case 2:
                    $jm="خرداد";
                    break;
                case 3:
                    $jm="تیر";
                    break;
                case 4:
                    $jm="مرداد";
                    break;
                case 5:
                    $jm="شهریور";
                    break;
                case 6:
                    $jm="مهر";
                    break;
                case 7:
                    $jm="آبان";
                    break;
                case 8:
                    $jm="آذر";
                    break;
                case 9:
                    $jm="دی";
                    break;
                case 10:
                    $jm="بهمن";
                    break;
                case 11:
                    $jm="اسفند";
                    break;
            };
        $jd = $j_day_no+1;
        switch($g_w){
            case "Sat":
                $jw="&#1588;&#1606;&#1576;&#1607;";
                break;
            case "Sun":
                $jw="&#1610;&#1603;&#8204;&#1588;&#1606;&#1576;&#1607;";
                break;
            case "Mon":
                $jw="&#1583;&#1608;&#1588;&#1606;&#1576;&#1607;";
                break;
            case "Tue":
                $jw="&#1587;&#1607;&#8204;&#1588;&#1606;&#1576;&#1607;";
                break;
            case "Wed":
                $jw="&#1670;&#1607;&#1575;&#1585;&#1588;&#1606;&#1576;&#1607;";
                break;
            case "Thu":
                $jw="&#1662;&#1606;&#1580;&#8204;&#1588;&#1606;&#1576;&#1607;";
                break;
            case "Fri":
                $jw="&#1580;&#1605;&#1593;&#1607;";
                break;
        };

        $time = $hastime == false ? '' : $time;

        return "$jw $jd $jm $jy $time";
    }

    function div($a,$b) {
        return (int) ($a / $b);
    }

    function jalali_to_gregorian($j_y, $j_m, $j_d)
    {
        $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);



        $jy = $j_y-979;
        $jm = $j_m-1;
        $jd = $j_d-1;

        $j_day_no = 365*$jy + $this->div($jy, 33)*8 + $this->div($jy%33+3, 4);
        for ($i=0; $i < $jm; ++$i)
            $j_day_no += $j_days_in_month[$i];

        $j_day_no += $jd;

        $g_day_no = $j_day_no+79;

        $gy = 1600 + 400*$this->div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
        $g_day_no = $g_day_no % 146097;

        $leap = true;
        if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
        {
            $g_day_no--;
            $gy += 100*$this->div($g_day_no,  36524); /* 36524 = 365*100 + 100/4 - 100/100 */
            $g_day_no = $g_day_no % 36524;

            if ($g_day_no >= 365)
                $g_day_no++;
            else
                $leap = false;
        }

        $gy += 4*$this->div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */
        $g_day_no %= 1461;

        if ($g_day_no >= 366) {
            $leap = false;

            $g_day_no--;
            $gy += $this->div($g_day_no, 365);
            $g_day_no = $g_day_no % 365;
        }

        for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++)
            $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap);
        $gm = $i+1;
        $gd = $g_day_no+1;

        return array($gy, $gm, $gd);
    }

    function gregorian_to_jalali($g_y, $g_m, $g_d)
    {
        $d_4 = $g_y % 4;
        $g_a = array(0, 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
        $doy_g = $g_a[(int)$g_m] + $g_d;
        if ($d_4 == 0 and $g_m > 2)
            $doy_g++;
        $d_33 = (int)((($g_y - 16) % 132) * 0.0305);
        $a = ($d_33 == 3 or $d_33 < ($d_4 - 1) or $d_4 == 0) ? 286 : 287;
        $b = (($d_33 == 1 or $d_33 == 2) and ($d_33 == $d_4 or $d_4 == 1)) ? 78 : (($d_33 == 3 and $d_4 == 0) ? 80 : 79);
        if((int)(($g_y - 10) / 63) == 30) {
            $a--;
            $b++;
        }
        if($doy_g > $b) {
            $jy = $g_y - 621;
            $doy_j = $doy_g - $b;
        }
        else {
            $jy = $g_y - 622;
            $doy_j = $doy_g + $a;
        }
        if($doy_j < 187) {
            $jm = (int)(($doy_j - 1) / 31);
            $jd = $doy_j - (31 * $jm++);
        }
        else {
            $jm = (int)(($doy_j - 187) / 30);
            $jd = $doy_j - 186 - ($jm * 30);
            $jm += 7;
        }
        return array($jy, $jm, $jd);
    }

}
