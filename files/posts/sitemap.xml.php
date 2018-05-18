<?php
/**
 * @var $this \edwrodrig\static_generator\template\Template
 * @var $post \edwrodrig\site\data\Post
 */

use edwrodrig\site\data\Repository;

?>
<xml version="1.0" encoding="UTF-8"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 ">
<?php foreach ( Repository::get($this)->getPosts() as $post ) : ?>
    <url><loc><?=$this->currentUrl($post->getUrl())?></loc></url>
<?php endforeach ?>

</urlset>
