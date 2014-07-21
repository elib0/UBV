<?php $this->load->view('partial/header'); ?>
<section class="main">
	<h1>General</h1>
	<hr>
	<ul>
		<?php foreach ($news as $name => $new): ?>
			<li class="notification-<?php echo $name ?>">
				<a href="index.php/<?php echo $new['url'] ?>"><?php echo $new['title'] ?><br><span><?php echo $new['count'] ?></span></a>
				<p><?php echo $new['description'] ?></p>
			</li>
		<?php endforeach ?>
	</ul>
</section>
<?php $this->load->view('partial/footer'); ?>