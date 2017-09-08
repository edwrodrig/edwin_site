<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
foreach ( ['sitemap.xml', '/posts/sitemap.xml'] as $page ) {
  printf('<sitemap><loc>%s</loc></sitemap>', url($page));
}
?>
</sitemapindex>

