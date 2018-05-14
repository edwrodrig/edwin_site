<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 14-05-18
 * Time: 17:10
 */

namespace edwrodrig\site\data;


use edwrodrig\site\theme\TemplatePost;
use edwrodrig\static_generator\Context;
use edwrodrig\static_generator\util\PageFileFactory;

class DataManager
{
    /**
     * @var Post[]|\Generator
     */
    private $posts;

    /**
     * @var Project[]|\Generator
     */
    private $projects;

    /**
     * @var SiteInfo
     */
    private $site_info;


    public function __construct(Context $context) {
        foreach ( PageFileFactory::createTemplates($context) as $page ) {
            $template = $page->getTemplate();

        }

        $site->globals['posts'] = Collection::create_from_elements($site->get_templates('post'));
        $site->globals['projects'] = Collection::create_from_json(__DIR__ . '/../../data/projects.json', Project::class);
        $site->globals['site_info'] = Singleton::create_from_json(__DIR__ . '/../../data/site_info.json', SiteInfo::class);

        $site->globals['posts']->reverse_sort();
        $site->globals['projects']->reverse_sort();
    }

    /**
     * @param Context $context
     * @throws \edwrodrig\static_generator\exception\InvalidTemplateClassException
     * @throws \edwrodrig\static_generator\util\exception\IgnoredPageFileException
     */
    protected function getPostFromTemplates(Context $context) {
        foreach ( PageFileFactory::createTemplates($context) as $page ) {
            $template = $page->getTemplate();
            if ( $template instanceof TemplatePost ) {
                yield $template->getPost();
            }
        }
    }

    /**
     * @return Project[]|\Generator
     */
    public function getProjects() {
        return $this->projects;
    }

    /**
     * @param string $id
     * @return Project
     */
    public function getProject(string $id) : Project {
        return $this->projects[$id];
    }

    /**
     * @return Post[]|\Generator
     */
    public function getPosts() {
       return $this->posts;
    }

    /**
     * @param string $id
     * @return Post
     */
    public function getPost(string $id) : Post {
        return $this->posts[$id];
    }

    /**
     * @return SiteInfo
     */
    public function getSiteInfo() : SiteInfo {
        return $this->site_info;
    }
}