<?php
use webfiori\entity\AutoLoader;

$DS = DIRECTORY_SEPARATOR;
//the name of tests directory. Update as needed.
define('TESTS_DIRECTORY', 'tests');
//an array that contains possible locations at which 
//WebFiori Framework might exist.
//Add and remove directories as needed.
$WebFioriFrameworkDirs = array(
    __DIR__.$DS.'src',
    __DIR__.$DS.'vendor'.$DS.'webfiori'.$DS.'framework'
);
fprintf(STDOUT, "Bootstrap Path: '".__DIR__."'\n");
fprintf(STDOUT,"Tests Directory: '".TESTS_DIRECTORY."'.\n");
fprintf(STDOUT,'Include Path: \''. get_include_path().'\''."\n");
fprintf(STDOUT,"Tryning to load the class 'AutoLoader'...\n");
$isAutoloaderLoaded = false;
if(explode($DS, __DIR__)[0] == 'home'){
    fprintf(STDOUT,"Run Environment: Linux.\n");
    foreach ($WebFioriFrameworkDirs as $dir){
        //linux 
        $file = $DS.$dir.'entity'.$DS.'AutoLoader.php';
        fprintf(STDOUT,"Checking if file '$file' is exist...\n");
        if(file_exists($file)){
            require_once $file;
            $isAutoloaderLoaded = true;
        }
    }
}
else{
    fprintf(STDOUT,"Run Environment: Other.\n");
    foreach ($WebFioriFrameworkDirs as $dir){
        //other
        $file = $dir.$DS.'entity'.$DS.'AutoLoader.php';
        fprintf(STDOUT,"Checking if file '$file' is exist...\n");
        if(file_exists($file)){
            require_once $file;
            $isAutoloaderLoaded = true;
        }
    }
}
if($isAutoloaderLoaded === false){
    fprintf(STDOUT, "Error: Unable to find the class 'AutoLoader'.\n");
    exit(-1);
}
else{
    fprintf(STDOUT,"Class 'AutoLoader' successfully loaded.\n");
}
AutoLoader::get(array(
    'search-folders'=>array(
        'tests',
        'src',
        'vendor'
    ),
    'define-root'=>true,
    'root'=>__DIR__,
    'on-load-failure'=>'do-nothing'
));
fprintf(STDOUT,'Autoloader Initialized.'."\n");
fprintf(STDOUT,'Root Directory: \''.AutoLoader::get()->getRoot().'\'.'."\n");
fprintf(STDOUT,'Class Search Paths:'."\n");
$dirs = AutoLoader::getFolders();
foreach ($dirs as $dir){
    echo $dir."\n";
}
fprintf(STDOUT, "Registering shutdown function...\n");

//run sum code after tests completion.
register_shutdown_function(function(){
});
fprintf(STDOUT, "Registering shutdown function completed.\n");

fprintf(STDOUT,"Starting to run tests...\n");