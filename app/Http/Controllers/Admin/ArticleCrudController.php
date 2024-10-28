<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Backpack\CRUD\app\Http\Controllers\CrudController;


class ArticleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel(Article::class);
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin') . '/article');
        $this->crud->setEntityNameStrings('article', 'articles');

        /*
        |--------------------------------------------------------------------------
        | LIST OPERATION
        |--------------------------------------------------------------------------
        */
        $this->crud->operation('list', function () {
            $this->crud->addColumn('title');
            $this->crud->addColumn([
                'name' => 'date',
                'label' => 'Date',
                'type' => 'date',
            ]);
            $this->crud->addColumn('status');
            $this->crud->addColumn([
                'name' => 'featured',
                'label' => 'Featured',
                'type' => 'check',
            ]);
            $this->crud->addColumn([
                'label' => 'Category',
                'type' => 'select',
                'name' => 'category_id',
                'entity' => 'category',
                'attribute' => 'name',
                'wrapper' => [
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('category/' . $related_key . '/show');
                    },
                ],
            ]);
            $this->crud->addColumn('tags');

            // $this->crud->addFilter([ // select2 filter
            //     'name' => 'category_id',
            //     'type' => 'select',
            //     'label' => 'Category',
            // ], function () {
            //     return \app\Models\Category::all()->keyBy('id')->pluck('name', 'id')->toArray();
            // }, function ($value) { // if the filter is active
            //     $this->crud->addClause('where', 'category_id', $value);
            // });
            // Category Filter
            $this->crud->addClause('where', function ($query) {
                if (request()->has('category_id') && request()->get('category_id') != '') {
                    $query->where('category_id', request()->get('category_id'));
                }
            });

            // $this->crud->addFilter([ // select2_multiple filter
            //     'name' => 'tags',
            //     'type' => 'select_multiple',
            //     'label' => 'Tags',
            // ], function () {
            //     return \app\Models\Tag::all()->keyBy('id')->pluck('name', 'id')->toArray();
            // }, function ($values) { // if the filter is active
            //     $this->crud->query = $this->crud->query->whereHas('tags', function ($q) use ($values) {
            //         foreach (json_decode($values) as $key => $value) {
            //             if ($key == 0) {
            //                 $q->where('tags.id', $value);
            //             } else {
            //                 $q->orWhere('tags.id', $value);
            //             }
            //         }
            //     });
            // });
            $this->crud->addField([
                'name' => 'category_id',
                'type' => 'select',
                'label' => 'Category',
                'entity' => 'category', // Relation name
                'model' => \App\Models\Category::class, // Related model
                'attribute' => 'name', // Attribute to show in select
                'options' => (function ($query) {
                    return $query->pluck('name', 'id');
                }),
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | CREATE & UPDATE OPERATIONS
        |--------------------------------------------------------------------------
        */
        $this->crud->operation(['create', 'update'], function () {
            $this->crud->setValidation(ArticleRequest::class);

            $this->crud->addField([
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'placeholder' => 'Your title here',
            ]);
            $this->crud->addField([
                'name' => 'slug',
                'label' => 'Slug (URL)',
                'type' => 'text',
                'hint' => 'Will be automatically generated from your title, if left empty.',
                // 'disabled' => 'disabled'
            ]);
            $this->crud->addField([
                'name' => 'date',
                'label' => 'Date',
                'type' => 'date',
                'default' => date('Y-m-d'),
            ]);
            $this->crud->addField([
                'name' => 'content',
                'label' => 'Content',
                'type' => 'summernote',
                'placeholder' => 'Your textarea text here',
            ]);
            $this->crud->addField([
                'name' => 'image',
                'label' => 'Image',
                'type' => 'upload',
            ]);
            $this->crud->addField([
                'name' => 'category_id',        // database column
                'label' => 'Category',          // field label
                'type' => 'select',            // Backpack field type
                'entity' => 'category',         // relationship method in the model
                'attribute' => 'name',          // attribute shown to the user (Category name)
                'model' => \App\Models\Category::class, // related model
            ]);
            $this->crud->addField([
                'name' => 'tags',               // method that defines the relationship in your model
                'label' => 'Tags',              // label shown in the form
                'type' => 'checklist',          // field type
                'entity' => 'tags',             // relationship method in the model
                'attribute' => 'name',          // foreign key attribute shown to the user
                'model' => \App\Models\Tag::class,  // related model
                'pivot' => true,                // specify if it's a many-to-many relationship (for pivot tables)
            ]);
            $this->crud->addField([
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select_from_array',
                'options' => [
                    'PUBLISHED' => 'PUBLISHED',
                    'DRAFT' => 'DRAFT',
                ],
            ]);
            $this->crud->addField([
                'name' => 'featured',
                'label' => 'Featured item',
                'type' => 'checkbox',
            ]);
        });
    }

    // /**
    //  * Respond to AJAX calls from the select2 with entries from the Category model.
    //  *
    //  * @return JSON
    //  */
    // public function fetchCategory()
    // {
    //     return $this->fetch(\app\Models\Category::class);
    // }

    // /**
    //  * Respond to AJAX calls from the select2 with entries from the Tag model.
    //  *
    //  * @return JSON
    //  */
    // public function fetchTags()
    // {
    //     return $this->fetch(\app\Models\Tag::class);
    // }
}
