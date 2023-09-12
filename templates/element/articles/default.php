<div class="col-md-6">
  <article class="article article--default">

    <?php
    if(!empty($article->attachments))
    {
        foreach($article->attachments as $a)
        {
          if($a->type == 'image')
          {
            echo $this->Attachment->image(
              [
                'image' => $a->path,
                'profile' => $a->profile,
                'width' => 1200
              ],
              [
                'cms:attachment' => 'attachments',
                'class' => 'img-fluid'
              ]
            );
            break;
          }
        }
    }
    else echo $this->Html->tag('div','',['cms:attachment' => 'attachments'])

    ?>

    <h1 cms:input_text="title" class="article__title"><?= $article->title ?></h1>

    <div cms:tiptap="header" class="article__header"><?= $article->header ?></div>

    <div cms:tinymce="body" class="article__body"><?= $article->body ?></div>

  </article>
</div>
