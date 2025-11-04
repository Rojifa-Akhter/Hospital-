<?php

return [
    'oracle' => [
       'driver'         => 'oracle',
        //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.5.95)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
       // 'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=140.238.241.147)(PORT=1521))(CONNECT_DATA=(service_name=orclpdb)))'),
        'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=140.238.241.147)(PORT=1521))(CONNECT_DATA=(service_name=orclpdb)))'), //main
        // 'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=202.51.181.181)(PORT=1500))(CONNECT_DATA=(SID=orcl)))'), //emwch
        //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.1.51)(PORT=1521))(CONNECT_DATA=(service_name=uhlpdb)))'),//uhl
        //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=199.192.28.11)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
        //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=152.67.5.234)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),

        //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=43.224.109.125)(PORT=1500))(CONNECT_DATA=(service_name=impdb)))'), //imperial

        // 'host'           => env('DB_HOST', '10.10.10.11'), //main
        // 'port'           => env('DB_PORT', '1521'),
        // 'database'       => env('DB_DATABASE', 'H360_V2'),
        // 'username'       => env('DB_USERNAME', 'H360_V2'),
        // 'password'       => env('DB_PASSWORD', 'ng#h360_v2db2#'),
# start
        // 'database'       => env('DB_DATABASE', 'h360_imperial_v2'),
        // 'username'       => env('DB_USERNAME', 'h360_imperial_v2'),
        // 'password'       => env('DB_PASSWORD', 'ng#imperial_dbv2#'),
        // 'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        // 'prefix'         => env('DB_PREFIX', ''),
        // 'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        // 'edition'        => env('DB_EDITION', 'ora$base'),
        // 'server_version' => env('DB_SERVER_VERSION', '11g'),

        'database'       => env('DB_DATABASE', 'H360_V2'), //main
        'username'       => env('DB_USERNAME', 'H360_V2'),
        'password'       => env('DB_PASSWORD', 'ng#h360_v2db2#'),
        // 'database'       => env('DB_DATABASE', 'H360_EWMCH_V1'), //EWMCH
        // 'username'       => env('DB_USERNAME', 'H360_EWMCH_V1'),
        // 'password'       => env('DB_PASSWORD', 'ng#ewmch_v1db1#'),

        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),

        // 'database'       => env('DB_DATABASE', 'H360_UHL_UAT_V2'), // UHL
        // 'username'       => env('DB_USERNAME', 'H360_UHL_UAT_V2'),
        // 'password'       => env('DB_PASSWORD', 'ng#uhl_uat_v2db2'),
        // 'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        // 'prefix'         => env('DB_PREFIX', ''),
        // 'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        // 'edition'        => env('DB_EDITION', 'ora$base'),
        // 'server_version' => env('DB_SERVER_VERSION', '11g'),
    # end
    ],

    // 'oracle' => [
    //     'driver'         => 'oracle',
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.5.95)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=140.238.241.147)(PORT=1521))(CONNECT_DATA=(service_name=orclpdb)))'),
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=199.192.28.11)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=152.67.5.234)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     //'host'           => env('DB_HOST', '10.10.10.11'),
    //     //'port'           => env('DB_PORT', '1521'),
    //     //'database'       => env('DB_DATABASE', 'H360_V2'),
    //     //'username'       => env('DB_USERNAME', 'H360_V2'),
    //     //'password'       => env('DB_PASSWORD', 'ng#h360_v2db2#'),
    //     'database'       => env('DB_DATABASE', 'H360_IMPALA_V2'),
    //     'username'       => env('DB_USERNAME', 'H360_IMPALA_V2'),
    //     'password'       => env('DB_PASSWORD', 'ng#impala_v2db2#'),
    //     'charset'        => env('DB_CHARSET', 'AL32UTF8'),
    //     'prefix'         => env('DB_PREFIX', ''),
    //     'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
    //     'edition'        => env('DB_EDITION', 'ora$base'),
    //     'server_version' => env('DB_SERVER_VERSION', '11g'),
    // ],

    // 'oracle' => [
    //     'driver'         => 'oracle',
    //     'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=202.51.181.181)(PORT=1500))(CONNECT_DATA=(sid=orcl)))'), //ewmch
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=202.51.181.181)(PORT=1500))(CONNECT_DATA=(service_name=orclpdb)))'),
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=199.192.28.11)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=152.67.5.234)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     //'host'           => env('DB_HOST', '10.10.10.11'),
    //     //'port'           => env('DB_PORT', '1521'),
    //     //'database'       => env('DB_DATABASE', 'H360_V2'),
    //     //'username'       => env('DB_USERNAME', 'H360_V2'),
    //     //'password'       => env('DB_PASSWORD', 'ng#h360_v2db2#'),
    //     'database'       => env('DB_DATABASE', 'H360_EWMCH_V1'),
    //     'username'       => env('DB_USERNAME', 'H360_EWMCH_V1'),
    //     'password'       => env('DB_PASSWORD', 'ng#ewmch_v1db1#'),
    //     'charset'        => env('DB_CHARSET', 'AL32UTF8'),
    //     'prefix'         => env('DB_PREFIX', ''),
    //     'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
    //     'edition'        => env('DB_EDITION', 'ora$base'),
    //     'server_version' => env('DB_SERVER_VERSION', '11g'),
    // ],

    // 'oracle' => [
    //     'driver'         => 'oracle',
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.5.95)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=202.4.115.110)(PORT=1522))(CONNECT_DATA=(sid=orcl)))'),
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=199.192.28.11)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=152.67.5.234)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     //'host'           => env('DB_HOST', '10.10.10.11'),
    //     //'port'           => env('DB_PORT', '1521'),
    //     //'database'       => env('DB_DATABASE', 'H360_V2'),
    //     //'username'       => env('DB_USERNAME', 'H360_V2'),
    //     //'password'       => env('DB_PASSWORD', 'ng#h360_v2db2#'),
    //     'database'       => env('DB_DATABASE', 'H360_JKMS_V2'),
    //     'username'       => env('DB_USERNAME', 'H360_JKMS_V2'),
    //     'password'       => env('DB_PASSWORD', 'ng#jkms_v2db2#'),
    //     'charset'        => env('DB_CHARSET', 'AL32UTF8'),
    //     'prefix'         => env('DB_PREFIX', ''),
    //     'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
    //     'edition'        => env('DB_EDITION', 'ora$base'),
    //     'server_version' => env('DB_SERVER_VERSION', '11g')
    // ]
    // 'oracle' => [
    //     'driver'         => 'oracle',
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.5.95)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.5.95)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=199.192.28.11)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=152.67.5.234)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     //'host'           => env('DB_HOST', '10.10.10.11'),
    //     //'port'           => env('DB_PORT', '1521'),
    //     //'database'       => env('DB_DATABASE', 'H360_V2'),
    //     //'username'       => env('DB_USERNAME', 'H360_V2'),
    //     //'password'       => env('DB_PASSWORD', 'ng#h360_v2db2#'),
    //     'database'       => env('DB_DATABASE', 'H360_EWMCH_V1'),
    //     'username'       => env('DB_USERNAME', 'H360_EWMCH_V1'),
    //     'password'       => env('DB_PASSWORD', 'ng#ewmch_v1db1#'),
    //     'charset'        => env('DB_CHARSET', 'AL32UTF8'),
    //     'prefix'         => env('DB_PREFIX', ''),
    //     'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
    //     'edition'        => env('DB_EDITION', 'ora$base'),
    //     'server_version' => env('DB_SERVER_VERSION', '11g'),
    // ],
    // 'oracle' => [
    //     'driver'         => 'oracle',
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.5.95)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.5.95)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=199.192.28.11)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     //'tns'            => env('DB_TNS', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=152.67.5.234)(PORT=1521))(CONNECT_DATA=(sid=orcl)))'),
    //     //'host'           => env('DB_HOST', '10.10.10.11'),
    //     //'port'           => env('DB_PORT', '1521'),
    //     //'database'       => env('DB_DATABASE', 'H360_V2'),
    //     //'username'       => env('DB_USERNAME', 'H360_V2'),
    //     //'password'       => env('DB_PASSWORD', 'ng#h360_v2db2#'),
    //     'database'       => env('DB_DATABASE', 'H360_EWMCH_UAT_V2'),
    //     'username'       => env('DB_USERNAME', 'H360_EWMCH_UAT_V2'),
    //     'password'       => env('DB_PASSWORD', 'ng#ewmch_uat2_v2db2#'),
    //     'charset'        => env('DB_CHARSET', 'AL32UTF8'),
    //     'prefix'         => env('DB_PREFIX', ''),
    //     'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
    //     'edition'        => env('DB_EDITION', 'ora$base'),
    //     'server_version' => env('DB_SERVER_VERSION', '11g'),
    // ],
];
