

<?php
$id = $_REQUEST['id'];
if(empty($id)){
echo "Error: unauthorised access!!!";
exit();
}

if($id == 't20eng')
{
  $id = 78;
/*
$url = '/astro.php';
header("Location: $url");
exit();
*/
}
else if($id == 't20hin')
{
$id = 24;
}


// Define the URL
$url = "https://tplayapi.code-crafters.app/321codecrafters/fetcher.json";

// Fetch and decode the JSON data
$data = json_decode(file_get_contents($url), true);

foreach($data['data']['channels'] as $channel)
if($channel['id'] == $id) {
    $title = $channel['name'];
    $src = "https://mediaready.videoready.tv/tatasky-epg/image/fetch/f_auto,fl_lossy,q_auto,w_500/" . $channel['logo_url'];
    $genres = $channel['genres'];
    $languages = $channel['languages'];
$mpd = $channel['manifest_url'];
foreach($channel['clearkeys'] as $clearkey) {
$hex = $clearkey['hex'];
break;
}
}

list($keyid, $key) = explode(':', $hex);

$mpd = str_replace('web','prod',$mpd);
$mpd = str_replace('.akamaized','catchup.akamaized',$mpd);

?>

<?php
//epg data

$json_url= "https://apstv.000webhostapp.com/tataplay/epg.php?id=$id";

// Fetch the JSON data
$json_content = file_get_contents($json_url);

// Decode the JSON data
$epg_data = json_decode($json_content, true);
$epgc = $epg_data['current_program'];
$epgn = $epg_data['next_program'];
$epgp = $epg_data['previous_programs'];

//current program
$epgc_title = $epgc['title'];
$epgc_date = $epgc['start_date_ist'];
$epgc_start = $epgc['start_time_ist'];
$epgc_end = $epgc['end_time_ist'];
$epgc_description = $epgc['description'];
$epgc_poster = $epgc['poster'];

//next program
$epgn_title = $epgn['title'];
$epgn_date = $epgn['start_date_ist'];
$epgn_start = $epgn['start_time_ist'];
$epgn_end = $epgn['end_time_ist'];
$epgn_description = $epgn['description'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    
    <title><?php echo $title . " - " . $year; ?> - CineMix</title>
    <style>
    body{
       background: rgba(14,19,29,0.95);
       margin: 1.5%;
       color: #fff;
    }

iframe{
        display: none;
        position: ;
        width: 100%;
        height: 100%;
        margin-top: 20px;
        aspect-ratio: 16/9; 
      //  max-width: 700px;
        max-height: 600px;
       // min-height: 260px;
       border-radius: 10px;
        background: url('./load1.svg') no-repeat;
        background-size: center;        
        background-position: center;
    }
    
    #player{
     display: none;
     position: ;
    }
            .container {
            width: 100%;
            border: 0px solid rgba(54,69,79,0.7);
            backdrop-filter: blur(15px); 
            padding: 0px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
            overflow: hidden;
            display: flex;
            flex-start: start;
    flex-direction: column;
    align-items: center;
            color: #fff;
            margin-top: 0px;         
            transition: transform 1s;
            opacity: 1;
        }

@media (min-width: 768px) {
.container {
      flex-direction: row;
      justify-content: center;
    }

    .movie {
      margin-top: 0px;
      margin-left: 0px; /* Adjust as needed */
      text-align: left;
      background: rgba(54,69,79,0.3);
      padding: 10px;
    }
  }
     .movie{
    margin-top: 10px;
    text-align: left;
    background: rgba(54,69,79,0.3);
    padding: 20px;
    border-radius: 8px;
    border: 0px solid rgba(255, 255, 255, .2);
    margin-top: -20px;
     }

        .movie-poster {
    width: 200px;
    height: ;
    margin-top: 10px;
    border-radius: 10px;
    margin-bottom: 0px;
    
        }
       
      .movie-title {
          width: 100%;
            align-items: center;
            text-align: left;
            font-size: 20px;
            font-weight: bold;
        }
      .movie-title img{
          max-width: 100%;
          max-height: 80px;
      }

     .movie-overview {
        font-size: 14px;
        margin-bottom: 20px;
        padding: 0px 0px;
        max-height: 350px;
        }

        .movie-release {
            font-size: 14px;
            margin-bottom: 20px;
           
        }

        .movie-details {
            font-size: 14px;
            margin-top: 15px;
        }
.episode-container {
    width: 100%;
   margin-top: 15px;
   display: grid;
 grid-template-columns: repeat(1, 1fr); /* Two columns */
 align-items: center;
 text-align: center;
 
}   
.episode-card {
    align-items: center;
    padding: 5px;
    border: 0px solid #ccc;
    border-radius: 5px;
    text-align: center;
    background: rgba(54,69,79,0.3);
}

.episode-image {
    max-width: 200px;
    height: 50%;
    margin: 0%;
    border-radius: 5px;
    position: center;
    background-size: cover;
    padding: 5px;
}

.episode-details {
    flex: 1;
    font-size: 14px;
   // font-weight: bold;
    font-family: ;
    color: #fff;
    padding: 5px;
    align-items: center;
    text-align: center;
}
.episode-details img{
    max-width: 150px;
    max-height: ;
}
.anime-info{
    width: 100%;
}
.home{
    margin: 10px 0px;
    border-radius: 5px;
    padding: 10px;
    text-align: center;
    width: 120px;
    background: rgba(54,69,79,0.8);
}
a{
    text-decoration: none;
    color: #fff;
    font-size: 14px;
}
        .watch-btn {
            border: 5px solid #aaa;
            border-radius: 10px;
            padding: 15px;
            align-items: center;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
        }
.play-btn{
    background: rgba(54,69,79,1);
    padding: 8px 20px;
    border-radius: 5px;
    width: 120px;
    font-weight: bold;
    }
</style>

</head>

<body>

<a href="./">
    <div class="home">
       <span>Return to Home</span>
    </div>
</a>


<div id="">
 <iframe id="videoIframe" src="" allowfullscreen="1" frameborder="0" marginheight="0" marginwidth="0" scrolling="no">   </iframe>

<div id="epg" style="display: none; text-align: center; font-size: 13px; color: #e4d00a">Start and end timings are not exact. Kindly seek forward to get the time where selected show begins.</div>
 <br>
</div>

  


<div id="main" class="container" style="width: 100%;">
<div id="poster" class="movie" style="background: transparent; text-align: center">
<img class="movie-poster" src="<?php echo $src; ?>" alt="<?php echo $title; ?>">
    <?php  echo "<p style='font-size: 20px; color: #e4d00a'><strong>$title</strong></p>"; ?>
    
<?php
 if (!empty($genres)) {
 echo "<p style='margin-top: 20px; margin-bottom: 25px'>";
 foreach ($genres as $genre) {
  echo "<a style='padding: 5px 8px; font-size: 12px; border-radius: 3px; margin-right: 8px; background: rgba(54,69,79,0.9);'><strong>" .  $genre . "</strong></a>";
     }
  echo "</p>";
  }
?>

</div>

<div class="movie" style="margin-top: 0px;">
<img style="float: right; margin-right: 5px; max-width: 35%; border-radius: 7px;" src="<?php echo $epgc_poster; ?>" />
<div class="movie-title" style="color: #fff; font-size: 16px; margin-top: 0px;"><?php echo $epgc_title; ?>
</div>

<div class="movie-details">
        
   <p><a style="background: rgba(54,69,79,0.9); padding: 7px; color: #fff; font-size: 13px; border-radius: 3px 0 0 3px"><strong>&nbsp;&nbsp;Date</strong>
        </a>
        <a style="background: ; padding: 5px 10px; color: #fff;border: 2px solid rgba(54,69,79,0.9);font-size: 13px; margin-right: 10px;border-radius: 0 3px 3px 0"><strong>&nbsp;<?php echo $epgc_date; ?></strong>
    </a></p>
    
    
     <div style="margin-top: 25px;"><a style="background: #fff; padding: 6px; color: #000; font-size: 12px;border-radius: 3px 0 0 3px"><strong>&nbsp;&nbsp;Start</strong>
        </a>
        <a style="background: ; padding: 4.1px; color: #fff;border: 2px solid #fff;font-size: 12px; margin-right: 10px;border-radius: 0 3px 3px 0"><strong>&nbsp;<?php echo $epgc_start; ?></strong>
     </a>
    
        <a style="background: #fff; padding: 6px; font-size: 12px;color: #000;border-radius: 3px 0 0 3px"><strong>&nbsp;&nbsp;End</strong>
        </a>
        <a style="background: ; padding: 4.1px; color: #fff;border: 2px solid #fff;font-size: 12px; border-radius: 0 3px 3px 0"><strong>&nbsp;<?php echo $epgc_end; ?>&nbsp;</strong>
        </a>  
    </div>

            </div><br>
                  <div class="movie-overview" style="font-family: arial; text-align: justify;"><strong></strong><?php echo $epgc_description; ?>
      </div> 
 <img style="float: right;margin-right: 5px; margin-top: -25px; max-width: 90px;" src="https://static.vecteezy.com/system/resources/previews/009/345/263/non_2x/live-streaming-icon-design-for-the-broadcast-system-live-streaming-icon-with-red-and-white-color-live-streaming-vector-design-with-font-effect-red-and-white-gradient-color-design-free-png.png" />
  <div class="play-btn" onclick='watchnow()'>
      ▶ Watch Live</div>
    
    </div>
    </div>
</div>


<?php include('./previous.php'); 
//include('next.php');
?>

<script>

function watchnow(){
    
 document.getElementById("poster").style.display = "none";
 
      // Show the iframe overlay
var iframe = document.getElementById("videoIframe");
iframe.style.display = 'block';
iframe.src = '<?php echo "./src.php?mpd=$mpd&key=$key&keyid=$keyid&img=$epgc_poster"; ?>';

document.getElementById('epg').style.display = 'none';

window.scrollTo({
    top: 0,
     behavior: 'smooth' // Smooth scrolling animation
            });
            
// Remove 'selected' class from any previously selected div
      document.querySelectorAll('.anime-item').forEach(selectedDiv => {
        selectedDiv.classList.remove('selected');
      });
            
}

   document.addEventListener('contextmenu', event => event.preventDefault());
document.addEventListener('keydown', event => {
    if (event.ctrlKey && (event.key === 'u' || event.key === 's' || event.key === 'c' || event.key === 'i')) {
        event.preventDefault();
    }
});

document.addEventListener('keydown', event => {
    if (event.key === 'F12') {
        event.preventDefault();
    }
});

window.addEventListener('devtoolschange', event => {
    // Developer tools were opened
    // Perform actions like redirecting or disabling functionality
    // For example:
    window.location.href = 'error-page.html'; // Redirect to an error page
});
window.addEventListener('devtoolschange', function(event) {
    if (event.detail.isOpen) {
        alert('Developer tools are restricted on this website.');
    }
});


</script>
    

</html>
