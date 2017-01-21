var app = {};
var errors = {};

app.loadingLabel = 'იტვირთება<span class="label-dots">...</span>';
app.uploadLabel = 'ატვირთე ნახატი';
app.uploadedLabel = 'აიტვირთა!';
app.messageQueue = [];

app.baseUrl = 'https://app-ralozkolya.rhcloud.com/'
app.galleryUrl = app.baseUrl+'gallery/';
app.myPicUrl = app.baseUrl+'my_pic/';
app.redirectUrl = app.baseUrl+'redirect/';
app.imageUrl = app.baseUrl+'uploads/';

errors.uploadError = 'ნახატი უნდა იყოს JPG ან PNG ფორმატის და მისი ზომა არ უნდა აღემატებოდეს 1MB-ს';
errors.errorOccured = 'დაფიქსირდა შეცდომა';
errors.noPic = 'თქვენ არ გაქვთ ნახატი ატვირთული';

$(document).ready(function(){
	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	 }(document, 'script', 'facebook-jssdk'));

	$('.click-here').click(function(){
		app.login();
	});

	$('#preview-back-button').click(app.closePreview);
	$('#gallery-back-button').click(app.closeGallery);

	$('.my-pic').click(app.showMyPic);

	$('.close-likebox').click(function(){
		$('.likebox-wrapper').fadeOut();
	});

	$('.close-info').click(function(){
		$('.info-wrapper').fadeOut();
	});

	$('.info-button').click(function(){
		$('.info-wrapper').fadeIn();
	});

	//app.galleryScroll = $('.gallery').jScrollPane();

	app.dots = new SplitText('.dots', {type: 'chars'}).chars;
	app.loadingTl = new TimelineMax({repeat: -1, repeatDelay: 0.5});
	app.loadingTl.staggerFrom(app.dots, 0.5, {opacity:0, ease:Power1.easeIn}, 0.5, "+=0.1");
});

window.fbAsyncInit = function() {
	FB.init({
		appId: '509028565938040',
		xfbml: true,
		version: 'v2.5',
		cookie: true
	});

	FB.Event.subscribe('edge.create', function(){
		$('.likebox-wrapper').fadeOut();
	});

	FB.getLoginStatus(function(r){
		if(r.status !== 'connected') {
			app.login();
		}

		else {
			app.drawView();
		}
	});
};

app.login = function() {
	FB.login(function(r){
		if(r.status !== 'connected') {
			$('.auth-needed-bg').show();
			$('.loading').hide();
		}

		else {
			app.drawView();
		}
	});
};

app.drawView = function() {
	
	$('.auth-needed-bg').hide();
	$('.loading').hide();
	app.loadingTl.stop();

	$('.controls').show();

	$('#upload-button').on('click', function(){
		$('#userfile').click();
	});

	$('#gallery-button').click(app.openGallery);

	$('#userfile').change(function(){
		app.upload();
	});

	if(window.linkImage) {

		try {
			var image = JSON.parse(linkImage);
			app.openPreview(image.id, image.name);
		}

		catch(e) {
			console.error(e);
		}
	}
};

app.upload = function() {

	$('#upload-button').off('click');

	var form = $('.upload-form')[0];
	var uploadUrl = $(form).attr('action');
	var formData = new FormData(form);

	$('.upload-label').html(app.loadingLabel);

	app.labelDots = new SplitText('.label-dots', {type: 'chars'}).chars;
	app.labelTl = new TimelineMax({repeat: -1, repeatDelay: 0.5});
	app.labelTl.staggerFrom(app.labelDots, 0.5, {opacity:0, ease:Power1.easeIn}, 0.5, "+=0.1");

	$.ajax({
		url: uploadUrl,
		data: formData,
		method: 'post',
		processData: false,
		contentType: false,
		complete: function(r) {

			form.reset();
			app.labelTl.stop();

			try {
				var response = JSON.parse(r.responseText);

				if(response.status === 'ok') {
					$('.upload-label').html(app.uploadedLabel);
					$('#upload-button').addClass('success');
					return;
				}

				else if(response.status === 'invalid_file') {
					app.messageQueue.push(errors.uploadError);
					app.showMessage();
				}

				else {
					console.error(e);
					app.messageQueue.push(errors.errorOccured);
					app.showMessage();
				}
			}

			catch(e) {
				console.error(e);
				app.messageQueue.push(errors.errorOccured);
				app.showMessage();
			}

			$('.upload-label').html(app.uploadLabel);

			$('#upload-button').on('click', function(){
				$('#userfile').click();
			});
		}
	});
	
};

app.showMessage = function(){
	var tip = $('.tip');

	if(app.messageQueue.length) {

		if(tip.css('bottom')[0] !== '-') {
			TweenMax.to(tip, 0.5, {bottom: -100, onComplete: function(){
				show();
			}});
		}

		else {
			show();
		}
	}

	else {
		TweenMax.to(tip, 0.5, {bottom: -100, onComplete: function(){
			tip.hide();
		}});
	}

	function show() {
		var message = app.messageQueue.shift();
		tip.html(message);
		tip.show();

		TweenMax.to(tip, 0.5, {bottom: 20});

		setTimeout(app.showMessage, 3000);
	}
};

app.openPreview = function(id, name) {

	$('#preview').css('background-image', '');

	$('#preview-wrapper').fadeIn();
	$('#preview').css('background-image',
		"url('"+app.imageUrl+name+"')");

	$('.fb-like').attr('data-href',
		app.redirectUrl + id);

	FB.XFBML.parse();
}

app.closePreview = function(){
	$('#preview-wrapper').fadeOut();
};

app.openGallery = function(){

	$('.gallery').empty();
	$('.gallery-loader').show();
	$('.gallery-container').fadeIn();
	$('.controls').fadeOut();

	app.galleryDots = new SplitText('.gallery-dots', {type: 'chars'}).chars;
	app.galleryTl = new TimelineMax({repeat: -1, repeatDelay: 0.5});
	app.galleryTl.staggerFrom(app.galleryDots, 0.5, {opacity:0, ease:Power1.easeIn}, 0.5, "+=0.1");

	$.get(app.galleryUrl, function(r){

		$('.gallery-loader').hide();
		app.galleryTl.stop();

		try {
			var response = JSON.parse(r);

			if(response.status === 'ok') {
				$('.gallery').append(response.body);

				//app.galleryScroll.data('jsp').reinitialise();

				$('.thumb-container').click(function(){

					var id = $(this).attr('data-id');
					var name = $(this).attr('data-url');

					app.openPreview(id, name);
				});
			}
		}

		catch(e) {
			console.error(e);
		}
	});
};

app.closeGallery = function(){
	$('.gallery-container').fadeOut();
	$('.controls').fadeIn();
};

app.showMyPic = function(){
	$.get(app.myPicUrl, function(r){

		try {
			var response = JSON.parse(r);

			if(response.status === 'ok') {
				app.openPreview(response.body.id, response.body.name);
			}

			else {
				console.log(errors.noPic);
				app.messageQueue.push(errors.noPic);
				app.showMessage();
			}
		}

		catch(e) {
			console.error(e);
			app.messageQueue.push(errors.errorOccured);
			app.showMessage();
		}
	});
};