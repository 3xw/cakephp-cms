<div class="col-md-6">
  <article class="article article--default">

    <h3 cms:input_text="title" class="article__title"><?= $article->title ?></h3>

    <div cms:textarea="header" class="article__header"><?= $article->header ?></div>

    <div cms:textarea="body" class="article__body"><?= $article->body ?></div>

  </article>
</div>
