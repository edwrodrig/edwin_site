<?php
namespace ephp\deploy;

class Github {

public $user;
public $target;
public $source = 'output';
public $branch = 'master';

public function __invoke() {
  echo "DEPLOYING to GITHUB\n";
  echo "Uploading files...\n";
  \ephp\Util::call('rm -rf /tmp/gitrepo', 'Error removing temporary folder');
  \ephp\Util::call(sprintf('git clone git@github.com:%s/%s.git /tmp/gitrepo', $this->user, $this->target), "Error cloning git repository $this->user@$this->target");
  \ephp\Util::call(sprintf('cd /tmp/gitrepo; git checkout %s', $this->branch), 'Fail to change branch');
  \ephp\Util::call("rm -rf /tmp/gitrepo/*; cp -rf $this->source/* /tmp/gitrepo/", 'Error preparing commit');
  \ephp\Util::call(sprintf('cd /tmp/gitrepo; git add -A; git commit -a -m "Automatic deploy"; git push origin %s', $this->branch), 'Error uploading to github');
  \ephp\Util::call('rm -rf /tmp/gitrepo', 'Error removing temporary file'); 
  echo "SITE DEPLOYED\n";

}

};


