<div class="col-md-6">
  <article class="article article--default">

    <?
    if(!empty($article->attachments))
    {
      echo $this->Attachment->image(
        [
          'image' => $article->attachment->path,
          'profile' => $article->attachment->profile,
          'width' => 1200
        ],
        [
          'cms:attachment' => 'attachments'
        ]
      );
    }else echo $this->Html->tag('div','',['cms:attachment' => 'attachments'])

    ?>

    <h1 cms:input_text="title" class="article__title"><?= $article->title ?></h1>

    <div cms:tiptap="header" class="article__header"><?= $article->header ?></div>

    <div cms:tinymce="body" class="article__body"><?= $article->body ?></div>

  </article>
</div>
