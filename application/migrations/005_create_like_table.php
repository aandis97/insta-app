<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_like_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'post_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
            'user_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('likes', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('likes', TRUE);
    }
}
