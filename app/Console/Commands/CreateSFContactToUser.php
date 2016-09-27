<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Activation;
use App\User;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Sentinel;
use URL;
use App\SF_settings;


use App\Contact;

class CreateSFContactToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sf-contact:copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy Salesforce Contacts to Users with password generated';

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
     * @return mixed
     */
    public function handle()
    {
        //$lastuser=User::All()->last();
        $lastuser=User::orderBy('created_at','DESC')->first();
        $this->info($lastuser->created_at->format('Y-m-d H:i:s'));
        //print_r($lastuser->created_at);exit;
        $contacts=Contact::where('createddate','>',$lastuser->created_at->format('Y-m-d H:i:s'))->where('attigo__express_portal_access__c','Y')->get();

       // print_r($contacts);
        foreach($contacts as $contact){
            $this->info($contact->email);
            if($contact->email){
            //check whether use should be activated by default or not
        $activate = true;//$request->get('activate') ? true : false;
            $usrarr['email']=$contact->email;
            $usrarr['password']=$this->randomPassword();
             $usrarr['first_name']=$contact->firstname;
             $usrarr['last_name']=$contact->lastname;
            // Register the user
            $user = Sentinel::register($usrarr, $activate);

            //add user to 'User' group
            $role = Sentinel::findRoleById(2);
            if ($role) {
                $role->users()->attach($user);
            }
            //check for activation and send activation mail if not activated by default
            if (!$activate) {
                // Data to be used on the email view

                $settings=SF_settings::where('name','eXpress main settings')->first();

                $msg=$settings->content_for_password_reset_mail__c;
            $msg=str_replace("\n","<br>",$msg);
            $msg=str_replace('%user',$user->first_name.' '.$user->last_name,$msg);
            $msg=str_replace('%username',$user->email,$msg);
            $msg=str_replace('%psswd',$usrarr['password'],$msg);

            $msg=str_replace('%link',URL::route('activate', [$user->id, Activation::create($user)->code]),$msg);
            $msg=str_replace('%Store_name',$settings->attigo__store_name__c,$msg);
            $msg=str_replace('%store_name',$settings->attigo__store_name__c,$msg);

            $sender=array('address' => $settings->attigo__transactional_email_sender__c, 'name' => $settings->attigo__attigo__store_name__c);


                $data = array(
                    'user' => $user,
                    'activationUrl' => URL::route('activate', [$user->id, Activation::create($user)->code]),
                    'password'=>$usrarr['password'],
                    'content'=>$msg
                );

                // Send the activation code through email
                Mail::send('emails.register-activate', $data, function ($m) use ($user) {
                     $m->from($sender['address'],$sender['name']);
                    $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                    $m->subject('Welcome ' . $user->first_name);
                });
            }
               // echo "<br/>".$contact->email." Done";
               // 
            $this->info($contact->email.' Added.');
        }
           
      
        }
        $this->info('Finish !!');
    }

    private function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
}
