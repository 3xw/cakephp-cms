<div class="page page--default" >

  <?= $this->Cms->controls('page', $page) ?>

  <h1><?= $page->title ?></h1>
  <div class="row">
    <?= $this->Cms->sections($page->sections) ?>
  </div>
</div>
