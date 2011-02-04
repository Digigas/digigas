<?php if(isset($data) && !empty($data)): ?>
<div class="rss-list">

	<?php foreach($data as $channel): ?>
	<div class="rss-channel">
		<h1 class="rss-website"><?php echo $this->Html->link($channel['digigas_title'], $channel['rss']['channel']['link']); ?></h1>

		<?php foreach($channel['rss']['channel']['item'] as $item): ?>
		<div class="news">
			<div class="news-date">
                   <?php
				   if(isset($item['pubdate'])) {
					   echo digi_date($item['pubdate']);
				   }
				   ?>
			</div>
			<h2><?php echo $this->Html->link($item['title'], $item['link']); ?></h2>
			<div class="news-content">
				<?php
				echo $this->Html->link(
					$this->Text->truncate(strip_tags($item['description'])),
					$item['link']);
				?>
			</div>
		</div>
		<?php endforeach; ?>

	</div>
	<?php endforeach; ?>
	
</div>
<?php endif; ?>