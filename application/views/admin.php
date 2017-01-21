<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Admin</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url().'res/css/admin.css'; ?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="<?php echo base_url().'res/js/admin.js'; ?>"></script>
</head>

<body>

<div class="header">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2 text-center">
				<a href="<?php echo base_url().'admin/images'; ?>">ნახატები</a>
			</div>
			<div class="col-sm-2 text-center">
				<a href="<?php echo base_url().'admin/users'; ?>">მომხმარებლები</a>
			</div>
			<div class="col-sm-2 text-center">
				<a href="<?php echo base_url().'admin/logout'; ?>">გასვლა</a>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<?php if(isset($users)): ?>
		<h2>მომხმარებლები</h2>

		<?php if(!count($users)): ?>
			<h3>არცერთი მომხმარებელი არაა დარეგისტრირებული</h3>
		<?php else: ?>
			<table class="table">
				<tr>
					<th>სახელი</th>
					<th>გვარი</th>
					<th>რეგისტრაციის დრო</th>
					<th>პროფილი</th>
				</tr>
			<?php foreach($users as $user): ?>
				<tr>
					<td><?php echo $user['first_name']; ?></td>
					<td><?php echo $user['last_name']; ?></td>
					<td><?php echo $user['modified']; ?></td>
					<td>
						<a target="_blank" href="<?php echo 'http://facebook.com/'.$user['user_id']; ?>">
							<?php echo 'https://www.facebook.com/'.$user['user_id']; ?>
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>
	<?php endif; ?>

	<?php if(isset($images)): ?>
		<h2>ნახატები</h2>

		<?php if(!count($images)): ?>
			<h3>არცერთი ნახატი არაა ატვირთული</h3>
		<?php else: ?>
			<table class="table">
				<tr>
					<th>სახელი</th>
					<th>გვარი</th>
					<th>ატვირთვის დრო</th>
					<th>ბმული სურათზე</th>
					<th>დადასტურება</th>
					<th>წაშლა</th>
				</tr>
			<?php foreach($images as $image): ?>
				<tr>
					<td>
						<a target="_blank" href="<?php echo 'http://facebook.com/'.$image['user_id']; ?>">
							<?php echo $image['first_name']; ?>
						</a>
					</td>
					<td>
						<a target="_blank" href="<?php echo 'http://facebook.com/'.$image['user_id']; ?>">
							<?php echo $image['last_name']; ?>
						</a>
					</td>
					<td><?php echo $image['modified']; ?></td>
					<td>
						<a target="_blank" href="<?php echo base_url().'uploads/'.$image['name']; ?>">
							<?php echo $image['name']; ?>
						</a>
					</td>
					<td>
						<?php if($image['approved'] == '1'): ?>
							<span class="text-success">დადასტურებულია</span>
						<?php else: ?>
							<a href="<?php echo base_url().'admin/approve_image/'.$image['id']; ?>">დადასტურება</a>
						<?php endif; ?>
					</td>
					<td>
						<a class="delete" href="<?php echo base_url().'admin/delete_image/'.$image['id']; ?>">წაშლა</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>
	<?php endif; ?>
</div>

</body>
</html>