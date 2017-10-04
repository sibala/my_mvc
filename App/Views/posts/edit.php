<div class="container">

	<div class="header">
		<div class='row'>
	 		<h1 class='col-12'>Ändra</h1>
	 	</div>
	</div>	

	<div class="main">
		<div class='row'>
			<section>
				<form class="col-11" name="postForm" action="<?=url('posts/update')?>" method="POST">
					<input class="col-12" type="text" name="title" placeholder="Rubrik" value="<?=htmlspecialchars($post->title)?>"> 
					<br>
					<textarea class="col-12" name="content" rows=10 placeholder="Lång beskrivning på flera rader"><?=htmlspecialchars($post->content)?></textarea> 
					<br>
					<input type="hidden" name="id" value="<?=$post->id?>">
					<input class="pull-right" type="submit" value="Spara">
				</form>
			</section>
		</div>
	</div>	

	<div class="footer"></div>	

</div>