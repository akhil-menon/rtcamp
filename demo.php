<?php
require_once __DIR__ . "/Facebook/autoload.php";
$fb = new \Facebook\Facebook([
  'app_id' => '452345461790574',
  'app_secret' => '1be44d0b8951900c03a9e67b57d8174e',
  'default_graph_version' => 'v2.9',
  'default_access_token' => 'EAACEdEose0cBAM6NZCgcorZAsMKzgr1Yl5tOtr5YMKT7CSGZCJzIFZCtcaFpMFqeyZBz9s5Rd8d8gqiNdkOCW59gASylAAQJzE10aqWoTw5ACtg09vS8EyE8MFtV47Hf2vZAjJQbO6SgdjsQf9NwK0Yhex8fnkJudCNafJsjMTrXbBeaGzXK5agXRTBwZAx4MIZD', // optional
]);

// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
   $helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
//   $helper = $fb->getCanvasHelper();
//   $helper = $fb->getPageTabHelper();

try {
  // Get the \Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
  $response = $fb->get('/me', $fb->getDefaultAccessToken());
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$me = $response->getGraphUser();
echo 'Logged in as ' . $me->getName();
?>