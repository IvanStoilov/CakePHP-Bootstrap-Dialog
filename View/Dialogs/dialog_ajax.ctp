<p style="text-align: center">
	<img src="/img/loader.gif" />
</p>
<script type="text/javascript">
	<?php echo $this->JS->request($templateUrl, array (
			'method' => empty($params) ? 'GET' : 'POST',
			'data' => empty($params) ? false : $params,
			'update' => "#{$dialogId}content",
			'error' => "$('#{$dialogId}').modal('hide');"
		));
	?>
</script>