<div class="col-md-4">
  <article class="article article--default">

    <?= $this->Cms->controls('article', $article) ?>

    <h3><?= $article->title ?></h3>

    <div class="article__header"><?= $article->header ?></div>

    <div class="article__body"><?= $article->body ?></div>

  </article>
</div>
