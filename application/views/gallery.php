<?php $i = 0; foreach($images as $image): ?>
	<?php if($i % 3 === 0): ?>
		<div class="row">
	<?php endif; ?>
	<div class="thumb-container col-xs-4" data-id="<?php echo $image['id']; ?>"
		data-url="<?php echo $image['name']; ?>">
		<div class="thumb" style="background-image: url('<?php echo base_url()."uploads/thumbs/".$image["name"]; ?>')"></div>
		<div class="text-center thumb-name"><?php echo mb_substr($image['first_name'].' '.$image['last_name'], 0, 23); ?></div>
	</div>

	<?php if($i % 3 === 2): ?>
		</div>
	<?php endif; $i++; ?>
<?php endforeach; ?>

<?php if($i % 3 !== 0): ?>
	</div>
<?php endif; ?>
<?php if(count($images) === 0): ?>
	<h1 class="no-images">ამ ეტაპზე არცერთი ნახატი არ მოიძებნა</h1>
<?php endif; ?>