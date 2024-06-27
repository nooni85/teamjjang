<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateErrorMigration extends AbstractMigration
{
    public function up(): void
    {
        $this->table('error', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', ['null' => false])
            ->changePrimaryKey('id')
            ->addColumn('file','string', ['null' => false, 'limit' => 255, 'comment' => '파일명'])
            ->addColumn('line','integer', ['null' => false, 'comment' => '라인번호'])
            ->addColumn('message','string', ['null' => false, 'limit' => 255, 'comment' => '메세지'])
            ->addColumn('created_at', 'datetime', ['null' => false, 'comment' => '생성일'])
            ->addColumn('updated_at', 'datetime', ['null' => false, 'comment' => '수정일'])
            ->create();
    }

    public function down(): void
    {
        $this->table('error')->drop()->save();
    }
}
