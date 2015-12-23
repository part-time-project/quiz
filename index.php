<?php

/**
 * include partial files
 * @param string $fileName
 * @param array $vars
 */
function include_partial($fileName, $vars = array())
{
    // initialize vars
    foreach ($vars as $varName => $varValue) {
        ${$varName} = $varValue;
    }
    // require partial
    require 'partial/' . $fileName;
}

if (!function_exists('lcfirst')) {
    function lcfirst($str)
    {
        $str[0] = strtolower($str[0]);
        return $str;
    }
}

$page = parse_url($_SERVER['REQUEST_URI']);

$page = ($page['path'] != '/index.php') ? str_replace('/', '', $page['path']) : '';
$page = str_replace('december', '', $page);
// all available pages
require 'routing.php';
// home-page by default
$page = empty($page) ? 'home-page' : $page;
// page is in the available pages
if (in_array($page, $pages)) {
    // remove dash and uppercase after it and lowercase the first one
    $page = lcfirst(implode(array_map(create_function('$v', 'return ucfirst($v);'), explode('-', $page)))) . '.php';
}

// page exist
if (file_exists($page)) {
    // start buffer
    ob_start();
    // require additional files
    include_partial('_require.php');
    session_start();
    // require file
    require $page;
    // get file content
    $content = ob_get_contents();
    // clean the buffer
    ob_end_clean();
    // page title
    $title = isset($title) ? $title : '';
    // additional head section
    $headSection = (isset($head) && is_array($head)) ? implode("\n", $head) : '';
    // header
    include_partial('_header.php', array('title' => $title, 'head' => $headSection));
    // show file content
    echo $content;
    // footer
    include_partial('_footer.php');
} else {
    echo 'Page not found. Return to <a href="/">Home</a>';
}
