<?php
$request_uri = $_SERVER['REQUEST_URI'];

$path = parse_url($request_uri, PHP_URL_PATH);

$root = '/SSASIT/Admin';


switch ($path) {

    case "$root/Dashboard":
        require 'Pages/Dashboard.php';
        break;

    case "$root/Authentication":
        require 'Pages/Authentication.php';
        break;

    case "$root/entities":
        require 'Pages/Entities.php';
        break;
    case "$root/Insert":
        require 'Services/Insert.php';
        break;
    case "$root/Entities_Record":
        require 'Pages/Entities_Record.php';
        break;
    case "$root/View-Record":
        require 'Pages/View_Record.php';
        break;
    case "$root/Delete":
        require 'Services/Delete.php';
        break;
    case "$root/Update":
        require 'Services/Update_Record.php';
        break;
    case "$root/Edit_Record":
        require 'Pages/Edit_Record.php';
        break;
    case "$root/View_Departments":
        require 'Pages/View_Departments.php';
        break;
    case "$root/Edit_Department":
        require 'Pages/Edit_Department.php';
        break;
    case "$root/Update_Department":
        require 'Services/Update_Department.php';
        break;
    case "$root/Delete_Department":
        require 'Services/Delete_Department.php';
        break;
    default:
        // Handle 404 Not Found errors for all other paths
        http_response_code(404);
        require 'Pages/404.html';
        break;
}
?>