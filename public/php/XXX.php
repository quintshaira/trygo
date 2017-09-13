<?php
class AuthController extends Zend_Controller_Action

{

    function init()

    {

        $this->initView();

        Zend_Loader::loadClass('Users');

        Zend_Loader::loadClass('Camp');

        Zend_Loader::loadClass('Lenders');

        Zend_Loader::loadClass('Borrowers');

        Zend_Loader::loadClass('Borrowerchecklist');


        $this->view->baseUrl = $this->_request->getBaseUrl();

    }



    function indexAction()

    {

        $this->_redirect('/');

    }



    function forgotAction()
    {

        if ($this->_request->isPost()) {

            Zend_Loader::loadClass('Zend_Filter_StripTags');

            $filter = new Zend_Filter_StripTags();

            $user = new Users();

            $email=$this->_request->getPost('email');

            $checkemail = $user->checkUser($email);

            $username  = $checkemail['username'];



            //$encrypted_update_pwd_email = $checkemail['encrypted_update_pwd_email'];
            //echo $encrypted_update_pwd_email;exit;



            if(empty($checkemail)){

                $this->view->emailerr = 'This email address is not registered with us';

            }
            else{

                //echo "ppppp";exit;

                //$this->view->emailsucc = 'Password changing link has been send to your email successfully';

                $conform_pwd_email_encripted=md5($email.time());



                $data = array(
                    'encrypted_update_pwd_email' => $conform_pwd_email_encripted,
                    'encrypted_update_pwd_status' => 0
                );

                $user = new Users();

                $wheress = $user->getAdapter()->quoteInto('email = ?', $email);

                $user->update($data, $wheress);


                $to = $email;

                $subject = 'Reset password for your mrsmint.sg account.';


                $message = '<table align="center" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0" border="0">
   <tr>
      <td valign="top" width="100%">
         <table cellpadding="0" cellspacing="0" border="0">
            <tr>
               <td width="100%">
                  <table bgcolor="#ffffff" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td width="100%" height="8"></td>
                     </tr>
                  </table>
                  <table class="table_scale" width="600" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td width="100%">
                           <table width="600" cellpadding="0" cellspacing="0" border="0">
                              <tr>
                                 <td class="spacer" width="30"></td>
                                 <td width="540">
                                    <table class="full" align="left" width="227" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                       <tr>
                                          <td width="227" align="left" class="center" style="padding: 0px; text-transform: uppercase; font-family: Lucida Sans Unicode; color:#666666; font-size:24px; line-height:34px;">
                                             <span>
                                             <a href="#" style="color:#ffc526;"> <img src="http://cfunding.mrsmint.sg/public/assets/custom/img/logo_new.png" alt="logo" width="200" border="0" style="display: inline;" /> </a>
                                             </span>
                                          </td>
                                       </tr>
                                    </table>
                                    <table width="25" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                       <tr>
                                          <td width="100%" height="30"></td>
                                       </tr>
                                    </table>
                                    <table class="full" align="right" width="280" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                       <tr>
                                          <td class="center" align="right" style="margin: 0; padding-top: 10px; text-transform: uppercase; font-size: 17px; color:#666666; font-family: Lucida Sans Unicode; line-height: 30px;  mso-line-height-rule: exactly;"> <span> call us:+1 604 376 9937 </span></td>
                                       </tr>
                                    </table>
                                 </td>
                                 <td class="spacer" width="30"></td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
                  <table bgcolor="#ffffff" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td width="100%" height="8"></td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<table align="center" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0" border="0">
   <tr>
      <td valign="top" width="100%">
         <table cellpadding="0" cellspacing="0" border="0">
            <tr>
               <td width="100%">
                  <table class="table_scale" width="600" bgcolor="#e6e4de" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td width="100%">
                           <table width="600" background="images/featured-bg.png" bgcolor="#e6e4de" cellpadding="0" cellspacing="0" border="0">
                              <tr>
                                 <td width="600" valign="middle" style="padding: 0px;">
                                    <table class="full" align="center" width="540" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                       <tr>
                                          <td width="100%" height="30">&nbsp; </td>
                                       </tr>
                                       <tr>
                                          <td class="center" align="left" style="margin: 0; padding-bottom:0px; margin:0; font-family: Lucida Sans Unicode; font-size: 20px; color: #000; line-height: 25px; mso-line-height-rule: exactly;"> <span>Dear '.$username.',</span></td>
                                       </tr>
                                       <tr>
                                          <td class="center" align="left" style="margin: 0; padding:0px; margin:0; font-size:14px ; color:#000; font-weight:normal; font-family: Helvetica, Arial, sans-serif; line-height: 20px; mso-line-height-rule: exactly;">
                                             <span> ';
                $message .= 'Please reset your <a href="http://cfunding.mrsmint.sg/">mrsmint.sg</a> password by clicking on the following link : <br><a href="'.BASE_URL.'/auth/resetpassword/code/'.$conform_pwd_email_encripted.'">'.BASE_URL.'/auth/resetpassword/code/'.$conform_pwd_email_encripted.'</a></br><br/><br/>';
                $message .= 'Regards ,<br/>';
                $message .= 'Team mrsmint.sg <br/>';
                $message .= 'Disclaimer: This is a system-generated email, please do not reply. <br/>';
                $message .= '</span>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td class="center" align="left" height="20"></td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<table align="center" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0" border="0">
   <tr>
      <td valign="top" width="100%">
         <table cellpadding="0" cellspacing="0" border="0">
            <tr>
               <td width="100%">
                  <table bgcolor="#ffffff" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td width="100%" height="40">&nbsp; </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<table align="center" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0" border="0">
   <tr>
      <td valign="top" width="100%">
         <table cellpadding="0" cellspacing="0" border="0">
            <tr>
               <td width="100%">
                  <table class="table_scale" width="600" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td width="100%">
                           <table width="600" cellpadding="0" cellspacing="0" border="0">
                              <tr>
                                 <td class="spacer" width="30"></td>
                                 <td width="540">
                                    <table class="full" align="left" width="540" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                       <tr>
                                          <td class="center" align="center" style="padding-bottom: 10px; font-family: Lucida Sans Unicode; color:#666666; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
                                             <span>Visit Us</span>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td class="center" align="left" style="margin: 0; font-size:14px ; color:#aaaaaa; font-family: Helvetica, Arial, sans-serif; line-height: 24px;mso-line-height-rule: exactly;">
                                          </td>
                                       </tr>
                                       <tr>
                                          <td align="center" valign="top" style="padding-top: 15px;">
                                             <table border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffc526" style="margin: 0;">
                                                <tr>
                                                   <td align="center" valign="middle" bgcolor="#428bca" style="padding: 5px 20px; font-size:14px; line-height: 24px; font-family:Arial, sans-serif; mso-line-height-rule: exactly;"> <a href="http://cfunding.mrsmint.sg/" target="_blank" style="font-weight: normal; color:#ffffff; "> <b>Go to our site!</b> </a> </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                                 <td class="spacer" width="30"> </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
                  <table bgcolor="#ffffff" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td width="100%" height="40">&nbsp; </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
</table>';

                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: support@mrsmint.sg <support@mrsmint.sg>' . "\r\n" .
                'Reply-To: '.$email. "\r\n" ;
                mail($to, $subject, $message, $headers);

            }

            $this->_redirect('/auth/chngpasswordmailed');

        }

        $this->render();

    }


    function chngpasswordmailedAction()
    {
        $this->render();
    }



    function loginAction()

    {

        $this->view->message = '';

        Zend_Loader::loadClass('Zend_Filter_StripTags');

        $filter = new Zend_Filter_StripTags();

        $username = $filter->filter($this->_request->getParam('username'));


        $password = $filter->filter($this->_request->getParam('password'));

        //$this->view->message="uname".$username." pass".$password;



        if ($username=="" || $password=="") {

            echo 'Please provide email and password.';

        }

        else {

            // setup Zend_Auth adapter for a database table

            Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');

            $db = Zend_Registry::get('db');

            $authAdapter = new Zend_Auth_Adapter_DbTable($db);

            $authAdapter->setTableName('users');

            $authAdapter->setIdentityColumn('email');

            $authAdapter->setCredentialColumn('password');



            // Set the input credential values to authenticate against

            $authAdapter->setIdentity($username);

            $encryptionpassword = hash('sha512', $password);

            $authAdapter->setCredential($encryptionpassword);



            // do the authentication

            $auth = Zend_Auth::getInstance();

            $result = $auth->authenticate($authAdapter);







            if ($result->isValid()) {





                $user = new Users();

                $check_result = $user->checkValidUser($username);



                if( $check_result ) {



                    // success : store database row to auth's storage system

                    // (not the password though!)



                    $data = $authAdapter->getResultRowObject(null, 'password');//print_r($data);die;


                    $user = new Users();

                    $lender = $user->getLenderDetails($data->id);

                    //echo $data['lender_knowledge_status'];exit;

                    $auth->getStorage()->write($data);

                    if($data->user_type == '3'){
                        if($lender[0]['lender_type']>0){
                            $_SESSION['lender_type'] = $lender[0]['lender_type'];
                        }
                    }

                    //$this->_redirect('/user/dashboard');


                    //old_one.......> echo $this->view->message = 'success##'.$data->lender_knowledge_status;
                    echo $this->view->message = 'success##'.$data->lender_passed_riskassesment.'##'.$data->user_type.'##'.$data->borrower_checklist_status.'##'.$data->lender_first_login_status.'##'.$data->status;
                    //$this->view->lender_knowledge_status=$lender_knowledge_status=$check_result['lender_knowledge_status'];

                    //echo $lender_knowledge_status;exit;



                } else {

                    echo $this->view->message = 'Incorrect Email Address or Password.';

                }



            } else {

                // failure: clear database row from session

                echo $this->view->message = 'Incorrect Email Address or Password.';

            }





        }





        // $this->view->title = "Log in";

        // $this->render();



    }



    function lenderregistrationAction()

    {


        Zend_Loader::loadClass('Zend_Filter_StripTags');

        $filter = new Zend_Filter_StripTags();



        $lender_name = $filter->filter($this->_request->getParam('lender_name'));
        $lender_email = $filter->filter($this->_request->getParam('lender_email'));
        $lender_password = $filter->filter($this->_request->getParam('lender_password'));
        $lender_repassword = $filter->filter($this->_request->getParam('lender_repassword'));

        //$this->view->message="uname".$username." pass".$password;



        if ($lender_name=="" || $lender_email=="" || $lender_password=="" || $lender_repassword=="") {
            echo 'Please provide all details.';
        }

        else {

            // setup Zend_Auth adapter for a database table

            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter = new Zend_Filter_StripTags();

            Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');

            $db = Zend_Registry::get('db');

            $authAdapter = new Zend_Auth_Adapter_DbTable($db);

            $authAdapter->setTableName('users');

            $authAdapter->setTableName('lenders');


            $user = new Users();
            $user_row=$user->checkUserEmail($lender_email);


            if(  !isset($user_row['email']) || $user_row == NULL) {





                $encryptionpassword = hash('sha512', $lender_password);
                $encrypted_email_time = md5($lender_email.time());
                $lender_terms_accept_date=date("Y-m-d H:i:s");
                $data = array(
                    'username' => $lender_name,
                    'email' =>$lender_email,
                    'password' =>$encryptionpassword,
                    'is_email_confirmed' => "0",
                    'encrypted_email_time' => $encrypted_email_time,
                    'status' => 0,
                    'user_type' => "3",
                    'lender_first_login_status' => "0",
                    'terms_accept_date' => $lender_terms_accept_date
                );




                $result = $user->insert($data);
                //echo "<pre>"; print_r($result); die;
                $user_id= $user->getAdapter()->lastInsertId();






                $data1 = array(
                    'user_id' => $user_id

                );




                $lenders = new Lenders();
                $lenders->insert($data1);




                $mail = new Zend_Mail('utf-8');
                //$mail->setBodyText('Welcome, To Register As A Borrower, Successfully Authenticate your Email Id . ');


                $mail->setBodyHtml('<table border="1" width="100%"><tr><td  style="font-family:Gotham, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:16px; color:#000; border:none;  padding:10px 20px;">Dear '.$lender_name.',</td></tr><tr><td style="font-family:Gotham, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:16px; color:#000; border:none;  padding:0 20px 10px 20px;">Please activate your mrsmint.sg account by clicking on the following link: <a href="'.BASE_URL.'/user/confirm/code/'.$encrypted_email_time.'">'.BASE_URL.'/user/confirmation/code/'.$encrypted_email_time.'</a></td></tr><tr><td style="font-family:Gotham, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:16px; color:#000; border:none;  padding:0 20px 10px 20px;">Regards, <br><a href="mailto:team@mrsmint.sg" title="team@mrsmint.sg"  style="font-family:Gotham, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:16px; color:#000; text-decoration:none;">team@mrsmint.sg</a></td></tr></table>');
                /*$mail->setBodyHtml('Welcome '.$name.' , <br><br>Thank you for your registration in mrsmint! <br><br> To confirm your account please browse through the below provided URL.<br> <a href="'.BASE_URL.'/user/confirm/code/'.$encrypted_email_time.'">'.BASE_URL.'/user/confirmation/code/'.$encrypted_email_time.'</a><br><br>Thank You<br>mrsmint');*/



                $mail->setFrom('support@mrsmint.sg', 'support@mrsmint.sg');
                $mail->addTo($lender_email, $lender_name);
                /*$mail->setSubject('Thank you for your registration in mrsmint!');*/
                $mail->setSubject('Email to activate account');
                $mail->send();

                //echo "<pre>"; print_r($borrowers); die;

                echo 'success';
                //$this->_redirect('/applyuserlender/thankyou');

            } else {

                echo 'Email already exist! Please use another one.';
            }

        }


        die;


        // $this->view->title = "Log in";

        // $this->render();



    }

    function borrowerregistrationAction()

    {


        Zend_Loader::loadClass('Zend_Filter_StripTags');

        $filter = new Zend_Filter_StripTags();



        $borrower_name = $filter->filter($this->_request->getParam('borrower_name'));
        $borrower_email = $filter->filter($this->_request->getParam('borrower_email'));
        $borrower_password = $filter->filter($this->_request->getParam('borrower_password'));
        $borrower_repassword = $filter->filter($this->_request->getParam('borrower_repassword'));

        //$this->view->message="uname".$username." pass".$password;



        if ($borrower_name=="" || $borrower_email=="" || $borrower_password=="" || $borrower_repassword=="") {
            echo 'Please provide all details.';
        }

        else {

            // setup Zend_Auth adapter for a database table

            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter = new Zend_Filter_StripTags();

            Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');

            $db = Zend_Registry::get('db');

            $authAdapter = new Zend_Auth_Adapter_DbTable($db);


            $user = new Users();
            $user_row=$user->checkUserEmail($borrower_email);


            if(  !isset($user_row['email']) || $user_row == NULL) {





                $encryptionpassword = hash('sha512', $borrower_password);
                $encrypted_email_time = md5($borrower_email.time());
                $terms_date=date("Y-m-d H:i:s");
                $data = array(
                    'username' => $borrower_name,
                    'email' =>$borrower_email,
                    'password' =>$encryptionpassword,
                    'is_email_confirmed' => "0",
                    'encrypted_email_time' => $encrypted_email_time,
                    'status' => 0,
                    'user_type' => "2",
                    'terms_accept_date' => $terms_date
                );




                $result = $user->insert($data);
                //echo "<pre>"; print_r($result); die;
                $user_id= $user->getAdapter()->lastInsertId();






                $data1 = array(
                    'user_id' => $user_id

                );




                $borrowers = new Borrowers();
                $borrowers->insert($data1);

                $data2 = array(

                    'user_id' => $user_id

                );



                $borrowerchecklist = new Borrowerchecklist();

                $borrowerchecklist->insert($data2);


                $mail = new Zend_Mail('utf-8');


                $message = '<table align="center" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0" border="0">
   <tr>
      <td valign="top" width="100%">
         <table cellpadding="0" cellspacing="0" border="0">
            <tr>
               <td width="100%">
                  <table bgcolor="#ffffff" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td width="100%" height="8"></td>
                     </tr>
                  </table>
                  <table class="table_scale" width="600" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td width="100%">
                           <table width="600" cellpadding="0" cellspacing="0" border="0">
                              <tr>
                                 <td class="spacer" width="30"></td>
                                 <td width="540">
                                    <table class="full" align="left" width="227" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                       <tr>
                                          <td width="227" align="left" class="center" style="padding: 0px; text-transform: uppercase; font-family: Lucida Sans Unicode; color:#666666; font-size:24px; line-height:34px;">
                                             <span>
                                             <a href="#" style="color:#ffc526;"> <img src="http://cfunding.mrsmint.sg/public/assets/custom/img/logo_new.png" alt="logo" width="200" border="0" style="display: inline;" /> </a>
                                             </span>
                                          </td>
                                       </tr>
                                    </table>
                                    <table width="25" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                       <tr>
                                          <td width="100%" height="30"></td>
                                       </tr>
                                    </table>
                                    <table class="full" align="right" width="280" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                       <tr>
                                          <td class="center" align="right" style="margin: 0; padding-top: 10px; text-transform: uppercase; font-size: 17px; color:#666666; font-family: Lucida Sans Unicode; line-height: 30px;  mso-line-height-rule: exactly;"> <span> call us:+1 604 376 9937 </span></td>
                                       </tr>
                                    </table>
                                 </td>
                                 <td class="spacer" width="30"></td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
                  <table bgcolor="#ffffff" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td width="100%" height="8"></td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<table align="center" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0" border="0">
   <tr>
      <td valign="top" width="100%">
         <table cellpadding="0" cellspacing="0" border="0">
            <tr>
               <td width="100%">
                  <table class="table_scale" width="600" bgcolor="#e6e4de" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td width="100%">
                           <table width="600" background="images/featured-bg.png" bgcolor="#e6e4de" cellpadding="0" cellspacing="0" border="0">
                              <tr>
                                 <td width="600" valign="middle" style="padding: 0px;">
                                    <table class="full" align="center" width="540" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                       <tr>
                                          <td width="100%" height="30">&nbsp; </td>
                                       </tr>
                                       <tr>
                                          <td class="center" align="left" style="margin: 0; padding-bottom:0px; margin:0; font-family: Lucida Sans Unicode; font-size: 20px; color: #000; line-height: 25px; mso-line-height-rule: exactly;"> <span>Dear '.$borrower_name.',</span></td>
                                       </tr>
                                       <tr>
                                          <td class="center" align="left" style="margin: 0; padding:0px; margin:0; font-size:14px ; color:#000; font-weight:normal; font-family: Helvetica, Arial, sans-serif; line-height: 20px; mso-line-height-rule: exactly;">
                                             <span> ';
                $message .= 'Thank you for registering <a href="http://cfunding.mrsmint.sg/">mrsmint.sg</a> account !<br/><br/>';
                $message .= 'Please activate your <a href="http://cfunding.mrsmint.sg/">mrsmint.sg</a> account by clicking on the following link : <br><a href="'.BASE_URL.'/user/confirm/code/'.$encrypted_email_time.'">'.BASE_URL.'/user/confirmation/code/'.$encrypted_email_time.'</a></br><br/><br/>';
                $message .= 'Regards ,<br/>';
                $message .= 'Team mrsmint.sg <br/>';
                $message .= 'Disclaimer: This is a system-generated email, please do not reply. <br/>';
                $message .= '</span>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td class="center" align="left" height="20"></td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<table align="center" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0" border="0">
   <tr>
      <td valign="top" width="100%">
         <table cellpadding="0" cellspacing="0" border="0">
            <tr>
               <td width="100%">
                  <table bgcolor="#ffffff" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td width="100%" height="40">&nbsp; </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<table align="center" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0" border="0">
   <tr>
      <td valign="top" width="100%">
         <table cellpadding="0" cellspacing="0" border="0">
            <tr>
               <td width="100%">
                  <table class="table_scale" width="600" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td width="100%">
                           <table width="600" cellpadding="0" cellspacing="0" border="0">
                              <tr>
                                 <td class="spacer" width="30"></td>
                                 <td width="540">
                                    <table class="full" align="left" width="540" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                       <tr>
                                          <td class="center" align="center" style="padding-bottom: 10px; font-family: Lucida Sans Unicode; color:#666666; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
                                             <span>Visit Us</span>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td class="center" align="left" style="margin: 0; font-size:14px ; color:#aaaaaa; font-family: Helvetica, Arial, sans-serif; line-height: 24px;mso-line-height-rule: exactly;">
                                          </td>
                                       </tr>
                                       <tr>
                                          <td align="center" valign="top" style="padding-top: 15px;">
                                             <table border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffc526" style="margin: 0;">
                                                <tr>
                                                   <td align="center" valign="middle" bgcolor="#428bca" style="padding: 5px 20px; font-size:14px; line-height: 24px; font-family:Arial, sans-serif; mso-line-height-rule: exactly;"> <a href="http://cfunding.mrsmint.sg/" target="_blank" style="font-weight: normal; color:#ffffff; "> <b>Go to our site!</b> </a> </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                                 <td class="spacer" width="30"> </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
                  <table bgcolor="#ffffff" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td width="100%" height="40">&nbsp; </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
</table>';



















                //$mail->setBodyHtml('<table border="1" width="100%"><tr><td  style="font-family:Gotham, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:16px; color:#000; border:none;  padding:10px 20px;">Dear '.$borrower_name.',</td></tr><tr><td  style="font-family:Gotham, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:16px; color:#000; border:none;  padding:10px 20px;">Please activate your mrsmint.sg account by clicking on the following link: <a href="'.BASE_URL.'/user/confirm/code/'.$encrypted_email_time.'">'.BASE_URL.'/user/confirmation/code/'.$encrypted_email_time.'</a> </td></tr><tr><td style="font-family:Gotham, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:16px; color:#000; border:none;  padding:0 20px 10px 20px;">Regards, <br><a href="mailto:team@mrsmint.sg" title="team@mrsmint.sg"  style="font-family:Gotham, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:16px; color:#000; text-decoration:none;">team@mrsmint.sg</a></td></tr></table>');

                $mail->setBodyHtml($message);

                $mail->setFrom('support@mrsmint.sg', 'support@mrsmint.sg');

                $mail->addTo($borrower_email, $borrower_name);

                $mail->setSubject('Thank you for your registration in mrsmint!');

                $mail->send();

                //echo "<pre>"; print_r($borrowers); die;

                echo 'success';
                //$this->_redirect('/applyuserlender/thankyou');

            } else {

                echo 'Email already exist! Please use another one.';
            }

        }


        die;


        // $this->view->title = "Log in";

        // $this->render();



    }



    /*function dashboardAction()

    {		



            $this->render();



    }*/






    function loginfundAction()

    {

        $user = new Users();

        $this->view->message = '';

        Zend_Loader::loadClass('Zend_Filter_StripTags');

        $filter = new Zend_Filter_StripTags();

        $username = $filter->filter($this->_request->getParam('username'));

        $password = $filter->filter($this->_request->getParam('password'));

        //$this->view->message="uname".$username." pass".$password;



        if ($username=="" || $password=="") {

            echo 'Please provide username and password.';

        }

        else {

            // setup Zend_Auth adapter for a database table

            Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');

            $db = Zend_Registry::get('db');

            $authAdapter = new Zend_Auth_Adapter_DbTable($db);

            $authAdapter->setTableName('users');

            $authAdapter->setIdentityColumn('username');

            $authAdapter->setCredentialColumn('password');



            // Set the input credential values to authenticate against

            $authAdapter->setIdentity($username);

            $authAdapter->setCredential($password);



            // do the authentication

            $auth = Zend_Auth::getInstance();

            $result = $auth->authenticate($authAdapter);

            if ($result->isValid()) {

                // success : store database row to auth's storage system

                // (not the password though!)



                $data = $authAdapter->getResultRowObject(null, 'password');//print_r($data);die;

                $auth->getStorage()->write($data);

                //$this->_redirect('/');

                $defaultNamespace = new Zend_Session_Namespace('Default');

                $defaultNamespace->uid = $data->id;

                echo $this->view->message = $data->id;

            } else {

                // failure: clear database row from session

                echo $this->view->message = '';

            }





        }





        // $this->view->title = "Log in";

        // $this->render();



    }



    function usersignupAction()

    {

        Zend_Loader::loadClass('Zend_Filter_StripTags');



        $filter = new Zend_Filter_StripTags();

        $user = new Users();



        $name=trim($filter->filter($this->_request->getParam('name')));

        $email=trim($filter->filter($this->_request->getParam('email')));

        $password=trim($filter->filter($this->_request->getParam('password')));

        $cpassword=trim($filter->filter($this->_request->getParam('cpassword')));

        $lname=trim($filter->filter($this->_request->getParam('lname')));

        $dobmonth=trim($filter->filter($this->_request->getParam('dobmonth')));

        $dobday=trim($filter->filter($this->_request->getParam('dobday')));

        $dobyear=trim($filter->filter($this->_request->getParam('dobyear')));



        /*$defaultNamespace = new Zend_Session_Namespace('Default');

        $fid = (int)$this->_request->getParam('fundid',0);

        $defaultNamespace->f_id = $fid;*/



        if($email!=''){

            $user_exist = $user->checkUser($email);

        }



        if($name==''){

            $signuperr['name']='Please enter name';

        }

        else{

            $signuperr['name']='';

        }



        if($email=='' || !filter_var($email, FILTER_VALIDATE_EMAIL)){

            $signuperr['mail']='Please enter vaild email';

        }

        else{

            if(empty($user_exist))

            {$signuperr['mail']='';}

            else

            {$signuperr['mail']='Username already exist';}

        }



        if($password==''){

            $signuperr['password']='Please enter password';

        }

        else{

            $signuperr['password']='';

        }



        if($cpassword=='')

        {

            $signuperr['cpassword']='Please reenter password';}

        else

        {

            $signuperr['cpassword']='';}



        if($password!='' && $cpassword!='')

        {

            if($password!=$cpassword)

            {

                $signuperr['password']='';

                $signuperr['cpassword']='Please check your password';

            }

        }

        if($lname==''){

            $signuperr['lname']='Please enter last name';

        }

        else{

            $signuperr['lname']='';

        }



        if($dobmonth=='' || $dobday=='' || $dobyear==''){

            $signuperr['dobmonth']='Please select date of birth';

        }

        else{

            $signuperr['dobmonth']='';

        }



        $sing=$signuperr;

        $signuperr = array_filter($signuperr);



        if(empty($signuperr))

        {

            $dob = $dobyear.'-'.$dobmonth.'-'.$dobday;



            $user_data = array(

                'username' => $email,

                'password' => $password,

                'last_name' => $lname,

                'dob' => $dob,

                'real_name' => $name

            );

            $user_master = new Users();

            $user_master->insert($user_data);

            $user_id= $user_master->getAdapter()->lastInsertId();



            Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');

            $db = Zend_Registry::get('db');

            $authAdapter = new Zend_Auth_Adapter_DbTable($db);

            $authAdapter->setTableName('users');

            $authAdapter->setIdentityColumn('username');

            $authAdapter->setCredentialColumn('password');



            // Set the input credential values to authenticate against

            $authAdapter->setIdentity($email);

            $authAdapter->setCredential($password);



            // do the authentication

            $auth = Zend_Auth::getInstance();

            $result = $auth->authenticate($authAdapter);

            if ($result->isValid()) {

                $data = $authAdapter->getResultRowObject(null, 'password');//print_r($data);die;

                $auth->getStorage()->write($data);

            }



            $to      = $email;

            $subject = 'Thanks for registering with Fundomoney.';



            $message = '<table align="center" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0" border="0">

         <tr>

            <td valign="top" width="100%">

               <table cellpadding="0" cellspacing="0" border="0">

                  <tr>

                     <td width="100%">

                        <table bgcolor="#ffffff" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">

                           <tr>

                              <td width="100%" height="8"></td>

                           </tr>

                        </table>

                        <table class="table_scale" width="600" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0">

                           <tr>

                              <td width="100%">

                                 <table width="600" cellpadding="0" cellspacing="0" border="0">

                                    <tr>

                                       <td class="spacer" width="30"></td>

                                       <td width="540">

                                         <table class="full" align="left" width="227" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">

                                             <tr>

                                                <td width="227" align="left" class="center" style="padding: 0px; text-transform: uppercase; font-family: Lucida Sans Unicode; color:#666666; font-size:24px; line-height:34px;">

                                                   <span>

                                                   <a href="#" style="color:#ffc526;"> <img src="http://fundomony.com/public/asset/images/social/logo.png" alt="logo" width="200" border="0" style="display: inline;" /> </a>

                                                   </span>

                                                </td>

                                             </tr>

                                          </table>

                                           <table width="25" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">

                                             <tr>

                                                <td width="100%" height="30"></td>

                                             </tr>

                                          </table>

                                           <table class="full" align="right" width="280" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">

                                             <tr>

                                                <td class="center" align="right" style="margin: 0; padding-top: 10px; text-transform: uppercase; font-size: 17px; color:#666666; font-family: Lucida Sans Unicode; line-height: 30px;  mso-line-height-rule: exactly;"> <span> call us:+1 604 376 9937 </span></td>

                                             </tr>

                                          </table>

                                           </td>

                                       <td class="spacer" width="30"></td>

                                    </tr>

                                 </table>

                              </td>

                           </tr>

                        </table>

                        <table bgcolor="#ffffff" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">

                           <tr>

                              <td width="100%" height="8"></td>

                           </tr>

                        </table>

                         </td>

                  </tr>

               </table>

            </td>

         </tr>

      </table>      

      <table align="center" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0" border="0">

         <tr>

            <td valign="top" width="100%">

               <table cellpadding="0" cellspacing="0" border="0">

                  <tr>

                     <td width="100%">

                        <table class="table_scale" width="600" bgcolor="#e6e4de" cellpadding="0" cellspacing="0" border="0">

                           <tr>

                              <td width="100%">

                                 <table width="600" background="images/featured-bg.png" bgcolor="#e6e4de" cellpadding="0" cellspacing="0" border="0">

                                    

                                          <tr>

                                             <td width="600" valign="middle" style="padding: 0px;">

                                                <table class="full" align="center" width="540" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">

                                                   <tr>

                                                      <td width="100%" height="30">&nbsp; </td>

                                                   </tr>

                                                  

                                                   <tr>

                                                      <td class="center" align="left" style="margin: 0; padding-bottom:0px; margin:0; font-family: Lucida Sans Unicode; font-size: 20px; color: #000; line-height: 25px; mso-line-height-rule: exactly;"> <span>Dear Friend,</span></td>

                                                   </tr>

                                                  

                                                   <tr>

                                                      <td class="center" align="left" style="margin: 0; padding:0px; margin:0; font-size:14px ; color:#000; font-weight:normal; font-family: Helvetica, Arial, sans-serif; line-height: 20px; mso-line-height-rule: exactly;">

                                                         <span> ';

            $message .= 'Thanks for registering with Fundomoney and welcome!<br/><br/>';

            $message .= 'The world is looking to fund great ideas or worthy causes and yours might be one of the great ones!<br/><br/>';

            $message .= 'Fundomoney provides you with a sophisticated marketing platform and the right tools you need to succeed.<br/><br/>';

            $message .= 'Create your campaign and add convincing copy, upload photos and videos, whatever you need to make your listing stand out and be exciting.<br/><br/>';

            $message .= 'All donors receive a Fundomony lapel pin that they can proudly wear to show their support for your campaign, you might want to offer additional incentives, such as free copies, branded clothing, discounts, a keepsake or collectible, etc.<br/><br/>';

            $message .= 'And, although registering is free, there is a nominal fee when you receive funds (this offsets the cost for us to hand monetary donations securely).  You can view the pricing structure <a href="http://www.fundomony.com/pricing">here</a>.<br/><br/>';

            $message .= 'Again, welcome aboard, and good luck with your campaign!<br/><br/>';

            $message .= 'If you have any questions, please email us at contact@fundomony.com. <br/><br/>';

            $message .= '</span>

                                                      </td>

                                                   </tr>

                                                   <tr>

                                                     <td class="center" align="left" height="20"></td>

                                                   </tr>

                                                   

                                                </table>

                                             </td>

                                          </tr>

                                          

                                 </table>

                              </td>

                           </tr>

                        </table>

                     </td>

                  </tr>

               </table>

            </td>

         </tr>

      </table>      

      <table align="center" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0" border="0">

         <tr>

            <td valign="top" width="100%">

               <table cellpadding="0" cellspacing="0" border="0">

                  <tr>

                     <td width="100%">                        

                        

                        <table bgcolor="#ffffff" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">

                           <tr>

                              <td width="100%" height="40">&nbsp; </td>

                           </tr>

                        </table>

                        

                     </td>

                  </tr>

               </table>

            </td>

         </tr>

      </table>

      <table align="center" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0" border="0">

         <tr>

            <td valign="top" width="100%">

               <table cellpadding="0" cellspacing="0" border="0">

                  <tr>

                     <td width="100%">

                        <table class="table_scale" width="600" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0">

                           <tr>

                              <td width="100%">

                                 <table width="600" cellpadding="0" cellspacing="0" border="0">

                                    <tr>

                                       <td class="spacer" width="30"></td>

                                       <td width="540">

                                          <table class="full" align="left" width="540" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">

                                             

                                             <tr>

                                                <td class="center" align="center" style="padding-bottom: 10px; font-family: Lucida Sans Unicode; color:#666666; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">

                                                   <span>Visit Us</span>

                                                </td>

                                             </tr>

                                             <tr>

                                                <td class="center" align="left" style="margin: 0; font-size:14px ; color:#aaaaaa; font-family: Helvetica, Arial, sans-serif; line-height: 24px;mso-line-height-rule: exactly;">

                                                   <span>Fundomony posts fundraising campaigns to develop businesses or fund charities and humanitarian causes all over the world by helping to raise money to fund the projects. All donors receive a Fundomony lapel pin that they can proudly wear to show their desire to make the world a better place to live for everyone.</span>

                                                </td>

                                             </tr>

                                             <tr>

                                                <td align="center" valign="top" style="padding-top: 15px;">

                                                   <table border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffc526" style="margin: 0;">

                                                      <tr>

                                                         <td align="center" valign="middle" bgcolor="#428bca" style="padding: 5px 20px; font-size:14px; line-height: 24px; font-family:Arial, sans-serif; mso-line-height-rule: exactly;"> <a href="http://www.fundomony.com/" target="_blank" style="font-weight: normal; color:#ffffff; "> <b>Go to our site!</b> </a> </td>

                                                      </tr>

                                                   </table>

                                                </td>

                                             </tr>

                                            

                                          </table>

                                       </td>

                                       <td class="spacer" width="30"> </td>

                                    </tr>

                                 </table>

                              </td>

                           </tr>

                        </table>

                        

                        <table bgcolor="#ffffff" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">

                           <tr>

                              <td width="100%" height="40">&nbsp; </td>

                           </tr>

                        </table>

                        

                     </td>

                  </tr>

               </table>

            </td>

         </tr>

      </table>

      <table align="center" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0" border="0">

         <tr>

            <td valign="top" width="100%">

               <table cellpadding="0" cellspacing="0" border="0">

                  <tr>

                     <td width="100%">

                       

                        <table bgcolor="#ededed" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">

                           <tr>

                              <td width="100%" height="30">&nbsp; </td>

                           </tr>

                        </table>

                        

                        <table class="table_scale" width="600" bgcolor="#ededed" cellpadding="0" cellspacing="0" border="0">

                           <tr>

                              <td width="100%">

                                 <table width="600" cellpadding="0" cellspacing="0" border="0">

                                    <tr>

                                       <td class="spacer" width="30"> </td>

                                       <td width="540">

                                          

                                          <table class="full" align="left" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">

                                             <tr>

                                                <td class="center" align="left" style="margin: 0;  text-transform: uppercase; font-size: 20px; color:#666666; font-family: Lucida Sans Unicode; line-height: 30px;  mso-line-height-rule: exactly;"> <span> FOLLOW US ONLINE:</span> </td>

                                             </tr>

                                          </table>

                                          

                                          <table width="25" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">

                                             <tr>

                                                <td width="100%" height="30"></td>

                                             </tr>

                                          </table>

                                          

                                          <table class="full" align="right" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">

                                             <tr>

                                                <td class="center" align="right" style="margin: 0; font-size:14px ; color:#aaaaaa; font-family: Helvetica, Arial, sans-serif; line-height: 100%;"> <span> 

<a href="#" style="color:#ededed;"> <img src="http://fundomony.com/public/asset/images/social/fac_01.png" alt="facebook" width="32" height="32" border="0" /> </a> &nbsp;

 <a href="https://twitter.com/fundomony"  style="color:#ededed;"> <img src="http://fundomony.com/public/asset/images/social/fac_02.png" alt="youtube" width="32" height="32" border="0" /> </a> &nbsp;

 <a href="https://www.linkedin.com/pub/fundomony-com/a7/874/57a" style="color:#ededed;"> <img src="http://fundomony.com/public/asset/images/social/fac_03.png" alt="twitter" width="32" height="32" border="0" /> </a> </span> </td>

                                             </tr>

                                          </table>

                                          

                                       </td>

                                       <td class="spacer" width="30"> </td>

                                    </tr>

                                 </table>

                              </td>

                           </tr>

                        </table>

                        

                        <table bgcolor="#ededed" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">

                           <tr>

                              <td width="100%" height="30">&nbsp; </td>

                           </tr>

                        </table>

                        

                     </td>

                  </tr>

               </table>

            </td>

         </tr>

      </table>

      <table align="center" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0" border="0">

         <tr>

            <td valign="top" width="100%">

               <table cellpadding="0" cellspacing="0" border="0">

                  <tr>

                     <td width="100%">

                       

                        <table bgcolor="#666666" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-top: 1px solid #767373;">

                           <tr>

                              <td width="100%" height="20">&nbsp; </td>

                           </tr>

                        </table>

                       

                        <table class="table_scale" width="600" bgcolor="#666666" cellpadding="0" cellspacing="0" border="0">

                           <tr>

                              <td width="100%">

                                 <table width="600" cellpadding="0" cellspacing="0" border="0">

                                    <tr>

                                       <td width="600">

                                          <table class="full" align="center" width="540" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">

                                             <tr>

                                                <td class="center" align="center" style="margin: 0;  font-size:12px ; color:#ededed; font-family: Helvetica, Arial, sans-serif; line-height: 18px;"> <span>                                                

                                                Copyright 2014 - 2015 <a href="http://fundomony.com/" target="_blank" style="color:#ff920d;">fundomony</a>, All Rights Reserved.</span> </td>

                                             </tr>

                                          </table>

                                       </td>

                                    </tr>

                                 </table>

                              </td>

                           </tr>

                        </table>

                        

                        <table bgcolor="#666666" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">

                           <tr>

                              <td width="100%" height="20">&nbsp; </td>

                           </tr>

                        </table>

                        

                        <table bgcolor="#f8f8f8" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">

                           <tr>

                              <td width="100%" height="10"></td>

                           </tr>

                        </table>

                        

                     </td>

                  </tr>

               </table>

            </td>

         </tr>

      </table>';



            $headers  = 'MIME-Version: 1.0' . "\r\n";

            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            $headers .= 'From: contact@fundomony.com' . "\r\n" .

                'Reply-To: contact@fundomony.com' . "\r\n" ;



            mail($to, $subject, $message, $headers);



            header ("content-type: application/json; charset=utf-8");

            echo json_encode(array('status'=>$user_id));

        }

        else

        {

            header ("content-type: application/json; charset=utf-8");

            //$this->view->errmessage = $signuperr;

            echo json_encode($signuperr);

            //echo $marr;

        }





    }



    function logoutAction()

    {

        Zend_Auth::getInstance()->clearIdentity();

        //$this->_redirect('/auth/logoutsucc');
        unset($_SESSION['lender_type']);

        $this->render();



    }


    function resetpasswordAction()

    {

        $uri = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();



        $uri = $this->_request->getParams('code');



        $encrp_email_time_password = ($uri['code']);


        $user = new Users();
        $check_password_mail = $user->checkEncpwdmail($encrp_email_time_password);


        $encrypted_update_pwd_email = $check_password_mail['encrypted_update_pwd_email'];
        $encrypted_update_pwd_status = $check_password_mail['encrypted_update_pwd_status'];
        $email = $check_password_mail['email'];
        $username = $check_password_mail['username'];

        $this->view->err_reenterlink ='';

        //echo "pppppp";exit;

        if($encrypted_update_pwd_status == 1 || $encrypted_update_pwd_email != $encrp_email_time_password )
        {
            $this->view->err_reenterlink = "Invalid Password reset Attempt";
        }
        else
        {


            if ($this->_request->isPost()) {

                Zend_Loader::loadClass('Zend_Filter_StripTags');
                $filter = new Zend_Filter_StripTags();

                $this->view->err_repass ='';


                $this->view->password = $password =  $filter->filter($this->_request->getPost('password'));
                $encryption_new_password = hash('sha512', $password);


                if ($password != $repassword)
                {$this->view->err_repass = "Please Retype The Password It should Be Same As Password";}

                $data = array(
                    'encrypted_update_pwd_status' => 1,
                    'password' => $encryption_new_password
                );

                $user = new Users();

                $wheress = $user->getAdapter()->quoteInto('encrypted_update_pwd_email = ?', $encrp_email_time_password);

                $user->update($data, $wheress);


                $mail = new Zend_Mail('utf-8');
                //echo "pppp"; exit;
                $mail->setBodyHtml('Dear '.$username.' <br><br>You have just changed the password to your mrsmint.sg account. If you did not make the change, please email us at jennifer@mrsmint.sg or call us at 7777777777<br><br>Regards,<br>Team mrsmint.sg');
                $mail->setFrom('support@mrsmint.sg', 'support@mrsmint.sg');
                $mail->addTo($email, 'test');
                $mail->setSubject('Change of Password');
                $mail->send();


                $this->_redirect('/auth/passwordchanged');

            }

            //$this->_redirect('/auth/passwordchanged');

        }

        //$user = new Users();

        //$result = $user->checkCodeAndUpdate($encrp_email_time);





        /*if( $result )

           $this->_redirect('/user/confirmsucc');

        else

          $this->_redirect('/user/confirminvalid');*/





        $this->render();



    }

    function passwordchangedAction()
    {
        $this->render();
        //$this->_redirect($_SERVER["HTTP_REFERER"]);
        //return;	
    }





}