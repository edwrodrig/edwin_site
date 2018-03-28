<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 ">
    <?php
    foreach ( ['/index.html', '/posts.html', '/projects.html'] as $page ) {?>
        <sitemap>
            <loc><?=\edwrodrig\site\Site::absolute_url($page)?></loc>
        </sitemap>
        <?php
    }
    ?>
</urlset>
