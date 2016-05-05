<?php
$slack_webhook_uri = 'YOUR_SLACK_HOOK_URI';
$ch = curl_init($slack_webhook_uri);

$IP_sonos_1 = "YOUR_SONO_IP";
require("sonos.class.php");
$sonos_1 = new SonosPHPController($IP_sonos_1); 

while (true) {
  $info = $sonos_1->GetPositionInfo();
  $duration = strtotime($info['TrackDuration']) - strtotime($info['RelTime']);
  if ($duration <= 0) {
    echo "No TrackDuration, setting next check 300 seconds later\n";
    $duration = 300;
  }

  if ($info['Title'] != "" && $title != $info['Title']) {
    $title = $info['Title'];
    $message = htmlspecialchars_decode("Your Sonos are currently playing: *".$info['Title']."* from the album *".$info['Album']."* by *".$info['TitleArtist']."*", ENT_QUOTES | ENT_HTML5);
  
    $data = "payload=" . json_encode(array(
      "channel"       =>  "#sonos-sydney",
      "text"          =>  $message
    ));
  
    if (preg_match('/pandora/', $info['TrackURI'])) {
      parse_str(htmlspecialchars_decode(parse_url(urldecode($info["TrackURI"]), PHP_URL_QUERY)), $album_image);
      if ($album_image['a'] != "") {
        $attachments = array([
          'title'     => '',
          'image_url' => $album_image['a']
        ]);
      }
      $data = "payload=" . json_encode(array(
        "channel"       =>  "#sonos-sydney",
        "text"          =>  $message,
        "attachments"   =>  $attachments
      ));
    }
  
    echo $data."\n";
  
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $slack_result = curl_exec($ch);
    echo "Slack returned - ".$slack_result."\n";
  }

  sleep($duration);
}
?>
