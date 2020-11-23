<?php
$dir = scandir(__DIR__);

if(in_array($page->slug.'.php',$dir ) || $page->is_home){
	$this->load->view($page->slug);
}else{
	echo $page->layout->body; 
} 
?>

<?php if (Settings::get('enable_comments') and $page->comments_enabled): ?>

<div id="comments">
	
	<div id="existing-comments">
		
		<h4><?php echo lang('comments:title') ?></h4>

		<?php echo $this->comments->display() ?>

	</div>

	<?php echo $this->comments->form() ?>

</div>

<?php endif ?>