<?php if (!empty($possibleConnections)):?>
<ul>
<?php foreach ($possibleConnections as $possibleConnection):?>
	<li>
		<?=$secure->link(ucwords(___d($possibleConnection . ' request')),
			array('controller' => 'connections', 'action' => 'request',
				$possibleConnection, $possibleConnectionsProfileId))?> 
	</li>
<?php endforeach?>
</ul>
<?php endif?>