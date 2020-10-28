<?php
use Phalcon\Escaper;
use Phalcon\Http\Request;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\File;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;



class PostController extends ControllerBase
{
    public function indexAction()
    {

    }

    public function detailAction($id)
    {
        $post = Posts::find($id);
        $this->view->post= $post[0];
    }

    public function addAction()
    {
        $form = new Form();
        $title = new Text('title');
        $title->addValidator(
            new PresenceOf(['message' => 'The Title is required',])
        );
        $form->add($title);


        $form->add(
            new TextArea(
                'description'
            )
        );
        $form->add(
            new File(
                'image'
            )
        );
        $this->view->form = $form;
    }

    public function createAction()
    {
        $post = new Posts();
        $arr = $this->request->getPost();

        if($this->request->hasFiles())
        {

            $baseLocation = BASE_PATH.'/public/images/post/';
            $file = $this->request->getUploadedFiles();
            $file[0]->moveTo($baseLocation.$file[0]->getName());
            $arr['image'] = $file[0]->getName();
        }

        $post->save($arr,['title', 'description','image']);
//        $this->flashSession->success("Add Post Success!!")
        return $this->response->redirect('index/index');
    }

    public function editAction($id)
    {
        $post = Posts::find($id);
        $formEdit = new Form();
        $formEdit->add(
            new Text(
                'title',
                [
                    'maxlength'   => 30,
                    'value' => $post[0]->title,
                ]
            )
        );
        $formEdit->add(
            new TextArea(
                'description',
                [
                    'value' => $post[0] ->description
                ]
            )
        );
        $this->view->form = $formEdit;
    }

    public function updateAction()
    {

    }

    public function deleteAction($id)
    {

        $post = Posts::find($id);
        $post->delete();
        return $this->response->redirect('index/index');

    }

}