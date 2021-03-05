<?php

use GreenCheap\Application as App;
use GreenCheap\Blog\Model\Post;

return [

    'name' => 'medusa/blogs',

    'label' => 'Blogs',

    'events' => [

        'view.scripts' => function ($event, $scripts) use ($app) {
            if($app->config('blog')){
                $scripts->register('widget-blogs', 'theme:app/bundle/widgets-blogs.js', ['~widgets']);
            }
        }

    ],

    'render' => function ($widget) use ($app) {

        $query = Post::query();

        $query->where(['status = :status', 'date < :date'], ['status' => Post::getStatus('STATUS_PUBLISHED'), 'date' => new \DateTime])
        ->where(function ($query) {
            return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
        });        

        if($category = $widget->get('selectedCategories')){
            $query->where(function ($query) use ($category) {
                $query->whereInSet('categories_id', (int) $category);
            });
        }

        $query->orderBy('date', 'DESC')->limit($widget->get('limit'))->related('user');

        foreach($posts = $query->get() as $post) {
            $post->excerpt = App::content()->applyPlugins($post->excerpt, ['post' => $post, 'markdown' => $post->get('markdown')]);
        }

        $response = match($widget->get('type')){
            'slider' => 'theme:views/widgets/blog-slider.php',
            default => 'theme:views/widgets/blog-grid.php'
        };
        
        return $app->view($response, compact('posts', 'widget'));
    }

];