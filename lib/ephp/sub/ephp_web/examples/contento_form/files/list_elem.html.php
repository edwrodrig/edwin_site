<?php
(new TemplatePage(<<<EOF
{
  "name": "list",
  "type": "list",
  "elem": {
    "type" : "string"
  }
}
EOF
, [['line' => 'text', 'area' => 'area', 'rich' => 'some']]))();
