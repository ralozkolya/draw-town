<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<meta property="og:title" content="ნაცნობი ქალაქი">
	<meta property="og:type" content="website">
	<meta property="fb:app_id" content="509028565938040">
	<meta property="og:locale" content="ka_GE">

	<?php if(!$image): ?>
		<meta property="og:description" content="დახატე ქალაქი, ატვირთე და ყველაზე მეტი LIKE-ს მოპოვების შემთხვევაში მოიგე iPhone 6s">
		<meta property="og:url" content="<?php echo 'http://app-ralozkolya.rhcloud.com/redirect'; ?>">
		<meta property="og:image" content="http://app-ralozkolya.rhcloud.com/res/img/logo.png">
		<script>
			location.replace('https://www.facebook.com/pages/ნაცნობი-ქალაქი/1484040361890699/?sk=app_509028565938040');
		</script>
	<?php else: ?>
		<meta property="og:description" content="მე დავხატე ქალაქი და ვმონაწილეობ კონკურსში! გთხოვ, გადადი ბმულზე და მოიწონე ჩემი ნამუშევარი!">
		<meta property="og:url" content="<?php echo 'http://app-ralozkolya.rhcloud.com/redirect/'.$image['id']; ?>">
		<meta property="og:image" content="<?php echo 'http://app-ralozkolya.rhcloud.com/uploads/'.$image['name']; ?>">
		<meta property="og:image:width" content="<?php echo getimagesize('uploads/'.$image['name'])[0]; ?>">
		<meta property="og:image:height" content="<?php echo getimagesize('uploads/'.$image['name'])[1]; ?>">
		<script>
			location.replace('https://www.facebook.com/pages/ნაცნობი-ქალაქი/1484040361890699/?sk=app_509028565938040&app_data=<?php echo $image["id"]; ?>');
		</script>
	<?php endif; ?>

	<title>ნაცნობი ქალაქი</title>
	
</head>
<body>
	redirecting...
</body>
</html>