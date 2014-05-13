<?php
################################################################################
################################ INITIALIZATION ################################
################################################################################
require __DIR__.'/../bootstrap/autoload.php';
$app = require_once __DIR__.'/../bootstrap/start.php';
################################################################################

$news = DB::table('news')->orderBy('id', 'ASC')->get();
#echo "<pre>" . print_r($news, 1) . "</pre>";

foreach ($news as $new) {

    $new = (array)$new;

	DB::table('i18n_news')->insert(
        array(
            'id' => $new['id'],
            'slug' => $new['seo_url'],
            'template' => $new['template'],
            'publication' => $new['publication'],
            'created_at' => $new['created_at'],
            'updated_at' => $new['updated_at'],
            'published_at' => $new['created_at'],
        )
    );

    DB::table('i18n_news_meta')->insert(
        array(
            'id' => null,
            'news_id' => $new['id'],
            'language' => 'ru',
            'title' => $new['title'],
            'preview' => $new['preview'],
            'content' => $new['content'],
            'seo_url' => $new['seo_url'],
            'seo_title' => $new['seo_title'],
            'seo_description' => $new['seo_description'],
            'seo_keywords' => $new['seo_keywords'],
            'seo_h1' => $new['seo_h1'],
            'created_at' => $new['created_at'],
            'updated_at' => $new['updated_at'],
        )
    );

}
