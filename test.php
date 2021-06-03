
<?php
if($_POST){


$data = [
'secret' => '6Lf6aAsaAAAAAFnwJ86DBVkIDoQ3iLKcsw1K7c7Y',
'response' => @$_POST['g-recaptcha-response']
];

$curl = curl_init();

curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

$response = curl_exec($curl);
$response = json_decode($response, true);
print_r($response);
if ($response['success'] === false) {
echo "okkk";
die();
// Failure

} else {
echo "sss";
die;
// Success
} 
}
?>
<!doctype html>
<html>
<head>
<title>Plugins | Variable</title>
<meta charset="utf-8" />
<script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body class="is-bg-image-page-redactor">

<form action="" method="post">
<div class="example">
<div class="g-recaptcha" data-sitekey="6Lf6aAsaAAAAAFHj8EFx6Ptn3rIr9q5WMQajaOEY"></div>
</div>
<button type="submit">Send</button>
</form>

</body>
</html>