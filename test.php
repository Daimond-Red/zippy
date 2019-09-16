
<html>
<head>
    <title></title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data"s>
        <input type="hidden" name="customer_id" value="280">
        <input type="file" name="image" >
        <input type="submit" name="submit" value="submit">
    </form>
</body>
</html>
<?php 
    // echo "Hello";


    if(isset($_POST['customer_id'])) {


        try {
            $localFile = $_FILES['image']['tmp_name']; 

            $fp = fopen($localFile, 'r');

            $base = 'http://zippy.co.in/zippy/public/api/customers/updateProfile';
            
            $data = [
                'customer_id' => $_POST['customer_id'],
                'image' => $_FILES['image']
            ];
            // print_r($data);die;
            $ch = curl_init();
            
            curl_setopt_array($ch, array(
                CURLOPT_URL => $base,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_UPLOAD => 1,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "content-type: multipart/form-data"
                ),
            ));
            
            $result = curl_exec($ch);

            curl_close($ch);

            echo " <pre>"; print_r(json_decode($result));
        } catch (Exeption $e) {
            echo $e->message;
        }
    }
