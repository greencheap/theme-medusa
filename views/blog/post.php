<?php $view->script('post', 'blog:app/bundle/post.js', 'vue') ?>

<article class="uk-article">
    <div class="uk-child-width-1-2@m uk-grid-small" uk-grid>
        <div class="uk-flex uk-flex-bottom">
            <div>
                <ul class="uk-subnav uk-subnav-pill">
                    <?php foreach($post->getCategories() as $category): ?>
                        <li><a class="tm-text-cardo uk-text-secondary" href="<?= $view->url('@blog/category/id' , ['id' => $category['id']]) ?>"><?= $category['title'] ?></a></li>
                    <?php endforeach ?>
                </ul>
                <h1 class="uk-h1"><?= $post->title ?></h1>
                <span class="uk-display-block tm-text-cardo uk-text-light uk-margin-medium"><?= __('%date%', ['%date%' => '<time datetime="'.$post->date->format(\DateTime::ATOM).'" v-cloak>{{ "'.$post->date->format(\DateTime::ATOM).'" | date("longDate") }}</time>' ]) ?></span>
            </div>
        </div>
        <div>
            <?php if ($image = $post->get('image.src')): ?>
                <div>
                    <img class="tm-blogs" src="<?= $image ?>" alt="<?= $post->get('image.alt') ?>">
                </div>
            <?php endif ?>
        </div>
    </div>

    <div class="uk-margin-large-top tm-blog-content">
        <?= $post->content ?>
    </div>
    
    <div>
        <?= $view->render('system/comment:views/comment.php', [
            'service' => [
                'type' => 'blog',
                'own_id' => $post->id,
                'type_url' => [
                    'url' => '@blog/id',
                    'key' => 'id',
                ]
            ]
        ]) ?>
    </div>
</article>