<?php
namespace ephp\backup;

class Rsync {

static public function backup($source, $target_dir) {
  echo "BACKUP using RSYNC\n";
  echo "Uploading files...\n";
  if ( !file_exists($target_dir) ) {
    mkdir($target_dir);
  }
  if ( !is_dir($target_dir) ) throw new \Exception("Not a directory");
 
  $last = null;

  foreach (new \DirectoryIterator($target_dir) as $fileInfo) {
    if( $fileInfo->isDot() ) continue;
    if ( is_null($last) ||  $last['time'] < $fileInfo->getCTime() )
      $last = [
        'time' => $fileInfo->getCTime(),
        'path' => realpath($fileInfo->getPathName())
      ];
  }

  $current_date = date('Y_m_d_H_i_s');
  if( is_null($last) ) {
    \ephp\Util::call(sprintf('rsync -avh --delete %s %s/%s', $source, $target_dir, $current_date)); 
  } else {
    echo "[" . $last['path']. "]\n";
    \ephp\Util::call(sprintf('rsync -avh --delete --link-dest=%s %s %s/%s', $last['path'], $source, $target_dir, $current_date));
  }
 
}

static public function clean($target_dir, $keep = 10) {
  if ( $keep < 1 ) $keep = 1;
  if ( !file_exists($target_dir) ) {
    mkdir($target_dir);
  }
  if ( !is_dir($target_dir) ) throw new \Exception("Not a directory");

  $files = [];

  foreach ( new \DirectoryIterator($target_dir) as $fileInfo) {
    if ( $fileInfo->isDot() ) continue;
    if ( !$fileInfo->isDir() ) continue;
    $files[] = realpath($fileInfo->getPathname());
  }

  sort($files);

  $files = array_splice($files, 0, -$keep);

  foreach ( $files as $file ) {
    passthru("rm -rf $file");
  } 
}

};


