{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <h1>Verify your email address</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Email Verification</h3>
                    </div>
                    <div class="card-body">
                       
                        <p class="card-text">Thank you for signing up with us. Please click the button below to verify your email address and activate your account.</p>
                        <a href="{{$url}}" class="button">Verify Email</a>
                        <p class="card-text mt-3">If you have any questions or problems, please contact us at <a href="mailto:{{config('mail.from.address')}}"></a></p>
                        <p class="card-text">Sincerely,</p>
                        <p class="card-text">HI Nepal Travel and Trek</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
</body>
</html> --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password Reset Confirmation</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<style>

</style>
</head>
<body>
  <div class="container pt-5 pb-5">
    <div class="row justify-content-center">
      <div class="col-md-8 rounded shadow-sm p-4 bg-white">
        <h2 class="mb-4 text-center">Confirm it's you</h2>
        <p>Hi {{$user->name}},</p>
        <p>We recently received a request to reset your password for your account {{$user->email}} <br> on <a href="{{env('APP_URL')}}">Hi Nepal Treks and Travel</a>. <br>To confirm your identity and choose a new password, please click the button below:</p>
         <button class="btnClass">


         </button>
        <p class="mb-4"><a href="{{$url}}" class="btn btn-primary btn-block">Reset Password</a></p>
        <p class="text-muted">This link will expire in 1  hours after it was sent. If you did not request a password reset, please ignore this email and keep your password secure.</p>
        <p>Sincerely,</p>
        <p>Hi Nepal Treks and Travel Team</p>
      </div>
    </div>
  </div>
</body>
</html>

