<?php
declare(strict_types=1);

namespace edwrodrig\mypage\site;

use DateTime;
use ImagickException;
use labo86\exception_with_data\ExceptionWithData;
use labo86\staty\BlockMetaAppleWebApplication;
use labo86\staty\BlockMetaFavicon;
use labo86\staty\BlockMetaOpenGraph;
use labo86\staty\BlockMetaSeoTags;
use labo86\staty\BlockMetaTwitterCardSummary;
use labo86\staty\PageImage;
use labo86\staty_core\PageFile;
use labo86\staty_core\SourceFile;

class BlockPage extends Block
{
    public function sectionBeginHeadAddition() {
        $this->sectionBegin('head_additional');
    }

    public function sectionBeginBodyContent()  {
        $this->sectionBegin('body_content');
    }

    public function html() {
        $this->sectionEnd();?>
<!doctype html>
<html lang="es">
<head>
    <?php $this->htmlHeadCommon() ?>
    <?php $this->htmlHeadCommonMeta()?>
    <title><?=$this->getTitle()?></title>
    <?=$this->getSectionContent('head_additional')?>
</head>
<body>
    <?php $this->htmlBodyHeader()?>
    <?=$this->getSectionContent('body_content')?>
    <?php $this->htmlBodyFooter()?>
</body>
</html>
<?php
    }

    /**
     * @throws ExceptionWithData
     */
    public function htmlHeadCommon() {

        $lib_js = new PageFile(new SourceFile(__DIR__ . '/../../site_res/dist/index.min.js') , 'bundle/index.min.js');
        ?>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="p:domain_verify" content="1f460d1f1d07c2ed75aa9bf4de514720"/>
        <script src="<?=$this->makePage($lib_js)?>"></script>
        <?php
    }

    public function getTitle() : string {
        return $this->page->getMetadata()['title'] ?? '';
    }

    public function getDescription() : string {
        return $this->page->getMetadata()['description'] ?? '';
    }

    /**
     * @throws ExceptionWithData
     * @throws ImagickException
     */
    public function htmlHeadCommonMeta() : void {

        $image = new PageImage($this->getRepository()->getImage('meta.jpg'), 'meta.jpg');
        $meta_image_url = '/' . $this->makePage($image, true);


        $meta = new BlockMetaSeoTags($this->page);
        $meta
            ->setDescription($this->getDescription())
            ->html();

        $og = new BlockMetaOpenGraph($this->page);
        $og
            ->setType('website')
            ->setTitle($this->getTitle())
            ->setDescription($this->getDescription())
            ->setImage($this->url($meta_image_url))
            ->setImageWidth($image->getWidth())
            ->setImageHeight($image->getHeight())
            ->setUpdateTime(new DateTime())
            ->setSeeAlso('https://github.com/edwrodrig')
            ->html();

        $twitter_card = new BlockMetaTwitterCardSummary($this->page);
        $twitter_card
            ->setTitle($this->getTitle())
            ->setDescription($this->getDescription())
            ->setImage($this->url($meta_image_url))
            ->setImageAlt('My portrait')
            ->setSite('@edwrodrig')
            ->html();

        $favicon = new BlockMetaFavicon($this->page);
        $favicon
            ->setIcon16x16($this->imageContain('favicon.png', 16, 16))
            ->setIcon24x24($this->imageContain('favicon.png', 24, 24))
            ->setIcon32x32($this->imageContain('favicon.png', 32, 32))
            ->setIcon48x48($this->imageContain('favicon.png', 48, 48))
            ->setIcon64x64($this->imageContain('favicon.png', 64, 64))
            ->html();

        $apple = new BlockMetaAppleWebApplication($this->page);
        $apple
            ->setIcon72x72($this->imageContain('favicon.png', 72, 72))
            ->setIcon152x125($this->imageContain('favicon.png', 152, 152))
            ->setIcon167x167($this->imageContain('favicon.png', 167, 167))
            ->setIcon180x180($this->imageContain('favicon.png', 180, 180))
            ->setWebCapable(true)
            ->setStatusBarStyle('black-translucent')
            ->html();

        ?>
        <?php
    }

    public function htmlBodyHeader() {
        ?>
        <div class="container-padding" style="position:fixed;width:100%;display:flex;flex-direction:row-reverse;box-sizing:border-box">
            <button type="button" class="nav-button" onclick="page.ANIM.modalIn('nav-menu')">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <div class="container-padding header">
            <a class="header-name" href="<?=$this->url('/index.html')?>">Edwin Rodríguez</a>
        </div>
        <?php $this->htmlNavMenu();
    }


    public function htmlNavMenu() {?>
        <div id="nav-menu" style="display:none">
            <div class="nav-menu-items">
                <h1>Edwin Rodríguez</h1>
                <a href="<?=$this->url('index.html')?>">Inicio</a>
                <a href="<?=$this->url('posts.html')?>">Artículos</a>
                <a href="<?=$this->url('projects.html')?>">Proyectos</a>
                <button type="button" class="nav-menu-close" onclick="page.ANIM.modalOut('nav-menu')"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <?php
    }


    /**
     * The footer section.
     *
     * Contain just the {@see PagePhp::socialButtonsBar() social buttons} and the current year with my name
     */
    public function htmlBodyFooter() {
        ?>
        <div>
            <div class="section-container container-padding">
                <hr>
                <?php $this->htmlSocialButtonBar() ?>
                <div class="footer-endline">
                    <?=date("Y")?> - Edwin Rodríguez León
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * The social buttons section
     */
    public function htmlSocialButtonBar() {
        ?>
        <div class="social-buttons-bar">
            <a href="http://www.github.com/edwrodrig" title="Github"><i class="fa fa-github"></i></a>
            <a href="http://www.linkedin.com/pub/edwin-iv%C3%A1n-rodr%C3%ADguez-le%C3%B3n/35/241/848" title="LinkedIn"><i class="fa fa-linkedin"></i></a>
            <a href="https://stackoverflow.com/users/2469099/edwin-rodr%c3%adguez?tab=profile" title="StackOverflow"><i class="fa fa-stack-overflow"></i></a>
            <a href="http://play.google.com/store/apps/developer?id=edwrodrig" title="Google Play"><i class="fa fa-android"></i></a>
            <a href="https://twitter.com/edwrodrig" title="Twitter"><i class="fa fa-twitter"></i></a>
            <a href="http://www.codepen.io/edwrodrig" title="Codepen"><i class="fa fa-codepen"></i></a>
            <a href="https://www.youtube.com/user/edwrodrig1" title="Youtube"><i class="fa fa-youtube-play"></i></a>
        </div>
        <?php
    }






}