<div class="page page--default">
  <h1 cms:input_text="title"><?= $page->title ?></h1>

  <?php
  echo $this->Cms->sections($page->sections, 'row')
  ?>

</div>
