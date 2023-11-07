<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .content {
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>Your Application details are as follows:-</h2>
        <h5>Name: {{ $full_name }}</h5> 
        <h5>Email: {{ $email }}</h5> 
        <h5>Mobile_no: {{ $contact }}</h5> 
        <h5>Password: {{ $password }}</h5>
        <!-- You can add more dynamic content here as needed -->
    </div>
</body>
</html>
