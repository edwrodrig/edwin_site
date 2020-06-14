<?php
declare(strict_types=1);

namespace edwrodrig\mypage\site;

use edwrodrig\mypage\model\Repository;
use Exception;
use labo86\cache\Cache;

class Context extends \labo86\staty_core\Context
{

    private Repository $repository;

    /**
     * Context constructor.
     * @param string $absolute_path
     * @throws Exception
     */
    public function __construct(string $absolute_path = '') {
        parent::__construct($absolute_path);
        $this->repository = new Repository($this);
        $this->setCache(new Cache(__DIR__ . '/../../www', 'cache'));
    }

    public function getRepository() : Repository {
        return $this->repository;
    }
}