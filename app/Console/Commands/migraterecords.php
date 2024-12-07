<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Agents;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class migraterecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A command to migrate database records automatically.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = DB::table('agents')->get()->toArray();

        $i = 10;
        foreach ($data as $record) {
            $user = new User();
            $user->name = $record->firstname . $record->lastname;
            $user->email = $record->email;
            $user->password = Hash::make('root');
            $user->role = "Supplier";
            $user->status = "Inactive";
            $user->created_at = $record->created_at;
            $user->updated_at = $record->updated_at;

            if ($record->mobile != null) {
                $user->mobile_no = $record->mobile;
            } else {
                $user->mobile_no =  '999999'.$i;
            }

            $user->save();
            $i++;
        }
    }
}
