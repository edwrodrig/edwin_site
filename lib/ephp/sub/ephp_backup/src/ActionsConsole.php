<?php

namespace ephp\backup;

class ActionsConsole {

public $target_dir;
public $source_dir;

/**
 * @desc Backup data
 */
function backup() {
  Rsync::backup($this->source_dir, $this->target_dir);
}

/**
 * @desc Clean backup data 
 * @param keep number of backups to keep
 */
function backup_clean($keep = 10) {
  Rsync::clean($this->target_dir, $keep);

}

}
