<?php $this->load->view('partial/header'); ?>
<section class="main">
	<h1>General</h1>
	<ul>
		<?php foreach ($notifications as $name => $notification): ?>
			<li class="notification-<?php echo $name ?>">
				<a href="index.php/<?php echo $notification['url'] ?>"><?php echo $notification['title'] ?><br><span><?php echo $notification['count'] ?></span></a>
				<p><?php echo $notification['description'] ?></p>
			</li>
		<?php endforeach ?>
	</ul>
</section>
<?php $this->load->view('partial/footer'); ?>