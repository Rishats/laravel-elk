<?php

namespace App\Admin\Controllers;

use App\Models\Author;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PostController extends Controller
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
        $grid = new Grid(new Post);

        $grid->author_id('Author')->display(function($authorId) {
            return Author::find($authorId)->name;
        });
        $grid->id('Id');
        $grid->title('Title');
        $grid->slug('Slug');
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
        $show = new Show(Post::findOrFail($id));

        $show->id('Id');
        $show->title('Title');
        $show->slug('Slug');
        $show->description('Description');
        $show->body('Body');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        $show->author('Author information', function ($author) {

            $author->setResource('/admin/authors');

            $author->id();
            $author->name();
            $author->lastname();
            $author->email();
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
        $form = new Form(new Post);

        $form->select('author_id', 'Author')->rules('required')->options(function ($id) {
            $author = Author::find($id);

            if ($author) {
                return [$author->id => $author->name];
            }
        })->ajax('/admin/api/authors');
        $form->text('title', 'Title')->rules('required');
        $form->text('slug', 'Slug')->rules('required');
        $form->editor('description', 'Description');
        $form->editor('body', 'Body');

        return $form;
    }
}
