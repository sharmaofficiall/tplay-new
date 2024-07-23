<?php
$id = $_REQUEST['id'];

// Specify the URL of the XMLTV file
$xmltv_url = 'https://raw.githubusercontent.com/mitthu786/tvepg/main/tataplay/epg.xml.gz';

// Download and save the XMLTV file locally
$temp_file = tempnam(sys_get_temp_dir(), 'epg');
copy($xmltv_url, $temp_file);

// Decompress the XMLTV file if necessary (assuming it's gzip-compressed)
$xml_content = file_get_contents('compress.zlib://' . $temp_file);

// Parse the XML content
$xml = simplexml_load_string($xml_content);

if ($xml === false) {
    die('Error parsing XML');
}

// Function to convert UTC time to IST and return separate date and time
function convert_utc_to_ist_separate($utc_time) {
    $utc_timestamp = strtotime($utc_time);
    $ist_timestamp = $utc_timestamp + 5.5 * 3600; // Add 5 hours 30 minutes for IST
    return [
        'date' => date('Y-m-d', $ist_timestamp),
        'time' => date('H:i', $ist_timestamp)
    ];
}

// Function to return separate UTC date and time
function separate_utc_date_time($utc_time) {
    $utc_timestamp = strtotime($utc_time);
    return [
        'date' => date('Ymd', $utc_timestamp),
        'time' => date('His', $utc_timestamp)
    ];
}

// Get the current timestamp in UTC
$current_time_utc = time();
$current_time_ist = $current_time_utc + 5.5 * 3600; // Convert current UTC time to IST

// Initialize arrays to hold current, previous, and next program details
$current_program = array();
$programs_today = array();
$programs_yesterday = array();
$programs_day_before_yesterday = array();
$next_program = array();

// Example: Get EPG data for a specific channel
$channel_id = "ts$id";

// Calculate timestamps for the start and end of today, yesterday, and the day before yesterday in IST
$start_today_ist = strtotime("today midnight", $current_time_ist);
$end_today_ist = strtotime("tomorrow midnight", $current_time_ist) - 1;
$start_yesterday_ist = strtotime("yesterday midnight", $current_time_ist);
$end_yesterday_ist = $start_today_ist - 1;
$start_day_before_yesterday_ist = strtotime("2 days ago midnight", $current_time_ist);
$end_day_before_yesterday_ist = $start_yesterday_ist - 1;

$programs = array();
foreach ($xml->programme as $programme) {
    $attributes = $programme->attributes();
    if ((string)$attributes['channel'] == $channel_id) {
        $programs[] = $programme;
    }
}

// Sort programs by start time
usort($programs, function($a, $b) {
    return strtotime((string)$a->attributes()['start']) - strtotime((string)$b->attributes()['start']);
});

$current_index = null;
foreach ($programs as $index => $programme) {
    $attributes = $programme->attributes();
    $start_utc = (string)$attributes['start'];
    $end_utc = (string)$attributes['stop'];
    $poster = (string)$programme->icon['src']; // Extracting from <icon src="">

    // Convert start time to IST timestamp
    $start_time_ist = strtotime($start_utc) + 5.5 * 3600;

    // Determine which day the program belongs to based on IST
    if ($start_time_ist >= $start_today_ist && $start_time_ist <= $end_today_ist) {
        $programs_today[] = [
            'channel_id' => $channel_id,
            'start_date_utc' => separate_utc_date_time($start_utc)['date'],
            'start_time_utc' => separate_utc_date_time($start_utc)['time'],
            'end_date_utc' => separate_utc_date_time($end_utc)['date'],
            'end_time_utc' => separate_utc_date_time($end_utc)['time'],
            'start_date_ist' => convert_utc_to_ist_separate($start_utc)['date'],
            'start_time_ist' => convert_utc_to_ist_separate($start_utc)['time'],
            'end_date_ist' => convert_utc_to_ist_separate($end_utc)['date'],
            'end_time_ist' => convert_utc_to_ist_separate($end_utc)['time'],
            'title' => (string)$programme->title,
            'description' => (string)$programme->desc,
            'poster' => $poster
        ];
    } elseif ($start_time_ist >= $start_yesterday_ist && $start_time_ist <= $end_yesterday_ist) {
        $programs_yesterday[] = [
            'channel_id' => $channel_id,
            'start_date_utc' => separate_utc_date_time($start_utc)['date'],
            'start_time_utc' => separate_utc_date_time($start_utc)['time'],
            'end_date_utc' => separate_utc_date_time($end_utc)['date'],
            'end_time_utc' => separate_utc_date_time($end_utc)['time'],
            'start_date_ist' => convert_utc_to_ist_separate($start_utc)['date'],
            'start_time_ist' => convert_utc_to_ist_separate($start_utc)['time'],
            'end_date_ist' => convert_utc_to_ist_separate($end_utc)['date'],
            'end_time_ist' => convert_utc_to_ist_separate($end_utc)['time'],
            'title' => (string)$programme->title,
            'description' => (string)$programme->desc,
            'poster' => $poster
        ];
    } elseif ($start_time_ist >= $start_day_before_yesterday_ist && $start_time_ist <= $end_day_before_yesterday_ist) {
        $programs_day_before_yesterday[] = [
            'channel_id' => $channel_id,
            'start_date_utc' => separate_utc_date_time($start_utc)['date'],
            'start_time_utc' => separate_utc_date_time($start_utc)['time'],
            'end_date_utc' => separate_utc_date_time($end_utc)['date'],
            'end_time_utc' => separate_utc_date_time($end_utc)['time'],
            'start_date_ist' => convert_utc_to_ist_separate($start_utc)['date'],
            'start_time_ist' => convert_utc_to_ist_separate($start_utc)['time'],
            'end_date_ist' => convert_utc_to_ist_separate($end_utc)['date'],
            'end_time_ist' => convert_utc_to_ist_separate($end_utc)['time'],
            'title' => (string)$programme->title,
            'description' => (string)$programme->desc,
            'poster' => $poster
        ];
    }

    // Determine the current program
    if ($current_time_utc >= strtotime($start_utc) && $current_time_utc < strtotime($end_utc)) {
        $current_program = [
            'channel_id' => $channel_id,
            'start_date_utc' => separate_utc_date_time($start_utc)['date'],
            'start_time_utc' => separate_utc_date_time($start_utc)['time'],
            'end_date_utc' => separate_utc_date_time($end_utc)['date'],
            'end_time_utc' => separate_utc_date_time($end_utc)['time'],
            'start_date_ist' => convert_utc_to_ist_separate($start_utc)['date'],
            'start_time_ist' => convert_utc_to_ist_separate($start_utc)['time'],
            'end_date_ist' => convert_utc_to_ist_separate($end_utc)['date'],
            'end_time_ist' => convert_utc_to_ist_separate($end_utc)['time'],
            'title' => (string)$programme->title,
            'description' => (string)$programme->desc,
            'poster' => $poster
        ];
        $current_index = $index;
    }
}

// Get next program
if ($current_index !== null && isset($programs[$current_index + 1])) {
    $programme = $programs[$current_index + 1];
    $attributes = $programme->attributes();
    $start_utc = (string)$attributes['start'];
    $end_utc = (string)$attributes['stop'];
    $poster = (string)$programme->icon['src']; // Extracting from <icon src="">

    $next_program = [
        'channel_id' => $channel_id,
        'start_date_utc' => separate_utc_date_time($start_utc)['date'],
        'start_time_utc' => separate_utc_date_time($start_utc)['time'],
        'end_date_utc' => separate_utc_date_time($end_utc)['date'],
        'end_time_utc' => separate_utc_date_time($end_utc)['time'],
        'start_date_ist' => convert_utc_to_ist_separate($start_utc)['date'],
        'start_time_ist' => convert_utc_to_ist_separate($start_utc)['time'],
        'end_date_ist' => convert_utc_to_ist_separate($end_utc)['date'],
        'end_time_ist' => convert_utc_to_ist_separate($end_utc)['time'],
        'title' => (string)$programme->title,
        'description' => (string)$programme->desc,
        'poster' => $poster
    ];
}

// Output EPG data in JSON format
header('Content-Type: application/json');
echo json_encode([
    'current_program' => $current_program,
    'programs_today' => $programs_today,
    'programs_yesterday' => $programs_yesterday,
    'programs_day_before_yesterday' => $programs_day_before_yesterday,
    'next_program' => $next_program
], JSON_PRETTY_PRINT);

// Clean up: Delete temporary file
unlink($temp_file);
?>
