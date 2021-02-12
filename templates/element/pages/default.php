<div class="page page--default">

  <h1 cms:input_text="title"><?= $page->title ?></h1>

  <?= $this->Cms->sections($page->sections, 'row') ?>

</div>
