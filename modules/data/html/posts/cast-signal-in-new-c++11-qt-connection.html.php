<?php
declare(strict_types=1);

use edwrodrig\mypage\site\BlockPagePost;
use labo86\staty_core\PagePhp;

/** @var PagePhp $page */
$page->prepareMetadata([
    'title' => "Castear signal en las nuevas conecciones C++11 de Qt",
    'description' =>"Castear signal en las nuevas conecciones C++11 de Qt",
    'publication_date' => '2017-02-09',
    'type' => 'post'
]);

$BLOCK = new BlockPagePost($page);
$BLOCK->sectionBeginPostContent();
?>
<p>This is the template</p>
<pre>
<?=htmlentities(<<<'EOF'
static_cast<return_type(ClassName::*)(arg_type1, arg_type2)>
EOF
)?>
</pre>

<p>Example</p>
<pre>
<?=htmlentities(<<<'EOF'
static_cast<void (QComboBox::*)(const QString &)>(&QComboBox::activated)
EOF
)?>
</pre>

<p>Full example</p>

<pre>
<?=htmlentities(<<<'EOF'
connect(ui->comboBox, 
        static_cast<void (QComboBox::*)(const QString &)>(&QComboBox::activated),
        ps,
        &PlotSystem::requestPlotsAvailable);
EOF
)?>
</pre>
<?php
$BLOCK->html();
