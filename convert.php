<?php
  if (count($argv) === 1){
    echo 'Require config key.'.PHP_EOL.'ex) php convert.php {config key}.';
    return;
  }
  $configKey = $argv[1];
  $yaml = yaml_parse_file($configKey.'.yaml');
  // array( {yaml_key} => {directory_key})
  $target = array(
    'dev'  => 'development',
    'stg'  => 'staging',
    'pro'  => 'production',
    'all'  => ''
  );
  foreach($target as $yaml_key => $env_key){
    if (array_key_exists($yaml_key, $yaml)) {
      output($configKey, $env_key, $yaml[$yaml_key]);
    }
  }
  function output($configKey, $env, $array){
    $dir = "";
    if ($env !== ''){
      if (!is_dir($env)){
        mkdir($env);
      }
      $dir = $env.DIRECTORY_SEPARATOR;
    }
    $fp = fopen($dir.$configKey.'.php', 'w');
    fwrite($fp, '<?php'.PHP_EOL);
    outputRecursive($fp, $array, 1);
    fwrite($fp, '?>');
    fclose($fp);
  }
  function outputRecursive($fp, $array, $level){
    $len = count($array);
    $cnt = 0;
    foreach($array as $k => $v){
      $cnt++;
      if($level === 1){
        fwrite($fp, '$config[\''.$k.'\'] = ');
      } else {
        fwrite($fp, createSpace($level)."'$k' => ");
      }
      if (is_array($v)){
        fwrite($fp, 'array( '.PHP_EOL);
        $level++;
        $level = outputRecursive($fp, $v, $level);
      } else {
        fwrite($fp, "'".$v."'");
      }
      if($cnt == $len){
        $level--;
        if($level > 1){
          fwrite($fp, PHP_EOL.createSpace($level).')');
        } elseif ($level === 1) {
          fwrite($fp, PHP_EOL.');'.PHP_EOL);
        }
      } else {
        if($level !== 1){
          fwrite($fp, ','.PHP_EOL);
        } else {
          fwrite($fp, ';'.PHP_EOL);
        }
      }
    }
    return $level;
  }
  function createSpace($level){
    $space = "";
    for($i = 1; $i <= $level*2; $i++){
      $space .= " ";
    }
    return $space;
  }
?>