<?php
function svg($iconName)
{
  $icons = [
    'account' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" fill="#4CAF50" height="24"><circle cx="12" cy="8" r="4"/><path d="M12 14c-4 0-7 2-7 5v1h14v-1c0-3-3-5-7-5z"/></svg>',
    'settings' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#FF9800">
  <path d="M19.14 12.94c.04-.31.06-.63.06-.94s-.02-.63-.06-.94l2.03-1.58c.18-.14.23-.39.12-.59l-1.91-3.3c-.11-.2-.35-.28-.56-.22l-2.39.96c-.5-.38-1.03-.7-1.6-.94L14.81 2h-5.62L8.77 5.33c-.57.24-1.1.56-1.6.94l-2.39-.96c-.21-.06-.45.02-.56.22l-1.91 3.3c-.11.2-.06.45.12.59l2.03 1.58c-.04.31-.06.63-.06.94s.02.63.06.94l-2.03 1.58c-.18.14-.23.39-.12.59l1.91 3.3c.11.2.35.28.56.22l2.39-.96c.5.38 1.03.7 1.6.94L9.19 22h5.62l.42-2.73c.57-.24 1.1-.56 1.6-.94l2.39.96c.21.06.45-.02.56-.22l1.91-3.3c.11-.2.06-.45-.12-.59l-2.03-1.58zM12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"/>
</svg>',
    'home' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#2196F3"><path d="M12 3l9 8h-3v8h-4v-6h-4v6H6v-8H3z"/></svg>',
    'map' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
      <path d="M9 2l6 2v18l-6-2-6 2V4l6-2z" fill="#8BC34A"/>  
      <path d="M9 2l6 2v18l-6-2z" fill="#4CAF50"/>  
      <path d="M3 4l6 2v14l-6-2z" fill="#CDDC39"/> 
      <path d="M15 4l6-2v18l-6 2z" fill="#FFC107"/> 
      <path d="M21 2l-6 2v14l6-2z" fill="#FF5722"/> 
    </svg>',
    'password' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#9C27B0"><path d="M12 2C9.24 2 7 4.24 7 7v3H5c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V12c0-1.1-.9-2-2-2h-2V7c0-2.76-2.24-5-5-5zm0 2c1.66 0 3 1.34 3 3v3H9V7c0-1.66 1.34-3 3-3zm-1 8h2v6h-2v-6z"/></svg>',
    'email' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#03A9F4">
      <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 2v.01L12 13 4 6.01V6h16zM4 18v-9l8 6 8-6v9H4z"/>
    </svg>',
    'validate' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#4CAF50">
      <path d="M9 16.2l-4.2-4.2-1.4 1.4L9 19l12-12-1.4-1.4z"/>
    </svg>',
    'clock' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#C89100">
      <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-.5-13h-1v6l5.25 3.15.75-1.23-4.5-2.67V7z"/>
    </svg>',
    'attention' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#F44336">
      <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
    </svg>',
    'logout' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#F44336">
  <path d="M16 13v-2H7V9l-5 4 5 4v-2h9zm4-11H4a2 2 0 00-2 2v14a2 2 0 002 2h16a2 2 0 002-2V4a2 2 0 00-2-2zm0 16H4V4h16z"/>
</svg>',
    'route-planning' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
  <path d="M5 3a2 2 0 1 1 0 4 2 2 0 0 1 0-4z" fill="#4CAF50"/>
  <path d="M19 17a2 2 0 1 1 0 4 2 2 0 0 1 0-4z" fill="#FF5722"/>
  <path d="M5 5v5c0 3 2.5 5 5.5 5h3c1.5 0 2.5 1 2.5 2.5V19"/>
  <path d="M5 5l2.5 2.5M19 19l-2.5-2.5"/>
</svg>',
    'admin' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#3F51B5">
  <path d="M12 2l7 3v6c0 5.25-3.25 10-7 11-3.75-1-7-5.75-7-11V5l7-3z"/>
  <path d="M12 11.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm-1 1h2v5h-2z" fill="#FFFFFF"/>
</svg>',
    'warning' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#FF5722">
  <path d="M19.14 12.94c.04-.31.06-.63.06-.94s-.02-.63-.06-.94l2.03-1.58c.18-.14.23-.39.12-.59l-1.91-3.3c-.11-.2-.35-.28-.56-.22l-2.39.96c-.5-.38-1.03-.7-1.6-.94L14.81 2h-5.62L8.77 5.33c-.57.24-1.1.56-1.6.94l-2.39-.96c-.21-.06-.45.02-.56.22l-1.91 3.3c-.11.2-.06.45.12.59l2.03 1.58c-.04.31-.06.63-.06.94s.02.63.06.94l-2.03 1.58c-.18.14-.23.39-.12.59l1.91 3.3c.11.2.35.28.56.22l2.39-.96c.5.38 1.03.7 1.6.94L9.19 22h5.62l.42-2.73c.57-.24 1.1-.56 1.6-.94l2.39.96c.21.06.45-.02.56-.22l1.91-3.3c.11-.2.06-.45-.12-.59l-2.03-1.58zM12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"/>
  <path d="M11 10v4l1.5-1.5 1.5 1.5v-4h-3z" fill="#D32F2F"/>
</svg>',
    'cart' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#4CAF50">
  <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM7.16 14h9.67c.78 0 1.48-.45 1.81-1.14l3.24-6.88a1 1 0 00-.91-1.45H5.21L4.27 2H1v2h2l3.6 7.59-.35.73c-.16.34-.25.71-.25 1.09 0 1.1.9 2 2 2h9v-2H7.42l.75-1.5zM6.16 6h14.19l-2.76 5.88c-.09.19-.28.32-.48.32H7.58l-1.42-3z"/>
</svg>',
  ];

  return $icons[$iconName] ?? null;
}
