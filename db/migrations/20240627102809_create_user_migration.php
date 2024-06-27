<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up(): void
    {
        $table = $this->table('users');
        $table->addColumn('username', 'string', ['null' => false, 'limit' => 60, 'comment'=> '아이디'])
            ->addColumn('password', 'char', ['null' => false, 'limit' => 60, 'comment'=> '비밀번호'])
            ->addColumn('created_at', 'datetime', ['null' => false, 'comment'=> '생성일'])
            ->addColumn('updated_at', 'datetime', ['null' => false, 'comment'=> '수정일'])
            ->create();
    }

    public function down(): void
    {
        $this->table('users')->drop()->save();
    }
}
