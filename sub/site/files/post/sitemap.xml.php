<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
foreach ( \data()['posts'] as $post ) {
  printf('<url><loc>%s</loc></url>', $post['link']);
}
?>
 </urlset>
