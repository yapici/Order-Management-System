<?php
class Email {

    /** @var string E-mail HTML text header */
    private static $emailHtmlBodyHeader;

    /** @var string E-mail HTML text footer */
    private static $emailHtmlBodyFooter;

    /** @var string Signature after the message body */
    private static $emailHtmlBodySignature;

    /** @var string Domain name */
    private static $domain = Constants::DOMAIN_NAME;

    /** @var string Domain name */
    private static $domainEmailExt = Constants::DOMAIN_EMAIL_EXT;

    /** @var string Noreply e-mail adress */
    private static $fromEmailAdress;

    function __construct() {
        self::$emailHtmlBodyHeader = "<html><body align='center' style='width: 100%'>";
        self::$emailHtmlBodyHeader .= "<div style='min-width: 600px; width: 600px; background: #e8e8e8; color: #222222; border-radius: 4px; -moz-border-radius: 4px; -webkit-border-radius: 4px;'>";
        self::$emailHtmlBodyHeader .= "<div style='width: 100%; height: 4.8em; position: relative; background: #0093d0; color: #ffffff; -webkit-border-top-left-radius: 4px; -webkit-border-top-right-radius: 4px; -moz-border-radius-topleft: 4px; -moz-border-radius-topright: 4px; border-top-left-radius: 4px; border-top-right-radius: 4px;'>";
        self::$emailHtmlBodyHeader .= "<a href='http://" . self::$domain . "' style='color: #ffffff; text-decoration: none;'><img align='left' style='padding-left: 1em; padding-top: 0.4em; width: 4.0em;' src='http://" . self::$domain . "/images/logo.png'/>";
        self::$emailHtmlBodyHeader .= "<div align='center' style='font-size: 1.6em; line-height: 3em; font-weight: bold; padding-right: 3.2em;'>Order Management System</div>";
        self::$emailHtmlBodyHeader .= "</div>";
        self::$emailHtmlBodyHeader .= "<div style='margin-top: 20px; width: 80%; padding: 20px 10%; margin: 0 auto; display: inline-block;'>";

        self::$emailHtmlBodySignature = "<p>Thank you!<br>";
        self::$emailHtmlBodySignature .= "<b>Order Management System</b></p>";

        self::$emailHtmlBodyFooter = "<p style='color: #444444; font-size: 0.9em;'><i>This is an automatically generated email. Please do not reply to this email.</i></p>";
        self::$emailHtmlBodyFooter .= "</div></div></body></html>";

        self::$fromEmailAdress = "noreply@" . self::$domainEmailExt;
    }

    /**
     * @param string $email User e-mail address where the e-mail will be sent
     * @param string $username Username to place in the e-mail body greeting
     * @param string $subject E-mail subject
     * @param string $messageBody E-mail body
     * @return boolean The result of PHP mail send
     */
    function sendEmail($email, $username, $subject, $messageBody) {
        $Mail = new PHPMailer;

        $Mail->isSMTP();
        $Mail->SMTPAuth = true;
        $Mail->SMTPSecure = 'tls';
        $Mail->Host = "smtp.gmail.com";
        $Mail->Port = 587;
        $Mail->IsHTML(true);
        $Mail->Username = "username@gmail.com";
        $Mail->Password = "password";

        $Mail->setFrom(self::$fromEmailAdress, "Order Management System");
        $Mail->addAddress($email);
        $Mail->addBCC(Constants::WEBMASTER_EMAIL);
        $Mail->isHTML(true);

        if ($username == "") {
            $username = 'Hi';
        } else {
            $username = 'Hi ' . $username;
        }

        $message = self::$emailHtmlBodyHeader;
        $message .= "<h3 align='left' style='color: #0093d0'>$username,</h3>";
        $message .= "<div align='left' style='padding-bottom: 20px;'>";
        $message .= $messageBody;
        $message .= self::$emailHtmlBodySignature;
        $message .= "</div>";
        $message .= self::$emailHtmlBodyFooter;

        $Mail->Subject = $subject;
        $Mail->Body = $message;

        if ($Mail->send()) {
            return true;
        } else {
            return false;
        }
    }

}
?>