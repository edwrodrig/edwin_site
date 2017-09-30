<?php

if ( !defined('THEME_USAC') ) : define('THEME_USAC', true);

require_once(__DIR__ . '/..' . '/theme_app/include.php');
require_once(__DIR__ . '/..' . '/theme_tokac/include.php');

require_once(__DIR__ . '/src/Util.php');
require_once(__DIR__ . '/src/TemplateModalSessionError.php');
require_once(__DIR__ . '/src/TemplatePage.php');
require_once(__DIR__ . '/src/TemplatePageTokac.php');
require_once(__DIR__ . '/src/TemplateModalLogin.php');
require_once(__DIR__ . '/src/TemplateModalSessionError.php');
require_once(__DIR__ . '/src/TemplateSigned.php');
require_once(__DIR__ . '/src/TemplateLogin.php');
require_once(__DIR__ . '/src/TemplateRequestSignin.php');
require_once(__DIR__ . '/src/TemplateRequestChangeMail.php');
require_once(__DIR__ . '/src/TemplateForgotPassword.php');
require_once(__DIR__ . '/src/TemplateSignin.php');
require_once(__DIR__ . '/src/TemplateChangePassword.php');
require_once(__DIR__ . '/src/TemplateChangeMail.php');
require_once(__DIR__ . '/src/Site.php');

endif;
