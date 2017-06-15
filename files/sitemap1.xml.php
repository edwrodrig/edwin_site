<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
foreach ( ['/index.html', '/posts.html', '/projects.html'] as $p ) {
  printf('<url><loc>%s</loc></url>', url($p));
}
?>
 </urlset>
