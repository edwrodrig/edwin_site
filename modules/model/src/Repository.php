<?php
declare(strict_types=1);

namespace edwrodrig\mypage\model;

use labo86\exception_with_data\ExceptionWithData;
use labo86\staty_core\Context;
use labo86\staty_core\PagePhp;
use labo86\staty_core\ReaderDirectory;
use labo86\staty_core\SourceFile;
use Throwable;

class Repository
{
    /**
     * @var Post[]
     */
    private array $posts;

    /**
     * @var Project[]
     */
    private array $projects;

    protected Context $context;

    public function __construct(Context $context) {
        $this->context = $context;
    }

    /**
     * Los posts que están en la carpeta data/html/posts.
     * Están ordenados por su fecha de publicación con el más actual primero.
     * @return Post[]
     * @throws ExceptionWithData
     * @throws Throwable
     */
    public function getPosts() : array {
        if ( !isset($this->posts) ) {
            $this->posts = [];
            $reader = new ReaderDirectory($this->context, __DIR__ . '/../../data/html/posts');

            foreach ( $reader->readPages() as $page ) {
                if ( $page instanceof PagePhp ) {
                    $type = $page->getMetadata()['type'] ?? '';
                    if ($type == 'post')
                        $this->posts[] = new Post($page);
                }
            }
            //ordenamos por fecha de más próximo a más lejana
            usort($this->posts, function(Post $a, Post $b) { return -($a->getPublicationDate() <=> $b->getPublicationDate());});
        }
        return $this->posts;
    }

    /**
     * Son los proyectos establecidos en data/projects.json
     * Están ordenados por su grado de importancia de mayor a menor
     * @return Project[]
     */
    public function getProjects() : array {
        if ( !isset($this->projects) ) {
            $projects = json_decode(file_get_contents(__DIR__ . '/../../data/projects.json'), true);

            foreach ( $projects as $project )
                $this->projects[] = new Project($project);

            //ordenamos por importancia
            usort($this->projects, function(Project $a, Project $b) { return - ($a->getImportance() <=> $b->getImportance());});
        }
        return $this->projects;
    }

    /**
     * @param string $filename
     * @return SourceFile
     * @throws ExceptionWithData
     */
    public function getImage(string $filename) : SourceFile {
        return new SourceFile(__DIR__ . '/../../data/images/' . $filename);
    }
}