<?php

use yii\db\Migration;

class m160829_194628_alter_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'Registration_Number','varchar(250) NOT NULL');
        $this->addColumn('user', 'Mobile','varchar(20) NOT NULL');
        $this->addColumn('user', 'Profile_created_for','ENUM("BRIDE","GROOM","SELF") ');
        $this->addColumn('user', 'First_Name','varchar(100) NOT NULL');
        $this->addColumn('user', 'Last_Name','varchar(100) NOT NULL');
        $this->addColumn('user', 'Gender','ENUM("MALE","FEMALE") ');
        $this->addColumn('user', 'DOB','DATE NOT NULL');
        $this->addColumn('user', 'Time_of_Birth','TIME NOT NULL');
        $this->addColumn('user', 'Age','INT(11) NOT NULL');
        $this->addColumn('user', 'Birth_Place','varchar(250) NOT NULL');
        $this->addColumn('user', 'Marital_Status','INT(11) NOT NULL');
    }

    public function down()
    {
        echo "m160829_194628_alter_user_table cannot be reverted.\n";

        return false;
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
