<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<meta property="og:title" content="დახატე ქალაქი">
	<meta property="og:description" content="დახატე ქალაქი, ატვირთე და ყველაზე მეტი LIKE-ს მოპოვების შემთხვევაში მოიგე iPhone 6s">
	<meta property="og:type" content="website">
	<meta property="fb:app_id" content="509028565938040">

	<meta property="og:url" content="http://app-ralozkolya.rhcloud.com">
	<meta property="og:image" content="http://app-ralozkolya.rhcloud.com/res/img/logo.png">

	<title>დახატე ქალაქი</title>

	<link rel="stylesheet" href="<?php echo base_url().'res/css/general.css'; ?>">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url().'res/css/jscrollpane.css'; ?>">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.17.0/TweenMax.min.js"></script>
	<script src="<?php echo base_url().'res/js/mousewheel.js'; ?>"></script>
	<script src="<?php echo base_url().'res/js/jscrollpane.js'; ?>"></script>
	<script src="<?php echo base_url().'res/js/SplitText.js'; ?>"></script>
	<script src="<?php echo base_url().'res/js/general.js'; ?>"></script>

	<?php if(isset($link_image) && $link_image): ?>
		<script>var linkImage = '<?php echo str_replace("'", "\'", json_encode($link_image)); ?>';</script>
	<?php endif; ?>

</head>

<body>

	<div class="wrapper">
		<div class="loading">იტვირთება<span class="dots">...</span></div>
		<div class="auth-needed-bg">
			<div class="auth-needed-message">აპლიკაციის გამოსაყენებლად <span class="click-here">დააჭირეთ აქ</span> და მიანიჭეთ აპლიკაციას მოთხოვნილი უფლებები</div>
		</div>
		<div class="controls">
			<div class="rules">
				<img src="<?php echo base_url().'res/img/rules.png'; ?>">
			</div>
			<div class="buttons">
				<span id="upload-button" class="button">
					<span class="upload-label">ატვირთე ნახატი</span>&nbsp;&nbsp;
					<span class="glyphicon glyphicon-upload"></span>
				</span>
				<span id="gallery-button" class="button">
					გალერეა&nbsp;&nbsp;
					<span class="glyphicon glyphicon-picture"></span>
				</span>
			</div>
			<img class="info-button" src="<?php echo base_url().'res/img/info.png'; ?>">
		</div>

		<div class="gallery-container">
			<div class="gallery-loader">იტვირთება<span class="gallery-dots">...</span></div>
			<div class="my-pic">ჩემი ნახატი</div>
			<div class="gallery container-fluid"></div>
			<div class="container-fluid">
				<span class="button" id="gallery-back-button">
					<span class="glyphicon glyphicon-menu-left"></span>
					უკან
				</span>
			</div>
		</div>

		<div id="preview-wrapper">
			<div id="preview"></div>
			<div class="preview-controls">
				<span class="button" id="preview-back-button">
					<span class="glyphicon glyphicon-menu-left"></span>
					უკან
				</span>
				<div class="fb-like gallery-like" data-layout="standard" data-action="like"
					data-show-faces="true" data-share="true" data-colorscheme="dark"></div>
			</div>		
		</div>

		<?php if($first_time): ?>
			<div class="likebox-wrapper">
				<div class="likebox">
					<div class="glyphicon glyphicon-remove close-likebox"></div>
					გთხოვთ მოიწონეთ ჩვენი გვერდი
					<div>
					<div class="fb-like" data-href="https://www.facebook.com/Indie-Studio-497714517008804/" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="info-wrapper">
			<div class="info">
				<div class="glyphicon glyphicon-remove close-info"></div>
				მონაწილეს შეუძლია ატვირთოს მხოლოდ 1 ნახატი. ხელმეორედ ატვირთვის შემთხვევაში მოხდება წინა ნამუშევრის წაშლა და დაგროვებული "ლაიქების" განულება
			</div>
		</div>
	
		<div class="tip">
			ნახატი უნდა იყოს JPG ან PNG ფორმატის და მისი ზომა არ უნდა აღემატებოდეს 1MB-ს
		</div>
	</div>

	<form class="upload-form" action="<?php echo base_url().'app/upload'; ?>" method="post" enctype="multipart/form-data">
		<input type="file" name="userfile" id="userfile">
	</form>

</body>
</html>