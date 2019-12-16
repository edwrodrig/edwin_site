<?php
declare(strict_types=1);

namespace edwrodrig\site\data;

use edwrodrig\contento\collection\Collection;
use edwrodrig\contento\collection\Singleton;
use edwrodrig\site\theme\TemplatePost;
use edwrodrig\static_generator\Context;
use edwrodrig\static_generator\exception\InvalidTemplateClassException;
use edwrodrig\static_generator\exception\InvalidTemplateMetadataException;
use edwrodrig\static_generator\Repository as BaseRepository;
use edwrodrig\static_generator\util\exception\IgnoredPageFileException;
use Generator;

class Repository extends BaseRepository
{
    /**
     * @var Post[]|Generator
     */
    private $posts;

    /**
     * @var Project[]|Generator
     */
    private $projects;

    /**
     * @var SiteInfo
     */
    private SiteInfo $site_info;


    /**
     * @param Context $context
     * @return BaseRepository
     */
    public function setContext(Context $context) : BaseRepository
    {
        unset($this->posts);
        return parent::setContext($context);
    }

    /**
     * @return Generator
     * @throws InvalidTemplateClassException
     * @throws InvalidTemplateMetadataException
     * @throws IgnoredPageFileException
     */
    protected function getPostFromTemplates() {
        foreach ( $this->context->getTemplates() as $template ) {
            if ($template instanceof TemplatePost) {
                yield $template->getPost();
            }
        }
    }

    /**
     * @return Project[]|Generator
     */
    public function getProjects() {
        if ( !isset($this->projects) ) {
            $this->projects = Collection::createFromJson(__DIR__ . '/../../data/projects.json', Project::class);
            $this->projects->reverseSort();
        }
        return $this->projects;
    }

    /**
     * @param string $id
     * @return Project
     */
    public function getProject(string $id) : Project {
        return $this->getProjects()[$id];
    }

    /**
     * @return Post[]|Generator
     * @throws IgnoredPageFileException
     * @throws InvalidTemplateClassException
     * @throws InvalidTemplateMetadataException
     */
    public function getPosts() {
        if ( !isset($this->posts) ) {
            $this->posts = Collection::createFromElements(iterator_to_array($this->getPostFromTemplates()));
            $this->posts->reverseSort();
        }
        return $this->posts;
    }

    /**
     * @param string $id
     * @return Post
     * @throws IgnoredPageFileException
     * @throws InvalidTemplateClassException
     * @throws InvalidTemplateMetadataException
     */
    public function getPost(string $id) : Post {
        return $this->getPosts()[$id];
    }

    /**
     * @return SiteInfo
     */
    public function getSiteInfo() : SiteInfo {
        if ( !isset($this->site_info) ) {
            $this->site_info = Singleton::createFromJson(__DIR__ . '/../../data/site_info.json', SiteInfo::class);
        }
        return $this->site_info;
    }
}