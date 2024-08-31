<?php

$botToken = "7328687421:AAGM_f1CUUwXRL3xuVgpkEVCPgZBYOixJSc";  // Telegram bot tokeni
$chatId = "1998625340";  // Sizning Telegram chat ID'ingiz

function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Formdan kelgan ma'lumotlarni olish va xavfsiz qilish
    $name = htmlspecialchars(trim(stripslashes($_POST['name'])));
    $email = htmlspecialchars(trim(stripslashes($_POST['email'])));
    $contact_message = htmlspecialchars(trim(stripslashes($_POST['message'])));

    // Xabar matnini yaratish
    $message = "You have a new message from your website:\n\n";
    $message .= "Name: $name\n";
    $message .= "Email: $email\n";
    $message .= "Message:\n$contact_message\n";
    $message .= "\n\nThis email was sent from your site " . url() . " contact form.";

    // Telegram API URL
    $url = "https://api.telegram.org/bot$botToken/sendMessage";

    // Parametrlarni tayyorlash
    $postFields = [
        'chat_id' => $chatId,
        'text' => $message,
    ];

    // Curl yordamida xabarni Telegramga yuborish
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        // Xabar muvaffaqiyatli yuborildi
        echo "Message sent successfully!";
    } else {
        // Xatolik yuz berdi
        echo "Failed to send message.";
    }
}
