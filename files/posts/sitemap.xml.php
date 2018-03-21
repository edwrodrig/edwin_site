<?php
use edwrodrig\static_generator\Site;
?>
<xml version="1.0" encoding="UTF-8"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 ">
<?php
foreach (Site::get()->globals['posts'] as $post) {
    printf('<url><loc>%s</loc></url>', $post->get_url());
}
?>
</urlset>
