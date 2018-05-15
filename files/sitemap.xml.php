<?php
/**
 * @var $this \edwrodrig\static_generator\template\Template
 */

?>
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
              xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 ">
    <?php
    foreach ( ['/sitemap.xml', '/posts/sitemap.xml'] as $page ) {?>
        <sitemap>
            <loc><?=$this->url($page)?></loc>
        </sitemap>
        <?php
    }
    ?>
</sitemapindex>

