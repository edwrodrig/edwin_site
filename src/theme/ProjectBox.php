<?php
declare(strict_types=1);

namespace edwrodrig\site\theme;

use edwrodrig\file_cache\ImageItem;
use edwrodrig\site\data\Project;
use edwrodrig\static_generator\exception\CacheDoesNotExists;
use edwrodrig\static_generator\exception\NoTranslationAvailableException;

/**
 * Class ProjectBox
 * @package edwrodrig\site\theme
 */
class ProjectBox
{
    /**
     * @var Project
     */
    private Project $project;

    /**
     * @var TemplatePage
     */
    private TemplatePage $template;

    public function __construct(Project $project, TemplatePage $template) {
        $this->project = $project;
        $this->template = $template;
    }

    public function getUrl() : string {
        return $this->template->url(strval($this->project->getUrl()));
    }

    /**
     * @return string
     * @throws NoTranslationAvailableException
     */
    public function getDescription() : string {
        return $this->template->tr($this->project->getDescription(), '');
    }

    public function getName() : string {
        return $this->project->getName();
    }

    /**
     * @return string
     * @throws CacheDoesNotExists
     */
    public function getImage() : string {
        $file = $this->project->getImage() ?? 'default.svg';

        $image = new ImageItem(__DIR__ . '/../../data/images', 'projects/' . $file, 400);
            $image->resizeContain(200, 200);
            $image->setSalt();
        return strval($this->template->getCache('cache/images')->update($image));
    }

    /**
     * @throws CacheDoesNotExists
     * @throws NoTranslationAvailableException
     */
    public function html() {?>
        <a href="<?=$this->getUrl()?>" class="project-box clickable-box">
            <div class="grid-padding">
                <div class="project-logo">
                    <img width="100px" height="100px" src="<?=$this->getImage()?>"/>
                </div>
                <div>
                    <h2><?=$this->getName()?></h2>
                    <p><?=$this->getDescription()?></p>
                </div>
            </div>
        </a>
        <?php
    }

}