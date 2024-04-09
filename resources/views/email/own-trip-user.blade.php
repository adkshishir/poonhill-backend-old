<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Own Trip Information</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <style>
    .text-muted { color: #868e96; }
    .btn-primary { background-color: #2188FF; border-color: #2188FF; }
  </style>
</head>
<body>
  <div class="container pt-5 pb-5">
    <div class="row justify-content-center">
      <div class="col-md-8 rounded shadow-sm p-4 bg-white">
        <h2 class="mb-4 text-center">Congratulations!</h2>
        <p>Hi {{$details['name']}},</p>
        <p>This email confirms that you have successfully Send your own trip information to Hi Nepal Trek and Travel <br>
             Your  details are as follows:</p>
        <table class="table table-striped text-start">
          <tbody>
            <ul>              
              <li><b>Description:</b>{{$details['description']}}</li>
              <li><b> Date:</b>{{$details['duration']}}</li>
              <li><b>No.of Persons:</b> {{$details['counts']}}</li>
              <li><b>Country:</b> {{$details['country']}}</li>
            </ul>
          </tbody>
        </table>
        <p class="text-muted">**Additional Information:**</p>
        <p>Thank you for choosing Hi Nepal Treks and Travel.</p>
        <p>You can track your package progress and manage your bookings anytime by visiting our website: <a href="{{env('APP_URL')}}">Hi Nepal Treks and Travel</a></p>
        <p>For any questions or concerns regarding your booking, please don't hesitate to contact our customer support team at:</p>
        <ul>
          <li>Phone Number: <a href="tel:">[phone]</a></li>
          <li>Email Address: <a href="mailto:">[email]</a></li>
        </ul>
        <p class="text-muted">We are available 24/7 to assist you.</p>
        <p>Thank you for choosing Hi Nepal Travel and Treks! We look forward to delivering your package safely and efficiently.</p>
        <p>Sincerely,</p>
        <p>The Hi Nepal Treks and Travel Team</p>
      </div>
    </div>
  </div>
</body>
</html>
