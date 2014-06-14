<div class="modal fade hide" id="<?php echo $dialogId; ?>">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<?php if (!isset($hideXButton) || !$hideXButton) : ?>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<?php endif ?>

				<?php if (!in_array('dialog_title', $this->Blocks->keys())) : ?>
					<h4 class="modal-title"><?php echo $title; ?></h4>
				<?php else : ?>
					<?php echo $this->fetch('dialog_title'); ?>
				<?php endif ?>
			</div>
			<div class="modal-body" id="<?php echo $dialogId; ?>content">
				<?php if (isset($content)) : ?>
					<?php echo $content; ?>
				<?php else : ?>
					<?php echo $this->fetch('dialog_content'); ?>
				<?php endif ?>
			</div>
			<?php if (!isset($hideFooter) || !$hideFooter) : ?>
				<div class="modal-footer">
					<?php if (!in_array('dialog_buttons', $this->Blocks->keys())) : ?>
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
						<button type="button" class="btn btn-primary"><?php echo __('Save changes'); ?></button>
					<?php else : ?>
						<?php echo $this->fetch('dialog_buttons'); ?>
					<?php endif ?>
				</div>
			<?php endif; ?>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php if (isset($autoOpen) && $autoOpen) : ?>
<script>
	$(function () {
		$('#<?php echo $dialogId; ?>').modal({backdrop: 'static', keyboard: false});
	});
</script>	
<?php endif; ?>
