<html lang='<?=$mvc['lang']?>'>
<head>
	<meta charset="UTF-8">
	<title>Inlägg</title>
	
	<?php foreach ($mvc['stylesheets'] as $sheet): ?>
		<link rel="stylesheet" type="text/css" href="<?=url($sheet)?>">
	<?php endforeach; ?>	

</head>

<body>

	<div class="container">
		<?php require $page; ?>	
	</div>

	
	<?php if(isset($mvc['jquery'])): ?><script src="<?=$mvc['jquery']?>"></script>
	<?php endif; ?>

	<?php if(isset($mvc['javascript_inc'])): ?>
		<?php foreach ($mvc['javascript_inc'] as $script): ?>
			<script src="<?=url($script)?>"></script>
		<?php endforeach; ?>
	<?php endif; ?>	

</body>
</html>