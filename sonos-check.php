<?php
$IP_sonos_1 = "192.168.40.108";
require("sonos.class.php");
$sonos_1 = new SonosPHPController($IP_sonos_1); 

$info = $sonos_1->GetPositionInfo();
var_dump($info);
exit;

if (preg_match('/pandora/', $info['TrackURI'])) {
  parse_str(htmlspecialchars_decode(parse_url(urldecode($info["TrackURI"]), PHP_URL_QUERY)), $output);
  if ($output['a'] != "") {
    echo $output['a']."\n";
  }
} else {
  echo "Not Pandora\n";
}
$attachments = array(
  'attachments' => array([
    'title'     => '',
    'image_url' => $output['a']
  ]));
echo json_encode($attachments);
?>
