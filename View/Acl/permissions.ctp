<?php
$this->set( 'title_for_layout', "Permisos para ".$aroAlias );
$this->Html->addCrumb( 'Pemisos', array( 'plugin' => 'acl_manager', 'controller' => 'acl', 'action' => 'index' ) );
$this->Html->addCrumb( $aroAlias, array( 'plugin' => 'acl_manager', 'controller' => 'acl', 'action' => 'permissions', 'aro' => $aroAlias ) );
?>
<div class="table-toolbar btn-toolbar">
<p>Administrar permisos de: </p>
<div class="btn-group">
    <?php
    $aroModels = Configure::read("AclManager.aros");
    if ($aroModels > 1): ?>
        <?php foreach ($aroModels as $aroModel):
            echo $this->Html->link($aroModel, array('aro' => $aroModel), array( 'class' => 'btn  btn-xs btn-info' ) );
        endforeach;
    endif; ?>
</div>
<div class="btn-group pull-right">
        <?php
        echo $this->Html->link( '< Volver', array( 'action' => 'index' ), array( 'class' => 'btn  btn-xs btn-success' )  );
        echo $this->Html->link( 'Administrar permisos', array('action' => 'permissions'), array( 'class' => 'btn  btn-xs ' ) );
        echo $this->Html->link( 'Actualizar ACOs', array('action' => 'update_acos'), array( 'class' => 'btn btn-xs ' ) );
        echo $this->Html->link( 'Actualizar AROs', array('action' => 'update_aros'), array( 'class' => 'btn btn-xs ' ) );
        echo $this->Html->link( 'Borrar ACOs/AROs', array('action' => 'drop'), array( 'class' => 'btn btn-xs btn-danger' ), __("Do you want to drop all ACOs and AROs?"));
        echo $this->Html->link( 'Borrar permisos', array('action' => 'drop_perms'), array( 'class' => 'btn btn-xs btn-danger' ), __("Do you want to drop all the permissions?"));
        ?>
</div>
</div>
<?php echo $this->Form->create('Perms'); ?>
<table class="table table-bordered table-condensed">
	<tr>
		<th>Action</th>
		<?php foreach ($aros as $aro): ?>
		<?php $aro = array_shift($aro); ?>
		<th><?php echo h($aro[$aroDisplayField]); ?></th>
		<?php endforeach; ?>
	</tr>
<?php
$uglyIdent = Configure::read('AclManager.uglyIdent');
$lastIdent = null;
foreach ($acos as $id => $aco) {
	$action = $aco['Action'];
	$alias = $aco['Aco']['alias'];
	$ident = substr_count($action, '/');
	if ($ident <= $lastIdent && !is_null($lastIdent)) {
		for ($i = 0; $i <= ($lastIdent - $ident); $i++) {
			?></tr><?php
		}
	}
	if ($ident != $lastIdent) {
		?><tr class='aclmanager-ident-<?php echo $ident; ?>'><?php
	}
	?><td><?php echo ($ident == 1 ? "<strong>" : "" ) . ($uglyIdent ? str_repeat("&nbsp;&nbsp;", $ident) : "") . h($alias) . ($ident == 1 ? "</strong>" : "" ); ?></td>
	<?php foreach ($aros as $aro):
		$inherit = $this->Form->value("Perms." . str_replace("/", ":", $action) . ".{$aroAlias}:{$aro[$aroAlias][$aroPk]}-inherit");
		$allowed = $this->Form->value("Perms." . str_replace("/", ":", $action) . ".{$aroAlias}:{$aro[$aroAlias][$aroPk]}");
		$value = $inherit ? 'inherit' : null;
		$icon = $this->Html->image(($allowed ? 'test-pass-icon.png' : 'test-fail-icon.png')); ?>
		<td><?php echo $icon . " " . $this->Form->select("Perms." . str_replace("/", ":", $action) . ".{$aroAlias}:{$aro[$aroAlias][$aroPk]}", array(array('inherit' => 'Heredar', 'allow' => 'Permitir', 'deny' => 'Denegar')), array('empty' => 'Sin cambio', 'value' => $value)); ?></td>
	<?php endforeach; ?>
<?php
	$lastIdent = $ident;
}
for ($i = 0; $i <= $lastIdent; $i++) {
	?></tr><?php
}
?></table>
<?php echo $this->Form->end("Guardar"); ?>
<p><?php echo $this->BootstrapPaginator->counter(array('format' => 'Pagina %page% de %pages%, mostrando %current% de %count%, desde %start% al %end%'));
	echo $this->BootstrapPaginator->pagination(); ?>
</div>