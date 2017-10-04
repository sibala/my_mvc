<div class="container">

	<div class="header">
		<div class='row'>
	 		<h1 class='col-10'>Listan</h1>
	 		<a class='col-2' href="<?=url('posts/add-new')?>">Lägg till</a>
	 	</div>
	</div>	

	<div class="main">
		<?php foreach ($posts as $post): ?>
			<div>
				<article class='row'>
					<section class='col-10'>
						<h3><?=htmlspecialchars($post->title)?> #<?=htmlspecialchars($post->id)?></h3>
						<p><?=htmlspecialchars($post->content)?></p>
					</section>

					<section class='col-2'>
						<a href='<?=url('posts/edit/' . $post->id)?>'>Ändra</a>
					</section>
				</article>
			</div>
		<?php endforeach; ?>
	</div>	

	<div class="footer"></div>	

</div>