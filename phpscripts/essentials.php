<?php
    function get_human_time($time){
        $time = time() - $time;
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }
    }

    function seconds_to_string($seconds){
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($seconds < $unit) continue;
            $numberOfUnits = floor($seconds / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }
    }

    function timestamp_to_date($timestamp, $withtime=false){
        if($withtime){
            return getdate($timestamp)["mday"] . "/" . getdate($timestamp)["mon"] . "/" . getdate($timestamp)["year"] . " " . getdate($timestamp)["hours"] . ":" . getdate($timestamp)["minutes"] . ":" . getdate($timestamp)["seconds"];
        }else{
            return getdate($timestamp)["mday"] . "/" . getdate($timestamp)["mon"] . "/" . getdate($timestamp)["year"];
        }
    }

    function removeHTMLElement($identifier){
        echo "<script id='remove_script'>
            $('$identifier').remove()
        </script>";
    }

    function displayHTMLElement($identifier, $display){
        echo "<script id='remove_script'>
            $('$identifier').css('display', '$display')
        </script>";
    }

    function hideHTMLElement($identifier){
        echo "<script id='remove_script'>
            $('$identifier').css('display', 'none')
        </script>";
    }

    function redirectWindow($link){
        echo "<script id='remove_script'>
            window.location = '$link';
        </script>";
    }

    function filterXSS($string){
        $string = htmlspecialchars($string);
        $string = str_replace("javascript:", "javascript : ", $string);
        return $string;
    }
?>
