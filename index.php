<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Poyraz WiFi Giriş Sayfası</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="assets/logo.png" alt="logo" width="200">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Giriş Yap</h1>
							<form id="loginForm" method="POST" class="needs-validation" novalidate="" autocomplete="off">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="username">Kullanıcı Adı</label>
									<input id="username" type="username" class="form-control" name="username" value="" required autofocus>
									<div class="invalid-feedback">
										Kullanıcı Adı geçersiz!
									</div>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Şifre</label>
									</div>
									<input id="password" type="password" class="form-control" name="password" required>
									<div class="invalid-feedback">
										Şifre geçersiz!
									</div>
								</div>

								<div class="d-flex align-items-center justify-content-center">
									<button type="submit" class="btn btn-primary ">
										Giriş Yap
									</button>
								</div>
						</div>
						</form>

						<?php

						session_start();

						if ($_SERVER['REQUEST_METHOD'] == 'POST') {
							$username = $_POST['username'];
							$password = $_POST['password'];
							if (empty($username) || empty($password)) {
								echo '<span style="color: red; text-align: center; display: block;">Kullanıcı adı ve şifre boş bırakılamaz!</span>';
							}
							else {
								$url = 'https://poyrazwifi.com.tr/api/api.php';
								$data = array(
									'token' => 'cc03e747a6afbbcbf8be7668acfebee5',
									'action' => 'login',
									'username' => $username,
									'password' => $password
								);

								$options = array(
									'http' => array(
										'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
										'method'  => 'POST',
										'content' => http_build_query($data)
									)
								);

								$context  = stream_context_create($options);
								$result = file_get_contents($url, false, $context);

								if ($result === FALSE) {
									echo '<p>Hata oluştu.</p>';
								} else {
									/* echo '<pre>' . htmlspecialchars($result) . '</pre>'; */
									$tempData = json_decode($result, true);
									if($tempData['status'] == 0){
										echo '<span style="color: red; text-align: center; display: block;">Kullanıcı adı veya şifre hatalı!</span>';
									}
									else{
										$_SESSION['userData'] = $tempData['data']['customer'];
										header("Location: homepage.php");
										exit();

									}
									
								}
							}
							
						}
						?>

					</div>
				</div>
			</div>
		</div>
		</div>
		<div id="result"></div>
	</section>

</body>

</html>