<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TemplateType;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\Employee;
use App\Models\Holiday;

class HolidayMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'holiday:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // $templateType = TemplateType::where("slug","holiday")->first();
        $emailTemplate = EmailTemplate::where('template_type_id',"holiday")->first();
        $tommorow = date('Y-m-d',strtotime("+1 day"));
        echo $tommorow;
            $holidays = Holiday::where('from_date',$tommorow)->get();

            if(count($holidays)  >0 && !empty($emailTemplate)){
                $email_preHeader = '<div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">'.$emailTemplate->subject.'</div>';
                $email_body = $email_preHeader . $emailTemplate->comment;
                $email_body .= "<p>".$emailTemplate->sms_content."</p>";
                $email_body .= "<p>".$emailTemplate->content."</p>";
                foreach ($holidays as $key => $holiday) {
                    $email_body .= "<b>Tommorow is ".ucfirst($holiday->name);
                    if($holiday->from_date != $holiday->to_date)
                        $email_body .= "<p><b>So, Company gives you holiday On ".date('d M, Y',strtotime($holiday->from_date))." To ".date('d M, Y',strtotime($holiday->to_date))."</p>";
                    else
                        $email_body .= "<p><b>So, Company gives you holiday on ".date('d M, Y',strtotime($holiday->from_date))."</p>";

                        if($holiday->decsription != "")
                        $email_body .= "<p>".$holiday->description."</p>";
                }
                $email_body .="<b>Thank You....!!</b>";

                $users = User::where("status","Active")->get();
                $emails = [];
                foreach ($users as $key => $user) {
                   $emails[] = $user->email;
                }
                // if(auth()->user()->role == "Super Admin")
                //     $emails = auth()->user()->email;

                echo $email_body;

                echo "<pre>";
                print_r($emails);
                Mail::send(array(), array(), function ($message) use ($emails, $email_body, $emailTemplate) {
                    $message->to($emails)
                        ->subject($emailTemplate->subject)
                        ->setBody($email_body, 'text/html');
                });
            }
    }
}
