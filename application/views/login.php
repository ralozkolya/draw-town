<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Admin</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<style>
		form {
			max-width: 400px;
			margin: 40px auto;
		}

		.error-message {
			padding: 10px;
		}
	</style>
</head>

<body>

<div class="container text-center">
	<form method="post">
		<?php if(isset($error_message)): ?>
			<p class="bg-danger text-danger error-message"><?php echo $error_message; ?></p>
		<?php endif; ?>
		<div class="form-group">
			<input class="form-control" type="text" name="username" placeholder="მომხმარებელი" autofocus>
		</div>
		<div class="form-group">
			<input class="form-control" type="password" name="password" placeholder="პაროლი">
		</div>
		<div class="form-group">
			<input class="btn btn-default" type="submit" value="შესვლა">
		</div>
	</form>
</div>

</body>
</html>