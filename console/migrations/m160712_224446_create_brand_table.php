<?php

use yii\db\Migration;

/**
 * Handles the creation for table `brand_table`.
 */
class m160712_224446_create_brand_table extends Migration
{
    public function init()
    {
        $this->db = 'catalogueDb';
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
