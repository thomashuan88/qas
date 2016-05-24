<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_average_time')) {
    /**
     * Calculate average time
     * @param  [array] $times [array of string h:i:s]
     * @return formatted timeformat[h:i:s]
     */
    function get_average_time($times) {
        $totalSeconds = 0;
        $count = count( $times );
        foreach ($times as $time) {
            list($hour, $minute, $second) = explode(':', $time);
            $totalSeconds += $hour * 60 * 60;
            $totalSeconds += $minute * 60;
            $totalSeconds += $second;
        }
        $averageSec = $totalSeconds / $count;

        $hours = floor($averageSec / 60 / 60 );
        $minutes = floor( ( $averageSec - ( $hours * 60 * 60 ) ) /60 );
        $seconds = round($averageSec - $hours * 60 * 60 - $minutes * 60);

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}

/* End of file get_average_time.php */
/* Location: ./application/helpers/get_average_time.php */