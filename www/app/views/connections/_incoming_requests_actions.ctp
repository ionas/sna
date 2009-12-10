<?=$secure->link(__('Accept', true), array('action' => 'respond', 'accept', $connection['Connection']['id']))?>
<?=$secure->link(__('Reject', true), array('action' => 'respond', 'deny', $connection['Connection']['id']))?>
<?=$secure->link(__('Hide', true), array('action' => 'respond', 'hide', $connection['Connection']['id']))?>
<?=$secure->link(__('Ignore', true), array('action' => 'respond', 'deny', $connection['Connection']['id']))?>