<?php $view->script('posts', 'blog:app/bundle/post.js', 'vue') ?>
<?php if($params->get('subTitle')): ?>
    <h5 class="uk-margin-small tm-text-cardo uk-text-primary"><?= $params->get('subTitle') ?></h5>
<?php endif ?>
<?php if($params->get('pageTitle')): ?>
    <h1 class="uk-margin-small uk-width-xlarge@m"><?= $params->get('pageTitle') ?></h1>
<?php endif ?>
<?php
    array_unshift($posts, ['blank' => true]);
?>
<div class="uk-child-width-1-2@m uk-margin-large-bottom" uk-grid="masonry:true:parallax:150">
    <?php foreach( array_values($posts) as $key => $post ): ?>
        <?php if($key == 0): ?>
            <div>
                <div class="uk-height-small"></div>
            </div>
        <?php else: ?>
            <div>
                <?php if ($image = $post->get('image.src')): ?>
                    <a class="uk-display-block" href="<?= $view->url('@blog/id', ['id' => $post->id]) ?>">
                        <img class="tm-blogs" data-src="<?= $image ?>" alt="<?= $post->get('image.alt') ?>" uk-img>
                    </a>
                <?php endif ?>
                <ul class="uk-subnav uk-margin-bottom">
                    <?php foreach($post->getCategories() as $category): ?>
                        <li><a class="tm-text-cardo uk-text-secondary" href="<?= $view->url('@blog/category/id' , ['id' => $category['id']]) ?>"><?= $category['title'] ?></a></li>
                    <?php endforeach ?>
                </ul>
                <h2 class="uk-h4 uk-margin-small uk-text-uppercase uk-text-bold"><a href="<?= $view->url('@blog/id', ['id' => $post->id]) ?>"><?= $post->title ?></a></h2>
                <p><?= $post->excerpt ?: $post->content ?></p>
            </div>
        <?php endif ?> 
    <?php endforeach ?>
</div>

<?php

$range     = 3;
$total     = intval($total);
$page      = intval($page);
$pageIndex = $page - 1;

?>

<?php if ($total > 1) : ?>
    <ul class="uk-pagination uk-flex-center uk-margin-xlarge-top">

        <?php for($i=1;$i<=$total;$i++): ?>
            <?php if ($i <= ($pageIndex+$range) && $i >= ($pageIndex-$range)): ?>

                <?php if ($i == $page): ?>
                    <li class="uk-active"><span><?=$i?></span></li>
                <?php else: ?>
                    <li>
                        <a href="<?= $view->url($page_link, array_merge(['page' => $i], $page_params)) ?>"><?=$i?></a>
                    </li>
                <?php endif; ?>

            <?php elseif($i==1): ?>

                <li>
                    <a href="<?= $view->url($page_link, array_merge(['page' => 1], $page_params)) ?>">1</a>
                </li>
                <li><span>...</span></li>

            <?php elseif($i==$total): ?>

                <li><span>...</span></li>
                <li>
                    <a href="<?= $view->url($page_link, array_merge(['page' => $total], $page_params)) ?>"><?=$total?></a>
                </li>

            <?php endif; ?>
        <?php endfor; ?>


    </ul>
<?php endif ?>
