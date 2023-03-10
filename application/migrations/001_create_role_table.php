<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_role_table extends CI_Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ]
        ];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('roles', TRUE);

        $data = [
            [
                'id' => 1,
                'name' => 'All'
            ],
            [
                'id' => 2,
                'name' => 'Post'
            ],
            [
                'id' => 3,
                'name' => 'Like-Comment'
            ]
        ];

        $this->db->insert_batch('roles', $data);
    }

    public function down()
    {
        $this->dbforge->drop_table('roles', TRUE);
    }
}
