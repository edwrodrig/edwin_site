<?php
declare(strict_types=1);

namespace edwrodrig\mypage\site;

use edwrodrig\mypage\model\Project;
use labo86\staty\PageImage;
use labo86\staty_core\PagePhp;

class BlockProjectBox extends Block
{

    private Project $project;

    /**
     * BlockProjectBox constructor.
     * @param PagePhp $page
     * @param Project $project
     */
    public function __construct(PagePhp $page, Project $project) {
        parent::__construct($page);
        $this->project = $project;
    }

    public function getImage() : string {
        $file = $this->project->getImage();
        $output_file = pathinfo($file, PATHINFO_FILENAME). '.png';
        $image = new PageImage($this->getRepository()->getImage('projects/' . $file), 'cache/projects/' . $output_file );
            $image->resizeContain(200, 200);
        return $this->makePage($image, true);
    }

    public function html() {
        ?>
        <a href="<?=$this->project->getAbsoluteUrl()?>" class="project-box clickable-box">
            <div class="grid-padding">
                <div class="project-logo">
                    <img width="100px" height="100px" src="<?=$this->getImage()?>" alt="<?=$this->project->getName()?>"/>
                </div>
                <div>
                    <h2><?=$this->project->getName()?></h2>
                    <p><?=$this->project->getDescription()?></p>
                </div>
            </div>
        </a>
        <?php
    }

}