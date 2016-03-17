@include('elements.side-menu-parent-item', [
'folder' => 'failed-logins',
'menu' => 'Security',
'menuIcon' => 'fa-shield',
'children' => [ [
        'url' => 'list/all',
        'menu' => 'Failed Login Attempts',
    ]
]])
