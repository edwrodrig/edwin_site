<?php
declare(strict_types=1);

namespace edwrodrig\mypage\site;


use DateTime;
use edwrodrig\mypage\model\Repository;
use labo86\exception_with_data\ExceptionWithData;
use labo86\staty\PageImage;
use labo86\staty_core\Util;

class Block extends \labo86\staty\Block
{
    /**
     * Get the date in readable format.
     *
     * The date is already translated bt the {@see Template::getLang() current language}
     * @param DateTime $date
     * @return string
     */
    public function date(DateTime $date) : string {
        $lang = $this->page->getContext()->getLang();
        if ( $lang === 'es_CL' ) {
            $date = ucwords(strftime('%A %e de %B de %G',  $date->getTimestamp()));
            return str_replace(' De ', ' de ', $date);
        } else if ( $lang === 'en_US' ) {
            return ucwords(strftime('%A, %B %e, %G', $date->getTimestamp()));
        } else {
            return strftime('%e/%m/%G', $date->getTimestamp());
        }
    }

    public function url(string $relative_path) : string {
        $from = $this->page->getRelativeFilename();
        $init_char = $from[0] ?? '';
        if ( $init_char == '/')
            return $this->getContext()->getAbsolutePath() . $relative_path;
        else
            return Util::getRelativePath($from, $relative_path);
    }

    /**
     * @param string $file
     * @param int $width
     * @param int $height
     * @return string
     * @throws ExceptionWithData
     */
    public function imageContain(string $file, int $width, int $height) : string {

        $filename = pathinfo($file, PATHINFO_FILENAME);
        $image = new PageImage($this->getRepository()->getImage($file), 'cache/' . $filename . '.png');
        $image->resizeContain($width, $height);
        return $this->makePage($image, true);
    }

    /**
     * Esperar por {@see https://wiki.php.net/rfc/covariant-returns-and-contravariant-parameters}
     * @return Repository
     */
    public function getRepository() : Repository {
        return $this->getContext()->getRepository();
    }

    public function getContext() : Context {
        return $this->page->getContext();
    }
}