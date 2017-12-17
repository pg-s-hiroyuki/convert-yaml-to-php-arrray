# convert-yaml-to-php-arrray
php script for converting from yaml file to php array

# case
ex) migration from symphony (sfconfig) -> codeigniter.

# prepare
This php script use "yaml_parse_file" function.
You need to setup yaml dll from the following web page.
https://pecl.php.net/package/yaml

# how to converter
php convert.php {yaml file name}
※you need to exclude file extension.

ex) php convert sample

# result
* input
sample.yaml
```
dev:
  api_url: http://sample.com/api/dev/users
  api_login:
    user: dev
    pass: pass
    port: 8080
stg:
  api_url: http://sample.com/api/stg/users
  api_login:
    user: stg
    pass: pass
    port: 8080
pro:
  api_url: http://sample.com/api/pro/users
  api_login:
    user: pro
    pass: pass
    port: 8080
all:
  api_url: http://localhost/api/dev/users
  api_login:
    user: dev
    pass: pass
    port: 8080 
```

output directory
```
convert.php
sample.yaml

sample.php
dev
 |_sample.php
stg
 |_sample.php
pro
 |_sample.php
```

output file
```
# sample.php
# output "all:" in yaml file.

<?php
$config['api_url'] = 'http://localhost/api/dev/users';
$config['api_login'] = array( 
    'user' => 'dev',
    'pass' => 'pass',
    'port' => '8080'
);
?>

# development/sample.php
# output "dev:" in yaml file.

<?php
$config['api_url'] = 'http://localhost/api/dev/users';
$config['api_login'] = array( 
    'user' => 'dev',
    'pass' => 'pass',
    'port' => '8080'
);
?>

# staging/sample.php
# output "stg:" in yaml file.

<?php
$config['api_url'] = 'http://localhost/api/stg/users';
$config['api_login'] = array( 
    'user' => 'stg',
    'pass' => 'pass',
    'port' => '8080'
);
?>

# production/sample.php
# output "pro:" in yaml file.

<?php
$config['api_url'] = 'http://localhost/api/pro/users';
$config['api_login'] = array( 
    'user' => 'pro',
    'pass' => 'pass',
    'port' => '8080'
);
?>
```