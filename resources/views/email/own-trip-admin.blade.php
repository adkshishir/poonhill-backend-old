<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Booking on Hi Nepal Travels and Trek</title>
</head>
<body>
  <h1>New Own Trip Alert!</h1>
  <p>Hey team, someone just booked a package on the website!</p>
  <ul>
    <ul>              
        <li><b>Description:</b>{{$details["description"]}}</li>
        <li><b>Phone:</b>{{$details['phone']}}</li>
        <li><b>Email:</b>{{$details['email']}}</li>
        <li><b> Date:</b>{{$details['duration']}}</li>
        <li><b>No.of Persons:</b> {{$details['counts']}}</li>
        <li><b>Country:</b> {{$details['country']}}</li>
      </ul>
  </ul>
  <p>Check the system for more details. Don't forget to contact the customer!</p>
</body>
</html>
