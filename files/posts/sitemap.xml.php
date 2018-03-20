<?php
use edwrodrig\static_generator\Site;
?>
<xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
foreach ( Site::get()->get_templates('post') as $post ) {
  printf('<url><loc>%s</loc></url>', $post->get_url());
}
?>
 </urlset>
