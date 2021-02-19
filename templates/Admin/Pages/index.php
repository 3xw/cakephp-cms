<?php
/**
* @var \App\View\AppView $this
* @var \Cake\Datasource\EntityInterface $category
*/
?>
<nav class="navbar navbar-expand-lg">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <!--<li class="nav-item">
        <?= $this->Html->link('<i class="material-icons">list</i> '.__('List'),['action'=>'index'], ['class' => '','escape'=>false]) ?>
      </li>-->
    </ul>
  </div>
</nav>
<div class="utils--spacer-semi"></div>
<div class="row no-gutters">
  <div class="col-11 mx-auto ">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title">
          <?= __('Pages index')?>
        </h2>
      </div>
      <div class="card-body">
        <cms-pages>
      </div>
    </div>
  </div>
</div>
