<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Sendemail_library
 * @property Offers_model $offers_model
 * @property Users_Model $users_model
 */
class Sendemail_library
{
    private $CI;

    function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('offers_model');
        $this->CI->load->model('users_model');
        $this->CI->load->model('locations_model');
    }

    //Not in use function
    public function signUpWelcomeSendMail($userData)
    {
        $data['mailData'] = $userData;
        $data['breakfastCode'] = $this->generateBreakfastCode($userData['mugId']);

        $content = $this->CI->load->view('emailtemplates/signUpWelcomeMailView', $data, true);

        $fromEmail = 'priyanka@doolally.in';

        if(isset($this->CI->userEmail))
        {
            $fromEmail = $this->CI->userEmail;
        }
        $cc        = 'priyanka@doolally.in,tresha@doolally.in,daksha@doolally.in,shweta@doolally.in,richa@doolally.in';
        $fromName  = 'Doolally';
        if(isset($this->CI->userFirstName))
        {
            $fromName = ucfirst($this->CI->userFirstName);
        }
        $subject = 'Breakfast for Mug #'.$userData['mugId'];
        $toEmail = $userData['emailId'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function memberWelcomeMail($userData, $eventPlace)
    {
        $locData = $this->CI->locations_model->getLocationDetailsById($eventPlace);
        $mailRecord = $this->CI->users_model->searchUserByLoc($eventPlace);

        $data['locInfo'] = $locData['locData'][0];
        $data['commName'] = 'Doolally';
        if(isset($mailRecord['userData']['firstName']))
        {
            $data['commName'] = $mailRecord['userData']['firstName'];
        }
        if($userData['eventCost'] == EVENT_PAID || $userData['eventCost'] == EVENT_DOOLALLY_FEE)
        {
            for($i=0;$i<(int)$userData['buyQuantity'];$i++)
            {
                if((int)$userData['doolallyFee'] > 250)
                {
                    $userData['eveOfferCode'][] = $this->generateCustomCode($userData['eventId'],$userData['doolallyFee']);
                }
                else
                {
                    $userData['eveOfferCode'][] = $this->generateEventCode($userData['eventId']);
                }
            }
        }
        $data['mailData'] = $userData;
        $startDate = str_replace(' ','T',date('Ymd His',strtotime($userData['eventDate'].' '.$userData['startTime'])));
        $endDate = str_replace(' ','T',date('Ymd His',strtotime($userData['eventDate'].' '.$userData['endTime'])));
        $data['calendar_url'] =
            'https://www.google.com/calendar/event?action=TEMPLATE'.
            '&text='.urlencode($userData["eventName"]).
            '&dates='.$startDate.'/'.$endDate.
            '&location='.urlencode('Doolally Taproom, '.$locData['locData'][0]['locName']).
            '&details='. urlencode($userData["eventDescrip"]).
            '&sprop=&sprop=name:';

        $content = $this->CI->load->view('emailtemplates/memberWelcomeMailView', $data, true);

        $fromEmail = $mailRecord['userData']['emailId'];

        $cc        = 'tresha@doolally.in,'.$fromEmail;
        $fromName  = 'Doolally';
        if(isset($mailRecord['userData']['firstName']))
        {
            $fromName = $mailRecord['userData']['firstName'];
        }

        $subject = 'You are attending '.$userData['eventName'];
        $toEmail = $userData['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function eventRegSuccessMail($userData, $eventPlace)
    {
        $locData = $this->CI->locations_model->getLocationDetailsById($eventPlace);
        $mailRecord = $this->CI->users_model->searchUserByLoc($eventPlace);

        $data['locInfo'] = $locData['locData'][0];

        $data['commName'] = 'Doolally';
        if(isset($mailRecord['userData']['firstName']))
        {
            $data['commName'] = $mailRecord['userData']['firstName'];
        }
        if($userData['eventCost'] == EVENT_PAID || $userData['eventCost'] == EVENT_DOOLALLY_FEE)
        {
            for($i=0;$i<(int)$userData['buyQuantity'];$i++)
            {
                if((int)$userData['doolallyFee'] > 250)
                {
                    $userData['eveOfferCode'][] = $this->generateCustomCode($userData['eventId'],$userData['doolallyFee']);
                }
                else
                {
                    $userData['eveOfferCode'][] = $this->generateEventCode($userData['eventId']);
                }
            }
        }
        $data['mailData'] = $userData;
        $startDate = str_replace(' ','T',date('Ymd His',strtotime($userData['eventDate'].' '.$userData['startTime'])));
        $endDate = str_replace(' ','T',date('Ymd His',strtotime($userData['eventDate'].' '.$userData['endTime'])));
        $data['calendar_url'] =
            'https://www.google.com/calendar/event?action=TEMPLATE'.
            '&text='.urlencode($userData["eventName"]).
            '&dates='.$startDate.'/'.$endDate.
            '&location='.urlencode('Doolally Taproom, '.$locData['locData'][0]['locName']).
            '&details='. urlencode($userData["eventDescrip"]).
            '&sprop=&sprop=name:';

        $content = $this->CI->load->view('emailtemplates/eventRegSuccessMailView', $data, true);

        $fromEmail = $mailRecord['userData']['emailId'];

        $cc        = 'tresha@doolally.in,'.$fromEmail;
        $fromName  = 'Doolally';
        if(isset($mailRecord['userData']['firstName']))
        {
            $fromName = $mailRecord['userData']['firstName'];
        }

        $subject = 'You are attending '.$userData['eventName'];
        $toEmail = $userData['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }
    public function eventHostSuccessMail($userData, $eventPlace)
    {
        $phons = $this->CI->config->item('phons');
        $mailRecord = $this->CI->users_model->searchUserByLoc($eventPlace);

        $data['commName'] = 'Doolally';
        $data['commNum'] = $phons['Tresha'];
        if(isset($mailRecord['userData']['firstName']))
        {
            $data['commName'] = $mailRecord['userData']['firstName'];
            $data['commNum'] = $phons[$mailRecord['userData']['firstName']];
        }
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventHostInfoMailView', $data, true);

        $fromEmail = $mailRecord['userData']['emailId'];

        $cc        = 'tresha@doolally.in,'.$fromEmail;
        $fromName  = 'Doolally';
        if(isset($mailRecord['userData']['firstName']))
        {
            $fromName = $mailRecord['userData']['firstName'];
        }

        $subject = 'You have a sign up for '.$userData['eventName'];
        $toEmail = $userData['hostEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }
    public function eventVerifyMail($userData)
    {
        $mailRecord = $this->CI->users_model->searchUserByLoc($userData[0]['eventPlace']);
        $senderUser = 'U-0';

        if($mailRecord['status'] === true)
        {
            $senderUser = 'U-'.$mailRecord['userData']['userId'];
        }
        $userData['senderUser'] = $senderUser;

        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventVerifyMailView', $data, true);

        $fromEmail = 'events@doolally.in';

        $cc        = 'tresha@doolally.in';
        $fromName  = 'Doolally';

        $subject = 'Event Details';
        $toEmail = 'events@doolally.in';

        if($mailRecord['status'] === true)
        {
            $toEmail = $mailRecord['userData']['emailId'];
        }

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function eventEditMail($userData,$commPlace)
    {
        $mailRecord = $this->CI->users_model->searchUserByLoc($commPlace);
        $senderUser = 'U-0';

        if($mailRecord['status'] === true)
        {
            $senderUser = 'U-'.$mailRecord['userData']['userId'];
        }
        $userData['senderUser'] = $senderUser;

        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventEditMailView', $data, true);

        $fromEmail = 'events@doolally.in';

        $cc        = 'tresha@doolally.in';
        $fromName  = 'Doolally';

        $subject = 'Event Data Modified';
        $toEmail = 'events@doolally.in';

        if($mailRecord['status'] === true)
        {
            $toEmail = $mailRecord['userData']['emailId'];
        }

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function eventCancelMail($userData)
    {
        $mailRecord = $this->CI->users_model->searchUserByLoc($userData[0]['eventPlace']);

        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventCancelMailView', $data, true);

        $fromEmail = 'info@doolally.in';
        /*if(isset($userData[0]['creatorEmail']))
        {
            $fromEmail = $userData[0]['creatorEmail'];
        }*/
        $cc        = 'tresha@doolally.in';
        $fromName  = 'Doolally';

        $subject = 'Event Cancel';
        $toEmail = 'events@doolally.in';

        if($mailRecord['status'] === true)
        {
            $toEmail = $mailRecord['userData']['emailId'];
        }

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function eventCancelUserMail($userData)
    {
        $phons = $this->CI->config->item('phons');
        $mailRecord = $this->CI->users_model->searchUserByLoc($userData[0]['eventPlace']);
        if($mailRecord['status'] === true)
        {
            $senderName = $mailRecord['userData']['firstName'];
        }
        else
        {
            $senderName = 'Doolally';
        }
        $userData['senderName'] = $senderName;
        $userData['senderPhone'] = $phons[ucfirst($senderName)];

        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventCancelUserMailView', $data, true);

        $fromEmail = 'events@doolally.in';
        if(isset($mailRecord['userData']['emailId']) && isStringSet($mailRecord['userData']['emailId']))
        {
            $fromEmail = $mailRecord['userData']['emailId'];
        }
        $cc        = 'tresha@doolally.in';
        $fromName  = 'Doolally';
        if(isset($senderName) && isStringSet($senderName))
        {
            $fromName = ucfirst($senderName);
        }

        $subject = 'Event Cancel';
        $toEmail = $userData[0]['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    //Not in Use
    public function eventApproveMail($userData)
    {
        $phons = $this->CI->config->item('phons');
        $userData['senderPhone'] = $phons[ucfirst($userData['senderName'])];
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventApproveMailView', $data, true);

        $fromEmail = 'events@doolally.in';
        if(isset($userData['senderEmail']) && isStringSet($userData['senderEmail']))
        {
            $fromEmail = $userData['senderEmail'];
        }
        $cc        = 'events@doolally.in';
        $fromName  = 'Doolally';
        if(isset($userData['senderName']) && isStringSet($userData['senderName']))
        {
            $fromName = ucfirst($userData['senderName']);
        }

        $subject = 'Event Approved';
        $toEmail = $userData[0]['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }
    //Not in Use
    public function eventDeclineMail($userData)
    {
        $phons = $this->CI->config->item('phons');
        $userData['senderPhone'] = $phons[$userData['senderName']];
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventDeclineMailView', $data, true);

        $fromEmail = 'events@doolally.in';
        if(isset($userData['senderEmail']) && isStringSet($userData['senderEmail']))
        {
            $fromEmail = $userData['senderEmail'];
        }

        $cc        = 'events@doolally.in';
        $fromName  = 'Doolally';
        if(isset($userData['senderName']) && isStringSet($userData['senderName']))
        {
            $fromName = $userData['senderName'];
        }

        $subject = 'Sorry, your event has not been approved';
        $toEmail = $userData[0]['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function newEventMail($userData)
    {
        $phons = $this->CI->config->item('phons');
        $mailRecord = $this->CI->users_model->searchUserByLoc($userData['eventPlace']);
        $senderName = 'Doolally';
        $senderEmail = 'events@doolally.in';
        $senderPhone = $phons['Tresha'];

        if($mailRecord['status'] === true)
        {
            $senderName = $mailRecord['userData']['firstName'];
            $senderEmail = $mailRecord['userData']['emailId'];
            $senderPhone = $phons[$senderName];
        }
        $userData['senderName'] = $senderName;
        $userData['senderEmail'] = $senderEmail;
        $userData['senderPhone'] = $senderPhone;
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/newEventMailView', $data, true);

        $fromEmail = $senderEmail;

        $cc        = 'events@doolally.in';
        $fromName  = $senderName;

        $subject = 'Event Details';
        $toEmail = $userData['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    //Not in Use
    public function membershipRenewSendMail($userData)
    {
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/membershipRenewMailView', $data, true);

        $fromEmail = 'priyanka@doolally.in';

        if(isset($this->CI->userEmail))
        {
            $fromEmail = $this->CI->userEmail;
        }
        $cc        = 'priyanka@doolally.in,tresha@doolally.in,daksha@doolally.in,shweta@doolally.in,richa@doolally.in';
        $fromName  = 'Doolally';
        if(isset($this->CI->userFirstName))
        {
            $fromName = ucfirst($this->CI->userFirstName);
        }
        $subject = 'Renewal of Mug #'.$userData['mugId'];
        $toEmail = $userData['emailId'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function generateBreakfastCode($mugId)
    {
        $allCodes = $this->CI->offers_model->getAllCodes();
        $usedCodes = array();
        $toBeInserted = array();
        if($allCodes['status'] === true)
        {
            foreach($allCodes['codes'] as $key => $row)
            {
                $usedCodes[] = $row['offerCode'];
            }
            $newCode = mt_rand(1000,99999);
            while(myInArray($newCode,$usedCodes))
            {
                $newCode = mt_rand(1000,99999);
            }
            $toBeInserted = array(
                'offerCode' => $newCode,
                'offerType' => 'Breakfast',
                'offerLoc' => null,
                'offerMug' => $mugId,
                'isRedeemed' => 0,
                'ifActive' => 1,
                'createDateTime' => date('Y-m-d H:i:s'),
                'useDateTime' => null
            );
        }
        else
        {
            $newCode = mt_rand(1000,99999);
            $toBeInserted = array(
                'offerCode' => $newCode,
                'offerType' => 'Breakfast',
                'offerLoc' => null,
                'offerMug' => $mugId,
                'isRedeemed' => 0,
                'ifActive' => 1,
                'createDateTime' => date('Y-m-d H:i:s'),
                'useDateTime' => null
            );
        }

        $this->CI->offers_model->setSingleCode($toBeInserted);
        return 'DO-'.$newCode;
    }

    public function sendEmail($to, $cc = '', $from, $fromName, $subject, $content, $attachment = array())
    {
        $CI =& get_instance();
        $CI->load->library('email');
        $config['mailtype'] = 'html';
        $CI->email->clear(true);
        $CI->email->initialize($config);
        $CI->email->from($from, $fromName);
        $CI->email->to($to);
        if ($cc != '') {
            $CI->email->bcc($cc);
        }
        if(isset($attachment) && myIsArray($attachment))
        {
            foreach($attachment as $key)
            {
                $CI->email->attach($key);
            }
        }
        /*if($attachment != ""){
            $CI->email->attach($attachment);
        }*/
        $CI->email->subject($subject);
        $CI->email->message($content);
        return $CI->email->send();
    }

    // Mail send to organiser about cancellation of attendee
    public function eventCancelSendMail($userData)
    {
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/regisCancelMailView', $data, true);

        $fromEmail = 'events@doolally.in';
        $cc = 'priyanka@doolally.in,tresha@doolally.in,daksha@doolally.in,shweta@doolally.in,richa@doolally.in';
        $fromName  = 'Doolally';

        $subject = $userData['firstName'].' '.$userData['lastName'].' has withdrawn from '.$userData['eventName'];
        $toEmail = $userData['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function attendeeCancelMail($userData)
    {
        $phons = $this->CI->config->item('phons');
        $mailRecord = $this->CI->users_model->searchUserByLoc($userData['eventPlace']);
        $senderName = 'Doolally';
        $senderEmail = 'events@doolally.in';
        $senderPhone = $phons['Tresha'];

        if($mailRecord['status'] === true)
        {
            $senderName = $mailRecord['userData']['firstName'];
            $senderEmail = $mailRecord['userData']['emailId'];
            $senderPhone = $phons[$senderName];
        }
        $userData['senderName'] = $senderName;
        $userData['senderEmail'] = $senderEmail;
        $userData['senderPhone'] = $senderPhone;
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/attendeeCancelMailView', $data, true);

        $fromEmail = $senderEmail;

        $cc        = 'events@doolally.in';
        $fromName  = $senderName;

        $subject = 'You have withdrawn from '.$userData['eventName'];
        $toEmail = $userData['emailId'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function generateEventCode($eveId)
    {
        $allCodes = $this->CI->offers_model->getAllCodes();
        $usedCodes = array();
        $toBeInserted = array();
        if($allCodes['status'] === true)
        {
            foreach($allCodes['codes'] as $key => $row)
            {
                $usedCodes[] = $row['offerCode'];
            }
            $newCode = mt_rand(1000,99999);
            while(myInArray($newCode,$usedCodes))
            {
                $newCode = mt_rand(1000,99999);
            }
            $toBeInserted = array(
                'offerCode' => $newCode,
                'offerType' => 'Workshop',
                'offerLoc' => null,
                'offerMug' => '0',
                'offerEvent' => $eveId,
                'isRedeemed' => 0,
                'ifActive' => 1,
                'createDateTime' => date('Y-m-d H:i:s'),
                'useDateTime' => null
            );
        }
        else
        {
            $newCode = mt_rand(1000,99999);
            $toBeInserted = array(
                'offerCode' => $newCode,
                'offerType' => 'Workshop',
                'offerLoc' => null,
                'offerMug' => '0',
                'offerEvent' => $eveId,
                'isRedeemed' => 0,
                'ifActive' => 1,
                'createDateTime' => date('Y-m-d H:i:s'),
                'useDateTime' => null
            );
        }

        $this->CI->offers_model->setSingleCode($toBeInserted);
        return 'EV-'.$newCode;
    }

    public function generateCustomCode($eveId,$cusAmt)
    {
        $allCodes = $this->CI->offers_model->getAllCodes();
        $usedCodes = array();
        $toBeInserted = array();
        if($allCodes['status'] === true)
        {
            foreach($allCodes['codes'] as $key => $row)
            {
                $usedCodes[] = $row['offerCode'];
            }
            $newCode = mt_rand(1000,99999);
            while(myInArray($newCode,$usedCodes))
            {
                $newCode = mt_rand(1000,99999);
            }
            $toBeInserted = array(
                'offerCode' => $newCode,
                'offerType' => 'Rs '.$cusAmt,
                'offerLoc' => null,
                'offerMug' => '0',
                'offerEvent' => $eveId,
                'isRedeemed' => 0,
                'ifActive' => 1,
                'createDateTime' => date('Y-m-d H:i:s'),
                'useDateTime' => null
            );
        }
        else
        {
            $newCode = mt_rand(1000,99999);
            $toBeInserted = array(
                'offerCode' => $newCode,
                'offerType' => 'Rs '.$cusAmt,
                'offerLoc' => null,
                'offerMug' => '0',
                'offerEvent' => $eveId,
                'isRedeemed' => 0,
                'ifActive' => 1,
                'createDateTime' => date('Y-m-d H:i:s'),
                'useDateTime' => null
            );
        }

        $this->CI->offers_model->setSingleCode($toBeInserted);
        return 'EV-'.$newCode;
    }

}
/* End of file */