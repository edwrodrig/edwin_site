<?php
declare(strict_types=1);

namespace edwrodrig\site\data;

use edwrodrig\contento\collection\Collection;
use edwrodrig\contento\collection\Singleton;
use edwrodrig\site\theme\TemplatePost;
use edwrodrig\static_generator\Context;

class DataManager
{
    /**
     * @var Post[]|\Generator|null
     */
    private $posts = null;

    /**
     * @var Project[]|\Generator|null
     */
    private $projects = null;

    /**
     * @var SiteInfo|null
     */
    private $site_info = null;


    /**
     * @var Context
     */
    private $context;


    public function setContext(Context $context) : DataManager {
        $this->context = $context;
        $this->posts = null;
        return $this;
    }

    /**
     * @param Context $context
     * @return \Generator
     * @throws \edwrodrig\static_generator\exception\InvalidTemplateClassException
     * @throws \edwrodrig\static_generator\util\exception\IgnoredPageFileException
     */
    protected function getPostFromTemplates() {
        foreach ( $this->context->getTemplates() as $template ) {
            if ($template instanceof TemplatePost) {
                yield $template->getPost();
            }
        }
    }

    /**
     * @return Project[]|\Generator
     */
    public function getProjects() {
        if ( is_null($this->projects) ) {
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
     * @return Post[]|\Generator
     * @throws \edwrodrig\static_generator\exception\InvalidTemplateClassException
     * @throws \edwrodrig\static_generator\util\exception\IgnoredPageFileException
     */
    public function getPosts() {
        if ( is_null($this->posts) ) {
            $this->posts = Collection::createFromElements(iterator_to_array($this->getPostFromTemplates()));
            $this->posts->reverseSort();
        }
        return $this->posts;
    }

    /**
     * @param string $id
     * @return Post
     * @throws \edwrodrig\static_generator\exception\InvalidTemplateClassException
     * @throws \edwrodrig\static_generator\util\exception\IgnoredPageFileException
     */
    public function getPost(string $id) : Post {
        return $this->getPosts()[$id];
    }

    /**
     * @return SiteInfo
     */
    public function getSiteInfo() : SiteInfo {
        if ( is_null($this->site_info) ) {
            $this->site_info = Singleton::createFromJson(__DIR__ . '/../../data/site_info.json', SiteInfo::class);
        }
        return $this->site_info;
    }
}