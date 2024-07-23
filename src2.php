<?php
$mpd_default = $_REQUEST['mpd'];
$key = $_REQUEST['key'];
$keyid = $_REQUEST['keyid'];
$b = $_REQUEST['begin'];
$e = $_REQUEST['end'];
$d = $_REQUEST['date'];
$img = $_REQUEST['img'];

// Convert time to DateTime object
$b1 = DateTime::createFromFormat('His', $b);
$b1->modify('+0 minutes');
$begin1 = $b1->format('His');

    
$e1 = DateTime::createFromFormat('His', $e);
$e1->modify('+0 minutes');
$end1 = $e1->format('His');


$begin = $d . "T" . $begin1;
$end = $d . "T" . $end1;

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

<div id="player"></div>  
<script type="text/javascript">    

const playerInstance = jwplayer("player").setup({    
   file: "<?php echo $mpd; ?>",
   position: 'bottom',
   image: '<?php echo $img; ?>',
        logo : { 
           file: "./logo.svg",
           hide: "false",
           margin: "10px",
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

