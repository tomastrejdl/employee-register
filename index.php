<?php

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

$lexer = new Twig_Lexer($twig, array(
    'tag_block' => array('{','}')
));

$twig->setLexer($lexer);

$homepage_view = $twig->load('homepage/homepage.html');
$search_view = $twig->load('search/search.html');
$employee_detail_view = $twig->load('employee-detail/employee-detail.html');
$employee_edit_view = $twig->load('employee-edit/employee-edit.html');

Evizam\Router::set('index.php', function($homepage_view) {
    echo $homepage_view->render(array(
        'test' => 'Homepage loaded. It works!'
    ));
}, $homepage_view);

Evizam\Router::set('search', function($search_view) {
    echo $search_view->render(array(
        'test' => 'Search result loaded. It works!'
    ));
}, $search_view);

Evizam\Router::set('employee-detail', function($employee_detail_view) {
    echo $employee_detail_view->render(array(
        'test' => 'User page loaded. It works!'
    ));
}, $employee_detail_view);

Evizam\Router::set('employee-edit', function($employee_edit_view) {
    echo $employee_edit_view->render(array(
        'test' => 'User Edit page loaded. It works!'
    ));
}, $employee_edit_view);