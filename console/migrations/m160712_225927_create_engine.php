<?php

use yii\db\Migration;

/**
 * Handles the creation for table `engine`.
 * Has foreign keys to the tables:
 *
 * - `model`
 */
class m160712_225927_create_engine extends Migration
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
        $this->createTable('engine', [
            'id' => $this->primaryKey(),
            'modelId' => $this->integer()->notNull(),
            'engine' => $this->string(32)->notNull(),
            'year' => $this->string(6)->notNull(),
            'horsePower' => $this->integer(4)->notNull(),
        ]);

        // creates index for column `modelId`
        $this->createIndex(
            'idx-engine-modelId',
            'engine',
            'modelId'
        );

        // add foreign key for table `model`
        $this->addForeignKey(
            'fk-engine-modelId',
            'engine',
            'modelId',
            'model',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `model`
        $this->dropForeignKey(
            'fk-engine-modelId',
            'engine'
        );

        // drops index for column `modelId`
        $this->dropIndex(
            'idx-engine-modelId',
            'engine'
        );

        $this->dropTable('engine');
    }
}
