<div class="section section--default">
  <?php
  foreach ($section->articles as $key => $articles)
  echo $this->element(
    'sections/'.$section->section_template,
    [
      'ref' => 'section-'.$section->id,
      'section' => $section
    ]
  );
  ?>
</div>
