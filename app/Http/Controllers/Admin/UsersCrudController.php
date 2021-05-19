<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UsersRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UsersCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UsersCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Users::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/users');
        CRUD::setEntityNameStrings('users', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('login');
        CRUD::column('password');
        CRUD::column('name');
        CRUD::column('email');
        CRUD::column('profile_pictures');
        CRUD::column('faves');
        CRUD::column('rating');
        CRUD::column('role');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        // CRUD::setValidation(UsersRequest::class);

        // CRUD::field('login');
        // CRUD::field('password');
        // CRUD::field('name');
        // CRUD::field('email');
        // CRUD::field('profile_pictures');
        // CRUD::field('faves');
        // CRUD::field('rating');
        // CRUD::field('role');
        CRUD::setValidation(UsersRequest::class);

        CRUD::field('login');
        CRUD::field('password');
        CRUD::addField([
            'label' => 'Password confirm',
            'type' => 'password',
            'name' => 'password_confirm'
        ]);
        CRUD::field('name');
        CRUD::addField([
            'name' => 'email',
            'label' => 'Email Address',
            'type' => 'email'
        ]);
        CRUD::addField([
            'name' => 'role',
            'label' => 'Role',
            'type' => 'enum'
        ]);
        CRUD::addField([
            'name' => 'profile_picture',
            'label' => 'Avatar',
            'type' => 'image',
            'crop' => true,
            'aspect_ratio' => 1,
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::field('login');
        CRUD::field('name');
        CRUD::addField([
            'name' => 'email',
            'label' => 'Email Address',
            'type' => 'email'
        ]);
        CRUD::addField([
            'name' => 'role',
            'label' => 'Role',
            'type' => 'enum'
        ]);
        CRUD::addField([
            'name' => 'profile_picture',
            'label' => 'Avatar',
            'type' => 'image',
            'crop' => true,
            'aspect_ratio' => 1,
        ]);

    }
    public function store()
    {
        $credentials = request()->only([
            'login', 
            'password', 
            'password_confirm', 
            'email', 
            'role', 
            'name', 
            'profile_picture'
        ]);

        $validator = \Validator::make($credentials, [
            'login' => 'required|unique:App\Models\Users,login',
            'password' => 'min:6|max:14|required_with:password_confirm|same:password_confirm',
            'password_confirm' => 'min:6|max:14',
            'email' => 'required|unique:App\Models\Users,email',
            'name' => 'required|unique:App\Models\Users,name',
        ]);
        if ($validator->fails())
            abort(400, ($validator->errors())->first());
        
        $credentials['password'] = \Hash::make($credentials['password']);
        
        $image_data;
        if (isset($credentials['profile_picture'])) {
            $image_data = $credentials['profile_picture'];
            unset($credentials['profile_picture']);
        }

        $user = \App\Models\Users::create($credentials);

        if (isset($image_data)) {
            $avatar_data = explode(';', $image_data);
            $avatar_data[1] = explode(',', $avatar_data[1])[1];
            $image_data = 'avatars/' . $user->id . '.png';
            $file = fopen($image_data, "w");
            fwrite($file, base64_decode($avatar_data[1]));
            fclose($file);

            $user->profile_picture = $image_data;
            $user->save();
        }

        return redirect('/admin/users/' . $user->id . '/show');
    }

    public function update() {
        $validator = \Validator::make(request()->all(), [
            'login' => 'required',
            'email' => 'required',
        ]);
        if ($validator->fails())
            abort(400, ($validator->errors())->first());
        
        $image = request()->input('profile_picture');
        if (isset($image)) {
            $avatar_data = explode(';', $image);
            $avatar_data[1] = explode(',', $avatar_data[1])[1];
            request()['profile_picture'] = 'avatars/' . request()->input('id') . '.png';

            if (file_exists(request()['profile_picture']))
                file_put_contents(request()['profile_picture'], base64_decode($avatar_data[1]));
            else {
                $file = fopen(request()['profile_picture'], "w");
                fwrite($file, base64_decode($avatar_data[1]));
                fclose($file);
            }
        }
        else {
            if (file_exists('avatars/' . request()->input('id') . '.png'))
                unlink('avatars/' . request()->input('id') . '.png');
        }
        
        $response = $this->traitUpdate();
        return $response;
    }

    public function destroy($id) {
        $this->crud->hasAccessOrFail('delete');

        return $this->crud->delete($id);
    }
}
