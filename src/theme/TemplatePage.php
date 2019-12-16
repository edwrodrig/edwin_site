<?php
namespace edwrodrig\site\theme;

use DateTime;

use edwrodrig\file_cache\ImageItem;
use edwrodrig\site\data\Repository;
use edwrodrig\static_generator\exception\CacheDoesNotExists;
use edwrodrig\static_generator\exception\NoTranslationAvailableException;
use edwrodrig\static_generator\exception\RelativePathCanNotBeFullException;
use edwrodrig\static_generator\exception\UnregisteredWebDomainException;
use edwrodrig\static_generator\html\meta\AppleWebApplication;
use edwrodrig\static_generator\html\meta\Favicon;
use edwrodrig\static_generator\html\meta\OpenGraph;
use edwrodrig\static_generator\html\meta\SeoTags;
use edwrodrig\static_generator\html\meta\TwitterCardSummary;
use edwrodrig\static_generator\template\TemplateHtmlBasic;

class TemplatePage extends TemplateHtmlBasic {

    /**
     * Get the page title from metadata
     *
     * Every page must have a title
     * @return string
     * @throws NoTranslationAvailableException
     */
    public function getTitle() : string {
        /**
         * This does not throw
         * @noinspection PhpUnhandledExceptionInspection
         */
        return $this->tr($this->getData()['title']);
    }

    /**
     * Get the page description from metadata
     * Every page must have a description
     * @return string
     * @throws NoTranslationAvailableException
     */
    public function getDescription() : string {
        /**
         * This does not throw in this case
         * @noinspection PhpUnhandledExceptionInspection
         */
        return $this->tr($this->getData()['description']);
    }

    /**
     * @throws CacheDoesNotExists
     * @throws NoTranslationAvailableException
     * @throws RelativePathCanNotBeFullException
     * @throws UnregisteredWebDomainException
     */
    public function head() : void {

        $image = new ImageItem(__DIR__ . '/../../data/images', 'meta.jpg');
        $image->setSalt();

        $meta_image = $this->getCache('cache/images')->update($image);

        $meta = new SeoTags;
        $meta
            ->setDescription($this->getDescription())
            ->print();

        $og = new OpenGraph;
        $og
            ->setType('website')
            ->setTitle($this->getTitle())
            ->setDescription($this->getDescription())
            ->setImage($this->fullUrl(strval($meta_image)))
            ->setImageWidth($meta_image->getAdditionalData()['width'])
            ->setImageHeight($meta_image->getAdditionalData()['height'])
            ->setUpdateTime(new DateTime())
            ->setSeeAlso('https://github.com/edwrodrig')
            ->print();

        $twitter_card = new TwitterCardSummary;
        $twitter_card
            ->setTitle($this->getTitle())
            ->setDescription($this->getDescription())
            ->setImage($this->fullUrl(strval($meta_image)))
            ->setImageAlt('My portrait')
            ->setSite('@edwrodrig')
            ->print();

        $favicon = new Favicon;
        $favicon
            ->setIcon16x16($this->imageContain('favicon.png', 16, 16))
            ->setIcon24x24($this->imageContain('favicon.png', 24, 24))
            ->setIcon32x32($this->imageContain('favicon.png', 32, 32))
            ->setIcon48x48($this->imageContain('favicon.png', 48, 48))
            ->setIcon64x64($this->imageContain('favicon.png', 64, 64))
            ->print();

        $apple = new AppleWebApplication;
        $apple
            ->setIcon72x72($this->imageContain('favicon.png', 72, 72))
            ->setIcon152x125($this->imageContain('favicon.png', 152, 152))
            ->setIcon167x167($this->imageContain('favicon.png', 167, 167))
            ->setIcon180x180($this->imageContain('favicon.png', 180, 180))
            ->setWebCapable(true)
            ->setStatusBarStyle('black-translucent')
            ->print();

        ?>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cutive+Mono|VT323">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?=$this->url('/style/style.css')?>">
        <meta name="p:domain_verify" content="1f460d1f1d07c2ed75aa9bf4de514720"/>


        <script src="<?=$this->url('/lib.js')?>"></script>
        <title><?=$this->getTitle()?></title>
    <?php
    }

    /**
     * @throws NoTranslationAvailableException
     */
    public function body() : void {
        $this->bodyHeader();
        $this->bodyContent();
        $this->bodyFooter();
    }

    /**
     * @throws NoTranslationAvailableException
     */
    protected function bodyHeader() {
        ?>
        <div class="container-padding" style="position:fixed;width:100%;display:flex;flex-direction:row-reverse;box-sizing:border-box">
            <button type="button" class="nav-button" onclick="ANIM.modalIn('nav-menu')">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <div class="container-padding header">
            <a class="header-name" href="<?=$this->url('/')?>">Edwin Rodríguez</a>
        </div>
        <?php $this->navMenu();
    }

    /**
     * @throws NoTranslationAvailableException
     */
    public function navMenu() {?>
        <div id="nav-menu" style="display:none">
            <div class="nav-menu-items">
                <h1>Edwin Rodríguez</h1>
                <a href="<?=$this->url('/')?>"><?=$this->tr(['es' => 'Inicio', 'en' => 'Home'])?></a>
                <a href="<?=$this->url('/posts.html')?>"><?=$this->tr(['es' => 'Artículos', 'en' => 'Article'])?></a>
                <a href="<?=$this->url('/projects.html')?>"><?=$this->tr(['es' => 'Proyectos', 'en' => 'Projects'])?></a>
                <button type="button" class="nav-menu-close" onclick="ANIM.modalOut('nav-menu')"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <?php
    }

    /**
     * The body content
     *
     * Echo the content between the {@see TemplatePage::bodyHeader() body header} and {@see TemplatePage::bodyFooter() body footer}.
     */
    protected function bodyContent() {
        /** @noinspection PhpIncludeInspection */
        include $this->page_info->getSourceAbsolutePath();
    }

    /**
     * The footer section.
     *
     * Contain just the {@see TemplatePage::socialButtonsBar() social buttons} and the current year with my name
     */
    protected function bodyFooter() {
        ?>
        <div>
            <div class="section-container container-padding">
                <hr>
                <?php $this->socialButtonsBar() ?>
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
    protected function socialButtonsBar() {
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

    /**
     * Get the date in readable format.
     *
     * The date is already translated bt the {@see Template::getLang() current language}
     * @param DateTime $date
     * @return string
     */
    public function dateStr(DateTime $date) : string {
        $lang = $this->getLang();
        if ( $lang === 'es' ) {
            $date = ucwords(strftime('%A %e de %B de %G',  $date->getTimestamp()));
            return str_replace(' De ', ' de ', $date);
        } else if ( $lang === 'en' ) {
            return ucwords(strftime('%A, %B %e, %G', $date->getTimestamp()));
        } else {
            return strftime('%e/%m/%G', $date->getTimestamp());
        }
    }

    /**
     * @param string $file
     * @param int $width
     * @param int $height
     * @return string
     * @throws CacheDoesNotExists
     */
    public function imageContain(string $file, int $width, int $height) {

        $image = new ImageItem(__DIR__ . '/../../data/images', $file, $width + $height);
        $image->resizeContain($width, $height);
        $image->setSalt();
        return strval($this->getCache('cache/images')->update($image));
    }

    /**
     * @return Repository
     */
    public function getRepository() : Repository {
        return parent::getRepository();
    }

}

