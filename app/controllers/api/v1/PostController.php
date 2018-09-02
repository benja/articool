<?php
namespace Api\v1;
use Phalcon\Validation;

use Phalcon\Validation\Message;

use Phalcon\Validation\Validator\{PresenceOf, StringLength, Alnum};

use \ControllerBase;
use \Posts;
use \PostAuthor;
use \PostTrending;

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

            // validation - check lengths
            $validation->add(['post_title'], new StringLength([
                'max'   =>  [
                    'post_title'    =>  255
                ],
                'messageMaximum' => [
                    'post_title'    =>  'That title is too long'
                ]
            ]));
            
            // make sure title doesnt contain html characters
            $validation->add(['post_title'], new Alnum([
                'message' => 'The title can only contain alphanumeric characters'
            ]));

            $messages = $validation->validate($_POST);

            $post_title     = $this->request->getPost('post_title');
            $post_body      = $this->request->getPost('post_body');
            $post_language  = $this->request->getPost('post_language');
            $post_genre     = $this->request->getPost('post_genre');
            $post_authors   = ($this->request->getPost('post_authors') ? $this->request->getPost('post_authors') : NULL );

            // if email field is empty (meaning hasn't confirmed email yet)
            if(empty($auth->email_address)) {
                $messages->appendMessage( new Message('You have to confirm your email-address before you can post Articools') );
                return $this->ajaxResponse(false, $messages, 'ajax');
            }

            if(count($messages) == 0) {
                // save post to posts table
                $post = new Posts();
                $post->user_id           = $auth->user_id;
                $post->post_title        = $post_title;
                $post->post_body         = $post_body;
                $post->post_language     = $post_language;
                $post->post_genre        = $post_genre;
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

            // make sure title doesnt contain html characters
            $validation->add(['post_title'], new Alnum([
                'message' => 'The title can only contain alphanumeric characters'
            ]));

            // save all messages to array
            $messages = $validation->validate($_POST);

            // get inputs from post
            $post_title = $this->request->getPost('post_title');
            $post_body = $this->request->getPost('post_body');
            $post_language = $this->request->getPost('post_language');
            $post_genre = $this->request->getPost('post_genre');
            $post_authors = ($this->request->getPost('post_authors') ? $this->request->getPost('post_authors') : NULL );

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

            if(count($messages) == 0) {
                // update post
                $post->post_title = $post_title;
                $post->post_body = $post_body;
                $post->post_language = $post_language;
                $post->post_genre = $post_genre;
				$post->updated_at = date("Y-m-d H:i:s");
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

}