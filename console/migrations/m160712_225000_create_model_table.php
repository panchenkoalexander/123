<?php

use yii\db\Migration;

/**
 * Handles the creation for table `model_table`.
 * Has foreign keys to the tables:
 *
 * - `brand`
 */
class m160712_225000_create_model_table extends Migration
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
        $this->createTable('model', [
            'id' => $this->primaryKey(),
            'brandId' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
        ]);

        // creates index for column `brandId`
        $this->createIndex(
            'idx-model-brandId',
            'model',
            'brandId'
        );

        // add foreign key for table `brand`
        $this->addForeignKey(
            'fk-model-brandId',
            'model',
            'brandId',
            'brand',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `brand`
        $this->dropForeignKey(
            'fk-model-brandId',
            'model'
        );

        // drops index for column `brand_id`
        $this->dropIndex(
            'idx-model-brandId',
            'model'
        );

        $this->dropTable('model');
    }
}
