<?php

namespace Modules\Idocs\Events\Handlers;

use Illuminate\Contracts\Mail\Mailer;
use Modules\Idocs\Events\DocumentWasCreated;
use Modules\Idocs\Events\Handlers\SendEmail;

class SendDocument
{

    private $mail;
    private $setting;

    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
    }

    public function handle(DocumentWasCreated $event)
    {

        if (config('asgard.idocs.config.fields.documents.key') || config('asgard.idocs.config.fields.documents.users')) {
            $document = $event->entity;
            $sender = $this->setting->get('core::site-name');
            $subject = $document->title . " " . trans('idocs::documents.messages.subject') . " " . $sender;
            $view = ['idocs::frontend.emails.form', 'idocs::frontend.emails.textform'];

            if (isset($document->emmail)) {
                $email = $document->emmail;
                $this->mail->to($email)->send(new Sendmail(['document' => $document], $subject, $view));
            }else if(config('asgard.idocs.config.fields.documents.users') && count($document->users)){
                foreach ($document->users as $user){
                    $email = $user->emmail;
                    $this->mail->to($email)->send(new Sendmail(['document' => $document], $subject, $view));
                }

            }
        }
    }
}