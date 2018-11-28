<?php
use Phalcon\Mvc\Router;

$router = new Router(false);
$router->removeExtraSlashes(true); // This peace of code lets us add slashes at the end of the URL

/*
 *  POSTCONTROLLER
 */

// appreciate articool
$router->addPost(
    '/api/v1/post/like-articool',
    [
        'namespace'  => 'Api\v1',
        'controller' => 'post',
        'action'     => 'appreciateArticool'
    ]
);

// add or remove articool to trending
$router->addPost(
    '/api/v1/post/trend-articool',
    [
        'namespace'  => 'Api\v1',
        'controller' => 'post',
        'action'     => 'trendArticool'
    ]
);

// post articool
$router->addPost(
    '/api/v1/post/post-articool',
    [
        'namespace'  => 'Api\v1',
        'controller' => 'post',
        'action'     => 'postArticool' 
    ]
);

// draft articool
$router->addPost(
    '/api/v1/post/draft-articool',
    [
        'namespace'  => 'Api\v1',
        'controller' => 'post',
        'action'     => 'draftArticool' 
    ]
);

// delete articool
$router->addDelete(
    '/api/v1/post/delete-articool/{post_id}',
    [
        'namespace'  => 'Api\v1',
        'controller' => 'post',
        'action'     => 'deleteArticool' 
    ]
);

// edit articool
$router->addPost(
    '/api/v1/post/edit-articool/{post_id}',
    [
        'namespace'     =>  'Api\v1',
        'controller'    =>  'post',
        'action'        =>  'editArticool'
    ]
);

// edit draft
$router->addPost(
    '/api/v1/post/edit-draft/{post_id}',
    [
        'namespace'     =>  'Api\v1',
        'controller'    =>  'post',
        'action'        =>  'editDraft'
    ]
);

// generate share key
$router->addPost(
    '/api/v1/post/generate-sharekey',
    [
        'namespace'  => 'Api\v1',
        'controller' => 'post',
        'action'     => 'genShareKey'
    ]
);

// remove avatar
$router->addPost(
    '/api/v1/post/remove-background',
    [
        'namespace'     =>  'Api\v1',
        'controller'    =>  'post',
        'action'        =>  'removeBackground'
    ]
);

/*
 *  SETTINGSCONTROLLER
 */

// profile settings
$router->addPost(
    '/api/v1/settings/profile-settings',
    [
        'namespace'     =>  'Api\v1',
        'controller'    =>  'settings',
        'action'        =>  'profileSettings'
    ]
);

// security settings
$router->addPost(
    '/api/v1/settings/security-settings',
    [
        'namespace'     =>  'Api\v1',
        'controller'    =>  'settings',
        'action'        =>  'securitySettings'
    ]
);

// remove avatar
$router->addPost(
    '/api/v1/settings/profile-settings/remove-avatar',
    [
        'namespace'     =>  'Api\v1',
        'controller'    =>  'settings',
        'action'        =>  'removeAvatar'
    ]
);

// extension settings
$router->addPost(
    '/api/v1/settings/extension-settings',
    [
        'namespace'     =>  'Api\v1',
        'controller'    =>  'settings',
        'action'        =>  'extensionSettings'
    ]
);

/*
 *  LOGINCONTROLLER
 */

// login
$router->addPost(
    '/api/v1/auth/login',
    [
        'namespace'     =>  'Api\v1',
        'controller'    =>  'login',
        'action'        =>  'login'
    ]
);

/*
 *  REGISTERCONTROLLER
 */

// register
$router->addPost(
    '/api/v1/auth/register',
    [
        'namespace'     =>  'Api\v1',
        'controller'    =>  'register',
        'action'        =>  'register'
    ]
);

// confirm email
$router->addGet(
    '/api/v1/auth/confirm-email/{token}',
    [
        'namespace'     =>  'Api\v1',
        'controller'    =>  'register',
        'action'        =>  'confirmEmail',
        'token'         => 1
    ]
);

// accept cookie
$router->addPost(
    '/api/v1/auth/cookie-accept',
    [
        'namespace'     =>  'Api\v1',
        'controller'    =>  'register',
        'action'        =>  'cookieAccept'
    ]
);

/*
 *  LOGOUTCONTROLLER
 */

// logout
$router->addPost(
    '/api/v1/auth/logout',
    [
        'namespace'     =>  'Api\v1',
        'controller'    =>  'logout',
        'action'        =>  'logout'
    ]
);


/*
 *  FORGOTCONTROLLER
 */

// forgot password
$router->addPost(
    '/api/v1/forgot/forgot-password',
    [
        'namespace'     =>  'Api\v1',
        'controller'    =>  'forgot',
        'action'        =>  'forgotPassword'
    ]
);

// set new password
$router->addPost(
    '/api/v1/forgot/set-new-password/{token}',
    [
        'namespace'     =>  'Api\v1',
        'controller'    =>  'forgot',
        'action'        =>  'setNewPassword',
        'token'         =>  1,
    ]
);



/* -------------------------------------------------- */

$router->add(
    '/faq',
    [
        'controller' => 'legal',
        'action'     => 'faq'
    ]
);

$router->add(
    '/terms',
    [
        'controller' => 'legal',
        'action'     => 'terms'
    ]
);

$router->add(
    '/privacy',
    [
        'controller' => 'legal',
        'action'     => 'privacy'
    ]
);

$router->add(
    '/explore',
    [
        'controller' => 'explore'
    ]
);

$router->add(
    '/login',
    [
        'controller' => 'login'
    ]
);

$router->add(
    '/register',
    [
        'controller' => 'register'
    ]
);

$router->add(
    '/forgot',
    [
        'controller' => 'forgot'
    ]
);

$router->add(
    '/forgot/{token}',
    [
        'controller' => 'forgot',
        'action'     => 'resetPassword',
        'token'      => 1
    ]
);

$router->add(
    '/profile/{username}',
    [
        'controller' => 'profile',
        'action'     => 'getProfile',
        'username'   => 1
    ]
);

$router->add(
    '/author/{username}',
    [
        'controller' => 'profile',
        'action'     => 'getProfile',
        'username'   => 1
    ]
);

$router->add(
    '/settings/profile',
    [
        'controller' => 'settings',
        'action'     => 'profile'
    ]
);

$router->add(
    '/settings/security',
    [
        'controller' => 'settings',
        'action'     => 'security'
    ]
);

$router->add(
    '/settings/extension',
    [
        'controller' => 'settings',
        'action'     => 'extension'
    ]
);

$router->add(
    '/{user}/:int/:params',
    [
        'controller' => 'post',
        'action'     => 'post',
        'user'       => 1,
        'post_id'    => 2
    ]
);

// figure out how to display the sharekey in the url

$router->add(
    '/{user}/:int/{key}/:params',
    [
        'controller' => 'post',
        'action'     => 'post',
        'user'       => 1,
        'post_id'    => 2,
        'share_key'   => 3
    ]
);

/* -------------------------------------------------- */

return $router;