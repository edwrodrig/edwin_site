<?php
(new TemplatePage(<<<EOF
{
  "name": "object",
  "type": "object",
  "fields": [
    {"field": "line", "type": "string"},
    {"field": "area", "type": "string", "style" : "area", "tr" : true},
    {"field": "rich", "type": "string", "style" : "rich", "tr" : true },
    {"field": "value", "type" : "bool"}
  ]
}
EOF
))();
