<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Package Booking Confirmation on Hi Nepal</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #F8F9FA;
    }
    .container {
      max-width: 700px;
    }
    .card {
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    .card-header {
      background-color: #2188FF;
      color: #FFFFFF;
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
      padding: 20px;
    }
    .card-body {
      padding: 30px;
    }
    .text-muted {
      color: #868E96;
    }
    .btn-primary {
      background-color: #2188FF;
      border-color: #2188FF;
    }
    .text-primary {
      color: #2188FF;
    }
    a {
      color: inherit;
      text-decoration: none;
    }
    a:hover {
      color: #1D72EB;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="card">
      <div class="card-header text-center">
        <img src="https://example.com/logo.png" alt="Hi Nepal Treks and Travel" class="img-fluid" style="max-width: 200px;">
        <h2 class="mt-3">Congratulations!</h2>
      </div>
      <div class="card-body">
        <p>Hi {{$user->name}},</p>
        <p>This email confirms that you have successfully booked a package through Hi Nepal Trek and Travel on {{$bookingDetails->created_at}}. Your booking details are as follows:</p>
        <table class="table table-striped text-start mb-4">
          <tbody>
            <tr>
              <td><b>Booking ID:</b></td>
              <td>{{$bookingDetails->id}}</td>
            </tr>
            <tr>
              <td><b>Package Name:</b></td>
              <td>{{$activity->title}}</td>
            </tr>
            <tr>
              <td><b>Pickup Date:</b></td>
              <td>{{$bookingDetails->departure_date}}</td>
            </tr>
            <tr>
              <td><b>Delivery Date:</b></td>
              <td>{{$bookingDetails->arrival_date}}</td>
            </tr>
            <tr>
              <td><b>No. of Persons:</b></td>
              <td>{{$bookingDetails->counts}}</td>
            </tr>
            <tr>
              <td><b>Country:</b></td>
              <td>{{$bookingDetails->country}}</td>
            </tr>
            {{-- <tr>
              <td><b>Description:</b></td>
              <td>{{$bookingDetails->description}}</td>
            </tr> --}}
          </tbody>
        </table>
        <p class="text-muted"><strong>Additional Information:</strong></p>
        <p>Thank you for choosing Hi Nepal Treks and Travel.</p>
        <p>You can track your package progress and manage your bookings anytime by visiting our website: <a href="{{env('APP_URL')}}" class="text-primary">Hi Nepal Treks and Travel</a></p>
        <p>For any questions or concerns regarding your booking, please don't hesitate to contact our customer support team at:</p>
        <ul class="list-unstyled">
          <li><i class="bi bi-telephone-fill text-primary me-2"></i><a href="tel:">[phone]</a></li>
          <li><i class="bi bi-envelope-fill text-primary me-2"></i><a href="mailto:">[email]</a></li>
        </ul>
        <p class="text-muted">We are available 24/7 to assist you.</p>
        <p>Thank you for choosing Hi Nepal Travel and Treks! We look forward to delivering your package safely and efficiently.</p>
        <p class="mb-0">Sincerely,</p>
        <p class="mb-0">The Hi Nepal Treks and Travel Team</p>
      </div>
    </div>
  </div>
</body>
</html>