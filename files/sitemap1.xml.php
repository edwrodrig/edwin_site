<?php
/**
 * @var $this \edwrodrig\static_generator\template\TemplateXml
 */
?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 ">
    <?php foreach ( ['/index.html', '/posts.html', '/projects.html'] as $page ) :?>
        <sitemap>
            <loc><?=$this->url($page)?></loc>
        </sitemap>
    <?php endforeach?>
</urlset>
