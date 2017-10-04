<div class="container">

	<div class="header">
		<div class='row'>
	 		<h1 class='col-12'>Lägg till</h1>
	 	</div>
	</div>	

	<div class="main">
		<div class='row'>
			<section>
				<form class="col-11" name="postForm" action="<?=url('posts/create')?>" method="POST">
					<input class='col-12' type='text' name='title' placeholder='Rubrik'> <br>
					<textarea class='col-12' name='content' rows=10 placeholder='Lång beskrivning på flera rader'></textarea> <br>
					<input class='pull-right' type='submit' value='Spara'>
				</form>
			</section>
		</div>
	</div>	

	<div class="footer"></div>	

</div>