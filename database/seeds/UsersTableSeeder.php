<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert([
            0 =>
                [
                    'id'             => 3,
                    'name'           => 'Admin',
                    'email'          => 'admin@qq.com',
                    'password'       => '$2y$10$THzCWaxn/DPlwFGNX6o8/uEy5kK/0AFBa8z5GBG6ApyOgEvBwxwUG',
                    'is_super_admin' => 1,
                    'remember_token' => 'vnjLoBsi4zCqywOa0PBtWXz9ulfBTUHbjoACRXHe3HthmA8wDQO4bPBpOQs8',
                    'created_at'     => '2017-02-03 09:52:51',
                    'updated_at'     => '2017-02-03 09:52:51',
                ],
        ]);

        \DB::table('roles')->delete();

        \DB::table('roles')->insert([
            0 =>
                [
                    'id'             => 1,
                    'name'          => '游客',
                    'created_at'     => '2017-02-03 09:52:51',
                    'updated_at'     => '2017-02-03 09:52:51',
                ],
        ]);

        \DB::table('system_config')->delete();

        \DB::table('system_config')->insert([
            0 =>
                [
                    'id'             => 1,
                    'site_name'      => '网站名称',
                    'site_title'     => '网站标题',
                    'keyword'       => '关键词1,关键词2,关键词3,关键词4,关键词5',
                    'phone1'        => '027-87411245',
                    'phone2'        => '027-63524125',
                    'site_domain'   => 'www.motoogame.com',
                    'active_member_money' => 200,
                    'created_at'     => '2017-02-03 09:52:51',
                    'updated_at'     => '2017-02-03 09:52:51',
                ],
        ]);

        \DB::table('api')->delete();

        \DB::table('api')->insert([
            0 =>
                [
                    'id'             => 3,
                    'api_name'      => 'AG',
                    'created_at'     => '2017-02-03 09:52:51',
                    'updated_at'     => '2017-02-03 09:52:51',
                ],
            1 =>
                [
                    'id'             => 4,
                    'api_name'      => 'MG',
                    'created_at'     => '2017-02-03 09:52:51',
                    'updated_at'     => '2017-02-03 09:52:51',
                ],
            2 =>
                [
                    'id'             => 5,
                    'api_name'      => 'BBIN',
                    'created_at'     => '2017-02-03 09:52:51',
                    'updated_at'     => '2017-02-03 09:52:51',
                ],
            3 =>
                [
                    'id'             => 6,
                    'api_name'      => 'PT',
                    'created_at'     => '2017-02-03 09:52:51',
                    'updated_at'     => '2017-02-03 09:52:51',
                ],
            4 =>
                [
                    'id'             => 7,
                    'api_name'      => 'PNG',
                    'created_at'     => '2017-02-03 09:52:51',
                    'updated_at'     => '2017-02-03 09:52:51',
                ],
            5 =>
                [
                    'id'             => 8,
                    'api_name'      => 'OG',
                    'created_at'     => '2017-02-03 09:52:51',
                    'updated_at'     => '2017-02-03 09:52:51',
                ],
            6 =>
                [
                    'id'             => 9,
                    'api_name'      => 'ALLBET',
                    'created_at'     => '2017-02-03 09:52:51',
                    'updated_at'     => '2017-02-03 09:52:51',
                ],
            7 =>
                [
                    'id'             => 10,
                    'api_name'      => 'EBET',
                    'created_at'     => '2017-02-03 09:52:51',
                    'updated_at'     => '2017-02-03 09:52:51',
                ]
        ]);


    }
}
