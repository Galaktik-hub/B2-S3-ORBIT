<?php
function svg($iconName)
{
    $icons = [
        'account' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" fill="#ffff" height="24"><circle cx="12" cy="8" r="4"/><path d="M12 14c-4 0-7 2-7 5v1h14v-1c0-3-3-5-7-5z"/></svg>',
        'home' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M12 3l9 8h-3v8h-4v-6h-4v6H6v-8H3z"/></svg>',
        'settings' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M12 8a4 4 0 100 8 4 4 0 000-8zm-1 2v4h2v-4h-2zM2 12h4v2H2zM18 12h4v2h-4zM7.34 4.93l2.83 2.83-1.41 1.41-2.83-2.83zM16.24 14.83l2.83 2.83-1.41 1.41-2.83-2.83zM4.93 16.24l2.83 2.83-1.41 1.41-2.83-2.83zM14.83 7.34l2.83-2.83 1.41 1.41-2.83 2.83z"/></svg>',
        'map' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"> <path d="M9 2l6 2v18l-6-2-6 2V4l6-2z" fill="#ffff"/>  <path d="M9 2l6 2v18l-6-2z" fill="#ffff"/>  <path d="M3 4l6 2v14l-6-2z" fill="#ffff"/> <path d="M15 4l6-2v18l-6 2z" fill="#ffff"/> <path d="M21 2l-6 2v14l6-2z" fill="#ffff"/> </svg>',
        'password' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#ffffff"><path d="M12 2C9.24 2 7 4.24 7 7v3H5c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V12c0-1.1-.9-2-2-2h-2V7c0-2.76-2.24-5-5-5zm0 2c1.66 0 3 1.34 3 3v3H9V7c0-1.66 1.34-3 3-3zm-1 8h2v6h-2v-6z"/></svg>',
        'email' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#ffffff">
  <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 2v.01L12 13 4 6.01V6h16zM4 18v-9l8 6 8-6v9H4z"/>
</svg>',
    ];

    return $icons[$iconName] ?? null;
}
