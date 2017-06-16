<?php

use yii\db\Migration;

class m170611_092300_manufacturer extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('manufacturer', [
            'manufacturer_id' => $this->primaryKey(),
            'image' => $this->string(255)->notNull(),
            'sort_order' => $this->integer(11)->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('manufacturer');
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
