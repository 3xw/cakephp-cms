<div class="col-md-4">
  <section class="section section--default">

    <?= $this->Cms->controls('section', $section) ?>

    <div class="row">
      <?= $this->Cms->sectionItems($section->section_items) ?>
    </div>
  </section>
</div>
