<div class="container">
  <?php
  foreach ($page->sections as $key => $section)
  echo $this->element(
    $section->template,
    [
      'ref' => 'section-'.$section->id,
      'section' => $section
    ]
  );
  ?>
</div>
