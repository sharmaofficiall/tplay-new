
<?php
$mpd_default = $_REQUEST['mpd'];
$key = $_REQUEST['key'];
$keyid = $_REQUEST['keyid'];
$img = $_REQUEST['img'];
?>

<?php

// Create a DateTime object in GMT
$dt = new DateTime('now', new DateTimeZone('GMT'));

// Format current date and time
$currentDate = $dt->format('Ymd');
$currentTime = $dt->format('His');

// Format date one week ago
$begin = $dt->modify('-1 day')->format('Ymd') . "T" . $currentTime;
$end = $dt->modify('+2 days')->format('Ymd') . "T" . $currentTime;


$mpd = $mpd_default . "?begin=" . $begin . "&end=" . $end;

?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">  
<script src="//content.jwplatform.com/libraries/SAHhwvZq.js"></script> 

<title>
   <?php echo $data['name']; ?>
</title>
<style>   
   body {   
             margin: 0px;
             text-align: center;
        }   
      
        .jwplayer {   
             position:  
        }   
      
        .jwplayer.jw-flag-aspect-mode {   
             min-height: auto;   
             max-height: 100%   
        }   
   jwplayer.setup("logo": "https://apstv.000webhostapp.com/logo.png") 
.episode-container {
    width: 100%;
    margin-top: 40px;
   display: grid;
 grid-template-columns: repeat(1, 1fr); /* Two columns */
}   
.episode-card {
    align-items: center;
    padding: 10px;
    padding-left: 10px;
    border: 0px solid #ccc;
    border-radius: 5px;
    text-align: left;
    background: rgba(54,69,79,0.3);
    display: flex;
}

.episode-image {
    width: 100px;
    height: 100px;
    margin-right: 10px;
    border-radius: 5px;
    overflow: hidden;
    
}

.episode-details {
    flex: 1;
    font-size: 1.2em;
    font-weight: bold;
    font-family: Monospace;
}
  </style>  

<body>  

<div id="jwplayerDiv"></div>  
<script type="text/javascript">    
jwplayer("jwplayerDiv").setup({    
   file: "<?php echo $mpd; ?>",
   position: 'bottom',   
   image: '<?php echo $img; ?>',
    
        logo : { 
           file: "https://static.vecteezy.com/system/resources/previews/009/345/263/non_2x/live-streaming-icon-design-for-the-broadcast-system-live-streaming-icon-with-red-and-white-color-live-streaming-vector-design-with-font-effect-red-and-white-gradient-color-design-free-png.png",
           hide: "false",
           margin: "10px",
           width: "50px",
           position: "top-left"
        },
      type: "dash",    
      drm: { "clearkey": {    
              "keyId": "<?php echo $keyid; ?>",    
              "key": "<?php echo $key; ?>"   
            }    
             }               
});    
</script>

