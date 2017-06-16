<?php

use yii\db\Migration;

class m170521_130433_banner_image extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('banner_image', [
            'banner_image_id' => $this->primaryKey(),
            'title' => $this->string(64)->notNull(),
            'link' => $this->string(255)->notNull(),
            'image' => $this->string(255)->notNull(),
            'sort_order' => $this->integer(3)->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('banner_image');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
