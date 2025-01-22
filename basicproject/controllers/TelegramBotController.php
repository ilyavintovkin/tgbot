<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use Telegram\Bot\Api;

class TelegramBotController extends Controller
{
    public function actionSetWebhook()
    {
        // Токен вашего бота
        $token = '8181145365:AAFMWW7j7Ag8NxDiKyJG4YbGmkyGs_sb5Es'; 
        // URL для webhook (обратите внимание на использование реального URL вашего сервера)
        $webhookUrl = 'https://knlqst-213-108-21-154.ru.tuna.am/telegram-bot/webhook'; // Замените на ваш реальный URL
        // Формируем URL для установки webhook
        $url = 'https://api.telegram.org/bot' . $token . '/setWebhook?url=' . urlencode($webhookUrl);
        // Отправляем запрос на установку webhook
        $response = file_get_contents($url);
        // Декодируем ответ от Telegram API
        $responseData = json_decode($response, true);
        // Если ответ успешный
        if ($responseData['ok']) {
            return 'Webhook успешно установлен!';
        } else {
            // Если произошла ошибка, выводим описание ошибки
            return 'Ошибка при установке webhook: ' . $responseData['description'];
        }
    }

    public function actionWebhook()
    {
        // Получение данных из входящего запроса
        $input = file_get_contents('php://input');
        Yii::info("Полученные данные: $input", 'telegram'); // Логирование для отладки

        // Декодирование JSON в массив
        $update = json_decode($input, true);

        // Проверка структуры данных
        if (!$update || !isset($update['message'])) {
            Yii::error('Неверная структура данных: ' . print_r($update, true), 'telegram');
            return 'Invalid data';
        }

        // Извлечение данных из сообщения
        $chatId = $update['message']['chat']['id'];
        $text = $update['message']['text'];

        // Ответное сообщение
        if($text=="Лиза"){
            $responseText = "Оооо Лизу я люблю";
        }
        else{
            $responseText = "Вы написали: $text";
        }
       

        // Инициализация Telegram API с токеном
        $token = '8181145365:AAFMWW7j7Ag8NxDiKyJG4YbGmkyGs_sb5Es'; // Замените на ваш токен
        $telegram = new Api($token);

        try {
            // Отправка сообщения
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $responseText,
            ]);
            Yii::info("Сообщение успешно отправлено: $responseText", 'telegram');
        } catch (\Exception $e) {
            // Логирование ошибок отправки
            Yii::error("Ошибка отправки сообщения: " . $e->getMessage(), 'telegram');
        }

        // Возвращаем 'OK' для подтверждения обработки
        return 'OK';
    }
    // public function actionWebhook()
    // {
    //     // Проверяем, является ли запрос методом POST
    //     // if (!Yii::$app->request->isPost) {
    //     //     Yii::error('Неверный метод запроса: ' . Yii::$app->request->method, 'telegram');
    //      //     return 'Invalid request method';
    //     // }

    //     // Получаем данные из входящего запроса
    //     $input = file_get_contents('php://input');
    //     Yii::info("Полученные данные: $input", 'telegram'); // Логируем данные для отладки

    //     // Декодируем JSON в ассоциативный массив
    //     $update = json_decode($input, true);

    //     // Проверяем, есть ли сообщение в обновлении
    //     if ($update && isset($update['message'])) {
    //     // Извлекаем chat_id и текст сообщения
    //     $chatId = $update['message']['chat']['id'];
    //     $text = $update['message']['text'];

    //     // Формируем ответное сообщение
    //     $responseText = "Привет " . $text;

    //     // Инициализация Telegram API с токеном
    //     $token = '8181145365:AAFMWW7j7Ag8NxDiKyJG4YbGmkyGs_sb5Es'; // Замените на ваш токен
    //     $telegram = new Api($token);

    //     // Отправляем ответное сообщение
    //     try {
    //         $telegram->sendMessage([
    //             'chat_id' => $chatId,
    //             'text' => $responseText
    //         ]);
    //         Yii::info("Сообщение успешно отправлено: $responseText", 'telegram');
    //     } catch (\Exception $e) {
    //         Yii::error("Ошибка отправки сообщения: " . $e->getMessage(), 'telegram');
    //     }
    //     } else {
    //     // Логируем ошибку, если данные не содержат сообщение
    //     Yii::error('Неверная структура данных: ' . print_r($input, true), 'telegram');
    //     }

    //     // Ответный статус для Telegram (вы можете вернуть 'OK', чтобы Telegram знал, что запрос был обработан)
    //     return 'OK';
    // }
}