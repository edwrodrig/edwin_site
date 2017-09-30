<?php

(new TemplatePage(<<<EOF
{
  "name": "common_gender",
  "type": "enum",
  "options": [
    {
      "value": "m",
      "label": {
        "es": "masculino",
        "en": "male"
      }
    },
    {
      "value": "f",
      "label": {
        "es": "femenino",
        "en": "female"
      }
    }
  ],
  "label": {
    "es": "genero",
    "en": "gender"
  }
}
EOF
))();

