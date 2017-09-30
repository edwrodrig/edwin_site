<?php

namespace ephp;

class SingleProcess {

public $command;
public $id;
public $dir;

const STATUS_IDLE = 0;
const STATUS_WORKING = 1;
const STATUS_QUEUED = 2;

private function __construct() {
  $calling_info = Util::calling_info(1);
  $this->id = str_replace('/', '_', $calling_info['file']) . '_' . $calling_info['line'];
  $this->dir = '/tmp/ephp/single_proc/' . $this->id;
  @mkdir($this->dir, 0777, true);
  
}

private function file($name) {
  return $this->dir. DIRECTORY_SEPARATOR . $name;
}

function set_status($value) {
  $lock_file = $this->file('lock');
  if ( $value == self::STATUS_IDLE ) {
    unlink($lock_file);
  } else {
    file_put_contents($lock_file, $value);
  }
}

function get_status() {
  if ( !file_exists($this->file('lock')) )
    return self::STATUS_IDLE;
  
  $status = file_get_contents($this->file('lock'));
  return (int)$status;
}

function call_code() {
  ob_start();?>
$status;
do {
  file_put_contents('<?=$this->file('lock')?>', <?=self::STATUS_WORKING?>);


  $process = proc_open(
    $argv[1],
    [ 
      1 => ['file', '<?=$this->file('output')?>', 'a'],
      2 => ['file', '<?=$this->file('error')?>' , 'a']
    ],
    $pipes
  );

  if (is_resource($process) ) {
    proc_close($process);
  }

  $status = file_get_contents('<?=$this->file('lock')?>');
} while ( $status == <?=self::STATUS_QUEUED?> );
unlink('<?=$this->file('lock')?>');
<?php
  return ob_get_clean();
}

function launch() {
  $status = $this->get_status();
  if ( $status == self::STATUS_IDLE ) {
     $command = sprintf('nohup php -r %s %s >/dev/null 2>&1 &', escapeshellarg($this->call_code()), escapeshellarg($this->command));
     shell_exec($command);
     return self::STATUS_WORKING;
  } else if ( $status == self::STATUS_QUEUED ) {
    return self::STATUS_WORKING;
  } else if ( $status == self::STATUS_WORKING ) {
    $this->set_status(self::STATUS_QUEUED);
    return self::STATUS_WORKING;
  }
}

static function create($command) {
  $p = new SingleProcess();
  $p->command = $command;
  return $p;
}

};
