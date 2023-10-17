<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $recaptchaResponse = $_POST["g-recaptcha-response"];

    // Verify reCAPTCHA response
    $recaptchaSecretKey = "6LdHCxkoAAAAALsepISX1gnHqFLzw8xrmDdnDPsd"; // Replace with your reCAPTCHA secret key
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        "secret" => $recaptchaSecretKey,
        "response" => $recaptchaResponse,
    ];
    $options = [
        "http" => [
            "header" => "Content-type: application/x-www-form-urlencoded\r\n",
            "method" => "POST",
            "content" => http_build_query($data),
        ],
    ];
    $context = stream_context_create($options);
    $recaptchaResult = json_decode(file_get_contents($url, false, $context));

    if ($recaptchaResult->success) {
        // Process the form data
        // Insert into a database, send an email, etc.
        // Example: Mail sending (you need to configure your server to send emails)
        mail("your@email.com", "New Contact Form Submission", "Name: $name\nEmail: $email\nMessage: $message");
        echo "Form submitted successfully!";
    } else {
        echo "reCAPTCHA verification failed. Please try again.";
    }
} else {
    echo "Invalid request.";
}
?>
