<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // ask user for their credentials and store in user array
        $user['name'] = $this->ask('enter username');
        $user['email'] = $this->ask('enter email');
        $user['password'] = $this->secret('enter password');


        // ask user their role and check if it is a valid role
        $roleName = $this->choice('select user role', ['admin', 'editor'], default: 1);

        $role = Role::where('name', $roleName)->first();
        if(!$role) {
            $this->error('role not found');

            return -1;
        }

        // data validation
        $validator = Validator::make($user, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required']
        ]);

        if($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return -1;
        }

        // create a new user 
        DB::transaction(function() use ($user, $role) {
            $user['password'] = Hash::make($user['password']);
            $newUser = User::create($user);
            $newUser->roles()->attach($role->id);
        });

        $this->info('user '.$user['email']. ' created successfully');

        return 0;
    }
}
