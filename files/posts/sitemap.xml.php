<?php
use edwrodrig\site\Site;
?>
<xml version="1.0" encoding="UTF-8"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 ">
<?php
foreach (Site::posts() as $post) {?>
    <url><loc><?=Site::absolute_url($post->get_url())?></loc></url>
<?php
}
?>
</urlset>
