<?php
$this->set( 'title_for_layout', "Administrador de permisos" );
$this->set( 'title_icon', 'i-rulers' );
$this->Html->addCrumb( 'Permisos', array( 'plugin' => 'acl_manager', 'controller' => 'acl', 'action' => 'index' ) );
?>
<h3>Administrador de permisos <?php echo Configure::read('AclManager.version'); ?></h3>
<div class="btn-group">
    <?php
    echo $this->Html->link( 'Administrar permisos', array('action' => 'permissions'), array( 'class' => 'btn btn-info' ) );
	echo $this->Html->link( 'Actualizar ACOs', array('action' => 'update_acos'), array( 'class' => 'btn' ) );
	echo $this->Html->link( 'Actualizar AROs', array('action' => 'update_aros'), array( 'class' => 'btn' ) );
	echo $this->Html->link( 'Borrar ACOs/AROs', array('action' => 'drop'), array( 'class' => 'btn btn-danger' ), __("Do you want to drop all ACOs and AROs?"));
	echo $this->Html->link( 'Borrar permisos', array('action' => 'drop_perms'), array( 'class' => 'btn btn-danger' ), __("Do you want to drop all the permissions?"));
    ?>
</div>
