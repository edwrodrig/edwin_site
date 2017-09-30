<?php
(new TemplatePage(<<<EOF
{
  "name": "list",
  "type": "list",
  "elem": {
    "type" : "object",
    "fields" : [
      {"field": "line", "type": "string", "tr" : true, "display" : true, "label" : { "es" : "linea", "en" : "line" }},
      {"field": "line_2", "type": "string", "tr" : true, "display" : true, "label" : { "es" : "linea 2", "en" : "line 2"}},
      {"field": "area", "type": "string", "style" : "area"},
      {"field": "rich", "type": "string", "style" : "rich"}
    ]
  }
}
EOF
, [['line' => 'text', 'area' => 'area', 'rich' => 'some']]))();
