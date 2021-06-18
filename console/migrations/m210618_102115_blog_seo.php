<?php

use yii\db\Migration;

/**
 * Class m210618_102115_blog_seo
 */
class m210618_102115_blog_seo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('blog', 'seo_title', $this->string());
        $this->addColumn('blog', 'seo_keywords', $this->text());
        $this->addColumn('blog', 'seo_description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('blog', 'seo_title');
        $this->dropColumn('blog', 'seo_keywords');
        $this->dropColumn('blog', 'seo_description');
    }
}
