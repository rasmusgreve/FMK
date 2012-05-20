<?php

class Navigation
{
    public function show($command, $params, $user)
    {
        global $pages;
        $items = array();
        
        foreach ($pages as $page)
        {
            if (preg_match('/'.$user->type.'/',$page['usertype']))
            {
                if ($page['command'] == '_ANY_')
                    $page['command'] = '';
                
                $class = '';
                if ($page['command'] == $command || $page['command'] == '_ANY_')
                    $class = "class='active'";
                
                $items[] = "<li $class><a href='./{$page['command']}'>{$page['title']}</a></li>";
            }
        }
        
        $output = '<div class="navbar navbar-fixed-top">'.
                    '<div class="navbar-inner">'.
                        '<div class="container">'.
                            '<a class="brand" href="./">FMK</a>'.
                            '<div class="nav-collapse">'.
                                '<ul class="nav">'.
                                    implode($items).
                                '</ul>'.
                            '</div>'.
                        '</div>'.
                    '</div>'.
                '</div>';
        echo $output;
    }
}

?>