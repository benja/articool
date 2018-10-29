<?php
namespace Api\v1;
use Phalcon\Validation;

use Phalcon\Validation\Message;
use Phalcon\Http\Request;

use Phalcon\Validation\Validator\{PresenceOf, StringLength, Alnum, Url as UrlValidator};

use \ControllerBase;
use \Posts;
use \PostAuthor;
use \PostTrending;
use \Actions;

class PostController extends ControllerBase {


    public function postArticoolAction()
    {
        $auth = $this->checkAuth(1); // has to be registered user to do this

        if($auth) {

            //validate input
            $validation = new Validation();
            $validation->add([
                'post_title',
                'post_body',
                'post_language',
                'post_genre'
            ], new PresenceOf([
                'message' => [
                    'post_title'    =>  'Please enter a title',
                    'post_body'     =>  'Please enter some text',
                    'post_language' =>  'Please select the language',
                    'post_genre'    =>  'Please select the genre'
                ]
            ]));

            // make sure the link is a valid link (make sure it's not null)
            if($this->request->getPost('post_backgroundlink') !== "") {
                $validation->add([
                    'post_backgroundlink'
                ], new UrlValidator([
                    'message' => 'The link you have entered is not a valid link'
                ]));
            }

            if($this->request->getPost('canonical_url') !== "") {
                $validation->add([
                    'canonical_url'
                ], new UrlValidator([
                    'message' => 'The canonical link you entered is not a valid link'
                ]));
            }

            $messages = $validation->validate($_POST);

            $post_title          = strip_tags($this->request->getPost('post_title'));
            $post_body           = $this->request->getPost('post_body');
            $post_language       = $this->request->getPost('post_language');
            $post_genre          = $this->request->getPost('post_genre');
            $post_authors        = json_decode(($this->request->getPost('post_authors') ? $this->request->getPost('post_authors') : NULL ));
            $post_background     = $this->request->getPost('post_background');
            $post_backgroundlink = $this->request->getPost('post_backgroundlink');
            $canonical_url       = $this->request->getPost('canonical_url');

            /*
            *   Validating the avatar uploaded
            */
            $filemessages = []; // define before
            if($this->request->hasFiles() == true) {
                $filevalidation = new Validation();
                $file = new \Phalcon\Validation\Validator\File([
                    'maxSize'      => '2M',
                    'messageSize'  => 'Your avatar is too big. Max file size :max',
                    'allowedTypes' => [
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                    ],
                    'messageType'   => 'Allowed file types are JPEG, JPG, and PNG.',
                    //'maxResolution' => '1000x1000',
                    //'messageMaxResolution' => 'Max resolution of avatar is :max',
                ]);

                // then we add it to the validation list
                $filevalidation->add('post_background', $file);
                $filemessages = $filevalidation->validate($_FILES);
            }

            // put errors in array
            $messages = $validation->validate($_POST);
            $messages->appendMessages($filemessages); // append the filevalidation messages to main messages array

            // if email field is empty (meaning hasn't confirmed email yet)
            if(empty($auth->email_address)) {
                $messages->appendMessage( new Message('You have to confirm your email-address before you can post Articools') );
                return $this->ajaxResponse(false, $messages, 'ajax');
            }

            // if user has not written anything, ckeditor automatically prints this out if nothing is input
            if($post_body === "<p>&nbsp;</p>") {
                $messages->appendMessage( new Message('Did you forget to write something? o.O') );
            }

            // if user has not selected genre
            if($post_genre === "null") {
                $messages->appendMessage( new Message('Please select a genre') );
            }

            // if user has not selected genre
            if($post_language === "null") {
                $messages->appendMessage( new Message('Please select a language') );
            }

            if(count($messages) == 0) {
                // save post to posts table
                $post = new Posts();
                $post->user_id           = $auth->user_id;
                $post->post_title        = $post_title;
                $post->post_body         = $post_body;
                $post->post_language     = $post_language;
                $post->post_genre        = $post_genre;
                $post->is_draft          = 0;

                // if not empty, and not null string
                if($canonical_url == "") {
                    $post->canonical_url = NULL;
                } else {
                    $post->canonical_url = $canonical_url;
                }

                // check if files are uploaded
                if($this->request->hasFiles() == true) {
                    foreach($this->request->getUploadedFiles() as $file) {
                        if($file->getSize() > 0) {

                            // unique new filename for user
                            $newfilename = hash('sha1', $file->getName() . $auth->username) . '.jpg';

                            // Set user's avatar to filename in database
                            $post->post_background = $newfilename;
                            // Move the file to the application
                            $file->moveTo('img/backgrounds/' . $newfilename);

                            /* Changes to the image */
                            $image = new \Phalcon\Image\Adapter\Gd('img/backgrounds/' . $newfilename);
                            $image->save('img/backgrounds/' . $newfilename, 80);
                        }
                    }
                } else {
                    // taken from https://stackoverflow.com/questions/724391/saving-image-from-php-url
                    $content = file_get_contents($post_backgroundlink);
                    $newfilename = hash('sha1', $post_backgroundlink . $auth->username) . '.jpg';

                    if($content !== false) {
                        // from https://stackoverflow.com/questions/40694640/php-check-if-link-is-image-and-check-if-exists
                        $headers = get_headers($post_backgroundlink, 1);
                        if (strpos($headers['Content-Type'], 'image/') !== false) {
                            file_put_contents('img/backgrounds/' . $newfilename, $content);
                            $post->post_background = $newfilename;
                        }
                    }
                }
                $post->save();

                
                // save post contributions to postauthor table
                foreach($post_authors as $contributor) {
                    $postauthor = new PostAuthor();
                    $postauthor->post_id = $post->post_id;
                    $postauthor->user_id = $contributor;
                    $postauthor->save();
                }

                $messages->appendMessage( new Message('Articool published') );
                return $this->ajaxResponse(true, $messages, 'ajax', $post->toArray());
            }

            return $this->ajaxResponse(false, $messages, 'ajax');
        }
        return $this->ajaxResponse($auth, ['No authorization'], 'ajax');
    }

    public function draftArticoolAction()
    {
        $auth = $this->checkAuth(1); // has to be registered user to do this

        if($auth) {

            //validate input
            $validation = new Validation();
            $validation->add([
                'post_title',
                'post_body',
                'post_language',
                'post_genre'
            ], new PresenceOf([
                'message' => [
                    'post_title'    =>  'Please enter a title',
                    'post_body'     =>  'Please enter some text',
                    'post_language' =>  'Please select the language',
                    'post_genre'    =>  'Please select the genre'
                ]
            ]));

            // make sure the link is a valid link (make sure it's not null)
            if($this->request->getPost('post_backgroundlink') !== "") {
                $validation->add([
                    'post_backgroundlink'
                ], new UrlValidator([
                    'message' => 'The link you have entered is not a valid link'
                ]));
            }

            if($this->request->getPost('canonical_url') !== "") {
                $validation->add([
                    'canonical_url'
                ], new UrlValidator([
                    'message' => 'The canonical link you entered is not a valid link'
                ]));
            }

            $messages = $validation->validate($_POST);

            $post_title          = strip_tags($this->request->getPost('post_title'));
            $post_body           = $this->request->getPost('post_body');
            $post_language       = $this->request->getPost('post_language');
            $post_genre          = $this->request->getPost('post_genre');
            $post_authors        = json_decode(($this->request->getPost('post_authors') ? $this->request->getPost('post_authors') : NULL ));
            $post_background     = $this->request->getPost('post_background');
            $post_backgroundlink = $this->request->getPost('post_backgroundlink');
            $canonical_url       = $this->request->getPost('canonical_url');

            /*
            *   Validating the avatar uploaded
            */
            $filemessages = []; // define before
            if($this->request->hasFiles() == true) {
                $filevalidation = new Validation();
                $file = new \Phalcon\Validation\Validator\File([
                    'maxSize'      => '2M',
                    'messageSize'  => 'Your avatar is too big. Max file size :max',
                    'allowedTypes' => [
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                    ],
                    'messageType'   => 'Allowed file types are JPEG, JPG, and PNG.',
                    //'maxResolution' => '1000x1000',
                    //'messageMaxResolution' => 'Max resolution of avatar is :max',
                ]);

                // then we add it to the validation list
                $filevalidation->add('post_background', $file);
                $filemessages = $filevalidation->validate($_FILES);
            }

            // put errors in array
            $messages = $validation->validate($_POST);
            $messages->appendMessages($filemessages); // append the filevalidation messages to main messages array

            // if email field is empty (meaning hasn't confirmed email yet)
            if(empty($auth->email_address)) {
                $messages->appendMessage( new Message('You have to confirm your email-address before you can post Articools') );
                return $this->ajaxResponse(false, $messages, 'ajax');
            }

            // if user has not written anything, ckeditor automatically prints this out if nothing is input
            if($post_body === "<p>&nbsp;</p>") {
                $messages->appendMessage( new Message('Did you forget to write something? o.O') );
            }

            // if user has not selected genre
            if($post_genre === "null") {
                $messages->appendMessage( new Message('Please select a genre') );
            }

            // if user has not selected genre
            if($post_language === "null") {
                $messages->appendMessage( new Message('Please select a language') );
            }

            if(count($messages) == 0) {
                // save post to posts table
                $post = new Posts();
                $post->user_id           = $auth->user_id;
                $post->post_title        = $post_title;
                $post->post_body         = $post_body;
                $post->post_language     = $post_language;
                $post->post_genre        = $post_genre;
                $post->is_draft          = 1;

                // if not empty, and not null string
                if($canonical_url == "") {
                    $post->canonical_url = NULL;
                } else {
                    $post->canonical_url = $canonical_url;
                }

                // check if files are uploaded
                if($this->request->hasFiles() == true) {
                    foreach($this->request->getUploadedFiles() as $file) {
                        if($file->getSize() > 0) {

                            // unique new filename for user
                            $newfilename = hash('sha1', $file->getName() . $auth->username) . '.jpg';

                            // Set user's avatar to filename in database
                            $post->post_background = $newfilename;
                            // Move the file to the application
                            $file->moveTo('img/backgrounds/' . $newfilename);

                            /* Changes to the image */
                            $image = new \Phalcon\Image\Adapter\Gd('img/backgrounds/' . $newfilename);
                            $image->save('img/backgrounds/' . $newfilename, 80);
                        }
                    }
                } else {
                    // taken from https://stackoverflow.com/questions/724391/saving-image-from-php-url
                    $content = file_get_contents($post_backgroundlink);
                    $newfilename = hash('sha1', $post_backgroundlink . $auth->username) . '.jpg';

                    if($content !== false) {
                        // from https://stackoverflow.com/questions/40694640/php-check-if-link-is-image-and-check-if-exists
                        $headers = get_headers($post_backgroundlink, 1);
                        if (strpos($headers['Content-Type'], 'image/') !== false) {
                            file_put_contents('img/backgrounds/' . $newfilename, $content);
                            $post->post_background = $newfilename;
                        }
                    }
                }
                $post->save();

                
                // save post contributions to postauthor table
                foreach($post_authors as $contributor) {
                    $postauthor = new PostAuthor();
                    $postauthor->post_id = $post->post_id;
                    $postauthor->user_id = $contributor;
                    $postauthor->save();
                }

                $messages->appendMessage( new Message('Articool saved as draft') );
                return $this->ajaxResponse(true, $messages, 'ajax', $post->toArray());
            }

            return $this->ajaxResponse(false, $messages, 'ajax');
        }
        return $this->ajaxResponse($auth, ['No authorization'], 'ajax');
    }

    public function trendArticoolAction()
    {
        $auth = $this->checkAuth(3); // has to be moderator
        if($auth) {

            // validate input
            $validation = new Validation();
            $validation->add([
                'post_id'
            ], new PresenceOf([
                'message' => [
                    'post_id' => 'Nice try, but you can\'t tweak our system'
                ]
            ]));

            // validate errors, and put in array
            $messages = $validation->validate($_POST);

            // check if post is found in trending
            $trendingPost = PostTrending::findFirst([
                'conditions' => 'post_id = :post_id:',
                'bind' => [
                    'post_id' => $this->request->getPost('post_id'),
                ]
            ]);

            $post = Posts::findFirst([
                'conditions' => 'post_id = :post_id:',
                'bind' => [
                    'post_id' => $this->request->getPost('post_id')
                ]
            ]);

            if(!empty($trendingPost)) {
                $trendingPost->delete();
                $messages->appendMessage( new Message('Articool is no longer trending') );
                return $this->ajaxResponse(true, $messages, 'ajax');
            } else {
                // if post does not exist in database
                if(empty($post)) {
                    $messages->appendMessage( new Message('The given Articool was not found') );
                    return $this->ajaxResponse(false, $messages, 'ajax');
                }

                $newTrendingArticool = new PostTrending();
				$newTrendingArticool->post_id = $this->request->getPost('post_id');
                $newTrendingArticool->save();

                $messages->appendMessage( new Message('Articool is now trending') );
                return $this->ajaxResponse(true, $messages, 'ajax', $newTrendingArticool->toArray());
            }
        }
        return $this->ajaxResponse($auth, ['No authorization'], 'ajax');
    }

    public function editArticoolAction()
    {
        $auth = $this->checkAuth(1); // has to be registered to do this

        if($auth) {

            $validation = new Validation();

            // validate inputs
            $validation->add(['post_title', 'post_body'], new PresenceOf([
                'message'   =>  [
                    'post_title'    =>  'Please enter a title',
                    'post_body'     =>  'Please enter a text'
                ]
            ]));

            $validation->add(['post_title'], new StringLength([
                'max'   =>  [
                    'post_title'    =>  255
                ],
                'messageMaximum'    =>  [
                    'post_title'    =>  'That title is too long'
                ]
            ]));

            // make sure the link is a valid link (make sure it's not null)
            if($this->request->getPost('post_backgroundlink') !== "") {
                $validation->add([
                    'post_backgroundlink'
                ], new UrlValidator([
                    'message' => 'The link you have entered is not a valid link'
                ]));
            }

            if($this->request->getPost('canonical_url') !== "") {
                $validation->add([
                    'canonical_url'
                ], new UrlValidator([
                    'message' => 'The canonical link you entered is not a valid link'
                ]));
            }

            // save all messages to array
            $messages = $validation->validate($_POST);

            // get inputs from post
            $post_title          = strip_tags($this->request->getPost('post_title'));
            $post_body           = $this->request->getPost('post_body');
            $post_language       = $this->request->getPost('post_language');
            $post_genre          = $this->request->getPost('post_genre');
            $post_authors        = json_decode(($this->request->getPost('post_authors') ? $this->request->getPost('post_authors') : NULL ));
            $post_background     = $this->request->getPost('post_background');
            $post_backgroundlink = $this->request->getPost('post_backgroundlink');
            $canonical_url       = $this->request->getPost('canonical_url');

            /*
            *   Validating the avatar uploaded
            */
            $filemessages = []; // define before
            if($this->request->hasFiles() == true) {
                $filevalidation = new Validation();
                $file = new \Phalcon\Validation\Validator\File([
                    'maxSize'      => '2M',
                    'messageSize'  => 'Your avatar is too big. Max file size :max',
                    'allowedTypes' => [
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                    ],
                    'messageType'   => 'Allowed file types are JPEG, JPG, and PNG.',
                    //'maxResolution' => '1000x1000',
                    //'messageMaxResolution' => 'Max resolution of avatar is :max',
                ]);

                // then we add it to the validation list
                $filevalidation->add('post_background', $file);
                $filemessages = $filevalidation->validate($_FILES);
            }

            // put errors in array
            $messages = $validation->validate($_POST);
            $messages->appendMessages($filemessages); // append the filevalidation messages to main messages array

            $post = Posts::findFirst([
                'conditions' => 'post_id = :post_id:',
                'bind'  =>  [
                    'post_id' => $this->dispatcher->getParam('post_id')
                ]
            ]);

            // if not your articool, stop delete
            if( $auth->user_id !== $post->user_id && $auth->rank_id < 3) {
                $messages->appendMessage( new Message('You do not have sufficient permissions to edit this Articool') );
                return $this->ajaxResponse(false, $messages, 'ajax');
            }

            // if articool is not found
            if(empty($post)) {
                $messages->appendMessage( new Message('The given Articool was not found') );
                return $this->ajaxResponse(false, $messages, 'ajax');
            }

            // if articool is deactivated, don't let them edit it
            if($post->post_active == 0) {
                $messages->appendMessage( new Message('You cannot edit a deleted Articool') );
                return $this->ajaxResponse(false, $messages, 'ajax');
            }

            // if user has not written anything, ckeditor automatically prints this out if nothing is input
            if($post_body === "<p>&nbsp;</p>") {
                $messages->appendMessage( new Message('Did you forget to write something? o.O') );
            }

            // if user has not selected genre
            if($post_genre === "null") {
                $messages->appendMessage( new Message('Please select a genre') );
            }

            // if user has not selected genre
            if($post_language === "null") {
                $messages->appendMessage( new Message('Please select a language') );
            }

            if(count($messages) == 0) {
                // update post
                $post->post_title       = $post_title;
                $post->post_body        = $post_body;
                $post->post_language    = $post_language;
                $post->post_genre       = $post_genre;
                $post->updated_at       = date("Y-m-d H:i:s");

                // if not empty, and not null string
                if($canonical_url == "") {
                    $post->canonical_url = NULL;
                } else {
                    $post->canonical_url = $canonical_url;
                }

                // if post is draft, we assume they want to publish it and set draft to 0
                // we assume they clicked "publish" because it runs this code. the "save changes" runs another
                // function that doesn't set is_draft to 0
                if($post->is_draft == 1) {
                    $post->is_draft = 0;
                    $post->post_views = 0;
                    $post->created_at = date("Y-m-d H:i:s");
                    $post->updated_at = date("Y-m-d H:i:s");
                    $messages->appendMessage( new Message('Successfully published draft') );
                } else {
                    $messages->appendMessage( new Message('Successfully edited the Articool') );
                }
                
                // check if files are uploaded
                if($this->request->hasFiles() == true) {
                    foreach($this->request->getUploadedFiles() as $file) {
                        if($file->getSize() > 0) {

                            // unique new filename for user
                            $newfilename = hash('sha1', $file->getName() . $auth->username) . '.jpg';

                            // Set user's avatar to filename in database
                            $post->post_background = $newfilename;
                            // Move the file to the application
                            $file->moveTo('img/backgrounds/' . $newfilename);

                            /* Changes to the image */
                            $image = new \Phalcon\Image\Adapter\Gd('img/backgrounds/' . $newfilename);
                            $image->save('img/backgrounds/' . $newfilename, 80);
                        }
                    }
                } else {
                    // taken from https://stackoverflow.com/questions/724391/saving-image-from-php-url
                    $content = file_get_contents($post_backgroundlink);
                    $newfilename = hash('sha1', $post_backgroundlink . $auth->username) . '.jpg';

                    if($content !== false) {
                        // from https://stackoverflow.com/questions/40694640/php-check-if-link-is-image-and-check-if-exists
                        $headers = get_headers($post_backgroundlink, 1);
                        if (strpos($headers['Content-Type'], 'image/') !== false) {
                            file_put_contents('img/backgrounds/' . $newfilename, $content);
                            $post->post_background = $newfilename;
                        }
                    }
                }
                $post->update();

                // delete authors before we add all new ones
                $existingpostauthors = PostAuthor::find([
                    'conditions'    =>  'post_id = :post_id:',
                    'bind'          =>  [
                        'post_id'   =>  $this->dispatcher->getParam('post_id')
                    ]
                ]);

                foreach($existingpostauthors as $author) {
                    $author->delete();
                }

                // save new post authors in postauthors table
                foreach($post_authors as $contributor) {
                    $postauthor = new PostAuthor();
                    $postauthor->post_id = $post->post_id;
                    $postauthor->user_id = $contributor;
                    $postauthor->save();
                }
                return $this->ajaxResponse(true, $messages, 'ajax', $post->toArray());
            }
            return $this->ajaxResponse(false, $messages, 'ajax');

        }
        return $this->ajaxResponse($auth, ['No authorization'], 'ajax');
    }

    public function editDraftAction()
    {
        $auth = $this->checkAuth(1); // has to be registered to do this

        if($auth) {

            $validation = new Validation();

            // validate inputs
            $validation->add(['post_title', 'post_body'], new PresenceOf([
                'message'   =>  [
                    'post_title'    =>  'Please enter a title',
                    'post_body'     =>  'Please enter a text'
                ]
            ]));

            $validation->add(['post_title'], new StringLength([
                'max'   =>  [
                    'post_title'    =>  255
                ],
                'messageMaximum'    =>  [
                    'post_title'    =>  'That title is too long'
                ]
            ]));

            // make sure the link is a valid link (make sure it's not null)
            if($this->request->getPost('post_backgroundlink') !== "") {
                $validation->add([
                    'post_backgroundlink'
                ], new UrlValidator([
                    'message' => 'The link you have entered is not a valid link'
                ]));
            }

            if($this->request->getPost('canonical_url') !== "") {
                $validation->add([
                    'canonical_url'
                ], new UrlValidator([
                    'message' => 'The canonical link you entered is not a valid link'
                ]));
            }

            // save all messages to array
            $messages = $validation->validate($_POST);

            // get inputs from post
            $post_title             = strip_tags($this->request->getPost('post_title'));
            $post_body              = $this->request->getPost('post_body');
            $post_language          = $this->request->getPost('post_language');
            $post_genre             = $this->request->getPost('post_genre');
            $post_authors           = json_decode(($this->request->getPost('post_authors') ? $this->request->getPost('post_authors') : NULL ));
            $post_background        = $this->request->getPost('post_background');
            $post_backgroundlink    = $this->request->getPost('post_backgroundlink');
            $canonical_url          = $this->request->getPost('canonical_url');

            /*
            *   Validating the avatar uploaded
            */
            $filemessages = []; // define before
            if($this->request->hasFiles() == true) {
                $filevalidation = new Validation();
                $file = new \Phalcon\Validation\Validator\File([
                    'maxSize'      => '2M',
                    'messageSize'  => 'Your avatar is too big. Max file size :max',
                    'allowedTypes' => [
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                    ],
                    'messageType'   => 'Allowed file types are JPEG, JPG, and PNG.',
                    //'maxResolution' => '1000x1000',
                    //'messageMaxResolution' => 'Max resolution of avatar is :max',
                ]);

                // then we add it to the validation list
                $filevalidation->add('post_background', $file);
                $filemessages = $filevalidation->validate($_FILES);
            }

            // put errors in array
            $messages = $validation->validate($_POST);
            $messages->appendMessages($filemessages); // append the filevalidation messages to main messages array

            $post = Posts::findFirst([
                'conditions' => 'post_id = :post_id:',
                'bind'  =>  [
                    'post_id' => $this->dispatcher->getParam('post_id')
                ]
            ]);

            // if not your articool, stop delete
            if( $auth->user_id !== $post->user_id && $auth->rank_id < 3) {
                $messages->appendMessage( new Message('You do not have sufficient permissions to edit this Articool') );
                return $this->ajaxResponse(false, $messages, 'ajax');
            }

            // if articool is not found
            if(empty($post)) {
                $messages->appendMessage( new Message('The given Articool was not found') );
                return $this->ajaxResponse(false, $messages, 'ajax');
            }

            // if articool is deactivated, don't let them edit it
            if($post->post_active == 0) {
                $messages->appendMessage( new Message('You cannot edit a deleted Articool') );
                return $this->ajaxResponse(false, $messages, 'ajax');
            }

            // if user has not written anything, ckeditor automatically prints this out if nothing is input
            if($post_body === "<p>&nbsp;</p>") {
                $messages->appendMessage( new Message('Did you forget to write something? o.O') );
            }

            // if user has not selected genre
            if($post_genre === "null") {
                $messages->appendMessage( new Message('Please select a genre') );
            }

            // if user has not selected genre
            if($post_language === "null") {
                $messages->appendMessage( new Message('Please select a language') );
            }

            if(count($messages) == 0) {
                // update post
                $post->post_title       = $post_title;
                $post->post_body        = $post_body;
                $post->post_language    = $post_language;
                $post->post_genre       = $post_genre;
                $post->updated_at       = date("Y-m-d H:i:s");

                // if not empty, and not null string
                if($canonical_url == "") {
                    $post->canonical_url = NULL;
                } else {
                    $post->canonical_url = $canonical_url;
                }

                // check if files are uploaded
                if($this->request->hasFiles() == true) {
                    foreach($this->request->getUploadedFiles() as $file) {
                        if($file->getSize() > 0) {

                            // unique new filename for user
                            $newfilename = hash('sha1', $file->getName() . $auth->username) . '.jpg';

                            // Set user's avatar to filename in database
                            $post->post_background = $newfilename;
                            // Move the file to the application
                            $file->moveTo('img/backgrounds/' . $newfilename);

                            /* Changes to the image */
                            $image = new \Phalcon\Image\Adapter\Gd('img/backgrounds/' . $newfilename);
                            $image->save('img/backgrounds/' . $newfilename, 80);
                        }
                    }
                } else {
                    // taken from https://stackoverflow.com/questions/724391/saving-image-from-php-url
                    $content = file_get_contents($post_backgroundlink);
                    $newfilename = hash('sha1', $post_backgroundlink . $auth->username) . '.jpg';

                    if($content !== false) {
                        // from https://stackoverflow.com/questions/40694640/php-check-if-link-is-image-and-check-if-exists
                        $headers = get_headers($post_backgroundlink, 1);
                        if (strpos($headers['Content-Type'], 'image/') !== false) {
                            file_put_contents('img/backgrounds/' . $newfilename, $content);
                            $post->post_background = $newfilename;
                        }
                    }
                }
                $post->update();

                // delete authors before we add all new ones
                $existingpostauthors = PostAuthor::find([
                    'conditions'    =>  'post_id = :post_id:',
                    'bind'          =>  [
                        'post_id'   =>  $this->dispatcher->getParam('post_id')
                    ]
                ]);

                foreach($existingpostauthors as $author) {
                    $author->delete();
                }

                // save new post authors in postauthors table
                foreach($post_authors as $contributor) {
                    $postauthor = new PostAuthor();
                    $postauthor->post_id = $post->post_id;
                    $postauthor->user_id = $contributor;
                    $postauthor->save();
                }
                $messages->appendMessage( new Message('Successfully edited the Articool') );
                return $this->ajaxResponse(true, $messages, 'ajax', $post->toArray());
            }
            return $this->ajaxResponse(false, $messages, 'ajax');

        }
        return $this->ajaxResponse($auth, ['No authorization'], 'ajax');
    }

    public function deleteArticoolAction()
    {
        $auth = $this->checkAuth(1); // has to be registered user to do this

        if($auth) {

            // array of error messages
            $messages = [];

            // find post, id given in url
            $post = Posts::findFirst([
                'conditions'    =>  'post_id = :post_id:',
                'bind'  =>  [
                    'post_id'   =>  $this->dispatcher->getParam('post_id')
                ]
            ]);

            // if not your articool, stop delete
            if( $auth->user_id !== $post->user_id && $auth->rank_id < 3) {
                $messages[] = 'You do not have sufficient permissions to delete this Articool';
                return $this->ajaxResponse(false, $messages, 'ajax');
            }

            // if articool is not found
            if(empty($post)) {
                $messages[] = 'The given Articool was not found';
                return $this->ajaxResponse(false, $messages, 'ajax');
            }

            // if articool is deactivated, don't let them deactive again
            if($post->post_active == 0) {
                $messages[] = 'This Articool has already been deleted';
                return $this->ajaxResponse(false, $messages, 'ajax');
            }


            if(count($messages == 0)) {
                // find authors if any
                $authors = PostAuthor::find([
                    'conditions'    =>  'post_id = :post_id:',
                    'bind'  => [
                        'post_id' => $this->dispatcher->getParam('post_id')
                    ]
                ]);

                // find in trending, if trending
                $postTrending = PostTrending::findFirst([
                    'conditions'    =>  'post_id = :post_id:',
                    'bind'  => [
                        'post_id' => $this->dispatcher->getParam('post_id')
                    ]
                ]);

                // delete from trending before we delete post
                if($postTrending) {
                    $postTrending->delete();
                }

                /* MEANWHILE WE JUST DEACITIVATE IT
                // delete all authors before we delete post
                foreach($authors as $author) {
                    $author->delete();
                }
                // time to delete post
                $post->delete();
                */

                $post->post_active = 0;
                $post->save();

                $messages[] = 'Articool successfully deleted';
                return $this->ajaxResponse(true, $messages, 'ajax');
            }

        }
        return $this->ajaxResponse($auth, ['No authorization'], 'ajax');
    }

    public function appreciateArticoolAction()
    {
        $auth = $this->checkAuth(1); // has to be registered user
        if($auth) {

            // validate input
            $validation = new Validation();
            $validation->add([
                'post_id'
            ], new PresenceOf([
                'message' => [
                    'post_id' => 'Nice try, but you can\'t tweak our system'
                ]
            ]));

            // validate errors, and put in array
            $messages = $validation->validate($_POST);

            // check if post has been liked by user before
            $actions = Actions::findFirst([
                'conditions' => 'post_id = :post_id: and user_id = :user_id: and action = :action: and user_agent = :user_agent:',
                'bind' => [
                    'post_id' => $this->request->getPost('post_id'),
                    'user_id' => ($this->_user) ? $this->_user->user_id : 0,
                    'action' => 'like',
                    'user_agent' => $this->request->getClientAddress()
                ]
            ]);

            if(!$actions) {

                // create new row in table, because post is not liked
                $action = new Actions();
                $action->user_id = ($this->_user) ? $this->_user->user_id : 0;
                $action->post_id = $this->request->getPost('post_id');
                $action->action = 'like';
                $action->user_agent = $this->request->getClientAddress();
                $action->save();

                $messages->appendMessage( new Message('Appreciated articool') );
                return $this->ajaxResponse(true, $messages, 'ajax');

            } else {

                // if post does not exist in database
                if(empty($actions)) {
                    $messages->appendMessage( new Message('The given Articool was not found') );
                    return $this->ajaxResponse(false, $messages, 'ajax');
                }

                $actions->delete(); // delete the action we already found

                $messages->appendMessage( new Message('Unappreciated articool') );
                return $this->ajaxResponse(true, $messages, 'ajax');
            }
        }
        return $this->ajaxResponse($auth, ['Create an account to appreciate articools'], 'ajax');
    }

    public function genShareKeyAction()
    {
        $auth = $this->checkAuth(1); // has to be registered to do this 
        if($auth) {

            // validate input
            $validation = new Validation();
            $validation->add([
                'post_id'
            ], new PresenceOf([
                'message' => [
                    'post_id' => 'Nice try, but you can\'t tweak our system'
                ]
            ]));

            // validate errors, and put in array
            $messages = $validation->validate($_POST);

            // check if we can find the post (based on post_id)
            $post = Posts::findFirst([
                'conditions' => 'post_id = :post_id:',
                'bind' => [
                    'post_id' => $this->request->getPost('post_id')
                ]
            ]);

            if(empty($post)) {
                $messages->appendMessage( new Message('Post was not found') );
                return $this->ajaxResponse(true, $messages, 'ajax');
            } else {
                // we dont do an if-stmt to check if it exists, because we always want to generate a new code
                // whether or not the user has already generated a code

                // generate a random key (https://stackoverflow.com/a/28171796)
                $sharekey = base_convert(rand(1000000000,PHP_INT_MAX), 10, 36);

                // input it in database
                $post->post_sharekey = $sharekey;
                $post->update();
                $messages->appendMessage( new Message('Generated new share url') );
                return $this->ajaxResponse(true, $messages, 'ajax', $post->toArray());
            }
        }
        return $this->ajaxResponse($auth, ['No authorization'], 'ajax');
    }

}