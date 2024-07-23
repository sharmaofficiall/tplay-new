<?php
//epg data

$json_url= "https://apstv.000webhostapp.com/tataplay/epg2.php?id=$id";

// Fetch the JSON data
$json_content = file_get_contents($json_url);

// Decode the JSON data
$epg_data = json_decode($json_content, true);
$epg_today = $epg_data['programs_today'];
$epg_yesterday = $epg_data['programs_yesterday'];
$epg_2daysago = $epg_data['programs_day_before_yesterday'];

?>

<?php

date_default_timezone_set('Asia/Kolkata'); // Set timezone to IST

// Get current time in H:i format (hours and minutes)
$today_date = date('Y-m-d');
$yesterday_date = date('Y-m-d', strtotime('-1 day'));


$current_time = date('H:i');

// Convert times to seconds since midnight to compare easily
$cts = strtotime($current_time);
?>

<html lang="en">
<head>    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="script.js"></script>
<title>AniPlay</title>
<link rel="icon" href="/logo.png" type="image/x-icon" sizes="any"/><link rel="apple-touch-icon" href="/logo.png" type="image/png" sizes="128x128"/>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrQkTy7dHw6KXy3MZzU15M6EufS5Az2xN1FL4xk5PpSXVwpOM8aVnPfjX4D2qM65V65Ff+HZO5qzKxkVXA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
.selected {
    background: rgba(54,69,79,1); /* Change this to your preferred color */
    color: #fff; /* Optional: Change text color for contrast */
}

    body{
       background: rgba(14,19,29,0.95);
       margin: 1.5%;
       color: #fff;
    }
    
header {
    background-color: #111;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

nav {
    display: flex;
    align-items: center;
    width: 100%;
}

.logo {
    font-size: 30px;
    font-weight: bold;
    color: #ff4081;
}

nav ul {
    display: flex;
    list-style: none;
    padding: 0;
}

nav ul li {
    margin: 0 20px;
}

nav ul li a {
    text-decoration: none;
    color: #fff;
}

.join-now {
    background-color: #ff4081;
    color: #fff;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    margin-left: auto;
}

main {
    padding: 0px;
}


.anime-list {
    display: flex;
    background: rgba(54,69,79,0.3);
    overflow-y: hidden; 
    margin-bottom: 20px;
    flex-direction: row-reverse;
    border-radius: 5px;
}
.anime-list::-webkit-scrollbar {
  display: none;
}
.anime-item {
    margin-top: 0px;
    margin-right: 0px;
    text-align: left;
    width: ; /* or any specific width */
    height: 200px;
    padding: 5px 10px;
    border-radius: 7px;
    position: relative;
    text-align: center;
    font-size: 1rem;
}

.anime-item img {
    width: 140px;
    height: 80px;
    object-position: cover;
    object-fit: center;
    border-radius: 10px;
}
  

.anime-item p {
    margin-top: 10px;
    font-weight: bold;
    font-size: 14px;
}

h3{
    margin-top: 30px;
}
.time{
    background: rgba(14,19,29,0.95);
    padding: 8px ;
    border-radius: 8px;
}
</style>
    
</head>
<body>

<div style="text-align: left;text-decoration: underline; font-size:16px; font-weight: bold; margin: 20px">Today <?php echo $today_date; ?></div>

<div class="anime-list">

 <?php 
 
$rev_today = array_reverse($epg_today);
 
foreach($rev_today as $p)
{
$start = $p['start_time_ist'];
$sts = strtotime($start);


if($sts < $cts)
{  
$title = $p['title'];
$des = $p['description'];
$imgsrc = str_replace('http','https',$p['poster']);

$start_date = $p['start_date_utc'];
$start_time = $p['start_time_utc'];
$end_time = $p['end_time_utc'];

echo "<div class='anime-item' img='$imgsrc' start_date='$start_date' start_time='$start_time' end_time='$end_time'><a style='text-decoration: none; color: #fff;'>";
echo "<p class='time'>$start $m</p>";
echo "<img src='$imgsrc' alt='$title'>";
echo "<p style='font-size: 11px'>$title</p>";
echo "</a></div>";
}
}
?>            
         </div>
            

<?php

/*
<div style="text-align: left;text-decoration: underline; font-size:16px; font-weight: bold; margin: 20px;">Yesterday <?php echo $yesterday_date; ?></div>

<div class="anime-list">

 <?php 
 
$rev_today = array_reverse($epg_yesterday);
 
foreach($rev_today as $p)
{
$start = $p['start_time_ist'];
$sts = strtotime($start);


$title = $p['title'];
$des = $p['description'];
$imgsrc = str_replace('http','https',$p['poster']);

$start_date = $p['start_date_utc'];
$start_time = $p['start_time_utc'];
$end_time = $p['end_time_utc'];

echo "<div class='anime-item' start_date='$start_date' start_time='$start_time' end_time='$end_time'><a style='text-decoration: none; color: #fff;'>";
echo "<p class='time'>$start $m</p>";
echo "<img src='$imgsrc' alt='$title'>";
echo "<p style='font-size: 11px;'>$title</p>";
echo "</a></div>";

}
?>            
 </div>
 
*/
?>
  </main>

<script>

  // Function to handle the click event
  function handleClick(event) {
    // Get the clicked div
    const div = event.currentTarget;

    // Retrieve the start, end, and date attributes
    const start = div.getAttribute('start_time');
    const end = div.getAttribute('end_time');
    const date = div.getAttribute('start_date');
    const img = div.getAttribute('img');

    /* Output the values to the console or use them as needed
    console.log('Start:', start);
    console.log('End:', end);
    console.log('Date:', date);
   */
document.getElementById('poster').style.display = 'none';

var iframe = document.getElementById('videoIframe');
var url = '<?php echo "./src2.php?mpd=$mpd&key=$key&keyid=$keyid&begin="; ?>' + start + '&end=' + end + '&date=' + date + '&img=' + img;
iframe.src = url;
iframe.style.display = 'block'; 
   
// Remove 'selected' class from any previously selected div
      document.querySelectorAll('.anime-item').forEach(selectedDiv => {
        selectedDiv.classList.remove('selected');
      });

      // Add 'selected' class to the clicked div
      div.classList.add('selected');
      
      
window.scrollTo({
                top: 0,
                behavior: 'smooth' // Smooth scrolling animation
            });      
      
    
  }

  // Attach the click event listener to all divs with the class 'time-slot'
  document.querySelectorAll('.anime-item').forEach(div => {
    div.addEventListener('click', handleClick);
  }); 
 
 
</script>  
