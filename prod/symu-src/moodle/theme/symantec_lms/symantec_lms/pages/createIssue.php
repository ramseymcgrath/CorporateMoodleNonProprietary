<html>
    <head></head>
    <body>
    <?php

        $username = 'feedback_user';
        $password = '4zS^2ikEg*';

        $url = "https://greenhopper.symantec.com/rest/api/2/issue/";
        $raw = file_get_contents('php://input');
        $json= urldecode($raw);
        $values = json_decode($json);

        if(isset($values)){
            $ticket_data = $values;
            $ticket_data->{'description'} = $ticket_data->{'description'} . "URL: " . $_SERVER['HTTP_REFERER'];
            $data = array(
                'fields' => array(
                    'project' => array(
                        'key' => 'LMS',
                    ),
                    'summary' => $ticket_data->{'summary'},
                    'description' =>  $ticket_data->{'description'},
                    "issuetype" => array(
                        "name" => "LMS Feedback"
                    ),
                ),
            );

            $ch = curl_init();

            $headers = array(
                'Accept: application/json',
                'Content-Type: application/json'
            );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

            $result = curl_exec($ch);
            $ch_error = curl_error($ch);

            if ($ch_error) {

                echo "cURL Error: $ch_error";
                return "Fail";

            } else {

                echo $result;

            }
            curl_close($ch);
            return "Success!";
        }
        return "Fail";
    ?>
    </body>
</html>
