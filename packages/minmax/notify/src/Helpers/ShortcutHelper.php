<?php

if (! function_exists('sendNotifyEmail')) {
    /**
     * Send notify email.
     *
     * @param  string $key
     * @param  string|array $to
     * @param  array $attributes
     * @return void
     */
    function sendNotifyEmail($key, $to = '', $attributes = [])
    {
        if (is_array($to)) {
            $attributes = $to;
            $to = '';
        }

        $useProxy = config('mail.driver') == 'minmaxproxy';

        if ($notify = \Minmax\Notify\Models\NotifyEmail::where(['code' => $key, 'active' => true])->first()) {
            // Custom Send
            try {
                if ($notify->notifiable
                    && filter_var($to, FILTER_VALIDATE_EMAIL)
                    && $mailable = new $notify->custom_mailable($notify, ...$attributes)) {
                    $toEmail = array_wrap($to);

                    if ($useProxy) {
                        sendProxyMail($toEmail, $mailable);
                    } else {
                        if ($notify->queueable) {
                            \Mail::to($toEmail)->queue($mailable);
                        } else {
                            \Mail::to($toEmail)->send($mailable);
                        }
                    }
                }
            } catch (\Exception $e) {}

            // Admin Send
            try {
                if (count($notify->receivers ?? []) > 0
                    && $mailable = new $notify->admin_mailable($notify, ...$attributes)) {
                    $toEmail = [];

                    foreach ($notify->receivers as $receiver) {
                        $attr = explode('.', $receiver);
                        if (count($attr) == 3) {
                            $email = \DB::table($attr[0])->where('id', $attr[2])->value($attr[1]);
                            if (isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $toEmail[] = $email;
                            }
                        } elseif (count($attr) > 3) {
                            $email = \DB::table($attr[0])->where('id', $attr[2])->value($attr[1]);
                            for ($i = 3; $i < count($attr); $i++) {
                                if (isset($attr[$i]) && isset($email[$attr[$i]])) {
                                    $email = $email[$attr[$i]];
                                }
                            }
                            if (isset($email) && is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $toEmail[] = $email;
                            }
                        }
                    }

                    if (count($toEmail) > 0) {
                        if ($useProxy) {
                            sendProxyMail($toEmail, $mailable);
                        } else {
                            if ($notify->queueable) {
                                \Mail::bcc($toEmail)->queue($mailable);
                            } else {
                                \Mail::bcc($toEmail)->send($mailable);
                            }
                        }
                    }
                }
            } catch (\Exception $e) {}
        }
    }
}
