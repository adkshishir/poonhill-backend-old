<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Booking on Hi Nepal</title>
  <style>
    /* Reset some default styles */
    body, ul {
      margin: 0;
      padding: 0;
    }

    /* Container styles */
    .container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #f5f5f5;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      font-family: Arial, sans-serif;
    }

    /* Heading styles */
    h1 {
      color: #333;
      text-align: center;
      margin-bottom: 20px;
    }

    /* Paragraph styles */
    p {
      color: #666;
      line-height: 1.5;
      margin-bottom: 20px;
    }

    /* Link styles */
    a {
      color: #007bff;
      text-decoration: none;
    }

    /* List styles */
    ul {
      list-style-type: none;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    li {
      margin-bottom: 10px;
      color: #666;
    }

    li b {
      color: #333;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>New Booking Alert!</h1>
    <p>Hey team, <a href="mailto:{{$user->email}}">{{$user->name}}</a> just booked a package on the website!</p>
       <p>User : Details</p>
    <ul>
        <li><b>Name:</b>{{$user->name}}</li>
        <li><b>Phone:</b>{{$user->phone}}</li>
        <li><b>Email:</b>{{$user->email}}</li>
       </ul>
    <p>Here are the details of the booking:</p>
    <ul>
      <li><b>Booking ID:</b> {{$bookingDetails->id}}</li>
      <li><b>Package Name:</b> {{$activity->title}}</li>
      <li><b>Pickup Date:</b> {{$bookingDetails->departure_date}}</li>
      <li><b>Delivery Date:</b> {{$bookingDetails->arrival_date}}</li>
      <li><b>No. of Persons:</b> {{$bookingDetails->counts}}</li>
      <li><b>Country:</b> {{$bookingDetails->country}}</li>
      {{-- <li><b>Description:</b> {{$bookingDetails->description}}</li> --}}
    </ul>
    <strong>Check the system for more details. Don't forget to contact the customer!</strong>
  </div>
</body>
</html>