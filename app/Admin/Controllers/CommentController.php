<?php

namespace App\Admin\Controllers;

use App\Models\Author;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CommentController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment);

        $grid->id('Id');
        $grid->body('Body');
        $grid->commentable_id('Commentable id');
        $grid->commentable_type('Commentable type');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Comment::findOrFail($id));

        $show->id('Id');
        $show->author_id('Author ID');
        $show->body('Body');
        $show->commentable_id('Commentable id');
        $show->commentable_type('Commentable type');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        $show->author('Author information', function ($author) {

            $author->setResource('/admin/authors');

            $author->id();
            $author->name();
            $author->lastname();
            $author->email();
        });

        $show->comments('Comments information', function ($comments) {
            $comments->setResource('/admin/comments');

            $comments->id();
            $comments->body();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Comment);


        $form->select('author_id', 'Author')->rules('required')->options(function ($id) {
            $author = Author::find($id);

            if ($author) {
                return [$author->id => $author->name];
            }
        })->ajax('/admin/api/authors');
        $form->textarea('body', 'Body');
        $form->number('commentable_id', 'Commentable ID')->rules('required');
        $form->text('commentable_type', 'Commentable type')->rules('required');

        return $form;
    }
}
