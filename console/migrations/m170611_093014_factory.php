<?php

use yii\db\Migration;

class m170611_093014_factory extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('factory', [
            'factory_id' => $this->primaryKey(),
            'price' => $this->decimal(5, 2)->notNull()->defaultValue(0),
            'area' => $this->integer(5)->notNull()->defaultValue(0),
            'location_id' => $this->integer(11)->notNull()->defaultValue(0),
            'factory_type_id' => $this->integer(11)->notNull()->defaultValue(0),
            'industry_type_id' => $this->integer(11)->notNull()->defaultValue(0),
            'manufacturer_id' => $this->integer(11)->notNull()->defaultValue(0),
            'viewed' => $this->integer(11)->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'sort_order' => $this->integer(3)->notNull()->defaultValue(0),
            'language_id' => $this->integer(3)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-factory',
            'factory',
            [
                'price',
                'area',
                'location_id',
                'factory_type_id',
                'industry_type_id',
                'manufacturer_id',
            ]
        );
    }

    public function down()
    {
        $this->dropTable('factory');
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
