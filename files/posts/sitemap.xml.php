<?php
/**
 * @noinspection PhpUnhandledExceptionInspection
 * @var $this \edwrodrig\static_generator\template\TemplateXml
 * @var $post \edwrodrig\site\data\Post
 */

use edwrodrig\site\data\Repository;

?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 ">
<?php foreach ( Repository::get($this)->getPosts() as $post ) : ?>
    <url><loc><?=$this->url($post->getUrl())?></loc></url>
<?php endforeach ?>

</urlset>
